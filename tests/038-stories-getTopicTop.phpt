--TEST--
Services_Digg_Stories::getTopicTop()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Stories');

$params = array('count' => 2);

try {
    $res = $api->getTopicTop('Apple', $params);
    if (!isset($res->stories) || !count($res->stories)) {
        echo $api->lastCall . "\n";
        echo $api->lastResponse . "\n";
    }

    foreach ($res as $story) {
        var_dump(is_numeric($story->id));
    }
} catch (Services_Digg_Exception $e) {
    echo $api->lastCall . "\n";
    echo $api->lastResponse . "\n";
}

?>
--EXPECT--
bool(true)
bool(true)
