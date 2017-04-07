<?PHP
echo "<pre>POST: ";	print_r($_POST);	echo "</pre>";
$demo_event = 1;


?>

<form name="frmDataEdit" id="frmDataEdit" method="post" action="test.php?action=editsave&pID=<?=$pID;?>&p=<?=$p;?>" enctype="multipart/form-data" >

	<input type="text" name="title" id="title" size="30" value="<?=$event_title?>" />
	&nbsp;&nbsp;
<input type="checkbox" name="demo_event_chk" id="demo_event_chk" value="1"  /> Add to demo
&nbsp;&nbsp;

<input type="submit" value="Update Event" class="submitButton" />
</form>