--TEST--
Services_Digg_Stories::getStoryById()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Stories');
$story = $api->getStoryById(1728726);
echo $story->title . "\n";

?>
--EXPECT--
Hey Apple! Fix the green button already!
