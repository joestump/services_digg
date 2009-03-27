--TEST--
Services_Digg_Stories::getStoriesDiggs()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Stories');
$diggs = $api->getStoriesDiggs(
                    array(1743038, 1743672), 
                    array('count' => 5)
);

foreach ($diggs->diggs as $digg) {
    var_dump(is_numeric($digg->id));
}


?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
