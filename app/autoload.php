<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';
ini_set('xdebug.max_nesting_level', 400);

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
