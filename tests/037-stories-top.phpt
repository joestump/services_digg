--TEST--
Services_Digg_Stories::top()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Stories');
$params = array('count' => 5);
foreach ($api->top($params) as $story) {
    var_dump(is_numeric($story->id));
}

?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
