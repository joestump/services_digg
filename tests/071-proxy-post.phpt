--TEST--
Services_Digg_Proxy::proxy()
--POST--
endPoint=/errors&code=404
--FILE--
<?php

require_once 'tests-config.php';
require_once 'Services/Digg/Proxy.php';

$proxy = new Services_Digg_Proxy();
$proxy->proxy();

?>
--EXPECTF--
{"timestamp":%i,"errors":[{"code":%i,"message":"Not found"}]}
