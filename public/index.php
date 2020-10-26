<?php
define("BASE_PATH", dirname(__DIR__, 1));
var_dump(BASE_PATH);
require __DIR__.'/../vendor/autoload.php';

app('application.web')->load();

phpinfo();