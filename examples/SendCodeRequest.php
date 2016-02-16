<?php
/**
 * This Example send a Code request to the FortyTwo 2FA API.
 * The request ask for an alphanumeric code with a length of 10.
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
    $sendCodeRequest = new \fortytwo\TwoFactorAuthentication\TwoFactorAuthentication('mytoken');
    $response = $sendCodeRequest->requestCode(
        "clientRef",
        "35699982888",
        array(
            "codeType" => "alphanumeric",
            "codeLength" => "10"
        )
    );
} catch (\Exception $e) {
    echo $e->getMessage();
}
