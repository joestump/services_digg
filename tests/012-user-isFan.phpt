--TEST--
Services_Digg_User::isFan()
--FILE--
<?php

require_once 'tests-config.php';
$api = Services_Digg::factory('User');

var_dump($api->isFan('kevinrose', 'joestump'));
var_dump($api->isFan('legal817', 'joestump'));

?>
--EXPECT--
bool(true)
bool(false)
