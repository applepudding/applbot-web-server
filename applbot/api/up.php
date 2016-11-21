<?php
//Broadcast script

//require_once("../../../con_configs/connection.php"); 
require_once("../con_configs/connection.php"); //on production use put this folder outside of ur root www folder

if (isset($_REQUEST["c"]))
{    
    $inputChannel = $_REQUEST["c"];
    $inputMsg = (isset($_REQUEST["m"])) ?  $_REQUEST["m"] : "";
    $inputEvent = (isset($_REQUEST["e"])) ?  $_REQUEST["e"] : "";
    $sqlquery="INSERT INTO `ffxiv.applbot` (channel,msg,event) VALUES ('$inputChannel','$inputMsg', '$inputEvent')";
    $result = $db->query($sqlquery);
    
    print "OK";
}
else 
{
    if (isset($_REQUEST["r"]))
    {  
        //clear all old channels
        //SELECT channel FROM `ffxiv.applbot` WHERE timestamp < (NOW() - INTERVAL 1 DAY) GROUP BY channel 
        $sqlquery = "SELECT channel FROM `ffxiv.applbot` WHERE timestamp < (NOW() - INTERVAL 1 DAY) GROUP BY channel";
        $result = $db->query($sqlquery);
        while($row = $result->fetch_object()) 
        {
            $user_channel = $row->channel;
            $sqlquery = "DELETE FROM `ffxiv.applbot` WHERE channel = $user_channel";
            $db->query($sqlquery);
        }
        //get smallest channel number available
        $available_channel = 1;
        $sqlquery = "SELECT channel FROM `ffxiv.applbot` WHERE channel = 1 LIMIT 1";
        $result = $db->query($sqlquery);
        if ($result->num_rows > 0)
        {
            //get available channel
            $sqlquery = "SELECT (channel + 1) available_channel
                        FROM `ffxiv.applbot` t
                        WHERE NOT EXISTS
                        (
                        SELECT channel
                            FROM `ffxiv.applbot`
                        WHERE channel = t.channel + 1
                        )
                        ORDER BY channel
                        LIMIT 1";
            $result = $db->query($sqlquery);
            $row = $result->fetch_object();

            //set available id as channel number
            $available_channel = (int) $row->available_channel;
            
        }  
        print $available_channel; 
        $sqlquery="INSERT INTO `ffxiv.applbot` (channel,event) VALUES ('$available_channel', '=START=')";
        $result = $db->query($sqlquery);
    }
    else
    {
        print "1.4"; //active version for auto update stuff later
    }
}
?>