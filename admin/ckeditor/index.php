<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script type="text/javascript" src="ckeditor.js"></script>
</head>

<body>

<?
if(isset($_POST['editor1'])){
	if ( get_magic_quotes_gpc() )
		$postedValue1 = htmlspecialchars( stripslashes( $_POST['editor1'] ) ) ;
	else
		$postedValue1 = htmlspecialchars( $_POST['editor1'] ) ;
		
	$content = $postedValue1;	
	//echo $_POST['editor1'];
}
?>
<?=$content?>

<form action="" method="post">
		<div style="width:600px;height:200px;">
			<label for="editor1">Editor 1:</label>
			<textarea  id="editor1" name="editor1">&lt;p&gt;This is some &lt;strong&gt;sample text&lt;/strong&gt;. You are using &lt;a href="http://ckeditor.com/"&gt;CKEditor&lt;/a&gt;.&lt;/p&gt;</textarea>
			<script type="text/javascript">
			//<![CDATA[

				// This call can be placed at any point after the
				// <textarea>, or inside a <head><script> in a
				// window.onload event handler.

				// Replace the <textarea id="editor"> with an CKEditor
				// instance, using default configurations.
				CKEDITOR.replace( 'editor1' );

			//]]>
			</script>
			<label for="editor1">Editor 2:</label>
			<textarea  id="editor2" name="editor1">&lt;p&gt;This is some &lt;strong&gt;sample text&lt;/strong&gt;. You are using &lt;a href="http://ckeditor.com/"&gt;CKEditor&lt;/a&gt;.&lt;/p&gt;</textarea>
			<script type="text/javascript">
			//<![CDATA[

				// This call can be placed at any point after the
				// <textarea>, or inside a <head><script> in a
				// window.onload event handler.

				// Replace the <textarea id="editor"> with an CKEditor
				// instance, using default configurations.
				CKEDITOR.replace( 'editor2' );

			//]]>
			</script>
		
		<input type="submit" name="submit" value="Submit" />
		</div>
</form>	

<br />

</body>
</html>
