--TEST--
Services_Digg_Stories::popular()
--FILE--
<?php

require_once 'tests-config.php';

$params = array('count' => 5);
foreach (Services_Digg::factory('Stories')->popular($params)->stories as $story) {
    var_dump((isset($story->id) && is_numeric($story->id)));
}

?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
