--TEST--
Services_Digg_Stories::getAll()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = Services_Digg::factory('Stories');
    $params = array(
        'count' => 10,
        'sort' => 'submit_date-desc',
        'min_submit_date' => 1168551405,
        'max_submit_date' => 1168637807
    );

    $stories = $api->getAll($params);
    if (!is_array($stories->stories) || !count($stories->stories)) {
        echo $stories->lastCall . "\n";
        print_r($stories); 
    }

    foreach ($stories->stories as $story) {
        var_dump((is_numeric($story->id)));
    }
} catch (PEAR_Exception $error) {
    echo $error->getMessage();
}

?>
--EXPECT--
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
bool(true)
