--TEST--
Services_Digg_Stories::getContainerPopular()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Stories');
$params = array('count' => 2,
                'min_promote_date' => 1176144033,
                'max_promote_date' => 1176230424,
                'sort' => 'promote_date-asc');

$stories = $api->getContainerPopular('Science', $params);
foreach ($stories->stories as $story) {
    echo $story->title . "\n";
}

?>
--EXPECT--
EARTH NEEDS MEN: Male births declining 
Photo: Will Make You Think Twice Before Sleeping in a Forest in Angola
