--TEST--
Services_Digg_User::getFriendsUpcoming()
--SKIPIF--
<?php

require_once 'tests-config.php';
$api = Services_Digg::factory('User');
$params = array('count' => 5);

try {
    $stories = $api->getFriendsUpcoming('joestump', $params);
    if (!isset($stories->stories) || !is_array($stories->stories) ||
        count($stories->stories) < 5) {
        echo "skip no upcoming diggs by friends of joestump";
    }
} catch (Services_Digg_Exception $e) {

}

?>
--FILE--
<?php

require_once 'tests-config.php';
$api = Services_Digg::factory('User');
$params = array('count' => 5);

try {
    $stories = $api->getFriendsUpcoming('joestump', $params);
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
