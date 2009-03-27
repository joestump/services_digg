--TEST--
Services_Digg_User::isFriend()
--FILE--
<?php

require_once 'tests-config.php';
$api = Services_Digg::factory('User');

var_dump($api->isFriend('joestump', 'sterntastic223'));
var_dump($api->isFriend('blink21', 'joestump'));

?>
--EXPECT--
bool(false)
bool(true)
