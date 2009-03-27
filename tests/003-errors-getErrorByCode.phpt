--TEST--
Services_Digg_Errors::getErrorByCode()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = Services_Digg::factory('Errors');
    $result = $api->getErrorByCode(404);
    echo $result->getCode() . "\n";
    echo $result->getMessage() . "\n";
} catch (PEAR_Exception $error) {
    echo $error->getMessage() . "\n";
}

?>
--EXPECT--
404
Not found
