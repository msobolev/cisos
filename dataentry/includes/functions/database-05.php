<?php
function com_db_connect($server = DB_SERVER, $username = DB_SERVER_USERNAME, $password = DB_SERVER_PASSWORD, $database = DB_DATABASE, $link = 'db_link') {
    global $$link;
      $$link = mysql_connect($server, $username, $password);

    if ($$link) mysql_select_db($database);

    return $$link;
  }


function com_db_output($string) {
	return stripslashes($string);
}

function com_db_input($string) {
    return addslashes($string);
}

////////////////////////////////////

function com_db_query($query) {
 
	
	$qid = mysql_query($query);

	if (!$qid) {
		
			echo "<h2>Can't execute query</h2>";
			echo "<pre>" . htmlspecialchars($query) . "</pre>";
			echo "<p><b>MySQL Error</b>: ", mysql_error();
			echo "<p>This script cannot continue, terminating.";
			die();
	}

	return $qid;
}

function com_db_fetch_array($qid,$param = MYSQL_ASSOC) {

	return mysql_fetch_array($qid,$param);
}

function com_db_fetch_row($qid) {
	return mysql_fetch_row($qid);
}

function com_db_fetch_object($qid) {

	return mysql_fetch_object($qid);
}

function com_db_num_rows($qid) {

	return mysql_num_rows($qid);
}

function com_db_affected_rows() {

	return mysql_affected_rows();
}

function com_db_insert_id() {

	return mysql_insert_id();
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