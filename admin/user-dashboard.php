<?php
require('includes/include_top.php');
$total_active_user = com_db_GetValue("select count(user_id) from ".TABLE_USER." where status=0");
//Active User Login
$login_user_today = com_db_GetValue("select count(distinct(h.user_id)) from " . TABLE_LOGIN_HISTORY." h, ".TABLE_USER." u where h.user_id=u.user_id and u.status=0 and h.add_date='".date("Y-m-d")."'");
$login_user_lastweek = com_db_GetValue("select count(distinct(h.user_id)) from " . TABLE_LOGIN_HISTORY." h, ".TABLE_USER." u where h.user_id=u.user_id and u.status=0 and h.add_date <='".date("Y-m-d")."' and h.add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-6,date("Y")))."'");
$login_user_lastmonth = com_db_GetValue("select count(distinct(h.user_id)) from " . TABLE_LOGIN_HISTORY." h, ".TABLE_USER." u where h.user_id=u.user_id and u.status=0 and h.add_date<='".date("Y-m-d")."' and h.add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y")))."'");

$login_user_today_in = $total_active_user - $login_user_today;
$login_user_lastweek_in = $total_active_user - $login_user_lastweek;
$login_user_lastmonth_in = $total_active_user - $login_user_lastmonth;

//Active User Search
$search_user_today = com_db_GetValue("select count(distinct(h.user_id)) from " . TABLE_SEARCH_HISTORY." h, ".TABLE_USER." u where h.user_id=u.user_id and u.status=0 and h.add_date='".date("Y-m-d")."'");
$search_user_lastweek = com_db_GetValue("select count(distinct(h.user_id)) from " . TABLE_SEARCH_HISTORY." h, ".TABLE_USER." u where h.user_id=u.user_id and u.status=0 and h.add_date <='".date("Y-m-d")."' and h.add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-6,date("Y")))."'");
$search_user_lastmonth = com_db_GetValue("select count(distinct(h.user_id)) from " . TABLE_SEARCH_HISTORY." h, ".TABLE_USER." u where h.user_id=u.user_id and u.status=0 and h.add_date<='".date("Y-m-d")."' and h.add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y")))."'");

$search_user_today_in = $total_active_user - $search_user_today;
$search_user_lastweek_in = $total_active_user - $search_user_lastweek;
$search_user_lastmonth_in = $total_active_user - $search_user_lastmonth;

//Active User Download
$download_user_today = com_db_GetValue("select count(distinct(d.user_id)) from " . TABLE_DOWNLOAD." d, ".TABLE_USER." u where d.user_id=u.user_id and u.status=0 and d.add_date='".date("Y-m-d")."'");
$download_user_lastweek = com_db_GetValue("select count(distinct(d.user_id)) from " . TABLE_DOWNLOAD." d, ".TABLE_USER." u where d.user_id=u.user_id and u.status=0 and d.add_date <='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-6,date("Y")))."'");
$download_user_lastmonth = com_db_GetValue("select count(distinct(d.user_id)) from " . TABLE_DOWNLOAD." d, ".TABLE_USER." u where d.user_id=u.user_id and u.status=0 and d.add_date<='".date("Y-m-d")."' and add_date>='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y")))."'");

$download_user_today_in = $total_active_user - $download_user_today;
$download_user_lastweek_in = $total_active_user - $download_user_lastweek;
$download_user_lastmonth_in = $total_active_user - $download_user_lastmonth;

