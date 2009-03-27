--TEST--
Services_Digg_Exception::__toString()
--FILE--
<?php

require_once 'tests-config.php';
Services_Digg::$uri = 'http://digg.com';

try {
    $stories = Services_Digg::factory('Stories')->getAll();
} catch (Services_Digg_Exception $e) {
    echo $e;
}


?>
--EXPECT--
Could not parse result (Code: 0, Call: http://digg.com/stories?type=php&appkey=http%3A%2F%2Fwww.example.com%2FServices_Digg_Proxy.php)
