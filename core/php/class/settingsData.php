<?php

final class settingsData
{
    public static function lock(string $directory)
    {
        $stream = fopen($directory.'/.settings-lock', 'c');
        if ($stream === false || !flock($stream, LOCK_EX)) {
            throw new RuntimeException('Could not lock settings');
        }
        return $stream;
    }

    public static function backup(string $stem, string $variable, int $limit): bool
    {
        for ($index = $limit; $index > 0; $index--) {
            $previous = $stem.($index === 1 ? '' : $index - 1).'.json';
            if (self::exists($previous)
                && !self::write($stem.$index.'.json', self::read($previous, $variable))) {
                return false;
            }
        }
        return true;
    }

    public static function remove(string $file): bool
    {
        $legacy = substr($file, 0, -5).'.php';
        return (!is_file($legacy) || unlink($legacy)) && (!is_file($file) || unlink($file));
    }

    public static function exists(string $file): bool
    {
        return is_file($file) || is_file(substr($file, 0, -5).'.php');
    }

    public static function read(string $file, string $variable): array
    {
        if (is_file($file)) {
            $source = file_get_contents($file);
            $data = json_decode($source, true, 64, JSON_THROW_ON_ERROR);
            if (!is_array($data) || !str_starts_with(ltrim($source), '{')) {
                throw new UnexpectedValueException('Invalid settings document');
            }
            return self::validate($data, $variable);
        }

        $legacy = substr($file, 0, -5).'.php';
        if (!is_file($legacy)) {
            return [];
        }
        $reader = new legacySettingsReader(file_get_contents($legacy));
        $data = $variable === 'layout'
            ? $reader->read(['currentSelectedTheme', 'listOfFolders'], ['currentSelectedTheme'])
            : $reader->read([$variable])[$variable];
        if (!is_array($data)) {
            throw new UnexpectedValueException('Invalid legacy settings document');
        }
        $data = self::validate($data, $variable);
        // Publish only if another request has not saved settings in the meantime.
        $shippedThemes = realpath(__DIR__.'/../../Themes').DIRECTORY_SEPARATOR;
        if (!str_starts_with(realpath($legacy), $shippedThemes)) {
            self::write($file, $data, true);
        }
        return is_file($file) ? self::read($file, $variable) : $data;
    }

    private static function validate(array $data, string $variable): array
    {
        if ($variable === 'layout') {
            $profile = $data['currentSelectedTheme'] ?? null;
            if (is_string($profile) && str_starts_with($profile, 'profiles/')) {
                $profile = substr($profile, strlen('profiles/'));
            }
            if (!is_string($profile) || !self::validName($profile)
                || (isset($data['listOfFolders']) && !is_array($data['listOfFolders']))) {
                throw new UnexpectedValueException('Invalid profile layout');
            }
            return $data;
        }

        $defaults = self::defaults($variable);
        foreach (array_intersect_key($data, $defaults) as $key => $value) {
            $default = $defaults[$key];
            if (is_int($default) && is_string($value)) {
                $value = filter_var($value, FILTER_VALIDATE_INT);
            }
            if (gettype($value) !== gettype($default)
                || (is_string($value) && !self::validString($value, $key))) {
                throw new UnexpectedValueException('Invalid value for setting '.$key);
            }
            $data[$key] = $value;
        }
        return $data;
    }

    public static function defaults(string $variable): array
    {
        static $defaults = [];
        if (!isset($defaults[$variable])) {
            if ($variable === 'config') {
                require __DIR__.'/../../conf/config.php';
                $defaults[$variable] = $defaultConfig;
            } elseif ($variable === 'globalConfig') {
                require __DIR__.'/../../conf/globalConfig.php';
                $defaults[$variable] = $defaultGlobalConfig;
            } else {
                $defaults[$variable] = [];
            }
        }
        return $defaults[$variable];
    }

    private static function validName(string $value): bool
    {
        return $value !== '' && $value !== '.' && $value !== '..'
            && strpbrk($value, "/\\:\0") === false;
    }

