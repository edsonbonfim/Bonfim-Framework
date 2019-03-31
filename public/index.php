<?php

define('BONFIM_START', microtime(true));

chdir(dirname(getcwd()));

include getcwd() . '/vendor/autoload.php';

$app = new \Bonfim\Framework\App;
$app->run();

exit;
