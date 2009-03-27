--TEST--
Services_Digg_Story::comments()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Stories');
$story = $api->getStoryById(1729758);
$comments = $story->comments(array('sort' => 'date-asc', 'count' => 1));
foreach ($comments->comments as $comment) {
    echo $comment->id . "\n";
    echo $comment->content . "\n";
}

?>
--EXPECT--
6071768
The bloggers who have a unruly audience will take action (registration, moderation, etc.) because it serves their interests and their readers, not because Mr. O'reilly said so.