    private static function validString(string $value, string $key): bool
    {
        if (in_array($key, ['currentTheme', 'currentThemeBase'], true)) {
            return self::validName($value);
        }
        if ($key === 'moduleDisabledList') {
            $modules = json_decode($value, true);
            return is_array($modules) && array_is_list($modules)
                && count(array_filter($modules, 'is_string')) === count($modules);
        }
        return preg_match('//u', $value) === 1;
    }

    public static function write(string $file, array $data, bool $createOnly = false): bool
    {
        $json = self::encode($data);
        $pending = dirname($file).'/.settings-'.bin2hex(random_bytes(16));
        $stream = @fopen($pending, 'xb');
        if ($stream === false) {
            return false;
        }
        try {
            $written = fwrite($stream, $json);
            $closed = fclose($stream);
            if (!$closed || $written !== strlen($json)) {
                return false;
            }
            return $createOnly ? @link($pending, $file) : @rename($pending, $file);
        } finally {
            if (is_file($pending)) {
                unlink($pending);
            }
        }
    }

    public static function encode(array $data): string
    {
        return json_encode((object)$data, JSON_PRETTY_PRINT | JSON_PRESERVE_ZERO_FRACTION | JSON_THROW_ON_ERROR)."\n";
    }

    public static function structuredInput(array $fields, array $defaultConfig): array
    {
        $data = [];
        if (isset($fields['numberOfRows'])) {
            $data['watchList'] = [];
            $rows = self::input($fields['numberOfRows'], 0);
            for ($i = 1; $i <= min($rows, count($fields)); $i++) {
                $name = $fields['watchListKey'.$i] ?? null;
                if (!is_string($name) || $name === '' || !self::validString($name, '')) {
                    continue;
                }
                $row = [];
                foreach ($defaultConfig['watchList']['HHVM'] as $key => $value) {
                    $row[$key] = self::input($fields['watchListKey'.$i.$key] ?? null, $value);
                }
                $data['watchList'][$name] = $row;
            }
        }

        if (isset($fields['folderThemeCount'])) {
            $data['folderColorArrays'] = [];
            $count = self::input($fields['folderThemeCount'], 0);
            for ($i = 1; $i <= min($count, count($fields)); $i++) {
                $name = $fields['folderColorThemeNameForPost'.$i] ?? null;
                if (!is_string($name) || $name === '' || !self::validString($name, '')) {
                    continue;
                }
                $data['folderColorArrays'][$name] = [];
                foreach (['main' => 'Main', 'highlight' => 'Highlight', 'active' => 'Active',
                    'highlightActive' => 'ActiveHighlight'] as $group => $field) {
                    $colors = [];
                    for ($j = 1; isset($fields['folderColorValue'.$field.'Background'.$i.'-'.$j]); $j++) {
                        $suffix = $i.'-'.$j;
                        $colors[$group.'-'.$j] = [
                            'background' => self::input($fields['folderColorValue'.$field.'Background'.$suffix], ''),
                            'fontColor' => self::input($fields['folderColorValue'.$field.'Font'.$suffix] ?? null, ''),
                        ];
                    }
                    $data['folderColorArrays'][$name][$group] = $colors;
                }
            }
        }

        if (isset($fields['logLoad1x1-0-A'])) {
            $data['logLoadLayout'] = [];
            foreach ($fields as $field => $value) {
                if (is_string($value) && self::validString($value, '')
                    && preg_match('/\AlogLoad([1-9][0-9]*x[1-9][0-9]*)-(0|[1-9][0-9]*)-([A-G])\z/', (string)$field, $match)) {
                    $data['logLoadLayout'][$match[1]][(int)$match[2]][$match[3]] = $value;
                }
            }
        }
        return $data;
    }

    public static function input($value, $default, string $key = '')
    {
        if (is_string($default) && is_string($value) && self::validString($value, $key)) {
            return $value;
        }
        if (is_int($default) && (is_int($value) || is_string($value))) {
            $integer = filter_var($value, FILTER_VALIDATE_INT);
            if ($integer !== false && ($key !== 'backupNumConfig' || ($integer >= 0 && $integer <= 1000))) {
                return $integer;
            }
        }
        if (is_float($default) && is_numeric($value) && is_finite((float)$value)) {
            return (float)$value;
        }
        return $default;
    }
}

