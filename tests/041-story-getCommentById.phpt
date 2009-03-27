--TEST--
Services_Digg_Story::comments()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Stories');
$story = $api->getStoryById(1729758);
$comment = $story->getCommentById(6071768);
echo $comment;

?>
--EXPECT--
The bloggers who have a unruly audience will take action (registration, moderation, etc.) because it serves their interests and their readers, not because Mr. O'reilly said so.
