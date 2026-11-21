import assert from 'node:assert/strict';
import { execFileSync, spawn } from 'node:child_process';
import { once } from 'node:events';
import { mkdtemp, readFile, rm } from 'node:fs/promises';
import { tmpdir } from 'node:os';
import { join } from 'node:path';
import { setTimeout as delay } from 'node:timers/promises';

const browserPath = process.env.LOGHOG_CHROME || (process.platform === 'win32'
    ? 'C:/Program Files/Google/Chrome/Application/chrome.exe'
    : process.platform === 'darwin'
        ? '/Applications/Google Chrome.app/Contents/MacOS/Google Chrome'
        : 'google-chrome');
const profile = await mkdtemp(join(tmpdir(), 'loghog-browser-'));
const browser = spawn(browserPath, [
    '--headless', '--disable-gpu', '--no-first-run', '--remote-debugging-port=0',
    '--window-size=1280,850', '--user-data-dir=' + profile, process.argv[2],
], { stdio: 'ignore', windowsHide: true });
let launchError;
browser.on('error', error => { launchError = error; });
const exited = new Promise(resolve => browser.once('close', resolve));
let socket;

async function waitFor(check, description, timeout = 12000) {
    const until = Date.now() + timeout;
    while (Date.now() < until) {
        const result = await check();
        if (result) return result;
        await delay(100);
    }
    throw new Error('Timed out waiting for ' + description);
}

