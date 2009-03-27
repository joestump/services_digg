--TEST--
Services_Digg_Stories::getTopicHot()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Stories');

$params = array('count' => 2);

foreach ($api->getTopicHot('Apple', $params) as $story) {
    var_dump(is_numeric($story->id));
}

?>
--EXPECT--
bool(true)
bool(true)
