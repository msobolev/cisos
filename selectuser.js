// JavaScript Document
var xmlhttp;

function AddUser(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getuser.php";
url=url+"?type=Add&q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=addChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function addChanged()
{
	if (xmlhttp.readyState==4)
	{	
		var msg = xmlhttp.responseText;
		var patt1=new RegExp("the email already exists in our");

		var found = patt1.test(msg);
		if(found){
			document.getElementById('div_email_ok').style.display='none';
			document.getElementById('div_email').style.display='block';
			//document.getElementById("txtEmail").innerHTML=xmlhttp.responseText;
			document.getElementById('ok_email').value='';
		}else{
			document.getElementById('div_email').style.display='none';
			document.getElementById('div_email_ok').style.display='block';
			//document.getElementById("txtEmail").innerHTML=xmlhttp.responseText;
			document.getElementById('ok_email').value='ok';
		}
	}
}

function EditUserEmail(str,old_email)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getuser.php";
url=url+"?type=EmailEdit&q="+str+"&oldValue="+old_email;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=EditEmailChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function EditEmailChanged()
{
	if (xmlhttp.readyState==4)
	{	
		var msg = xmlhttp.responseText;
		var patt1=new RegExp("the email already exists in our");

		var found = patt1.test(msg);
		if(found){
			document.getElementById('div_email_ok').style.display='none';
			document.getElementById('div_email').style.display='block';
			document.getElementById('ok_email').value='';
		}else{
			document.getElementById('div_email').style.display='none';
			document.getElementById('div_email_ok').style.display='block';
			document.getElementById('ok_email').value='ok';
		}
	}
}

function AddUserRE(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getuser.php";
url=url+"?type=AddRE&q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=addChangedRE;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function addChangedRE()
{
	if (xmlhttp.readyState==4)
	{	
		var msg = xmlhttp.responseText;
		var patt1=new RegExp("the email already exists in our");
		var found = patt1.test(msg);
		if(found){
			document.getElementById('div_retype_mail_ok').style.display='none';
			document.getElementById('div_retype_mail').style.display='block';
			document.getElementById("div_retype_mail_err").innerHTML = 'the email already exists in our system ddd, <strong><a href="javascript:LoginPage();">loign here</a></strong>';
			document.getElementById('ok_retype_email').value='';
		}else{
			document.getElementById('div_retype_mail').style.display='none';
			document.getElementById('div_retype_mail_ok').style.display='block';
			document.getElementById('ok_retype_email').value='ok';
		}
	}
}

function EditUserRE(str,old_email)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getuser.php";
url=url+"?type=EmailEditRE&q="+str+"&oldValue="+old_email;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=EditChangedRE;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function EditChangedRE()
{
	if (xmlhttp.readyState==4)
	{	
		var msg = xmlhttp.responseText;
		var patt1=new RegExp("the email already exists in our");
		var found = patt1.test(msg);
		if(found){
			document.getElementById('div_retype_mail_ok').style.display='none';
			document.getElementById('div_retype_mail').style.display='block';
			document.getElementById("div_retype_mail_err").innerHTML = 'the email already exists in our system, <strong><a href="javascript:LoginPage();">loign here</a></strong>';
			document.getElementById('ok_retype_email').value='';
		}else{
			document.getElementById('div_retype_mail').style.display='none';
			document.getElementById('div_retype_mail_ok').style.display='block';
			document.getElementById('ok_retype_email').value='ok';
		}
	}
}

function EditUser(str,oldValue)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getuser.php";
url=url+"?type=Edit&q="+str+"&oldValue="+oldValue;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=editChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function editChanged()
{
	if (xmlhttp.readyState==4)
	{	
		var msg = xmlhttp.responseText;
		var patt1=new RegExp("the email already exists in our");
		var found = patt1.test(msg);
		if(found){
			document.getElementById('div_email_ok').style.display='none';
			document.getElementById('div_email').style.display='block';
			document.getElementById('div_email_err').style.display='block';
			document.getElementById("txtEmail").innerHTML=xmlhttp.responseText;
		}else{
			document.getElementById('div_email_err').style.display='none';
			document.getElementById('div_email').style.display='block';
			document.getElementById('div_email_ok').style.display='block';
			document.getElementById("txtEmail").innerHTML=xmlhttp.responseText;
		}
	}
}

function captchaCheck(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getuser.php";
url=url+"?type=Captcha&q="+str ;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=captchaChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function captchaChanged()
{
	if (xmlhttp.readyState==4)
	{
		var msg = xmlhttp.responseText;
		var patt1=new RegExp("the confirmation code you typed in");
		var found = patt1.test(msg);
		if(found){
			document.getElementById('div_security_code_ok').style.display='none';
			document.getElementById('div_security_code').style.display='block';
			document.getElementById("div_security_code_err").innerHTML=xmlhttp.responseText ;
			return false;
		}else{
			document.getElementById('div_security_code').style.display='none';
			document.getElementById('div_security_code_ok').style.display='block';
		}
	}
}

function LiveSearch(str)
{
var search_val = document.getElementById(str).value;
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
 if(search_val.length > 3){ 
	var url="getuser.php";
	url=url+"?type=Search&q="+search_val ;
	url=url+"&sid="+Math.random();
	xmlhttp.onreadystatechange=searchChanged;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
 }
}

function searchChanged()
{
	if (xmlhttp.readyState==4)
	{
		document.getElementById("txtLiveSearch").style.display='block';
		document.getElementById("txtLiveSearch").innerHTML=xmlhttp.responseText;
	}
}


function AddProject(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getuser.php";
url=url+"?type=AddProject&q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=addProjectChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function addProjectChanged()
{
	if (xmlhttp.readyState==4)
	{
		document.getElementById("txtProjectAdd").innerHTML=xmlhttp.responseText;
	}
}

function EditProject(str,cmodel)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getuser.php";
url=url+"?type=EditProject&q="+str + "&cmodel=" + cmodel;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=editProjectChanged;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function editProjectChanged()
{
	if (xmlhttp.readyState==4)
	{
		document.getElementById("txtProjectEdit").innerHTML=xmlhttp.responseText;
	}
}

//combo
function AddCountry(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
  
var sval =document.getElementById(str).value;
var url="getuser.php";
url=url+"?type=AddCountry&q="+sval;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangeCountry;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangeCountry()
{
	if (xmlhttp.readyState==4)
	{
		document.getElementById("div_country").style.display='block';
		document.getElementById("div_country").innerHTML=xmlhttp.responseText;
	}
}

function AddState(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
  
var sval =document.getElementById(str).value;
var url="getuser.php";
url=url+"?type=AddState&q="+sval;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangeState;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangeState()
{
	if (xmlhttp.readyState==4)
	{
		document.getElementById("div_state").style.display='block';
		document.getElementById("div_state").innerHTML=xmlhttp.responseText;
	}
}

function AddManagement(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
  
var sval =document.getElementById(str).value;
var url="getuser.php";
url=url+"?type=AddManagement&q="+sval;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangeManagement;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangeManagement()
{
	if (xmlhttp.readyState==4)
	{
		document.getElementById("div_management").style.display='block';
		document.getElementById("div_management").innerHTML=xmlhttp.responseText;
	}
}
function SignUpEmailCheck(){
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
  
	var email = document.getElementById('email').value;
	if (email== ''){
		document.getElementById('email').value='Your Email';
	}else if(email !='' && email !='Your Email'){
		var url="getuser.php";
		url=url+"?type=SignUpEmailManagement&q="+email;
		url=url+"&sid="+Math.random();
		xmlhttp.onreadystatechange=SignUpEmailStatus;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
	}
}
function SignUpEmailStatus()
{
	if (xmlhttp.readyState==4)
	{
		var msg = xmlhttp.responseText;
		var patt1=new RegExp("This email is already in use. please registration here");
		var found = patt1.test(msg);
		if(found){
			alert(msg);
			document.getElementById('email').value='';
			document.getElementById('email').focus();
			return false;
		}
	}
}
function GetXmlHttpObject()
{
if (window.XMLHttpRequest)
  {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
  }
if (window.ActiveXObject)
  {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
  }
return null;
}