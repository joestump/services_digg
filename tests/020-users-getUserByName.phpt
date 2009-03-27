--TEST--
Services_Digg_Users::getUserByName()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Users');
$user = $api->getUserByName('joestump');
var_dump($user->registered);

?>
--EXPECT--
int(1129926889)
