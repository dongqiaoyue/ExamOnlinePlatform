<?php
require_once 'sql_server.php';
$sqlServer = new sql_server();
//$data = $_POST;
//$data = json_decode($data);
//$file = fopen('c.txt','r');
//$info = fread($file,filesize('c.txt'));
$data['code'] =  file_get_contents('c.txt') ;
$data['id'] = '65700ccf33cd44ce8e6be355503ffced';
$data['test'] = $sqlServer->selectTestCase($data['id']);


echo json_encode($data);


