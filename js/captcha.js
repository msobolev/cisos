// JavaScript Document
var url = 'captcheck.php?code=';
 var captchaOK = 2; 
 // 2 - not yet checked, 1 - correct, 0 - failed 
 function getHTTPObject()
  { 
  try { 
  req = new XMLHttpRequest(); 
  } catch (err1) 
  { 
  try { 
  eq = new ActiveXObject("Msxml12.XMLHTTP");
  } catch (err2) 
  { 
  try { 
  req = new ActiveXObject("Microsoft.XMLHTTP"); 
  } catch (err3) 
  { req = false; 
  } } } 
  return req; 
  } 
  
  var http = getHTTPObject(); // We create the HTTP Object
  function handleHttpResponse() 
  { 
	if (http.readyState == 4) { 
	  captchaOK = http.responseText; 
	  if(captchaOK != 1) {
		 alert('The entered code was not correct. Please try again');
		 document.myform.code.value=''; 
		 document.myform.code.focus(); 
		 return false; 
		} 
		document.myform.submit(); 
	} 
  }
   
function checkcode(thecode) 
{ 
	http.open("GET", url + thecode, true); 
	http.onreadystatechange = handleHttpResponse;
	http.send(null); 
} 
function checkform() 
{ 
	 var flname=document.getElementById('flname').value;	
	 if(flname==''){
		alert("Please enter your name.");
		document.getElementById('flname').focus();
		return false;
	 }
	 
	var email=document.getElementById('email').value;	
	 if(email==''){
		alert("Please enter email.");
		document.getElementById('email').focus();
		return false;
	 }
	 var regExpr=new RegExp("^([a-zA-Z0-9_.-]+[@][a-zA-Z]+[.](([a-z]{3})|([a-z]{2}[.][a-z]{2})))+$");
	 if(!email.match(regExpr)){
		alert("Please enter valid email.");	
		document.getElementById('email').focus();
		return false;	
	 }
	 var msg=document.getElementById('msg').value;	
	 if(msg==''){
		alert("Please enter message.");
		document.getElementById('msg').focus();
		return false;
	 }
	checkcode(document.myform.securitycode.value); 
	return false; 
 } 