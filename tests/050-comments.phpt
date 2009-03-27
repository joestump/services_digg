--TEST--
Services_Digg_Comments::getAll()
--FILE--
<?php

require_once 'tests-config.php';

$api = Services_Digg::factory('Comments');
$params = array('min_date' => 1176220250,
                'max_date' => 1176220280,
                'count'    => 1);
                
$comments = $api->getAll($params);
echo $comments->comments[0];

?>
--EXPECT--
Big bust? Sadly, I don't think there are a million people left in iraq who can march.
