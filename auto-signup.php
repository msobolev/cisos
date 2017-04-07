<?php
include("includes/include-top.php");

$new_signup_query = "select * from ".TABLE_VIGILANT_SIGN_UP." where signup_to_aweber='' or signup_to_aweber=NULL";	
$new_signup_result = com_db_query($new_signup_query);

while($nsRow = com_db_fetch_array($new_signup_result)){	
?>
<html>
<body>
<form name="frmAutoSignup" method="post" class="af-form-wrapper" action="http://www.aweber.com/scripts/addlead.pl"  >

<input type="hidden" name="meta_web_form_id" value="1184537449" />
<input type="hidden" name="meta_split_id" value="" />
<input type="hidden" name="listname" value="testra" />
<input type="hidden" name="redirect" value="http://www.aweber.com/thankyou-coi.htm?m=text" id="redirect_ab52aa3bd5ddf4f668dab4fcc3000531" />
<input type="hidden" name="meta_adtracking" value="My_Web_Form" />
<input type="hidden" name="meta_message" value="1" />
<input type="hidden" name="meta_required" value="name,email" />
<input type="hidden" name="meta_tooltip" value="" />
<input id="awf_field-30038383" type="hidden" name="name" value="<?=com_db_output($nsRow['full_name'])?>" />
<input id="awf_field-30038384" type="hidden" name="email" value="<?=com_db_output($nsRow['email'])?>" tabindex="501"  />
</form>
<script type="text/javascript" language="javascript">
	document.frmAutoSignup.submit();
</script>
</body>
</html>
<? 

com_db_query("update ".TABLE_VIGILANT_SIGN_UP." set signup_to_aweber='Yes' where email='".$nsRow['email']."'");
}
echo 'Auto Signup Done';
 ?>