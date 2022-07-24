
<?php

if (!function_exists('env')) {
    function env($key)
    {
        $res = null;

        if (isset($_SERVER[$key])) {
            $res = $_SERVER[$key];
        }

        if (isset($_ENV[$key])) {
            $res = $_ENV[$key];
        }

        return $res;
    }
}

if (!function_exists('dd')) {
    function dd(...$data)
    {
        echo PHP_EOL;

        foreach ($data as $d) {
            var_dump($d) . PHP_EOL;
        }

        exit;
    }
}