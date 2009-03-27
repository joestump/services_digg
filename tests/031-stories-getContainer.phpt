--TEST--
Services_Digg_Stories::getContainer()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Stories');
$params = array('count' => 2,
                'min_submit_date' => 1176144033,
                'max_submit_date' => 1176230424,
                'sort' => 'submit_date-asc');

$stories = $api->getContainer('Sports', $params);
foreach ($stories->stories as $story) {
    echo $story->title . "\n";
}

?>
--EXPECT--
The Masters: Tiger struggles as Clark, Wetterich share lead on tough August
Jack Lilley Motorcycles are planning to offer an extremely limited-edition.
