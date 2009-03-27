--TEST--
Services_Digg_Errors::getAll()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = Services_Digg::factory('Errors');
    $result = $api->getAll();
} catch (PEAR_Exception $error) {
    echo 'UH OH! ' . $error->getMessage() . "\n";
}

?>
--EXPECT--
