--TEST--
DiggAPIUser::isFriend()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Users');
$user = $api->getUserByName('joestump');
var_dump($user->isFriend('blink21'));
var_dump($user->isFriend('golfpublisher'));

$api = Services_Digg::factory('User');
var_dump($api->isFriend('joestump', 'blink21'));
var_dump($api->isFriend('joestump', 'golfpublisher'));

?>
--EXPECT--
bool(true)
bool(false)
bool(true)
bool(false)
