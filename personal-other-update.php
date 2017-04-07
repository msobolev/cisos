<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// 10.132.233.131


ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

//$hre = mysqli_connect("10.132.233.131","ctou2","ToC@!mvCo23","ctou2","3306") or die("Database ERROR: ".mysqli_connect_error());

$hre = mysqli_connect("10.132.233.131","ciso_user","tejank1","ctou2","3306") or die("Database ERROR: ".mysqli_connect_error());

//
//
////$hre = mysqli_connect("10.132.233.131","root","77c2TpUdfD","ctou2","3306") or die("Database ERROR: ".mysqli_connect_error());
//$hre = mysqli_connect("localhost","root","mycisobd123!","ctou2","3306") or die("Database ERROR: ".mysqli_connect_error());

//$hre = @mysqli_connect("10.132.233.131","ctou2","ToC@!mvCo23","ctou2");

//$db = new PDO('mysql:host=10.132.233.131;dbname=ctou2', "ctou2", "ToC@!mvCo23");

/*
$mysqli = new mysqli('10.132.233.131', 'ctou2', 'ToC@!mvCo23', 'ctou2');
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}
*/


die("d3");
mysql_select_db("ctou2",$hre) or die ("ERROR: Database not found ");

$exec = mysqli_connect("localhost","root","mycisobd123!",TRUE) or die("Database ERROR ");
mysql_select_db("ctou2",$exec) or die ("ERROR: Database not found ");

$personal_not_added = array();


$table='cto_personal_master';
$result = mysql_query("DELETE FROM $table  ",$exec);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$hre)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2

//echo "<br>SELECT * FROM $table where company_website = 'www.boeing.com' limit 0,10";

//$result = mysql_query("SELECT * FROM $table where personal_id in ( 199, 23992, 58373, 58781, 59336, 23992, 60215, 68097, 68098 ) limit 0,10",$hre); // select all content		
$result = mysql_query("SELECT * FROM $table where status = 0",$hre); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) 
{		
    //$p_res = mysql_query("INSERT INTO $table (personal_id,first_name,middle_name,last_name,email,phone,personal_image,add_date,level,level_order,add_to_funding,about_person) VALUES (".$row['personal_id'].",'".addslashes($row['first_name'])."','".addslashes($row['middle_name'])."','".addslashes($row['last_name'])."','".addslashes($row['email'])."','".addslashes($row['phone'])."','".addslashes($row['personal_image'])."','".addslashes($row['add_date'])."','".addslashes($row['level'])."','".addslashes($row['level_order'])."','".addslashes($row['add_to_funding'])."','".addslashes($row['about_person'])."')",$exec); // insert one row into new table
    if(!$p_res)
    {
    }    
}



//echo "<pre>";   print_r($personal_not_added);   echo "</pre>";

$table='cto_personal_speaking';
$result = mysql_query("DELETE FROM $table  ",$exec);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$hre)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$hre); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$exec); // insert one row into new table
}



$table='cto_personal_publication';
$result = mysql_query("DELETE FROM $table  ",$exec);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$hre)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$hre); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$exec); // insert one row into new table
}


$table='cto_personal_media_mention';
$result = mysql_query("DELETE FROM $table  ",$exec);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$hre)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$hre); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$exec); // insert one row into new table
}


$table='cto_personal_awards';
$result = mysql_query("DELETE FROM $table  ",$exec);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$hre)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$hre); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$exec); // insert one row into new table
}


$table='cto_personal_board';
$result = mysql_query("DELETE FROM $table  ",$exec);
$tableinfo = mysql_fetch_array(mysql_query("SHOW CREATE TABLE $table  ",$hre)); // get structure from table on server 1
mysql_query(" $tableinfo[1] ",$exec); // use found structure to make table on server 2
$result = mysql_query("SELECT * FROM $table  ",$hre); // select all content		
while ($row = mysql_fetch_array($result, MYSQL_ASSOC) ) {		
       mysql_query("INSERT INTO $table (".implode(", ",array_keys($row)).") VALUES ('".implode("', '",array_values($row))."')",$exec); // insert one row into new table
}


mysql_close($hre);
mysql_close($exec);

?>