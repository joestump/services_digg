--TEST--
Services_Digg_Comment::replies()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $stories = Services_Digg::factory('Stories');
    $story = $stories->getStoryById(1729758);

    $params = array('count' => 1,
                    'sort' => 'date-asc');

    $comments = $story->comments($params);
    $replies = $comments->comments[0]->replies($params);
    echo $replies->comments[0] . "\n";
} catch (PEAR_Exception $error) {
    echo $error->getMessage() . "\n";
}

?>
--EXPECT--
The road to hell is paved with good intentions.
