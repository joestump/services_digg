--TEST--
Services_Digg_Stories::getStoriesComments()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Stories');
$comments = $api->getStoriesComments(
                    array(1743038, 1743672), 
                    array('count' => 5)
);

foreach ($comments->comments as $comment) {
    var_dump(is_numeric($comment->id));
}


?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
