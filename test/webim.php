<?php

require_once(dirname(__FILE__).'/../webim.class.php');
$test = array("id" => 'test', "nick" => "Test", "show" => "available");
$susan = array("id" => 'susan', "nick" => "Susan", "show" => "available");
$jack = array("id" => 'jack', "nick" => "Jack", "show" => "available");


$im_test = new WebIM($test, "monit.cn", "public", "192.168.1.32", 8000);
$im = new WebIM($susan, "monit.cn", "public", "192.168.1.32", 8000);
$im->online("jack,josh", "room1");


$im = new WebIM($jack, "monit.cn", "public", "192.168.1.32", 8000);

//var_export($im);
echo "\n\n\nWebIM PHP Lib Test\n";
echo "===================================\n\n";
echo "check_connect: ".json_encode($im_test->check_connect())."\n";
echo "-----------------------------------\n";
echo "online: ".json_encode($im->online("susan,josh", "room1"))."\n";
echo "-----------------------------------\n";

?>
