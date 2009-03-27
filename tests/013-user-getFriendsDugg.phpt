--TEST--
Services_Digg_User::getFriendsDugg()
--FILE--
<?php

require_once 'tests-config.php';
$api = Services_Digg::factory('User');
$params = array('count' => 5,
                'min_date' => 1185311792,
                'max_date' => 1185484569);

try {
    $stories = $api->getFriendsDugg('joestump', $params);
} catch (Services_Digg_Exception $e) {
    echo $api->lastCall . "\n";
    echo $api->lastResponse . "\n";
}

if (!isset($stories->stories) || !is_array($stories->stories)) {
    echo $api->lastCall . "\n";
    echo $api->lastResponse . "\n";
}

foreach ($stories as $story) {
    var_dump(is_numeric($story->id));
}

?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
