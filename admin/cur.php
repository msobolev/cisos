<?PHP
require('includes/include_top.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);


if(1 == 2)
{
$email_domain = "gw.com";

$first_name_initial = "";
$middle_name_initial = "";
$last_name_initial = "";
$generated_email = "";
$fn = "faraz";
$mn = "Ch";
$ln = "aleem";
$pattern = $_GET['p'];


// First name initial, last name
// First name, dot, last name

?>
<select name="company_revenue" id="company_revenue" style="width:206px;">
							<?=selectComboBox("select pattern_id,email_pattern from  cto_email_patterns ","")?>
							<option value="Any">Any</option>
							</select>
<?PHP

if($pattern == 1 || $pattern == 9 ||  $pattern == 10 || $pattern == 12 || $pattern == 14 || $pattern == 15 || $pattern == 16 || $pattern == 17 || $pattern == 18 || $pattern == 19 || $pattern == 20 || $pattern == 24 || $pattern == 26 || $pattern == 27 || $pattern == 28)
//if(strpos($pattern,'First name initial') > -1 )
{
	$first_name_initial = substr($fn, 0, 1);
	
}
if($pattern == 5 || $pattern == 12 ||  $pattern == 27 || $pattern == 28)
//if(strpos($pattern,'initial of last name') > -1)
{
	$last_name_initial = substr($ln, 0, 1);
	
}

if($pattern == 14 || $pattern == 22 ||  $pattern == 23 || $pattern == 28)
//if(strpos($pattern,'middle name initial') > -1)
{
	$middle_name_initial = substr($mn, 0, 1);
	
}



if($pattern == 1)
{
	$generated_email = $first_name_initial.$ln;
}
elseif($pattern == 2)
{
	$generated_email = $fn.".".$ln;
}
elseif($pattern == 3)
{
	$generated_email = $fn;
}
elseif($pattern == 4)
{
	$generated_email = $fn.$last_name_initial;
}
elseif($pattern == 5)
{
	$generated_email = $fn."_".$ln;
}
elseif($pattern == 6)
{
	$generated_email = $ln;
}
elseif($pattern == 7)
{
	$generated_email = $fn.$ln;
}
elseif($pattern == 8)
{
	$generated_email = $ln.$first_name_initial;
}
elseif($pattern == 9)
{
	$generated_email =  $first_name_initial.".".$ln;
}
elseif($pattern == 10)
{
	$generated_email = $ln.".".$fn;
}
elseif($pattern == 11)
{
	$generated_email = $last_name_initial.$fn;
}
elseif($pattern == 12)
{
	$generated_email = $fn."-".$ln;
}
elseif($pattern == 13) // seems wrong in xls
{
	$generated_email = $first_name_initial.$first_name_initial.$ln;
}
elseif($pattern == 14)
{
	$generated_email = $first_name_initial.substr($fn, 0, 2);
}
elseif($pattern == 15)
{
	$generated_email = $first_name_initial.substr($fn, 0, 5);
}
elseif($pattern == 16)
{
	$generated_email = $first_name_initial.substr($fn, 0, 4);
}
elseif($pattern == 17)
{
	$generated_email = $first_name_initial.substr($fn, 0, 3);
}
elseif($pattern == 18)
{
	$generated_email = $first_name_initial.substr($fn, 0, 7);
}
elseif($pattern == 19)
{
	$generated_email = $first_name_initial.substr($fn, 0, 6);
}
elseif($pattern == 20)
{
	$generated_email = $ln."_".$fn;
}
elseif($pattern == 21)
{
	$generated_email = $fn.".".$middle_name_initial.".".$ln;
}
elseif($pattern == 22)
{
	$generated_email = $fn."_".$middle_name_initial."_".$ln;
}
elseif($pattern == 23)
{
	$generated_email = $ln.".".$first_name_initial;
}
elseif($pattern == 24)
{
	$generated_email = $ln."_".substr($fn, 0, 2);
}
elseif($pattern == 25)
{
	$generated_email =  $first_name_initial."_".$ln;
}
elseif($pattern == 26)
{
	$generated_email = $first_name_initial.$last_name_initial;
}
elseif($pattern == 27)
{
	$generated_email = $first_name_initial.$middle_name_initial.$last_name_initial;
}

$complete_email_address = $generated_email."@".$email_domain;

echo "<br>EM: ".$complete_email_address;

die();
}



if(1 == 1)
{

// test url
// https://www.ctosonthemove.com/admin/cur.php?email=faraz.aleem@nxb.com.pk

function _iscurl(){
    if(function_exists('curl_version'))
      return true;
    else 
      return false;
    }

//echo "<br>CURL Enable: "._iscurl();
//echo "<br><br><br>";


$email_verified_details = "";
$email_verified_result = "";
$email_to_check = $_GET['email'];

//open connection
$ch = curl_init();

//$url = "curl -v -X GET -H Authorization:1234567890 https://api.datavalidation.com/1.0/rt/john.doe%40example.com/";

//$url = "https://api.datavalidation.com/1.0/rt/faraz.aleem@nxb.pk/?pretty=true";
$url = "https://api.datavalidation.com/1.0/rt/".$email_to_check."/?pretty=true";

//$url = "curl --header Authorization:bearer 044a15fe3c511d8af236b21229e17550 https://api.datavalidation.com/1.0/rt/faraz.aleem@nxb.com.pk/";


// correct url
// curl --header "Authorization:bearer 044a15fe3c511d8af236b21229e17550" "https://api.datavalidation.com/1.0/rt/faraz.aleem@nxb.com.pk/"

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_HEADER, "Authorization:bearer 044a15fe3c511d8af236b21229e17550");


//$headr[] = "Authorization:bearer 044a15fe3c511d8af236b21229e17550";
//$headr[] = "Authorization:bearer 65378a7477ed556bc4489ab286b6237d";
//$headr[] = "Authorization:bearer cfbbf1b65d1b8abf4fccbed1112c03db"; // Commented on 14th juyl 2015
//$headr[] = "Authorization:bearer 3f1bd3e74c0e2a661bc6e580e925234a";

$headr[] = "Authorization:bearer 00d1ed7238b2d915738925c3688893ba";


//curl_setopt($ch, CURLOPT_HEADER, "1");
curl_setopt($ch, CURLOPT_HTTPHEADER,$headr);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//curl_setopt($ch,CURLOPT_POST, count($fields));
//curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//execute post
$result = curl_exec($ch);

//close connection
curl_close($ch);


echo "<pre>result : ";	print_r($result);	echo "</pre>";	

$email_verified_details = json_decode($result);

if($email_verified_details->grade == 'A+' || $email_verified_details->grade == 'A')
	$email_verified_result = date("m/d/Y")." - valid";
else	
	$email_verified_result = date("m/d/Y")." - undeliverable";

echo "<br><br>Result: ".$email_verified_result;
echo "<pre>JSON Result: ";	print_r($result);	echo "</pre>";


}

?>