--TEST--
Services_Digg_Stories::getContainerUpcoming()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Stories');
$stories = $api->getContainerUpcoming('Science', array('count' => 10));
foreach ($stories as $story) {
    var_dump(is_numeric($story->id));
}

?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
