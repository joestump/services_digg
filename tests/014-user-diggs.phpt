--TEST--
Services_Digg_User::diggs()
--FILE--
<?php

require_once 'tests-config.php';
$api = Services_Digg::factory('User');
$params = array('min_date' => 1175706000,
                'max_date' => 1175709600);
$diggs = $api->diggs('joestump', $params);
if (!isset($diggs->diggs) || !is_array($diggs->diggs)) {
    echo $api->lastCall . "\n";
    echo $api->lastResponse . "\n";
}

foreach ($diggs as $digg) {
    echo $digg->story . "\n";
}

?>
--EXPECT--
1697133
1692022
1693993
1694742