$TodaySendAlert = com_db_GetValue("select count(distinct(asi.user_id)) from " . TABLE_ALERT_SEND_INFO." asi, ".TABLE_USER." u where u.user_id=asi.user_id and DATE_FORMAT(FROM_UNIXTIME(`sent_date`), '%Y-%m-%d')='".date("Y-m-d")."'");
$LastweekSendAlert = com_db_GetValue("select count(distinct(asi.user_id)) from " . TABLE_ALERT_SEND_INFO." asi, ".TABLE_USER." u where u.user_id=asi.user_id and DATE_FORMAT(FROM_UNIXTIME(`sent_date`), '%Y-%m-%d') <='".date("Y-m-d")."' and DATE_FORMAT(FROM_UNIXTIME(`sent_date`), '%Y-%m-%d') >='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-6,date("Y")))."'");
$LastmonthSendAlert = com_db_GetValue("select count(distinct(asi.user_id)) from " . TABLE_ALERT_SEND_INFO." asi, ".TABLE_USER." u where u.user_id=asi.user_id and DATE_FORMAT(FROM_UNIXTIME(`sent_date`), '%Y-%m-%d') <='".date("Y-m-d")."' and DATE_FORMAT(FROM_UNIXTIME(`sent_date`), '%Y-%m-%d') >='".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y")))."'");


include("includes/header.php");
?>
 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF">
	<table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="center" valign="top">
        <script src="jquery.min.js" type="text/javascript"></script>
		<style type="text/css">
			.showhide{display:none;}
		</style>
       
        <script type="text/javascript">
		$(document).ready(function(){
		 $('#hrefLoginToday').on('click', function() {// This event fires when a button is clicked
			  $('#divLoginToday').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=LoginTodayUser&loginToday=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divLoginToday').html(''); // Clear #divLoginLastweek div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="1%">Sl.</td><td width="35%">Name</td><td width="43%">Email</td><td width="21%">Password</td></td>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="4">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td>'+sln+'</td><td>'+data.name[i] +'</td><td>' + data.email[i] + '</td><td>'+data.password[i] + '</td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divLoginToday').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //LoginToday 
		  
		 $('#hrefLoginLastweek').on('click', function() {// This event fires when a button is clicked
			  $('#divLoginLastweek').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=LoginLastweekUser&loginLastweek=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divLoginLastweek').html(''); // Clear #divLoginLastweek div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="1%">Sl.</td><td width="35%">Name</td><td width="43%">Email</td><td width="21%">Password</td></td>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="4">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td>'+sln+'</td><td>'+data.name[i] +'</td><td>' + data.email[i] + '</td><td>'+data.password[i] + '</td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divLoginLastweek').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //LoginLastweek 
		  
		  $('#hrefLoginLastmonth').on('click', function() {// This event fires when a button is clicked
			  $('#divLoginLastmonth').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=LoginLastmonthUser&loginLastmonth=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divLoginLastmonth').html(''); // Clear #divLoginLastweek div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="1%">Sl.</td><td width="35%">Name</td><td width="43%">Email</td><td width="21%">Password</td></td>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="4">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td>'+sln+'</td><td>'+data.name[i] +'</td><td>' + data.email[i] + '</td><td>'+data.password[i] + '</td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divLoginLastmonth').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //LoginLastmonth
		  
		  $('#hrefSearchToday').on('click', function() {// This event fires when a button is clicked
			  $('#divSearchToday').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=SearchToday&search_user_today=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divSearchToday').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="1%">Sl.</td><td width="20%">Name</td><td width="">Search Infromation</td></tr>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td valign="top">'+sln+'</td><td valign="top">'+data.name[i] +'</td><td valign="top">' + data.searchinfo[i] + '</td></tr>'; 
								htmlcode += '<tr><td colspan="3" style="line-height:10px;"></td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divSearchToday').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //SearchToday
		  
		  $('#hrefSearchLastweek').on('click', function() {// This event fires when a button is clicked
			  $('#divSearchLastweek').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=SearchLastweek&search_user_lastweek=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divSearchLastweek').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="1%">Sl.</td><td width="20%">Name</td><td width="">Search Infromation</td></tr>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td valign="top">'+sln+'</td><td valign="top">'+data.name[i] +'</td><td valign="top">' + data.searchinfo[i] + '</td></tr>'; 
								htmlcode += '<tr><td colspan="3" style="line-height:10px;"></td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divSearchLastweek').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //SearchLastweek
		  
		  $('#hrefSearchLastmonth').on('click', function() {// This event fires when a button is clicked
			  $('#divSearchLastmonth').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=SearchLastmonth&search_user_lastmonth=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divSearchLastmonth').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="1%">Sl.</td><td width="20%">Name</td><td width="">Search Infromation</td></tr>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td valign="top">'+sln+'</td><td valign="top">'+data.name[i] +'</td><td valign="top">' + data.searchinfo[i] + '</td></tr>'; 
								htmlcode += '<tr><td colspan="3" style="line-height:10px;"></td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divSearchLastmonth').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //SearchLastmonth
		  
		  $('#hrefDownloadToday').on('click', function() {// This event fires when a button is clicked
			  $('#divDownloadToday').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=DownloadToday&download_user_today=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divDownloadToday').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="1%">Sl.</td><td width="30%">Name</td><td width="">Download Infromation</td></tr>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td valign="top">'+sln+'</td><td valign="top">'+data.name[i] +'</td><td valign="top">' + data.downloadinfo[i] + '</td></tr>'; 
								htmlcode += '<tr><td colspan="3" style="line-height:10px;"></td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divDownloadToday').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //SearchToday
		  
		  $('#hrefDownloadLastweek').on('click', function() {// This event fires when a button is clicked
			  $('#divDownloadLastweek').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=DownloadLastweek&download_user_lastweek=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divDownloadLastweek').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="1%">Sl.</td><td width="30%">Name</td><td width="">Download Infromation</td></tr>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td valign="top">'+sln+'</td><td valign="top">'+data.name[i] +'</td><td valign="top">' + data.downloadinfo[i] + '</td></tr>'; 
								htmlcode += '<tr><td colspan="3" style="line-height:10px;"></td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divDownloadLastweek').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //DownloadLastweek
		  
		  $('#hrefDownloadLastmonth').on('click', function() {// This event fires when a button is clicked
			  $('#divDownloadLastmonth').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=DownloadLastmonth&download_user_lastmonth=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divDownloadLastmonth').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="1%">Sl.</td><td width="30%">Name</td><td width="">Download Infromation</td></tr>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td valign="top">'+sln+'</td><td valign="top">'+data.name[i] +'</td><td valign="top">' + data.downloadinfo[i] + '</td></tr>'; 
								htmlcode += '<tr><td colspan="3" style="line-height:10px;"></td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divDownloadLastmonth').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //DownloadLastmonth	
		  
		  
		  //Inactive user
		  
		  $('#hrefLoginTodayIn').on('click', function() {// This event fires when a button is clicked
			  $('#divLoginTodayIn').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=LoginTodayUserIn&loginTodayIn=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divLoginTodayIn').html(''); // Clear #divLoginLastweek div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="2%">Sl.</td><td width="40%">Name</td><td width="58%">Email</td></td>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td>'+sln+'</td><td>'+data.name[i] +'</td><td>' + data.email[i] + '</td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divLoginTodayIn').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //LoginTodayInactive 
		  
		  $('#hrefLoginLastweekIn').on('click', function() {// This event fires when a button is clicked
			  $('#divLoginLastweekIn').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=LoginLastweekUserIn&loginLastweekIn=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divLoginLastweekIn').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="2%">Sl.</td><td width="40%">Name</td><td width="58%">Email</td></td>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td>'+sln+'</td><td>'+data.name[i] +'</td><td>' + data.email[i] + '</td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divLoginLastweekIn').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //LoginLastweekInactive 
		  
		  $('#hrefLoginLastmonthIn').on('click', function() {// This event fires when a button is clicked
			  $('#divLoginLastmonthIn').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=LoginLastmonthUserIn&loginLastmonthIn=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divLoginLastmonthIn').html(''); // Clear #divLoginLastweek div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="2%">Sl.</td><td width="40%">Name</td><td width="58%">Email</td></td>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td>'+sln+'</td><td>'+data.name[i] +'</td><td>' + data.email[i] + '</td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divLoginLastmonthIn').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //LoginLastmonthInactive 
		 
		 $('#hrefSearchTodayIn').on('click', function() {// This event fires when a button is clicked
			  $('#divSearchTodayIn').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=SearchTodayIn&search_user_today_in=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divSearchTodayIn').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="2%">Sl.</td><td width="40%">Name</td><td width="58%">Email</td></td>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td>'+sln+'</td><td>'+data.name[i] +'</td><td>' + data.email[i] + '</td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divSearchTodayIn').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //SearchToday inactive
		  
		  $('#hrefSearchLastweekIn').on('click', function() {// This event fires when a button is clicked
			  $('#divSearchLastweekIn').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=SearchLastweekIn&search_user_lastweek_in=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divSearchLastweekIn').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="2%">Sl.</td><td width="40%">Name</td><td width="58%">Email</td></td>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td>'+sln+'</td><td>'+data.name[i] +'</td><td>' + data.email[i] + '</td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divSearchLastweekIn').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //SearchLastweek inactive
		  
		  $('#hrefSearchLastmonthIn').on('click', function() {// This event fires when a button is clicked
			  $('#divSearchLastmonthIn').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=SearchLastmonthIn&search_user_lastmonth_in=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divSearchLastmonthIn').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="2%">Sl.</td><td width="40%">Name</td><td width="58%">Email</td></td>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td>'+sln+'</td><td>'+data.name[i] +'</td><td>' + data.email[i] + '</td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divSearchLastmonthIn').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //SearchLastmonth inactive
		   
		  $('#hrefDownloadTodayIn').on('click', function() {// This event fires when a button is clicked
			  $('#divDownloadTodayIn').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=DownloadTodayIn&download_user_today_in=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divDownloadTodayIn').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="2%">Sl.</td><td width="40%">Name</td><td width="58%">Email</td></td>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td>'+sln+'</td><td>'+data.name[i] +'</td><td>' + data.email[i] + '</td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divDownloadTodayIn').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //DownloadToday inactive
		  
		  $('#hrefDownloadLastweekIn').on('click', function() {// This event fires when a button is clicked
			  $('#divDownloadLastweekIn').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=DownloadLastweekIn&download_user_lastweek_in=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divDownloadLastweekIn').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="2%">Sl.</td><td width="40%">Name</td><td width="58%">Email</td></td>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td>'+sln+'</td><td>'+data.name[i] +'</td><td>' + data.email[i] + '</td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divDownloadLastweekIn').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //DownloadLastweek inactive
		  
		  $('#hrefDownloadLastmonthIn').on('click', function() {// This event fires when a button is clicked
			  $('#divDownloadLastmonthIn').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=DownloadLastmonthIn&download_user_lastmonth_in=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divDownloadLastmonthIn').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="2%">Sl.</td><td width="40%">Name</td><td width="58%">Email</td></td>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td>'+sln+'</td><td>'+data.name[i] +'</td><td>' + data.email[i] + '</td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divDownloadLastmonthIn').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //DownloadLastmonth inactive
		  	
		//Alert Popup
		$('#hrefTodayAlert').on('click', function() {// This event fires when a button is clicked
			  $('#divTodayAlert').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=TodayAlertSend&user_today_alert=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divTodayAlert').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="2%" valign="top">Sl.</td><td width="23%" valign="top">Name</td><td width="75%" valign="top">Alert Send Date</td></td>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td>'+sln+'</td><td>'+data.name[i] +'</td><td>' + data.email[i] + '</td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divTodayAlert').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //Today Alert
		  
		  $('#hrefLastweekAlert').on('click', function() {// This event fires when a button is clicked
			  $('#divLastweekAlert').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=LastweekAlertSend&user_lastweek_alert=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divLastweekAlert').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="2%" valign="top">Sl.</td><td width="23%" valign="top">Name</td><td width="75%" valign="top">Alert Send Date</td></td>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td valign="top">'+sln+'</td><td valign="top">'+data.name[i] +'</td><td valign="top">' + data.email[i] + '</td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divLastweekAlert').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //Lastweek Alert
		  
		  $('#hrefLastmonthAlert').on('click', function() {// This event fires when a button is clicked
			  $('#divLastmonthAlert').toggleClass("showhide");
			  $.ajax({ // ajax call starts
				  url: 'serverside.php', // JQuery loads serverside.php
				  data: 'action=LastmonthAlertSend&user_lastmonth_alert=' + $(this).text(), // Send value of the clicked button
				  dataType: 'json', // Choosing a JSON datatype
				  success: function(data) // Variable data contains the data we get from serverside
				  {
					   $('#divLastmonthAlert').html(''); // Clear div
					   var htmlcode  = '<table width="100%" border="0" cellpadding="2" cellspacing="2"><tr bgcolor="#666666"><td width="2%" valign="top">Sl.</td><td width="23%" valign="top">Name</td><td width="75%" valign="top">Alert Send Date</td></td>';
					   var sln =0;
					   if(data.error){
						   htmlcode += '<tr><td colspan="3">'+data.error + '</td></tr>'; 
					   }else{
						   for (var i in data.name) {
								sln++;  
								htmlcode += '<tr><td  valign="top">'+sln+'</td><td  valign="top">'+data.name[i] +'</td><td  valign="top">' + data.email[i] + '</td></tr>';  
						   }
					   }
					   htmlcode +='</table>';
					   $('#divLastmonthAlert').append(htmlcode);
				  }
			  });
			  return false; // keeps the page from not refreshing 
		  }); //Lastmonth Alert
		  		
		});
		</script>
      
        <table width="760" border="0" align="center" cellpadding="2" cellspacing="2">
          <tr>
              <td align="left" colspan="3" valign="top"><b style="font-size:24px;">User Dashboard</b></td>
          </tr>
          <tr>
            <td width="33%"><div class="userInfo">Logins:</div></td>
            <td width="33%"><div class="userInfo">Searches:</div></td>
            <td width="33%"><div class="userInfo">Downloads:</div></td>
          </tr>
          <tr>
            <td align="left" colspan="3" valign="top" style="height:8px;"></td>
          </tr>
          <tr>
            <td align="left" valign="top">
            	<div class="userInfoResult">
                	<table width="90%" align="center" border="0" cellpadding="2" cellspacing="2">
                    	<tr>
                        	<td>Today:</td>
                            <td align="right">
                                <a href="javascript:;" id="hrefLoginToday"><?=$login_user_today;?></a>
                                <div id="divLoginToday" class="popDivUserResult showhide">
                                	<br />
                                	<p align="center"><img src="images/ajax-loader.gif" /></p>
                                </div>
                            </td>
                       </tr>     
                       <tr>
                        	<td>Last Week:</td>
                            <td align="right">
                            	<a href="javascript:;" id="hrefLoginLastweek"><?=$login_user_lastweek;?></a>
                                <div id="divLoginLastweek" class="popDivUserResult showhide">
                                	<br />
                                	<p align="center"><img src="images/ajax-loader.gif" /></p>
                                </div>
                            </td>
                       </tr> 
                       <tr>
                        	<td>Last Month:</td>
                            <td align="right">
								<a href="javascript:;" id="hrefLoginLastmonth"><?=$login_user_lastmonth?></a>
                                <div id="divLoginLastmonth" class="popDivUserResult showhide">
                                	<br />
                                	<p align="center"><img src="images/ajax-loader.gif" /></p>
                                </div>
                            </td>
                       </tr>    
                    </table>
                </div>
            </td>
            <td align="left" valign="top">
            	<div class="userInfoResult">
                	<table width="90%" align="center" border="0" cellpadding="2" cellspacing="2">
                    	<tr>
                        	<td>Today:</td>
                            <td align="right">
							<a href="javascript:;" id="hrefSearchToday"><?=$search_user_today?></a>
                            <div id="divSearchToday" class="popDivUserSearchResult showhide">
                                <br />
                                <p align="center"><img src="images/ajax-loader.gif" /></p>
                            </div>
                            </td>
                       </tr>     
                       <tr>
                        	<td>Last Week:</td>
                            <td align="right">
                            <a href="javascript:;" id="hrefSearchLastweek"><?=$search_user_lastweek?></a>
                            <div id="divSearchLastweek" class="popDivUserSearchResult showhide">
                                <br />
                                <p align="center"><img src="images/ajax-loader.gif" /></p>
                            </div>
                            </td>
                       </tr> 
                       <tr>
                        	<td>Last Month:</td>
                            <td align="right">
                            <a href="javascript:;" id="hrefSearchLastmonth"><?=$search_user_lastmonth?></a>
                            <div id="divSearchLastmonth" class="popDivUserSearchResult showhide">
                                <br />
                                <p align="center"><img src="images/ajax-loader.gif" /></p>
                            </div>
                            </td>
                       </tr>    
                    </table>
                </div>
            </td>
            <td align="left" valign="top">
            	<div class="userInfoResult">
                	<table width="90%" align="center" border="0" cellpadding="2" cellspacing="2">
                    	<tr>
                        	<td>Today:</td>
                            <td align="right">
							<a href="javascript:;" id="hrefDownloadToday"><?=$download_user_today?></a>
                            <div id="divDownloadToday" class="popDivUserDownloadResult showhide">
                                <br />
                                <p align="center"><img src="images/ajax-loader.gif" /></p>
                            </div>
                            </td>
                       </tr>     
                       <tr>
                        	<td>Last Week:</td>
                            <td align="right">
                            <a href="javascript:;" id="hrefDownloadLastweek"><?=$download_user_lastweek?></a>
                            <div id="divDownloadLastweek" class="popDivUserDownloadResult showhide">
                                <br />
                                <p align="center"><img src="images/ajax-loader.gif" /></p>
                            </div>
                            </td>
                       </tr> 
                       <tr>
                        	<td>Last Month:</td>
                            <td align="right">
                            <a href="javascript:;" id="hrefDownloadLastmonth"><?=$download_user_lastmonth?></a>
                            <div id="divDownloadLastmonth" class="popDivUserDownloadResult showhide">
                                <br />
                                <p align="center"><img src="images/ajax-loader.gif" /></p>
                            </div>
                            </td>
                       </tr>    
                    </table>
                </div>
            </td>
          </tr>
          
          <tr>
            <td align="left" colspan="3" valign="top" style="height:8px;"></td>
          </tr>
          <tr>
            <td width="33%"><div class="userInfo">Inactives (no logins):</div></td>
            <td width="33%"><div class="userInfo">Inactives (no searches):</div></td>
            <td width="33%"><div class="userInfo">Inactives (no downloads):</div></td>
          </tr>
          <tr>
            <td align="left" colspan="3" valign="top" style="height:8px;"></td>
          </tr>
          <tr>
            <td align="left" valign="top">
            	<div class="userInfoResult">
                	<table width="90%" align="center" border="0" cellpadding="2" cellspacing="2">
                    	<tr>
                        	<td>Today:</td>
                            <td align="right">
                                <a href="javascript:;" id="hrefLoginTodayIn"><?=$login_user_today_in;?></a>
                                <div id="divLoginTodayIn" class="popDivUserResult showhide">
                                	<br />
                                	<p align="center"><img src="images/ajax-loader.gif" /></p>
                                </div>
                            </td>
                       </tr>     
                       <tr>
                        	<td>Last Week:</td>
                            <td align="right">
                            	<a href="javascript:;" id="hrefLoginLastweekIn"><?=$login_user_lastweek_in;?></a>
                                <div id="divLoginLastweekIn" class="popDivUserResult showhide">
                                	<br />
                                	<p align="center"><img src="images/ajax-loader.gif" /></p>
                                </div>
                            </td>
                       </tr> 
                       <tr>
                        	<td>Last Month:</td>
                            <td align="right">
								<a href="javascript:;" id="hrefLoginLastmonthIn"><?=$login_user_lastmonth_in?></a>
                                <div id="divLoginLastmonthIn" class="popDivUserResult showhide">
                                	<br />
                                	<p align="center"><img src="images/ajax-loader.gif" /></p>
                                </div>
                            </td>
                       </tr>    
                    </table>
                </div>
            </td>
            <td align="left" valign="top">
            	<div class="userInfoResult">
                	<table width="90%" align="center" border="0" cellpadding="2" cellspacing="2">
                    	<tr>
                        	<td>Today:</td>
                            <td align="right">
							<a href="javascript:;" id="hrefSearchTodayIn"><?=$search_user_today_in?></a>
                            <div id="divSearchTodayIn" class="popDivUserSearchResultInactive showhide">
                                <br />
                                <p align="center"><img src="images/ajax-loader.gif" /></p>
                            </div>
                            </td>
                       </tr>     
                       <tr>
                        	<td>Last Week:</td>
                            <td align="right">
                            <a href="javascript:;" id="hrefSearchLastweekIn"><?=$search_user_lastweek_in?></a>
                            <div id="divSearchLastweekIn" class="popDivUserSearchResultInactive showhide">
                                <br />
                                <p align="center"><img src="images/ajax-loader.gif" /></p>
                            </div>
                            </td>
                       </tr> 
                       <tr>
                        	<td>Last Month:</td>
                            <td align="right">
                            <a href="javascript:;" id="hrefSearchLastmonthIn"><?=$search_user_lastmonth_in?></a>
                            <div id="divSearchLastmonthIn" class="popDivUserSearchResultInactive showhide">
                                <br />
                                <p align="center"><img src="images/ajax-loader.gif" /></p>
                            </div>
                            </td>
                       </tr>    
                    </table>
                </div>
            </td>
            <td align="left" valign="top">
            	<div class="userInfoResult">
                	<table width="90%" align="center" border="0" cellpadding="2" cellspacing="2">
                    	<tr>
                        	<td>Today:</td>
                            <td align="right">
							<a href="javascript:;" id="hrefDownloadTodayIn"><?=$download_user_today_in?></a>
                            <div id="divDownloadTodayIn" class="popDivUserDownloadResult showhide">
                                <br />
                                <p align="center"><img src="images/ajax-loader.gif" /></p>
                            </div>
                            </td>
                       </tr>     
                       <tr>
                        	<td>Last Week:</td>
                            <td align="right">
                            <a href="javascript:;" id="hrefDownloadLastweekIn"><?=$download_user_lastweek_in?></a>
                            <div id="divDownloadLastweekIn" class="popDivUserDownloadResult showhide">
                                <br />
                                <p align="center"><img src="images/ajax-loader.gif" /></p>
                            </div>
                            </td>
                       </tr> 
                       <tr>
                        	<td>Last Month:</td>
                            <td align="right">
                            <a href="javascript:;" id="hrefDownloadLastmonthIn"><?=$download_user_lastmonth_in?></a>
                            <div id="divDownloadLastmonthIn" class="popDivUserDownloadResult showhide">
                                <br />
                                <p align="center"><img src="images/ajax-loader.gif" /></p>
                            </div>
                            </td>
                       </tr>    
                    </table>
                </div>
            </td>
          </tr>
          <tr>
            <td align="left" colspan="3" valign="top" style="height:8px;"></td>
          </tr>
          <tr>
            <td colspan="3"><div class="userInfo">Send Alert Information</div></td>
          </tr>
          <tr>
            <td width="33%">
            	<div class="userInfoResult">
                	<table width="90%" align="center" border="0" cellpadding="2" cellspacing="2">
                    	<tr>
                        	<td>Today:</td>
                            <td align="right">
							<a href="javascript:;" id="hrefTodayAlert"><?=$TodaySendAlert?></a>
                            <div id="divTodayAlert" class="popDivUserAlertEmailSend showhide">
                                <br />
                                <p align="center"><img src="images/ajax-loader.gif" /></p>
                            </div>
                            </td>
                       </tr>     
                    </table>
                </div>
            </td>
            <td width="33%">
            	<div class="userInfoResult">
                	<table width="90%" align="center" border="0" cellpadding="2" cellspacing="2">
                    	<tr>
                        	<td>Last Week:</td>
                            <td align="right">
							<a href="javascript:;" id="hrefLastweekAlert"><?=$LastweekSendAlert?></a>
                            <div id="divLastweekAlert" class="popDivUserAlertEmailSend showhide">
                                <br />
                                <p align="center"><img src="images/ajax-loader.gif" /></p>
                            </div>
                            </td>
                       </tr>     
                    </table>
                </div>
            </td>
            <td width="33%">
            	<div class="userInfoResult">
                	<table width="90%" align="center" border="0" cellpadding="2" cellspacing="2">
                    	<tr>
                        	<td>Last Month:</td>
                            <td align="right">
							<a href="javascript:;" id="hrefLastmonthAlert"><?=$LastmonthSendAlert?></a>
                            <div id="divLastmonthAlert" class="popDivUserAlertEmailSend showhide">
                                <br />
                                <p align="center"><img src="images/ajax-loader.gif" /></p>
                            </div>
                            </td>
                       </tr>     
                    </table>
                </div>
            </td>
          </tr>
        </table></td>
      </tr>
    </table>
	</td>
  </tr>
<?php
include("includes/footer.php");
?>