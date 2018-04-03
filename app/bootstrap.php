<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

$configurator = new Nette\Configurator;

//$configurator->setDebugMode('192.168.99.1'); // enable for your remote IP
//TODO bootstrap.local.php
if (file_exists(__DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.local.php')) {
    include 'bootstrap.local.php';
}
$configurator->enableTracy(__DIR__ . '/../log');

$configurator->setTimeZone('Europe/Prague');
$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
    ->addDirectory(__DIR__)
    ->register();

$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$container = $configurator->createContainer();

return $container;
