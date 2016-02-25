<?php
/**
 * This Example send a code validation request to the Fortytwo API.
 */

$root = realpath(dirname(dirname(__FILE__)));

$library = $root . "/src";

$path = array($library, get_include_path());
set_include_path(implode(PATH_SEPARATOR, $path));

// Using the Composer autoload
require dirname(__FILE__) . '/../vendor/autoload.php';

// Declaring some dependencies for the Serializer
Doctrine\Common\Annotations\AnnotationRegistry::registerAutoloadNamespace(
    'JMS\Serializer\Annotation',
    $root . "/vendor/jms/serializer/src"
);

try {
    $validateCode = new \Fortytwo\SDK\TwoFactorAuthentication\TwoFactorAuthentication('mytoken');
    $response = $validateCode->validateCode('reference1', '123456');
} catch (\Exception $e) {
    echo $e->getMessage();
}
