// JavaScript Document
var xmlhttp;

function StateChangeAdd(str)
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
xmlhttp.onreadystatechange=ChangeStateAdd;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangeStateAdd()
{
	if (xmlhttp.readyState==4)
	{
		document.getElementById("div_state_add").innerHTML=xmlhttp.responseText;
	}
}

function StateChangeEdit(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
  
var sval =document.getElementById(str).value;
var url="getuser.php";
url=url+"?type=EditState&q="+sval;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangeStateEdit;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangeStateEdit()
{
	if (xmlhttp.readyState==4)
	{
		document.getElementById("div_state_edit").innerHTML=xmlhttp.responseText;
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

function AddCompanyInfo(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
  
var sval =document.getElementById(str).value;
var url="getuser.php";
url=url+"?type=AddCompanyInfo&q="+sval;
url=url+"&sid="+Math.random();
document.getElementById('div_company_website').style.display='block';
xmlhttp.onreadystatechange=ChangeCompanyInfo;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangeCompanyInfo()
{
	if (xmlhttp.readyState==4)
	{
		var tot_result = xmlhttp.responseText;
		var result = tot_result.split("###");
		if(result.length > 1){
			document.getElementById("email_pattern").value=result[0];
			document.getElementById("phone").value=result[1];
			document.getElementById("company_name").value=result[2];
			document.getElementById("div_company_revenue").innerHTML=result[3];
			document.getElementById("div_company_employee").innerHTML=result[4];
			document.getElementById("div_company_industry").innerHTML=result[5];
			document.getElementById("address").value=result[6];
			document.getElementById("address2").value=result[7];
			document.getElementById("city").value=result[8];
			document.getElementById("div_country").innerHTML=result[9];
			document.getElementById("div_state_add").innerHTML=result[10];
			document.getElementById("zip_code").value=result[11];
			document.getElementById("about_company").value=result[12];
		}
		document.getElementById('div_company_website').style.display='none';
	}
}


function AddCompanyInformation(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
  
var company_id =document.getElementById(str).value;
var url="getuser.php";
url=url+"?type=CompanyInformationShow&q="+company_id;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangeCompanyInformation;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangeCompanyInformation()
{
	if (xmlhttp.readyState==4)
	{
	 document.getElementById("DivCompanyInformationShow").innerHTML=xmlhttp.responseText;
	}
}
//Company at Movement Master
function CompanyInformationMovement(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
  
var company_id =document.getElementById(str).value;
var url="getuser.php";
url=url+"?type=CompanyInformationMovementShow&q="+company_id;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangeCompanyInformationMovement;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangeCompanyInformationMovement()
{
	if (xmlhttp.readyState==4)
	{
	 document.getElementById("DivCompanyInformationMovementShow").innerHTML=xmlhttp.responseText;
	}
}
//Personal at Movement Master
function PersonalInformationMovement(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
  
var personal_id =document.getElementById(str).value;
var url="getuser.php";
url=url+"?type=PersonalInformationMovementShow&q="+personal_id;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangePersonalInformationMovement;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangePersonalInformationMovement()
{
	if (xmlhttp.readyState==4)
	{
	 document.getElementById("DivPersonalInformationMovementShow").innerHTML=xmlhttp.responseText;
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