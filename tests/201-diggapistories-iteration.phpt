--TEST--
DiggAPIStories Iteration
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Stories');
$stories = $api->getAll(array('count' => 5));
foreach ($stories as $story) {
    var_dump((is_numeric($story->id)));
}

?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
