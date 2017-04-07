<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset="utf-8" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>CISOs</title>

	<link rel="shortcut icon" type="image/x-icon" href="css/images/favicon.ico" />

	<!-- Vendor Styles -->

	<!-- App Styles -->
	<link rel="stylesheet" href="css/style.css" />

	<!-- Vendor JS -->
	<script src="vendor/jquery-1.12.4.min.js"></script>

	<!-- App JS -->
	<script src="js/functions.js"></script>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <div class="shell">
            <a href="#" class="logo">HREXECs - on the move</a>
            <h1 class="slogan">What happened in lives of your Clients and Prospects today</h1><!-- /.slogan -->
        </div><!-- /.shell -->
    </div><!-- /.header -->
<?PHP
$hre  = mysqli_connect("localhost","root","mycisobd123!","ctou2") or die("Database ERROR ");
//mysql_select_db("hre2",$hre) or die ("ERROR: Database not found ");

$data_q = "SELECT * from hre_profiles where p_id = ".$_GET['i'];

$data_rs = mysqli_query($hre,$data_q);
$data_row = mysqli_fetch_array($data_rs);
$email = $data_row['email'];

$init_p = strpos($email,'@');
//echo "<br>init_p: ".$init_p;
//die();
$domain = substr($email,$init_p,strlen($email));
$first = substr($email,0,1);

$obf = $first."###".$domain;
?>

<script language="javascript">
var xmlhttp;
function store_db()
{
    //var to = $('#field-to').val());
    //xmlhttp=GetXmlHttpObject();
    
    
    /*
    xmlhttp = new XMLHttpRequest();
    
    if (xmlhttp==null)
    {
        alert ("Browser does not support HTTP Request");
        return;
    }
  
    var to = document.getElementById('field-to').value;
    var from_name = document.getElementById('field-from').value;
    var res = to.replace("###", "```");
    alert("TO BEF: "+to);
        
    var url="store.php";
    url = url+"?to="+to+"&from_name="+from_name;
    url = url+"&sid="+Math.random();
    console.log(url);
    xmlhttp.onreadystatechange = showRes;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
    */
   
   
   
   
   
    var to = document.getElementById('email_hidden').value;
    //to = 'testto';
    var from_name = document.getElementById('field-from').value;
    var from_email = document.getElementById('field-from2').value;
    
    if(from_name == '' || from_email == '')
    {
        alert("Your Name and Email fields are mandatory");
        preventDefault();
        return false;
    }    
    
    var url = "store.php";
    var params = "to="+to+"&from_name="+from_name+"&from_email="+from_email;
    console.log(url+"?"+params);
    var http = new XMLHttpRequest();

    http.open("GET", url+"?"+params, true);
    http.onreadystatechange = function()
    {
        if(http.readyState == 4 && http.status == 200) 
        {
            //alert(http.responseText);
            if(http.responseText == '1')
            {
                alert("Email is banned");
            }
            else
            {    
                window.location.href = "mailto:"+to+"?subject=congrats on your appointment";
                setTimeout(function() { your_func(); }, 3000);
            }
        }
    }
    http.send(null);
}

function your_func()
{
    //alert("delay");
    window.location.href = 'http://www.cisosonthemove.com/pricing.html';
}



function showRes()
{
    if (xmlhttp.readyState==4)
    {
        //alert("RES: "+xmlhttp.responseText);
            //document.getElementById("div_state_add").innerHTML=xmlhttp.responseText;
    }
}



</script>    
<input type="hidden" name="email_hidden" id="email_hidden" value="<?=$email?>" >    
    
    
    <div class="main">
        <div class="shell">
            <h1><?=$data_row['title']?></h1>

            <div class="main-inner">
                <aside class="aside">
                    <img src="../profile_photo/<?=$data_row['personal_image']?>" alt="">
                </aside><!-- /.aside -->

                <div class="content">
                    <div class="form-email">
                        <!-- <form action="?" method="post"> -->
                            <div class="form-body">
                                <div class="form-row">
                                    <label for="field-from" class="form-label">From:</label>

                                    <div class="form-controls">
                                        <input type="text" class="field field-italic" name="field-from" id="field-from" value="" placeholder="Type Your Name">
                                        <input type="text" class="field field-italic" name="field-from2" id="field-from2" value="" placeholder="Type Your Work Email" style="padding-left:10px;">
                                    </div><!-- /.form-controls -->
                                </div><!-- /.form-row -->

                                <div class="form-row">
                                    <label for="field-to" class="form-label">To:</label>
                                    <div class="form-controls">
                                        <input type="text" class="field" name="field-to" id="field-to" value="<?=$obf?>"> <!-- placeholder="Billie.Hartless@polycom.com" -->  
                                    </div><!-- /.form-controls -->
                                </div><!-- /.form-row -->

                                <div class="form-row">
                                    <label for="field-re" class="form-label">Re:</label>
                                    <div class="form-controls">
                                        <input type="text" class="field" name="field-re" id="field-re" value="" placeholder="Congrats on your appointment!">
                                    </div><!-- /.form-controls -->
                                </div><!-- /.form-row -->
                            </div><!-- /.form-body -->

                            <div class="form-actions">
                                <a onclick="store_db()" target="_top"> <!--  href="mailto:<?=$email?>?subject=congrats on your appointment" -->
                                    <button class="btn">Next <i class="ico-arrow-right"></i></button>
                                </a>    
                            </div><!-- /.form-actions -->
                        <!-- </form> -->
                    </div><!-- /.form-email -->
                </div><!-- /.content -->
            </div><!-- /.main-inner -->
        </div><!-- /.shell -->
    </div><!-- /.main -->

    <div class="footer">
        <div class="shell">
            <ul class="footer-nav">
                <li>
                    <a href="http://www.cisosonthemove.com/privacy-policy.html">Privacy</a>
                </li>
                <li>
                    <a href="http://www.cisosonthemove.com/terms-use.html">Terms of Use</a>
                </li>
                <li>
                    CISOs On The Move &copy; 2017
                </li>
            </ul><!-- /.footer-nav -->
        </div><!-- /.shell -->
    </div><!-- /.footer -->
</div><!-- /.wrapper -->
</body>
</html>

