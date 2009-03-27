--TEST--
Services_Digg_GalleryPhotos::getAll()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $api = Services_Digg::factory('GalleryPhotos');
    $params = array(
        'count' => 10
    );

    try {
        $photos = $api->getAll($params);
    } catch (Exception $e) {
        echo 'ERROR AT: ' . $api->lastCall . "\n";
    }

    foreach ($photos as $photo) {
        var_dump((is_numeric($photo->id)));
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
