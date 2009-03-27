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

$stories = $api->getTopic('Apple', $params);
foreach ($stories->stories as $story) {
    echo $story->title . "\n";
}

?>
--EXPECT--
X Questions for Fake Steve Jobs
Apple "boutiques" at Best Buy
