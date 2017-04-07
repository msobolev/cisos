<?php
include("includes/include-top.php");

$today = date("Y-m-d");
$older= date("Y-m-d",strtotime("-14 day"));

$movements_query = "select movement_url from ".TABLE_MOVEMENT_MASTER." where announce_date >= '".$older. "' and announce_date <= '".$today."' LIMIT 0,10";
//echo "<br>movements_query: ".$movements_query;
$movementsResult = com_db_query($movements_query);
while($mRow = com_db_fetch_array($movementsResult))
{
	echo "<a href=".$mRow['movement_url'].">".$mRow['movement_url']."</a><br><br><br>";
}

?>