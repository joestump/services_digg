--TEST--
Services_Digg_Stories::diggs()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Stories');
$params = array('count' => 5);
foreach ($api->diggs($params)->diggs as $digg) {
    var_dump((isset($digg->story) && is_numeric($digg->story)));
}

?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
