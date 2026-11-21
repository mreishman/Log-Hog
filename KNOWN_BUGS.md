# Known bugs

## LH-001 Shell-only file size fails for paths with spaces

When **Shell Only** is selected as the log-reading mode, Log-Hog can return an empty file size for a log whose path contains spaces. PHP 8.6 also logs a deprecation when the missing size reaches `htmlentities()`.

The regression test checks that a six-byte sample log reports size `6`. It runs on every test run and reports the currently observed empty result as a known failure. Other unexpected results and Docker or PHP execution errors still fail the test. Use **PHP Only** for paths with spaces until this is fixed.

## LH-002 Recursive polling omits nested logs

A folder with recursion enabled can show nested logs in the folder picker while omitting them from the dashboard. The fixture places `worker.log` one level below the watched folder and verifies the polling response contains its full path. The current response lists an unexpected numeric key in place of the nested path. Adding the nested folder or file as its own watch entry works around the issue.

The poll regression also appends to the nested log and creates a fresh log inside a newly created subdirectory. Both remain missing from the recursive poll results.

## LH-003 Global configuration version check rejects a matching version

The global configuration version endpoint returns `false` when the saved version and requested version are both `1`. It reads the saved version but compares the request against a different variable, which can prevent the migration screen from confirming completion.

## LH-004 Custom theme creation leaves assets missing

Creating a custom theme can report success even though its stylesheet and icons are missing. The test creates the theme directories and invokes the copy endpoint, then checks for `img/Gear.png` in the new theme. The copy endpoint targets a profile-relative `Themes` directory while creation and verification use `local/Themes`.

## LH-006 A watch entry's grep filter can return HTTP 500

Polling a dummy log with the per-watch grep filter set to `WARN` returns HTTP 500 on PHP 8.6. The handler passes an array to `explode()` during line counting. The regression test tolerates only the HTTP 500 paired with that type error.

## LH-007 Log tabs disappear when Filters is disabled

After reloading with Filters disabled, the dashboard can initialize without displaying any log tabs even though the server returns log data. The renderer tries to call `showFileFromFilter()` after the Filters script has been omitted. The Chrome check records this only when it observes the missing-function error.

## LH-008 Externally removed logs can leave a stale tab

When a log is deleted outside Log-Hog, polling can drop it from the file list while its tab stays visible. The browser test reproduces this for both individual files and files discovered through a folder. It also checks that recreating the file displays the new contents.

## LH-009 Automatic polling can miss same-size replacements

Overwriting a log or rotating it and replacing it with a file of the same byte length can leave the old contents visible. The browser test checks both direct and folder watches and waits through multiple polls with periodic full refresh disabled. It verifies that a manual refresh reads the replacement contents.

## LH-010 Some standalone settings saves leave the verification popup open

On the standalone Settings page, saving One Log, Multi-Log, or Watchlist options can leave the verification popup open. After persisting the settings, the save callback tries to access a dashboard-only control and throws a JavaScript error. The browser test checks that the saved file changed and reports this specific error before dismissing the popup to check navigation.
