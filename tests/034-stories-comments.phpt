--TEST--
Services_Digg_Stories::comments()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $stories = Services_Digg::factory('Stories');
    $params = array('count' => 5);
    $comments = $stories->comments($params);
    if (!is_array($comments->comments)) {
        print_r($comments);
        echo $stories->lastCall . "\n";
    }

    foreach ($comments->comments as $comment) {
        var_dump(is_numeric($comment->id));
    }
} catch (PEAR_Exception $error) {
    echo $error->getMessage() . "\n";
}

?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
