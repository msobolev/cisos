<?php
//function com_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
function com_db_connect() 
{
   
    /*
    echo "<br>DB_SERVER:".DB_SERVER;
    echo "<br>DB_SERVER_USERNAME:".DB_SERVER_USERNAME;
    echo "<br>DB_SERVER_PASSWORD:".DB_SERVER_PASSWORD;
    echo "<br>DB_DATABASEE:".DB_DATABASE;
     
    
    DB_SERVER:10.132.233.131
    DB_SERVER_USERNAME:ctou2
    DB_SERVER_PASSWORD:ToC@!mvCo23
    DB_DATABASEE:ctou2
    */
    
    $server = 'localhost';//'10.132.233.131';
    $username = 'root';//ctou2';
    $password = 'mycisobd123!';//'ToC@!mvCo23';
    $database = 'ctou2';
    
    global $link;
     //$link = mysqli_connect($server, $username, $password);
     $link = mysqli_connect($server, $username, $password,$database);
     //echo "<pre>LINK";  print_r($link);  echo "</pre>";
//die("<br>00");
    //echo "<br>ONE";  
    
    //if ($$link) mysql_select_db($database);
	if ($link){
		mysqli_select_db($link,$database);
	}else{
		$link = mysql_connect($server, $username, $password);
		mysql_select_db($database);
	}
        //echo "<br>TWO";  
//echo "<pre>LINK: ";   print_r($link);   echo "</pre>";
//echo "<br>THREE";  
    return $link;
  }


function com_db_output($string) {
	return stripslashes($string);
}

function com_db_input($string) {
    return addslashes($string);
}

////////////////////////////////////

function com_db_query($query) 
{
    global $link;
    $qid = mysqli_query($link,$query);
    //echo "<pre>";echo "</pre>";
    if (!$qid) 
    {
        echo "<h2>Can't execute query</h2>";
        echo "<pre>" . htmlspecialchars($query) . "</pre>";
        echo "<p><b>MySQL Error</b>: ", mysqli_error($link);
        echo "<p>This script cannot continue, terminating.";
        die();
    }
    return $qid;
}

//function com_db_fetch_array($qid,$param = MYSQL_ASSOC) {
function com_db_fetch_array($qid) {

	//return mysqli_fetch_array($qid,$param);
        return mysqli_fetch_array($qid);
        
}

function com_db_fetch_row($qid) {
	return mysqli_fetch_row($qid);
}

function com_db_fetch_object($qid) {

	return mysqli_fetch_object($qid);
}

function com_db_num_rows($qid) {

	return mysqli_num_rows($qid);
}

function com_db_affected_rows() {

	return mysql_affected_rows();
}

function com_db_insert_id() {

	return mysqli_insert_id();
}

function com_db_free_result($qid) {

	mysql_free_result($qid);
}

function com_db_num_fields($qid) {

	return mysql_num_fields($qid);
}

function com_db_field_name($qid, $fieldno) {

	return mysql_field_name($qid, $fieldno);
}

function val_com_db($value, $loc, $col) {

	$output = "";
	$query = "select * from " . $loc . " where " . $col . "=" . $value;
	$result = com_db_query($query);
	list($val, $label) = com_db_fetch_row($result);

	return $label;
}


function com_db_data_seek($qid, $row) {
/* move the database cursor to row $row on the SELECT query with the identifier
 * $qid */

	if (com_db_num_rows($qid)) { return mysql_data_seek($qid, $row); }
}
 

function com_db_GetValue($sql){
	$exe_query = com_db_query($sql);
	$num_row=com_db_num_rows($exe_query);
	if($num_row > 0){
		$data=com_db_fetch_row($exe_query);
		return $data[0];
	}else{
		return '';
	}
}

 
?>