// The old writer emitted literal assignments. Read that grammar without evaluating PHP.
final class legacySettingsReader
{
    private array $tokens;
    private int $offset = 0;

    public function __construct(string $source)
    {
        $this->tokens = array_values(array_filter(token_get_all($source), static function ($token) {
            return !is_array($token) || !in_array($token[0], [T_WHITESPACE, T_COMMENT, T_DOC_COMMENT], true);
        }));
    }

    public function read(array $variables, ?array $required = null): array
    {
        $this->expect(T_OPEN_TAG);
        $data = [];
        while ($this->type() === T_VARIABLE) {
            $name = substr($this->expect(T_VARIABLE), 1);
            if (!in_array($name, $variables, true) || array_key_exists($name, $data)) {
                throw new UnexpectedValueException('Unexpected legacy settings variable');
            }
            $this->expect('=');
            $data[$name] = $this->value(0);
            $this->expect(';');
        }
        if ($this->type() === T_CLOSE_TAG) {
            $this->expect(T_CLOSE_TAG);
        }
        if ($this->type() !== null || array_diff($required ?? $variables, array_keys($data))) {
            throw new UnexpectedValueException('Unexpected content in legacy settings');
        }
        return $data;
    }

    private function type()
    {
        $token = $this->tokens[$this->offset] ?? null;
        return is_array($token) ? $token[0] : $token;
    }

    private function expect($type): string
    {
        if ($this->type() !== $type) {
            throw new UnexpectedValueException('Expected a literal legacy settings value');
        }
        $token = $this->tokens[$this->offset++];
        return is_array($token) ? $token[1] : $token;
    }

    private function value(int $depth)
    {
        $type = $this->type();
        if ($depth >= 60) {
            throw new UnexpectedValueException('Legacy settings nesting limit exceeded');
        }
        if ($type === T_ARRAY || $type === '[') {
            $this->expect($type);
            $close = ']';
            if ($type === T_ARRAY) {
                $this->expect('(');
                $close = ')';
            }
            $values = [];
            while ($this->type() !== $close) {
                $value = $this->value($depth + 1);
                if ($this->type() === T_DOUBLE_ARROW) {
                    $this->expect(T_DOUBLE_ARROW);
                    if (!is_string($value) && !is_int($value)) {
                        throw new UnexpectedValueException('Invalid legacy array key');
                    }
                    $values[$value] = $this->value($depth + 1);
                } else {
                    $values[] = $value;
                }
                if ($this->type() !== ',') {
                    break;
                }
                $this->expect(',');
            }
            $this->expect($close);
            return $values;
        }
        if ($type === T_CONSTANT_ENCAPSED_STRING) {
            $literal = $this->expect($type);
            $body = substr($literal, 1, -1);
            if ($literal[0] === "'") {
                return strtr($body, ["\\\\" => "\\", "\\'" => "'"]);
            }
            return preg_replace_callback('~\\\\(?:[nrtvef"\\\\$]|[0-7]{1,3}|x[0-9a-fA-F]{1,2})~', static function ($match) {
                return $match[0] === '\\$' ? '$' : ($match[0] === '\\e' ? chr(27) : stripcslashes($match[0]));
            }, $body);
        }
        if ($type === T_STRING) {
            return match (strtolower($this->expect(T_STRING))) {
                'true' => true,
                'false' => false,
                'null' => null,
                default => throw new UnexpectedValueException('Unsupported legacy settings constant'),
            };
        }
        $sign = $type === '-' || $type === '+' ? $this->expect($type) : '';
        $type = $this->type();
        if ($type === T_LNUMBER || $type === T_DNUMBER) {
            $number = $sign.$this->expect($type);
            if (is_numeric($number)) {
                return $type === T_LNUMBER ? (int)$number : (float)$number;
            }
        }
        throw new UnexpectedValueException('Unsupported legacy settings expression');
    }
}
