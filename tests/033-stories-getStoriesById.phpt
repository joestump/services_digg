--TEST--
Services_Digg_Stories::getStoriesById()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = Services_Digg::factory('Stories');
    $params = array('sort' => 'promote_date-asc');
    $stories = $api->getStoriesById(array(1733280, 1733522, 1736097), $params);
    foreach ($stories->stories as $story) {
        echo $story->title . "\n";
    }
} catch (PEAR_Exception $error) {
    echo $api->lastCall . "\n";
    echo $error->getMessage() . "\n";
}

?>
--EXPECT--
Earth's Air Conditioner
Heat Vision and Jack: Jack Black and Owen Wilson's 1999 TV Show Pilot
U.S. military develops Robocop armour for soldiers
