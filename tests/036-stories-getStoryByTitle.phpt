--TEST--
Services_Digg_Stories::getStoryByTitle()
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Validate.php';

$api = Services_Digg::factory('Stories');
$story = $api->getStoryByTitle('Caught_Up');
var_dump(($story->id == 1170833));
var_dump(Validate::uri($story->href));

?>
--EXPECT--
bool(true)
bool(true)
