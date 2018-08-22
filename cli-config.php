<?php

/**
 * CLI Config file
 *
 * This file is sourced by the Resque command line tools. It should be copied out to the project that wants to use
 * Resque, and modified to suit. The only important thing is that this file returns a HelperSet, with a 'redis' helper,
 * so that Resque can talk to your Redis instance.
 */

(@include_once __DIR__ . '/vendor/autoload.php') || @include_once __DIR__ . '/../../autoload.php';

$predis = new \Predis\Client(array(
    'scheme' => 'tcp',
    'host'   => '127.0.0.1',
    'port'   => 6379
));

$logger = new \Resque\Logger();

return \Resque\Console\ConsoleRunner::createHelperSet($predis, $logger);
