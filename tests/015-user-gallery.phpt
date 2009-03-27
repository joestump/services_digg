--TEST--
Services_Digg_User::gallery()
--FILE--
<?php

require_once 'tests-config.php';
$api = Services_Digg::factory('User');
try {
    $params = array('count' => 2);
    $photos = $api->gallery('adrianakaninja', $params);
    foreach ($photos as $photo) {
        var_dump((isset($photo->href) && is_numeric($photo->id)));
    }
} catch (Exception $e) {
    echo $api->lastCall . "\n";
}

?>
--EXPECT--
bool(true)
bool(true)
