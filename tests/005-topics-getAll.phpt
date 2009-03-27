--TEST--
Services_Digg_Topics::getAll()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = Services_Digg::factory('Topics');
    $result = $api->getAll();
} catch (Services_Digg_Exception $e) {
    echo $e->getLastCall() . "\n";
}

?>
--EXPECT--
