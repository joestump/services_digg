<?php

$path = realpath('./../'); ;
ini_set('include_path', $path . ':' . ini_get('include_path'));

require_once 'Services/Digg.php';
Services_Digg::$appKey = 'http://www.example.com/Services_Digg_Proxy.php';
Services_Digg::$uri = 'http://services.digg.com';

?>
