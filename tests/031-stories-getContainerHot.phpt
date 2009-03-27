--TEST--
Services_Digg_Stories::getContainerHot()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Stories');

$params = array('count' => 2);

foreach ($api->getContainerHot('Technology', $params) as $story) {
    var_dump(is_numeric($story->id));
}

?>
--EXPECT--
bool(true)
bool(true)
