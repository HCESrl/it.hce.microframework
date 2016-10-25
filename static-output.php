<?php

// composer autoload
require __DIR__ . '/vendor/autoload.php';

// start the microframework
use it\hce\microframework\core\MicroFramework;

echo "\033[31m [WARNING]: no exception has been caught in this routine since You should fix your directories' permissions\033[0m\n";

MicroFramework::printProject();