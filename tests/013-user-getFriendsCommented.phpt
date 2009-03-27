--TEST--
Services_Digg_User::getFriendsCommented()
--FILE--
<?php

require_once 'tests-config.php';
$api = Services_Digg::factory('User');
$params = array('count' => 5,
                'min_date' => (time() - (60 * 60 * 24 * 2)),
                'max_date' => time());

try {
    $stories = $api->getFriendsCommented('kevinrose', $params);
} catch (Services_Digg_Exception $e) {
    echo $e->getCall() . "\n";
    echo $e->getResponse() . "\n";
    exit;
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
