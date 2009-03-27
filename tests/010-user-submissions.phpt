--TEST--
Services_Digg_User::submissions()
--FILE--
<?php

require_once 'tests-config.php';
$api = Services_Digg::factory('User');

$params = array('min_submit_date' => 1172736000,
                'max_submit_date' => 1174374000);

$result = $api->submissions('joestump', $params);
echo $result->stories[0]->title . "\n";

?>
--EXPECT--
Legislators aim to end DWT: Driving While Texting
