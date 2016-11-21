<?php
/*
//use this for AWS (disable the localhost part below)
define("DB_HOST", "YOURAWSHOSTNAME");
define("DB_USER", "YOURAWSUSERNAME");
define("DB_PASS", "YOURAWSPASSWORD");
define("DB_NAME", "YOURDBNAME");
*/

//use this for localhost testing (disable the AWS part above)
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "tts.db");

$db= new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$sqlquery="CREATE TABLE IF NOT EXISTS `ffxiv.applbot` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `channel` INT(13),
  `msg` VARCHAR(256) DEFAULT '',
  `event` VARCHAR(256) DEFAULT '',
  `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
)";

$result = $db->query($sqlquery);

?>