try {
    const port = await waitFor(async () => {
        if (launchError) throw launchError;
        if (browser.exitCode !== null) throw new Error('Chrome exited during startup');
        try {
            return (await readFile(join(profile, 'DevToolsActivePort'), 'utf8')).split('\n')[0];
        } catch (error) {
            if (error.code !== 'ENOENT') throw error;
            return false;
        }
    }, 'Chrome debugging port');

    const targets = await (await fetch('http://127.0.0.1:' + port + '/json/list')).json();
    socket = new WebSocket(targets.find(target => target.type === 'page').webSocketDebuggerUrl);
    await once(socket, 'open');
    let nextId = 0;
    const pending = new Map();
    const applicationMessages = [];
    const applicationErrors = [];
    let pollRequests = 0;
    socket.addEventListener('message', event => {
        const message = JSON.parse(event.data);
        pending.get(message.id)?.(message);
        if (message.method === 'Runtime.consoleAPICalled') {
            for (const arg of message.params.args) applicationMessages.push(arg.description || arg.value);
        }
        if (message.method === 'Runtime.exceptionThrown') {
            applicationErrors.push(message.params.exceptionDetails.exception?.description || message.params.exceptionDetails.text);
        }
        if (message.method === 'Network.requestWillBeSent' && message.params.request.url.includes('/pollCheck.php')) {
            pollRequests++;
        }
    });
    function send(method, params = {}) {
        return new Promise((resolve, reject) => {
            const id = ++nextId;
            const timeout = setTimeout(() => {
                pending.delete(id);
                reject(new Error('Chrome did not answer ' + method));
            }, method === 'Page.navigate' ? 15000 : 5000);
            pending.set(id, message => {
                clearTimeout(timeout);
                pending.delete(id);
                if (message.error) reject(new Error(message.error.message));
                else resolve(message.result);
            });
            socket.send(JSON.stringify({ id, method, params }));
        });
    }
    async function evaluate(expression) {
        const response = await send('Runtime.evaluate', { expression, returnByValue: true });
        assert.ok(!response.exceptionDetails, response.result.description || expression);
        return response.result.value;
    }
    const visible = id => evaluate(
        'Boolean(document.getElementById(' + JSON.stringify(id) + ')?.getClientRects().length)',
    );
    async function click(id) {
        await waitFor(() => visible(id), 'visible #' + id);
        await evaluate('document.getElementById(' + JSON.stringify(id) + ').click()');
    }
    const textVisible = value => evaluate('document.body.innerText.includes(' + JSON.stringify(value) + ')');

    async function openModulePanel() {
        await click('menuImage');
        await click('mainMenuSettings');
        await click('settingsAdvancedModulesMenu');
        await waitFor(() => visible('modules'), 'Modules form');
    }

    async function toggleModules() {
        await send('Runtime.enable');
        if (process.argv[4] === 'modules') {
            await waitFor(() => visible('tmploghogfixturesweblog'), 'dashboard before module changes');
        } else {
            await waitFor(() => visible('mainContent'), 'dashboard with all modules disabled');
        }
        await openModulePanel();
        const modules = await evaluate('[...document.querySelectorAll("#modules select")].map(select => select.name)');
        assert.equal(modules.length, 8);
        const state = () => evaluate('typeof moduleDisabledList === "string" ? JSON.parse(moduleDisabledList).sort() : null');
        const backupModule = 'backupNumConfigEnabled';
        const setSwitch = (name, enabled) => evaluate(
            '(() => { const select = document.querySelector("#modules").elements.namedItem(' + JSON.stringify(name) +
            '); select.value = ' + JSON.stringify(String(enabled)) +
            '; select.dispatchEvent(new Event("change", { bubbles: true })); })()',
        );
        async function save(expected) {
            const sorted = [...expected].sort();
            assert.deepEqual(await evaluate('JSON.parse(document.querySelector("#moduleDisabledList").value).sort()'), sorted);
            await evaluate('document.querySelector("#modules .modulesSaveButton").click()');
            const outcome = await waitFor(async () => {
                const error = await evaluate('location.pathname === "/error.php" ? new URLSearchParams(location.search).get("error") : null');
                if (error !== null) return { error };
                return JSON.stringify(await state()) === JSON.stringify(sorted) && { saved: true };
            }, 'saved module settings ' + JSON.stringify(sorted));
            if (outcome.error === '4' && sorted.includes(backupModule)) {
                console.log('LH-005: module save returned Error 4');
                return false;
            }
            assert.equal(outcome.saved, true, 'Unexpected settings error ' + outcome.error);
            await waitFor(async () => !await visible('popup'), 'module save popup to close');
            return true;
        }
        async function reloadDashboard() {
            const previousDocument = await evaluate('performance.timeOrigin');
            await send('Page.reload', { ignoreCache: true });
            await waitFor(async () => await evaluate('performance.timeOrigin') !== previousDocument &&
                await visible('mainContent'), 'reloaded dashboard');
        }

        if (process.argv[4] === 'modules') {
            for (const name of modules.filter(name => name !== backupModule)) {
                await setSwitch(name, false);
                assert.equal(await save([name]), true);
                await setSwitch(name, true);
                assert.equal(await save([]), true);
            }
            await setSwitch(backupModule, false);
            if (await save([backupModule])) {
                await setSwitch(backupModule, true);
                assert.equal(await save([]), true);
            }
            console.log('Completed individual module toggles');
            return;
        }

        const logTabs = await waitFor(async () => {
            if (await visible('tmploghogfixturesweblog')) return 'present';
            if (applicationMessages.some(message => String(message).includes('showFileFromFilter is not defined'))) {
                return 'LH-007';
            }
            return false;
        }, 'log tabs or the known error when Filters is disabled');
        if (logTabs === 'LH-007') console.log('LH-007: disabled Filters leaves the log tabs missing');
        assert.deepEqual(await state(), [...modules].sort());
        assert.deepEqual(await evaluate('[...document.querySelectorAll("#modules select")].map(select => select.value)'),
            modules.map(() => 'false'));
        for (const name of modules) await setSwitch(name, true);
        await save([]);
        await reloadDashboard();
        await waitFor(() => visible('oneLog'), 'dashboard with all modules enabled again');
        assert.deepEqual(await state(), []);
        console.log('Completed live toggles for 8 modules');
    }

    async function testDashboard() {
        await waitFor(() => visible('tmploghogfixturesweblog'), 'web log tab after dashboard initialization');
        await click('tmploghogfixturesweblog');
        await waitFor(() => textVisible('WARN queue slowdown'), 'web log content');
        await click('tmploghogfixturesnestedworkerlog');
        await waitFor(() => textVisible('INFO worker ready'), 'nested worker log content');
        assert.deepEqual(await evaluate('jsonDecodeTry(\'{"source":"fixture"}\')'), { source: 'fixture' });
        assert.equal(await evaluate('jsonDecodeTry("malformed")'), false);

        await click('tmploghogfixturesweblog');
        await click('showFilterTopBarButton');
        await waitFor(() => visible('searchFieldInput'), 'filter input');
        await evaluate('document.querySelector("#searchFieldInput").focus()');
        await send('Input.insertText', { text: 'slowdown' });
        assert.equal(await evaluate('document.querySelector("#searchFieldInput").value'), 'slowdown');
        assert.equal(await evaluate('filterContentCheck("WARN queue slowdown", getFilterTextField())'), true);
        assert.equal(await evaluate('filterContentCheck("INFO dashboard request", getFilterTextField())'), false);
        await evaluate('hideFilterTopBar()');
        await waitFor(() => textVisible('INFO dashboard request'), 'clearing the filter restores the log line');

        await evaluate('document.querySelector("#pauseImage").dispatchEvent(new MouseEvent("contextmenu", { bubbles: true }))');
        await waitFor(() => textVisible('Toggle pause on unfocus'), 'pause context menu');
        await click('pauseImage');
        await waitFor(() => evaluate('pausePollCurrentSession === true'), 'paused polling');
        await click('playImage');
        await waitFor(() => evaluate('pausePollCurrentSession === false'), 'resumed polling');

        await evaluate('const layout = document.querySelector("#windowConfig"); layout.value = "1x2"; layout.dispatchEvent(new Event("change", { bubbles: true }))');
        await waitFor(() => evaluate('Object.keys(logDisplayArray).length === 2'), 'two log panes');
        await evaluate('document.querySelector("#windowConfig").value = "1x1"; document.querySelector("#windowConfig").dispatchEvent(new Event("change", { bubbles: true }))');
        await waitFor(() => evaluate('Object.keys(logDisplayArray).length === 1'), 'single log pane');

        await click('oneLog');
        execFileSync('docker', ['exec', '-u', 'www-data', process.argv[3], 'sh', '-c',
            'echo "INFO combined fixture update" >> /tmp/loghog-fixtures/nested/worker.log']);
        await waitFor(() => textVisible('INFO combined fixture update'), 'new entry in the combined log');
        await click('menuImage');
        await click('mainMenuAbout');
        await click('aboutSubMenuChangelog');
        await waitFor(() => textVisible('PHP and Docker maintenance'), '9.0 release notes');
        await click('mainMenuNotifications');
        await click('mainMenuHistory');
        await waitFor(() => visible('fullScreenMenuHistory'), 'history panel');
        await click('archiveHistory');
        await waitFor(() => visible('fullScreenMenuArchive'), 'archive panel');
        await click('watchListMenu');
        await waitFor(() => visible('fullScreenMenuWatchList'), 'watch list panel');
        await click('ThemesLink');
        await waitFor(() => visible('fullScreenMenuTheme'), 'themes panel');
        await click('mainMenuSettings');
        await waitFor(() => visible('settingsSubMenu'), 'settings panel');
    }

    async function testThemeSwitching() {
        const themes = [
            { name: 'Default', background: 'rgb(41, 41, 41)' },
            { name: 'Ocean', background: 'rgb(15, 15, 40)' },
        ];
        async function expectDashboard(theme) {
            await waitFor(() => visible('tmploghogfixturesweblog'), 'dashboard log tab');
            assert.equal(await evaluate('getComputedStyle(document.body).backgroundColor'), theme.background);
            for (const asset of ['template/theme.css', 'img/Gear.png']) {
                execFileSync('docker', ['exec', process.argv[3], 'cmp',
                    `core/Themes/${theme.name}/${asset}`, `local/profiles/default/${asset}`]);
            }
        }
        async function openThemes() {
            await click('menuImage');
            await click('ThemesLink');
            await waitFor(() => visible('fullScreenMenuTheme'), 'theme chooser');
        }
        const card = theme => `document.getElementById(${JSON.stringify('themeMainSelection-' + theme.name)}).closest('.iframeThemeOuter')`;
        async function expectSelected(theme) {
            assert.equal(await evaluate(`${card(theme)}.querySelector('.linkSmallHover')?.textContent.trim()`), 'Selected');
        }
        async function expectNewDocument(previous, description) {
            await waitFor(() => evaluate(`performance.timeOrigin !== ${previous} && location.pathname === '/'`), description, 20000);
        }

        let active = themes[0];
        await expectDashboard(active);
        for (const next of [themes[1], themes[0]]) {
            await openThemes();
            await expectSelected(active);
            const previous = await evaluate('performance.timeOrigin');
            assert.equal(await evaluate(`(() => {
                const action = [...${card(next)}.querySelectorAll('a')].find(item => item.textContent.trim() === 'Select');
                action?.click();
                return Boolean(action);
            })()`), true, 'Select action for ' + next.name);
            await expectNewDocument(previous, 'theme save and automatic reload');
            await expectDashboard(next);

            const applied = await evaluate('performance.timeOrigin');
            await send('Page.reload', { ignoreCache: true });
            await expectNewDocument(applied, 'independent theme reload');
            await expectDashboard(next);
            await openThemes();
            await expectSelected(next);
            await click('menuImage');
            await waitFor(async () => !await visible('fullScreenMenu'), 'theme chooser to close');
            active = next;
        }
    }

    async function testUnsavedChanges(inline) {
        await send('Runtime.enable');
        const profileConfig = 'local/profiles/default/conf/config.php';
        const globalConfig = 'local/conf/globalConfig.php';
        const configs = [profileConfig, globalConfig];
        function fixture(command, ...args) {
            return execFileSync('docker', ['exec', '-u', 'www-data', process.argv[3],
                'sh', '-ec', command, 'fixture', ...args], { encoding: 'utf8' });
        }
        for (const [index, path] of configs.entries()) fixture('cp "$1" "$2"', path, `/tmp/guard-baseline-${index}`);
        let revision = 0;
        async function navigate(path) {
            const url = new URL(path, process.argv[2]);
            url.searchParams.set('guardFixture', String(++revision));
            await send('Page.navigate', { url: url.href });
            await waitFor(() => evaluate(`location.href === ${JSON.stringify(url.href)} && document.readyState === 'complete'`),
                `navigation to ${path}`);
        }
        async function openInlineSettings() {
            await click('menuImage');
            await click('mainMenuSettings');
            await waitFor(() => visible('settingsSubMenu'), 'inline settings');
        }
        if (inline) await openInlineSettings();
        else await navigate('/settings.php');
        const selector = inline ? '#settingsSubMenu [onclick^="toggleSettingSection"]' : '#menu2 [onclick^="toggleSettingSection"]';
        const sections = await evaluate(`Array.from(document.querySelectorAll(${JSON.stringify(selector)}))
            .filter(item => !item.classList.contains('hiddenMenu'))
            .map(item => ({ menu: item.id, form: item.getAttribute('onclick').match(/formId: '([^']+)'/)[1],
                group: item.getAttribute('onclick').match(/groupId: '([^']+)'/)?.[1] }))
            .filter(item => item.form !== 'settingsAdvancedAdvanced')`);
        assert.ok(sections.length >= 15, 'Expected the editable settings sections');
        if (inline) sections.push({ menu: 'watchListMenu', form: 'settingsMainWatch' });

        async function openSection(section) {
            if (inline) {
                await navigate('/');
                await openInlineSettings();
                await click(section.menu);
            } else {
                await navigate(`/settings.php?tab=${section.group}&id=${section.menu.slice(0, -4)}`);
            }
            await waitFor(() => visible(section.form), section.form);
            if (section.form === 'settingsMainWatch') {
                await waitFor(() => evaluate(`!!document.querySelector('#settingsMainWatch [name="watchListKey1Location"]') &&
                    !globalForcePageNavigate && !checkIfChanges()`), 'watch list fixture to load');
            }
            await waitFor(() => evaluate(`arrayOfDataSettings.includes(${JSON.stringify(section.form)}) && !checkIfChanges()`),
                'saved baseline for ' + section.form);
        }

        function tryLeaving() {
            return click(inline ? 'mainMenuAbout' : 'back');
        }
        function expectPopup() {
            return waitFor(() => evaluate(`document.querySelector('#popupHeaderText')?.textContent === 'Changes not Saved!' &&
                document.querySelector('#popup').getClientRects().length > 0`), 'unsaved changes prompt');
        }
        async function choosePopup(label) {
            assert.equal(await evaluate(`(() => {
                const button = [...document.querySelectorAll('#popupContentInnerHTMLDiv .linkSmall')]
                    .find(item => item.textContent.trim() === ${JSON.stringify(label)});
                button?.click();
                return Boolean(button);
            })()`), true);
        }
        async function expectDestination() {
            if (inline) await waitFor(() => visible('fullScreenMenuAbout'), 'About after navigation');
            else await waitFor(() => evaluate('location.pathname === "/index.php"'), 'dashboard after leaving settings');
        }

        const failures = [];
        for (const section of sections) {
            try {
                for (const [index, path] of configs.entries()) {
                    fixture('cp "$1" "$2.fixture"; mv -f "$2.fixture" "$2"', `/tmp/guard-baseline-${index}`, path);
                }
                await openSection(section);
                const edit = await evaluate(`(() => {
                    const form = document.getElementById(${JSON.stringify(section.form)});
                    const special = {
                        settingsMainWatch: ['watchListKey1Location', '/tmp/loghog-fixtures/nested'],
                        settingsInitialLoadLayoutVars: ['logLoad1x1-0-A', '/tmp/loghog-fixtures/web.log'],
                        // Keep the Timestamp and Linked Files menus available to the next case.
                        settingsLogFormatVars: ['logFormatPhpHideExtra', 'true'],
                        modules: ['rightClickMenuEnable', 'false'],
                        globalAdvanced: ['successVerifyNum', '2'],
                    }[form.id];
                    if (special) return { name: special[0], value: special[1] };
                    if (form.id === 'settingsColorFolderGroupVars') {
                        const row = [...form.querySelectorAll('tr')].find(item => item.querySelector('[value="theme-user-1"]'));
                        return { name: row.querySelector('[name^="folderColorValueMainBackground"]').name, value: '#123456' };
                    }
                    const controls = [...form.elements].filter(el => el.name && !el.disabled && el.getClientRects().length &&
                        !/^(samePageSettings|pauseOnNotFocus|pausePoll|pollingRate|logTrimOn|currentTheme|popup)/.test(el.name));
                    for (const control of controls) {
                        if (control.tagName === 'SELECT') {
                            const option = [...control.options].find(item => !item.disabled && item.value !== control.value);
                            if (option) return { name: control.name, value: option.value };
                        }
                        if (control.type === 'number') {
                            const value = Number(control.value) + 1;
                            if (!control.max || value <= Number(control.max)) return { name: control.name, value: String(value) };
                        }
                        if (control.type === 'text') {
                            const value = /color/i.test(control.name) ? '123456' : control.value + ' Fixture';
                            return { name: control.name, value };
                        }
                    }
                    return null;
                })()`);
                assert.ok(edit, 'No editable fixture field for ' + section.form);
                const field = `document.getElementById(${JSON.stringify(section.form)}).elements.namedItem(${JSON.stringify(edit.name)})`;
                async function change() {
                    await evaluate(`(() => { const control = ${field}; control.value = ${JSON.stringify(edit.value)};
                        control.dispatchEvent(new Event('change', { bubbles: true })); })()`);
                    assert.equal(await evaluate(field + '.value'), edit.value);
                }
                const oldValue = await evaluate(field + '.value');
                assert.notEqual(oldValue, edit.value, edit.name);
                const baseline = fixture('sha256sum "$@"', ...configs);
                await change();
                await tryLeaving();
                await expectPopup();
                await choosePopup('No');
                assert.equal(await visible(section.form), true);
                assert.equal(await evaluate(field + '.value'), edit.value);

                await tryLeaving();
                await expectPopup();
                await choosePopup('Yes');
                await expectDestination();
                assert.equal(fixture('sha256sum "$@"', ...configs), baseline, 'Discard changed saved files');

                await openSection(section);
                assert.equal(await evaluate(field + '.value'), oldValue);
                await change();
                applicationErrors.length = 0;
                assert.equal(await evaluate(`(() => {
                    const form = document.getElementById(${JSON.stringify(section.form)});
                    const button = [...form.querySelectorAll('[onclick]')].find(item => item.textContent.trim() === 'Save Changes');
                    button?.click();
                    return Boolean(button);
                })()`), true, 'Missing Save Changes action');
                const saveOutcome = await waitFor(async () => {
                    if (!await evaluate('!checkIfChanges()')) return false;
                    if (!await visible('popup')) return 'complete';
                    const knownSaveError = {
                        settingsOneLogVars: "Cannot read properties of undefined (reading 'value')",
                        settingsMultiLogVars: "Cannot read properties of undefined (reading 'value')",
                        settingsWatchlistVars: "Cannot set properties of null (setting 'innerHTML')",
                    }[section.form];
                    if (!inline && knownSaveError && applicationErrors.some(error =>
                        error.includes('saveVerified') && error.includes(knownSaveError))) {
                        return 'LH-010';
                    }
                    return false;
                }, 'save verification for ' + section.form);
                if (saveOutcome === 'LH-010') {
                    console.log(`LH-010: standalone ${section.form} save leaves the verification popup open`);
                    await evaluate('hidePopup()');
                }
                await tryLeaving();
                await expectDestination();
                assert.notEqual(fixture('sha256sum "$@"', ...configs), baseline, 'Save did not change either config');
                console.log('Unsaved changes verified: ' + section.form);
            } catch (error) {
                failures.push(`${section.form}: ${error.message}`);
                console.error(failures.at(-1));
            }
        }
        assert.deepEqual(failures, [], 'Unsaved changes failures');
    }

    async function testBackgroundPolling(autoPause) {
        await send('Network.enable');
        await click('tmploghogfixturesweblog');
        await waitFor(() => textVisible('INFO dashboard request'), 'initial log contents');
        assert.equal(await evaluate('pauseOnNotFocus'), String(autoPause));
        assert.equal(await evaluate('document.visibilityState'), 'visible');
        const { targetId } = await send('Target.createTarget', { url: 'about:blank' });
        try {
            await send('Target.activateTarget', { targetId });
            await waitFor(() => evaluate('document.visibilityState === "hidden"'), 'background tab visibility');
            if (autoPause) {
                await waitFor(() => evaluate('pausePollCurrentSession && !userPaused && pollTimer === null'),
                    'automatic pause without a manual pause');
            }
            const before = pollRequests;
            const marker = 'INFO written while tab was in background';
            execFileSync('docker', ['exec', '-u', 'www-data', process.argv[3], 'sh', '-ec',
                'printf "%s\\n" "$1" >> /tmp/loghog-fixtures/web.log', 'fixture', marker]);
            if (autoPause) {
                await delay(2200);
                assert.equal(await evaluate('document.visibilityState'), 'hidden');
                assert.equal(pollRequests, before, 'Log-Hog polled while automatically paused');
                assert.equal(await textVisible(marker), false);
            } else {
                await waitFor(() => pollRequests > before, 'polling in the background');
                await waitFor(() => textVisible(marker), 'new line in the background tab');
                assert.equal(await evaluate('document.visibilityState'), 'hidden');
                assert.equal(await evaluate('pausePollCurrentSession'), false);
            }
            await send('Page.bringToFront');
            await waitFor(() => evaluate('document.visibilityState === "visible" && !pausePollCurrentSession'),
                'foreground tab with polling resumed');
            if (autoPause) await waitFor(() => pollRequests > before, 'polling after returning to the tab');
            await waitFor(() => textVisible(marker), 'new line after returning to the tab');
        } finally {
            await send('Target.closeTarget', { targetId });
        }
    }

    async function testLogLifecycle() {
        const root = '/tmp/loghog-fixtures';
        const direct = root + '/nested/direct.log';
        const folderLog = root + '/web.log';
        const directLate = root + '/nested/late.log';
        const folderLate = root + '/created.log';
        function mutate(command, ...args) {
            execFileSync('docker', ['exec', '-u', 'www-data', process.argv[3],
                'sh', '-ec', command, 'fixture', ...args]);
        }
        async function tabId(path) {
            await waitFor(() => evaluate('typeof filterIdText === "function"'), 'log tab utilities');
            return evaluate('filterIdText(' + JSON.stringify(path) + ')');
        }
        async function readLog(path, text) {
            await click(await tabId(path));
            await expectLine(path, text);
        }
        const expectLine = (path, text) => waitFor(() => textVisible(text),
            `${path} to display ${JSON.stringify(text)}`);
        async function waitForPolls() {
            const count = () => evaluate('performance.getEntriesByType("resource").filter(entry => entry.name.includes("/pollCheck.php")).length');
            const before = await count();
            await waitFor(async () => (await count()) >= before + 3, 'three completed log polls');
        }

        await readLog(direct, 'DIRECT original record');
        await readLog(folderLog, 'INFO dashboard request');
        assert.equal(await visible(await tabId(directLate)), false);
        assert.equal(await visible(await tabId(folderLate)), false);

        await click(await tabId(direct));
        await click('pauseImage');
        await waitFor(() => evaluate('pausePollCurrentSession === true'), 'paused log polling');
        mutate('printf "%s\\n" "DIRECT written during pause" >> "$1"; printf "%s\\n" "FOLDER written during pause" >> "$2"',
            direct, folderLog);
        await delay(750);
        assert.equal(await textVisible('DIRECT written during pause'), false);
        await click('playImage');
        await expectLine(direct, 'DIRECT written during pause');
        await readLog(folderLog, 'FOLDER written during pause');

        for (const [path, label] of [[direct, 'DIRECT'], [folderLog, 'FOLDER']]) {
            await click(await tabId(path));
            for (const line of [`${label} appended first`, `${label} appended second`]) {
                mutate('printf "%s\\n" "$2" >> "$1"', path, line);
                await expectLine(path, line);
            }
            mutate(': > "$1"', path);
            await waitFor(() => evaluate(`Number(fileData[${JSON.stringify(path)}]?.size) === 0`),
                `${label} log truncation`);
            mutate('printf "%s\\n" "$2" > "$1"', path, `${label} after truncate`);
            await expectLine(path, `${label} after truncate`);
            assert.equal(await textVisible(`${label} appended second`), false);

            mutate('mv "$1" "$1.old"; printf "%s\\n" "$2" > "$1"', path,
                `${label} replacement after rotation with a different file size`);
            await expectLine(path, `${label} replacement after rotation`);
            assert.equal(await textVisible(`${label} after truncate`), false);
            assert.equal(await visible(await tabId(path + '.old')), false);

            const id = await tabId(path);
            mutate('rm "$1"', path);
            await waitFor(() => evaluate(`!Object.hasOwn(arrayOfData1, ${JSON.stringify(path)})`),
                `${label} log to disappear from polling after removal`);
            await waitForPolls();
            if (await visible(id)) {
                const state = await evaluate(`arrayOfDataMain[${JSON.stringify(path)}]?.log`);
                assert.ok(state === undefined || state === 'Error - File does not exist',
                    `${label} missing file still has a cached log payload`);
                console.log(`LH-008: ${label} missing log keeps a visible tab`);
            }
            mutate('printf "%s\\n" "$2" > "$1"', path, `${label} recreated after removal`);
            await readLog(path, `${label} recreated after removal`);
        }

        mutate('printf "%s\\n" "IGNORED extension" > "$1"; printf "%s\\n" "IGNORED subfolder" > "$2"',
            root + '/created.txt', root + '/nested/unwatched.log');
        mutate('printf "%s\\n" "$2" > "$1"', directLate, 'DIRECT created after startup');
        await readLog(directLate, 'DIRECT created after startup');
        mutate(': > "$1"', folderLate);
        await waitFor(() => evaluate(`Number(fileData[${JSON.stringify(folderLate)}]?.size) === 0`),
            'new empty file in watched folder');
        mutate('printf "%s\\n" "$2" >> "$1"', folderLate, 'FOLDER first line after empty creation');
        await readLog(folderLate, 'FOLDER first line after empty creation');
        const newLog = root + '/new.log';
        mutate('printf "%s\\n" "$2" > "$1"', newLog, 'FOLDER created with content');
        await readLog(newLog, 'FOLDER created with content');
        const moved = root + '/moved.log';
        mutate('printf "%s\\n" "FOLDER arrived by rename" > "$1.pending"; mv "$1.pending" "$1"', moved);
        await readLog(moved, 'FOLDER arrived by rename');
        for (const excluded of [root + '/created.txt', root + '/nested/unwatched.log']) {
            assert.equal(await visible(await tabId(excluded)), false, excluded);
        }

        for (const [path, label] of [[direct, 'DIRECT'], [folderLog, 'FOLDER']]) {
            const previous = `${label} same-size record A`;
            let lastVisible = previous;
            mutate('printf "%s\\n" "$2" > "$1"', path, previous);
            await readLog(path, previous);
            for (const [action, command, marker] of [
                // Keep the watched path present and the size unchanged throughout each operation.
                ['overwrite', 'printf "%s\\n" "$2" | dd of="$1" conv=notrunc status=none', `${label} same-size record B`],
                ['rotation', 'cp "$1" "$1.rotated"; printf "%s\\n" "$2" > "$1.pending"; mv -f "$1.pending" "$1"', `${label} same-size record C`],
            ]) {
                assert.equal(marker.length, previous.length);
                mutate(command, path, marker);
                await waitForPolls();
                const rendered = await evaluate('document.body.innerText');
                if (!rendered.includes(marker)) {
                    assert.ok(rendered.includes(lastVisible), `${label} same-size ${action} displayed neither record`);
                    console.log(`LH-009: ${label} same-size ${action} was not detected by polling`);
                    await click('refreshImage');
                    await readLog(path, marker);
                }
                lastVisible = marker;
            }
        }
    }

    if (['modules', 'modules-cold'].includes(process.argv[4])) await toggleModules();
    else if (['auto-pause-on', 'auto-pause-off'].includes(process.argv[4])) {
        await testBackgroundPolling(process.argv[4] === 'auto-pause-on');
    }
    else if (['unsaved-inline', 'unsaved-standalone'].includes(process.argv[4])) {
        await testUnsavedChanges(process.argv[4] === 'unsaved-inline');
    }
    else if (process.argv[4] === 'theme-switching') await testThemeSwitching();
    else if (process.argv[4] === 'log-lifecycle') await testLogLifecycle();
    else await testDashboard();
} finally {
    if (socket?.readyState === WebSocket.OPEN) {
        socket.send(JSON.stringify({ id: 9999, method: 'Browser.close' }));
        socket.close();
    }
    if (await Promise.race([exited.then(() => false), delay(2000, true)])) {
        browser.kill();
        await exited;
    }
    await rm(profile, { recursive: true, force: true, maxRetries: 5, retryDelay: 200 });
}
