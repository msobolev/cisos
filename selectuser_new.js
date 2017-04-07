// JavaScript Document
var xmlhttp;
//function PCIAddUser(str)
function AddUserPCI(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getuser_new.php";
url=url+"?type=Add&q="+str;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=addChangedPCI;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function addChangedPCI()
{
	if (xmlhttp.readyState==4)
	{	
		document.getElementById("div_email_status").innerHTML=xmlhttp.responseText;
		/*var msg = xmlhttp.responseText;
		var patt1=new RegExp("the email already exists in our");

		var found = patt1.test(msg);
		if(found){
			
			//
			
		}else{
			
			//document.getElementById("txtEmail").innerHTML=xmlhttp.responseText;
			
		}*/
	}
}

function EditUserEmailPCI(str,old_email)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getuser_new.php";
url=url+"?type=EmailEdit&q="+str+"&oldValue="+old_email;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=EditEmailChangedPCI;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function EditEmailChangedPCI()
{
	if (xmlhttp.readyState==4)
	{	
		document.getElementById("div_email_status").innerHTML=xmlhttp.responseText;
		/*var msg = xmlhttp.responseText;
		var patt1=new RegExp("the email already exists in our");

		var found = patt1.test(msg);
		if(found){
			
		}else{
			
		}*/
	}
}

function SignUpMailSend(email,full_name,contact_id,isPresent)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getuser_new.php";
url=url+"?type=SignUpEmailSend&email="+email+"&fname="+full_name+"&contact_id="+contact_id+"&isPresent=" + isPresent;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=SignUpMailSendChange;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function SignUpMailSendChange()
{
	if (xmlhttp.readyState==4)
	{	
		//alert('SignUpMail send');
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