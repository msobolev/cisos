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
    
<?PHP
$hre  = mysqli_connect("localhost","root","mycisobd123!","ctou2") or die("Database ERROR ");


//$link = mysqli_connect($server, $username, $password,$database);


//mysqli_select_db("hre2",$hre) or die ("ERROR: Database not found ");

$data_q = "SELECT * from hre_profiles where p_id = ".$_GET['i'];
//echo "<br>data_q: ".$data_q;
$data_rs = mysqli_query($hre,$data_q);
$data_row = mysqli_fetch_array($data_rs);

//echo "<pre>";print_r($data_row);    echo "</pre>";

?>    
    
    
    
    
<div class="wrapper">
    <div class="header">
        <div class="shell">
            <a href="#" class="logo">HREXECs - on the move</a>
            <h1 class="slogan">What happened in lives of your Clients and Prospects today</h1><!-- /.slogan -->
        </div><!-- /.shell -->
    </div><!-- /.header -->



    <div class="main">
        <div class="shell">
            <h1><?=$data_row['title']?></h1>

            <div class="main-inner">
                <aside class="aside">
                    <!-- <img src="css/images/profile.jpg" alt=""> -->
                    <img src="../profile_photo/<?=$data_row['personal_image']?>" alt="">
                    <a href="home.php?i=<?=$_GET['i']?>" class="btn">Email Now</a>
                </aside><!-- /.aside -->

                <div class="content content-secondary">
                    <article class="article">
                        <!-- <img src="css/images/press-release.jpg" alt="" width="687" height="433"> -->
                        <img src="../profile_photo/<?=$data_row['press_release_image']?>" alt="" width="687" height="433">
                    </article><!-- /.article -->
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

