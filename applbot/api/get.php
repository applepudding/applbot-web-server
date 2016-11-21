<?php

//client's browser polling api

//require_once("../../../con_configs/connection.php"); 
require_once("../con_configs/connection.php"); //on production use put this folder outside of ur root www folder


if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
{
    $inputChannel = $_POST["c"];
    $inputID = $_POST["id"];
}
else
{
    $inputChannel = 1;
    $inputID = 2;
}
$obj = ["id" => 0, "msg" => "", "event" => ""];
$sqlquery="SELECT * FROM `ffxiv.applbot` WHERE channel LIKE '$inputChannel' AND id>'$inputID' order by id asc limit 1";
if ($inputID == 0)
{
    $sqlquery="SELECT * FROM `ffxiv.applbot` WHERE channel LIKE '$inputChannel' AND id>'$inputID' order by id desc limit 1";
}
$result = $db->query($sqlquery);
if ($result->num_rows >0)
{
  $i=-1;
  $row = $result->fetch_object();
  $obj["id"]=$row->id;
  $obj["msg"]=$row->msg;
  $obj["event"]=$row->event;
}


//$obj['password'] = $password;
//////////////////////////////////////////////////////////////////////////////////////////////////
header('Content-Type: application/json; charset=UTF-8');
echo json_encode($obj);
?>
