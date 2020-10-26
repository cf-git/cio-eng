<?php

use CFGit\CIO\Application;

if (!function_exists('app')) {
    /**
     * @param null $key
     * @param null $val
     * @return Application|mixed|object|null
     */
    function app($key = null, $val = null) {
        static $application;

        if (!$application) {
            $application = new Application();
        }

        if (is_null($key)) {
            return $application;
        }

        if (is_null($val)) {
            if ($application->has($key)) {
                return $application->get($key);
            }
            return null;
        }

        $application->bind($key, $val);
        return $val;
    }
}