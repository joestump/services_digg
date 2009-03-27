--TEST--
Services_Digg_User::comments()
--FILE--
<?php

require_once 'tests-config.php';
$api = Services_Digg::factory('User');
$params = array('min_date' => 1173981000,
                'max_date' => 1173981600);
$comments = $api->comments('joestump', $params);
if (!isset($comments->comments) || !is_array($comments->comments)) {
    echo $api->lastCall . "\n";
    echo $api->lastResponse . "\n";
}

foreach ($comments as $comment) {
    echo $comment . "\n";
}

?>
--EXPECT--
One more thing: If you combined this with Google's API and wget you'd have one mean MP3 spider on your hands. Hrm.
There's a great book called Google Hacks that includes stuff like this. It also shows much more powerful features in Google, like finding numeric ranges (think SSN/CC numbers). A highly recommended book ... I read the whole thing in a plane ride in utter fascination. After that I immediately went back and updated my robots.txt and switched indexes off in Apache.
