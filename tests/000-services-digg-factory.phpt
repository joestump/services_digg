--TEST--
Services_Digg::factory()
--FILE--
<?php

require_once 'tests-config.php';

try {
    $check = array('Comments', 'Errors', 'Stories', 'Topics', 'Users');
    foreach ($check as $driver) {
        $i = Services_Digg::factory($driver);
    }
} catch (PEAR_Exception $error) {
    echo $driver . ' -> ' . $error->getMessage() . "\n";
}

?>
--EXPECT--
