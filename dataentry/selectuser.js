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
function CompanyInformationMovementEdit(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
  
var company_id =document.getElementById(str).value;
var url="getuser.php";
url=url+"?type=CompanyInformationMovementShowEdit&q="+company_id;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangeCompanyInformationMovementEdit;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangeCompanyInformationMovementEdit()
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

//Person name & Company name List as popup list show
function PersonalCompanyName(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
  
var personal_name =document.getElementById(str).value;
if(document.getElementById('person_option_old').checked){
	var person =document.getElementById('person_option_old').value;
}else if(document.getElementById('person_option_new').checked){
	var person =document.getElementById('person_option_new').value;
}
var url="getuser.php";
url=url+"?type=PersonalCompanyNameShow&q="+personal_name+"&person_type="+person;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangePersonalCompanyName;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangePersonalCompanyName()
{
	if (xmlhttp.readyState==4)
	{
	 document.getElementById('DivPersonalCompanyNameShow').style.display="block";	
	 document.getElementById("DivPersonalCompanyNameShow").innerHTML=xmlhttp.responseText;
	}
}

//Company name List as popup list show
function CompanyName(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
  
var company_url =document.getElementById(str).value;
var url="getuser.php";
url=url+"?type=CompanyNameShow&q="+company_url;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangeCompanyName;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangeCompanyName()
{
	if (xmlhttp.readyState==4)
	{
	 document.getElementById('DivCompanyNameShow').style.display="block";	
	 document.getElementById("DivCompanyNameShow").innerHTML=xmlhttp.responseText;
	}
}

//Company name List as popup list show in Movement
function CompanyNameMovement(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
  
var company_url =document.getElementById(str).value;
//var url="getuser.php";
var url="onlyCompany.php";
url=url+"?type=CompanyNameShowMovement&q="+company_url;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangeCompanyNameMovement;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangeCompanyNameMovement()
{
	if (xmlhttp.readyState==4)
	{
	 document.getElementById('DivCompanyNameShowMovement').style.display="block";	
	 document.getElementById("DivCompanyNameShowMovement").innerHTML=xmlhttp.responseText;
	}
}
//Person name & Company name List as popup list show in movemoent page
function PersonalCompanyNameMovement(str)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
  
var personal_name =document.getElementById(str).value;
if(document.getElementById('person_option_old').checked){
	var person =document.getElementById('person_option_old').value;
}else if(document.getElementById('person_option_new').checked){
	var person =document.getElementById('person_option_new').value;
}
var url="getuser.php";
url=url+"?type=PersonalCompanyNameShowMovement&q="+personal_name+"&person_type="+person;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangePersonalCompanyNameMovement;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangePersonalCompanyNameMovement()
{
	if (xmlhttp.readyState==4)
	{
	var tot_result = xmlhttp.responseText;
	var result = tot_result.split("###");
		if(result.length > 1){
			document.getElementById('DivPersonalCompanyNameShow').style.display="block";	
			document.getElementById("DivPersonalCompanyNameShow").innerHTML=result[1];
		}else{
			document.getElementById('DivPersonalCompanyNameShow').style.display="none";	
		}
	}
}

//Person & Company Details for Movement Page
function PersonalCompanyInformation(pid,cid)
{
    
    populate_abt_person();
    
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
    alert ("Browser does not support HTTP Request");
    return;
    }

    var url="getuser.php";
    url=url+"?type=PersonalCompanyDetailsShow&pid="+pid+"&cid="+cid;
    url=url+"&sid="+Math.random();
    xmlhttp.onreadystatechange=ChangePersonalCompanyDetails;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
}

function ChangePersonalCompanyDetails()
{
	if (xmlhttp.readyState==4)
	{
	 var tot_result = xmlhttp.responseText;
		var result = tot_result.split("###");
		//document.getElementById('DivPersonalCompanyNameInFirstName').style.display="none";
		document.getElementById('DivPersonalCompanyNameInLastName').style.display="none";
		if(result.length > 20){
			 document.getElementById("first_name").value=result[0];
			 document.getElementById("middle_name").value=result[1];
			 document.getElementById("last_name").value=result[2];
			 document.getElementById("person_email").value=result[3];
			 document.getElementById("person_phone").value=result[4];
			 document.getElementById("divPersonPhoto").innerHTML=result[5];
			 //document.getElementById("divAboutPerson").innerHTML=result[6];
                         
                         //document.getElementById("about_person").value=result[6];
                         CKEDITOR.instances.about_person.setData(result[6]);
                         
			 document.getElementById("company_website").value=result[7];
			 document.getElementById("company_name").value=result[8];
			 document.getElementById("divComapnyLogo").innerHTML=result[9];
			 document.getElementById("div_company_revenue").innerHTML=result[10];
			 document.getElementById("div_company_employee").innerHTML=result[11];
			 document.getElementById("div_company_industry").innerHTML=result[12];
			 document.getElementById("leadership_page").value=result[13];
			 document.getElementById("email_pattern").value=result[14];
			 document.getElementById("address").value=result[15];
			 document.getElementById("address2").value=result[16];
			 document.getElementById("city").value=result[17];
			 document.getElementById("div_country").innerHTML=result[18];
			 document.getElementById("div_state").innerHTML=result[19];
			 document.getElementById("zip_code").value=result[20];
			 document.getElementById("phone").value=result[21];
			 document.getElementById("fax").value=result[22];
			 document.getElementById("divAboutCompany").innerHTML=result[23];
			 document.getElementById("facebook_link").value=result[24];
			 document.getElementById("linkedin_link").value=result[25];
			 document.getElementById("twitter_link").value=result[26];
			 document.getElementById("googleplush_link").value=result[27];
			 document.getElementById('person_facebook_link').value=result[28];
			 document.getElementById('person_linkedin_link').value=result[29];
			 document.getElementById('person_twitter_link').value=result[30];
			 document.getElementById('person_googleplush_link').value=result[31];
			 
			 PersonalDetailsShow('person_email','movement_entry');
			 
		}else{
			 document.getElementById("first_name").value='';
			 document.getElementById("middle_name").value='';
			 document.getElementById("last_name").value='';
			 document.getElementById("person_email").value='';
			 document.getElementById("person_phone").value='';
			 document.getElementById('person_facebook_link').value='';
			 document.getElementById('person_linkedin_link').value='';
			 document.getElementById('person_twitter_link').value='';
			 document.getElementById('person_googleplush_link').value='';
			 document.getElementById("divPersonPhoto").innerHTML=result[0];
			 document.getElementById("company_name").value='';
			 document.getElementById("divComapnyLogo").innerHTML=result[1];
			 document.getElementById("div_company_revenue").innerHTML=result[2];
			 document.getElementById("div_company_employee").innerHTML=result[3];
			 document.getElementById("div_company_industry").innerHTML=result[4];
			 document.getElementById("leadership_page").value='';
			 document.getElementById("email_pattern").value='';
			 document.getElementById("address").value='';
			 document.getElementById("address2").value='';
			 document.getElementById("city").value='';
			 document.getElementById("div_country").innerHTML=result[5];
			 document.getElementById("div_state").innerHTML=result[6];
			 document.getElementById("zip_code").value='';
			 document.getElementById("phone").value='';
			 document.getElementById("fax").value='';
			 document.getElementById("facebook_link").value='';
			 document.getElementById("linkedin_link").value='';
			 document.getElementById("twitter_link").value='';
			 document.getElementById("googleplush_link").value='';
		}
	}
}

//Personal data entry , already enter 
function PersonIsPresent()
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
  
var fname =document.getElementById('first_name').value;
var mname =document.getElementById('middle_name').value;
var lname =document.getElementById('last_name').value;
var url="getuser.php";
url=url+"?type=PersonNameWithCompany&fname="+fname+"&mname="+mname+"&lname="+lname;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangePersonIsPresent;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangePersonIsPresent()
{
	if (xmlhttp.readyState==4)
	{
	 document.getElementById('PersonAlreadyPresent').style.display="block";	
	 document.getElementById("PersonAlreadyPresent").innerHTML=xmlhttp.responseText;
	}
}
//Company data entry , already enter 
function CompanyIsPresent()
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var company_website =document.getElementById('company_website').value;
var url="getuser.php";
url=url+"?type=CompanyAlreadyPresent&cwebsite="+company_website;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangeCompanyIsPresent;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangeCompanyIsPresent()
{
	if (xmlhttp.readyState==4)
	{
	 document.getElementById('CompanyAlreadyPresent').style.display="block";	
	 document.getElementById("CompanyAlreadyPresent").innerHTML=xmlhttp.responseText;
	}
}

//Only Personal Information for movement page
function OnlyPersonalInformation(personal_id)
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getuser.php";
url=url+"?type=OnlyPersonalInfoShow&personal_id="+personal_id;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangeOnlyPersonalInformation;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangeOnlyPersonalInformation()
{
	if (xmlhttp.readyState==4)
	{
		var tot_result = xmlhttp.responseText;
		var result = tot_result.split("###");
		//document.getElementById('DivPersonalCompanyNameInFirstName').style.display="none";
		document.getElementById('DivPersonalCompanyNameInLastName').style.display="none";
		if(result.length > 4){
			document.getElementById('first_name').value=result[0];
			document.getElementById('middle_name').value=result[1];
			document.getElementById('last_name').value=result[2];
			document.getElementById('person_email').value=result[3];
			document.getElementById('person_phone').value=result[4];
			document.getElementById('divPersonPhoto').innerHTML=result[5];
			document.getElementById('divAboutPerson').innerHTML=result[6];
			document.getElementById('person_facebook_link').value=result[7];
			document.getElementById('person_linkedin_link').value=result[8];
			document.getElementById('person_twitter_link').value=result[9];
			document.getElementById('person_googleplush_link').value=result[10];
		}
	}
}


//Person name & Company name List as popup list show in movemoent page at Lat name
function PersonalCompanyNameMovementInLastName()
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
  
var first_name =document.getElementById('first_name').value;
var last_name =document.getElementById('last_name').value;
if(document.getElementById('person_option_old').checked){
	var person =document.getElementById('person_option_old').value;
}else if(document.getElementById('person_option_new').checked){
	var person =document.getElementById('person_option_new').value;
}
var url="getuser.php";
url=url+"?type=PersonalCompanyNameShowMovementInFisrtName&first_name="+first_name+"&last_name="+last_name+"&person_type="+person;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangePersonalCompanyNameMovementInLastName;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangePersonalCompanyNameMovementInLastName()
{
	if (xmlhttp.readyState==4)
	{
	var tot_result = xmlhttp.responseText;
	var result = tot_result.split("###");
		if(result.length > 1){
			document.getElementById('DivPersonalCompanyNameInLastName').style.display="block";	
			document.getElementById("DivPersonalCompanyNameInLastName").innerHTML=result[1];
		}else{
			document.getElementById('DivPersonalCompanyNameInLastName').style.display="none";	
		}
	}
}

//Movement URL Create
function MovementUrlCreate()
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var title =document.getElementById('title').value;  
var first_name =document.getElementById('first_name').value;
var last_name =document.getElementById('last_name').value;
var company_name =document.getElementById('company_name').value;
var company_name = company_name.replace("&","-");
var movement_type =document.getElementById('movement_type').value;
var url="getuser.php";
url=url+"?type=MovementUrlCreateShow&title="+title+"&first_name="+first_name+"&last_name="+last_name+"&company_name="+company_name+"&movement_type="+movement_type;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangeMovementUrlCreate;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangeMovementUrlCreate()
{
	if (xmlhttp.readyState==4)
	{
		var str = xmlhttp.responseText;
		document.getElementById("movement_url").value=str.trim();
	}
}

//Dublicat Movement URL Show
function DublicatMovementUrlCreate()
{
xmlhttp=GetXmlHttpObject();
if (xmlhttp==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
document.getElementById("divDublicatMovementUrl").style.display='none';  
var title =document.getElementById('title').value;  
var first_name =document.getElementById('first_name').value;
var last_name =document.getElementById('last_name').value;
var company_name =document.getElementById('company_name').value;
var movement_type =document.getElementById('movement_type').value;
var url="getuser.php";
url=url+"?type=DublicateMovementUrlShow&title="+title+"&first_name="+first_name+"&last_name="+last_name+"&company_name="+company_name+"&movement_type="+movement_type;
url=url+"&sid="+Math.random();
xmlhttp.onreadystatechange=ChangeDublicatMovementUrlCreate;
xmlhttp.open("GET",url,true);
xmlhttp.send(null);
}

function ChangeDublicatMovementUrlCreate()
{
	if (xmlhttp.readyState==4)
	{
		document.getElementById("divDublicatMovementUrl").style.display='block';
		document.getElementById("divDublicatMovementUrl").innerHTML=xmlhttp.responseText;
	}
}

function update_btn_status()
{
	var email = document.getElementById('person_email').value;  
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var email_res = re.test(email);
	if(email_res == true)
	{
		//var selected_mail_server_setting = document.getElementById("div_company_mail_server_settings").innerHTML;
		//if(selected_mail_server_setting == 'open' || selected_mail_server_setting == 'none' || selected_mail_server_setting == 'Open' || selected_mail_server_setting == 'None')
		document.getElementById("validate_email_btn").disabled = false; 
	}
	else
	{		
		document.getElementById("validate_email_btn").disabled = true; 
	}	
}

function check_new_old_domain()
{
	var enteredEmail = document.getElementById('person_email').value;
	//var currentEmail = document.getElementById('company_email_domain').value;
	var currentEmail = document.getElementById('company_email_domain').innerHTML;
	var at_pos = enteredEmail.indexOf("@");
	at_pos = at_pos+1;
	var onlyDomain = enteredEmail.substr(at_pos, enteredEmail.length);
	//alert("Current Email: "+currentEmail);
	if(currentEmail != '' && onlyDomain != currentEmail && enteredEmail != '')
	{
		var r = confirm("“Change email domain to "+onlyDomain+"?");
		if (r == true) 
		{
			xmlhttp_yes = GetXmlHttpObject();
			if (xmlhttp_yes==null)
			  {
			  alert ("Browser does not support HTTP Request");
			  return;
			  }
			//var pemail =document.getElementById(email_id).value;  
			var url="getuser.php";
			url=url+"?type=updateEmailDomain&newEmailDomain="+onlyDomain+"&currentEmailDomain="+currentEmail;
			url=url+"&sid="+Math.random();
			//console.log(url);
			xmlhttp_yes.onreadystatechange=ChangeEmailDomainShow;
			xmlhttp_yes.open("GET",url,true);
			xmlhttp_yes.send(null);
		} 
		else 
		{
			//alert("No");
		}
	}
}

//Personal Details Popup Show
function PersonalDetailsShow(email_id,call_from)
{
	check_new_old_domain();
	update_btn_status();

	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
	var pemail =document.getElementById(email_id).value;  
	var url="getuser.php";
	url=url+"?type=PersonalDetailsShow&pemail="+pemail+"&call_from="+call_from;
	url=url+"&sid="+Math.random();
	xmlhttp.onreadystatechange=ChangePersonalDetailsShow;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);



}

function ChangeEmailDomainShow()
{
	
	if (xmlhttp_yes.readyState==4)
	{
		//console.log("In response:"+xmlhttp_yes.responseText);
		var output = xmlhttp_yes.responseText;
		console.log(output);
		alert(output);
	}
}


function ChangePersonalDetailsShow()
{
	if (xmlhttp.readyState==4)
	{
		var tot_result = xmlhttp.responseText;
		var result = tot_result.split("###");
		document.getElementById("DivPersonalDetails").style.display="block";
		
		if(result[0]=='Yes'){
			document.getElementById("email_verified").checked=true;
		}else{
			document.getElementById("email_verified").checked=false;
		}
		
		document.getElementById("email_verified_date").innerHTML=result[1];
		document.getElementById("DivPersonalDetails").innerHTML=result[2];
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

function personListBoxClose(){
	//document.getElementById('DivPersonalCompanyNameInFirstName').style.display="none";
	document.getElementById('DivPersonalCompanyNameInLastName').style.display="none";
}

function  chnageButton()
{
	var entered_email_address = document.getElementById("person_email").value.length;
	//alert("Entered_email_address: "+entered_email_address);
	if(entered_email_address > 0)
	{
		//alert("With in");
		document.getElementById("validate_email_btn").disabled = false;
	}	
			
}



function generate_email()
{

	var company_email_domain = document.getElementById("company_email_domain").value;
	var first_name = document.getElementById("first_name").value;
	var middle_name = document.getElementById("middle_name").value;
	var last_name = document.getElementById("last_name").value;
	
	/*
	if(document.getElementById("company_email_pattern"))
	{
		var e = document.getElementById("company_email_pattern");
		var company_email_pattern_id = e.options[e.selectedIndex].value;
	}
	*/	
	var company_email_pattern_id = document.getElementById("company_email_pattern_id").value;
	var company_email_domain = document.getElementById("company_email_domain").innerHTML;
	
	
	if(company_email_domain == '' || first_name == '')
	{
		
		document.getElementById('DivGeneratedEmail').style.display = "block";	
		document.getElementById("DivGeneratedEmail").innerHTML = 'No record';
	}
	else
	{
		
		xmlhttp=GetXmlHttpObject();
		if (xmlhttp==null)
		{
		alert ("Browser does not support HTTP Request");
		return;
		}
		var url="getuser.php";
		url=url+"?type=GenerateEmail&email_pattern_id="+company_email_pattern_id+"&email_domain="+company_email_domain+"&first_name="+first_name+"&middle_name="+middle_name+"&last_name="+last_name;
		url=url+"&sid="+Math.random();
		console.log("URL: "+url);
		xmlhttp.onreadystatechange=ShowGeneratedEmail;
		xmlhttp.open("GET",url,true);
		xmlhttp.send(null);
	}	
}

function ShowGeneratedEmail()
{
    if (xmlhttp.readyState==4)
    {

        document.getElementById("person_email").value = xmlhttp.responseText.trim();
        //var mss = document.getElementById("mail_server_settings");
        //var mss_val = mss.options[mss.selectedIndex].value;


        var mss = document.getElementById("div_company_mail_server_settings").innerHTML;

        // Ebabling validate email button immediately
        document.getElementById("validate_email_btn").disabled = false; 

        //if(mss_val != 'accept all')
        //	document.getElementById("validate_email_btn").disabled = false; 

    }
}

function validate_email()
{ 

    var validate_res = document.getElementById("DivValidatedEmail").innerHTML;
    //alert("Validate res : "+validate_res);
    var accept_all_pos = validate_res.indexOf("accept all");
    var unknown_pos = validate_res.indexOf("unknown");


    var person_email = document.getElementById("person_email").value;

    //var atSign = person_email.indexOf("@");
    //var dotSign = person_email.indexOf(".");

    //var showCofirm = 0;
    //if(atSign < 1 || dotSign < 0)
    //    showCofirm = 1;

    //if(atSign > 1 && dotSign > 0)
   // if(showCofirm == 1)
    //{
       
    //    var r = confirm("“is the email entered correctly?");
    //}
        //if((showCofirm == 1 && r == true) || (showCofirm == 0))
       // {
        var first_name = document.getElementById("first_name").value;
        var middle_name = document.getElementById("middle_name").value;
        var last_name = document.getElementById("last_name").value;
        var company_email_domain = document.getElementById("company_email_domain").value;
        //alert("Company_email_domain: "+company_email_domain);
        //if(typeofcompany_email_domain == '')
        if (typeof company_email_domain == "undefined")
        {
            company_email_domain = document.getElementById("company_email_domain").innerHTML;
            //alert("Company_email_domain2: "+company_email_domain);
        }    
        var company_website = document.getElementById("company_website").value;
        var selected_mail_pattern = document.getElementById("div_company_email_pattern").innerHTML;	
        var selected_mail_pattern_id = document.getElementById("company_email_pattern_id").value;

        if(person_email == '')
        {

            document.getElementById('DivValidatedEmail').style.display = "inline";	
            document.getElementById("DivValidatedEmail").innerHTML = 'No record';
        }
        else
        {
            var selected_mail_server_settings = document.getElementById("div_company_mail_server_settings").innerHTML;
            selected_mail_server_settings = 'accept all'; // Hardcodding so that it sends buyside email only
            if(selected_mail_server_settings == 'accept all' || (accept_all_pos) > -1 || (unknown_pos) > -1) // Sending executive email
            {
                document.getElementById('validation_wait').style.display='block';
                var entered_person_email = document.getElementById("person_email").value;
                var url="getuser.php";
                url=url+"?type=SendExecutiveEmail&entered_person_email="+entered_person_email+"&sid="+Math.random();
                console.log("ELSE URL: "+url);
                xmlhttp.onreadystatechange=ShowEmailSendResponse;
                xmlhttp.open("GET",url,true);
                xmlhttp.send(null);

            }
            else
            {
                xmlhttp=GetXmlHttpObject();
                if (xmlhttp==null)
                {
                    alert ("Browser does not support HTTP Request");
                    return;
                }
                // https://www.ctosonthemove.com/dataentry/getuser.php?type=ValidateEmail&person_email=faraz.aleem@nxb.com.pk&first_name=faraz&middle_name=&last_name=aleem&email_domain=nxb.com.pk&email_pattern=First%20name,%20dot,%20last%20name&company_website=www.faraztestc.com&email_pattern_id=2&sid=0.4422281130682677

                var url="getuser.php";
                url=url+"?type=ValidateEmail&person_email="+person_email+"&first_name="+first_name+"&middle_name="+middle_name+"&last_name="+last_name+"&email_domain="+company_email_domain+"&email_pattern="+selected_mail_pattern+"&company_website="+company_website+"&email_pattern_id="+selected_mail_pattern_id;
                url=url+"&sid="+Math.random();
                console.log("ELSE URL: "+url);
                document.getElementById('DivValidatedEmail').innerHTML = '';
                document.getElementById('validation_wait').style.display='block';
                xmlhttp.onreadystatechange=ShowValidatedEmail;
                xmlhttp.open("GET",url,true);
                xmlhttp.send(null);
            }	
        }
        //}    
}

function ShowEmailSendResponse()
{
    if (xmlhttp.readyState==4)
    {
        console.log("Email Resp: "+xmlhttp.responseText);
        document.getElementById('DivValidatedEmail').style.display="inline";	
        document.getElementById("DivValidatedEmail").innerHTML=xmlhttp.responseText;

        if(xmlhttp.responseText.indexOf("Executive Email Send") > -1)
                document.getElementById("executiveEmailSend").value = "1";

        if(document.getElementById('validation_wait').style.display == 'block')
                document.getElementById('validation_wait').style.display = 'none';


    }
}	




function ShowValidatedEmail()
{
    if (xmlhttp.readyState==4)
    {
        document.getElementById('DivValidatedEmail').style.display="inline";	
        document.getElementById("DivValidatedEmail").innerHTML=xmlhttp.responseText;
        //alert("FAR UNDO Resp TEXT: "+xmlhttp.responseText);

        if(xmlhttp.responseText.indexOf(" valid") > -1)  //  || (xmlhttp.responseText.indexOf("unknown") > -1)
        {
            document.getElementById("email_verified").checked = true;
           //ShowEmailVerifiedDate();
        }
        else
        if(xmlhttp.responseText.indexOf(" invalid") > -1)  //  || (xmlhttp.responseText.indexOf("unknown") > -1)
        {
            
            
            var cur_email_pattern = document.getElementById('div_company_email_pattern').innerHTML;
            
            if(cur_email_pattern == '')
            {
                document.getElementById('validate_email_btn').style.display="none";
                document.getElementById('another_pattern_btn').style.display="inline";
                //ShowEmailVerifiedDate();
            }    
        }
        else
        {
               //ShowEmailVerifiedDate();
        }
        document.getElementById('validation_wait').style.display='none';
    }
}




function buysideTiggerOnOff()
{
	if(document.getElementById('buyside_job').checked){
		document.getElementById('divBuysideWebsiteTigger').style.display="block";
	}else{
		document.getElementById('divBuysideWebsiteTigger').style.display="none";
	}
}


function ExecutiveJobTiggerOnOff()
{ 
	if(document.getElementById('buyside_job').checked){ 
		document.getElementById('divBuysideWebsiteTigger').style.display="block";
	}else{
		document.getElementById('divBuysideWebsiteTigger').style.display="none";
	}
}

			
			
function addFunding() { 
  var fi = document.getElementById('myFundingDiv');
  var numf = document.getElementById('theFundingValue');
  var num_funding = (document.getElementById("theFundingValue").value -1)+ 2;
  numf.value = num_funding;
  var divIdName = "my"+num_funding+"FundingDiv";
  var newdiv = document.createElement('div');
  //var pdt = 'post_date'+num_funding;
  var pdt = 'funding_date'+num_funding;
  newdiv.setAttribute("id",divIdName);
  newdiv.innerHTML = "<table border='0' width='100%' cellpadding='2' cellspacing='2'><tr><td class='page-text'>Date:</td><td><input type='text' name='funding_date[]' id=" + pdt + " value=''>&nbsp;<a href=\"javascript:NewCssCal('"+pdt+"','mmddyyyy','arrow')\"><img src=\"images/calender-icon.gif\" alt='' width='22' height='14' border='0'/></a></td></tr><tr><td width='25%' class='page-text'>Amount:</td><td width='75%'><input type='text' name='funding_amount[]'></td></tr><tr><td class='page-text'>Source:</td><td><input type='text' name='funding_source[]' value=''></td></tr><tr><td>&nbsp;</td><td><a href=\"javascript:;\" onclick=\"removeFundingElement(\'"+divIdName+"\')\">Remove the above Funding?</a></td></tr></table>";
  fi.appendChild(newdiv);
}			
			
function removeFundingElement(divNum) {
  var d = document.getElementById('myFundingDiv');
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
}

function fundingTiggerOnOff(){
	if(document.getElementById('demo_email_funding').checked){
		document.getElementById('divFundingWebsiteTigger').style.display="block";
	}else{
		document.getElementById('divFundingWebsiteTigger').style.display="none";
	}
}

			
			
			
function CompanySearch(){
	//window.location ='company.php?action=CompanySearch';
	window.location ='company_search.php?action=CompanySearch';
}



function addEvent() {
  var ni = document.getElementById('myDiv');
  var numi = document.getElementById('theValue');
  var num = (document.getElementById("theValue").value -1)+ 2;
  numi.value = num;
  var divIdName = "my"+num+"Div";
  var newdiv = document.createElement('div');
  var pdt = 'post_date'+num;
  newdiv.setAttribute("id",divIdName);
  newdiv.innerHTML = "<table border='0' width='100%' cellpadding='2' cellspacing='2'><tr><td width='25%' class='page-text'>Job Title:</td><td width='75%'><input type='text' name='job_title[]'></td></tr><tr><td class='page-text'>Posted Date:</td><td><input type='text' name='post_date[]' id=" + pdt + " value=''>&nbsp;<a href=\"javascript:NewCssCal('"+pdt+"','mmddyyyy','arrow')\"><img src=\"images/calender-icon.gif\" alt='' width='22' height='14' border='0'/></a></td></tr><tr><td class='page-text'>Location:</td><td><input type='text' name='location[]' value=''></td></tr><tr><td class='page-text'>Source:</td><td><input type='text' name='source[]' value=''></td></tr><tr><td valign='top' class='page-text'>Description:</td><td><textarea name='description[]' id='description' cols='23' rows='5'></textarea></td></tr><tr><td>&nbsp;</td><td><a href=\"javascript:;\" onclick=\"removeElement(\'"+divIdName+"\')\">Remove the above Job?</a></td></tr></table>";
  ni.appendChild(newdiv);
}

function removeElement(divNum) {
  var d = document.getElementById('myDiv');
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
}


function removeFundingElement(divNum) {
  var d = document.getElementById('myFundingDiv');
  var olddiv = document.getElementById(divNum);
  d.removeChild(olddiv);
}




function show_mul_www()
{
	$("#multiple_websites").show();
}

function show_fields(inp_val_0,inp_val_1,inp_val_2,inp_val_3,inp_val_4)
{ 
	$("#multiple_websites_form").empty();
	var e = document.getElementById("num_of_www");
	var num_of_www = e.options[e.selectedIndex].text;
	//alert("Num www: "+num_of_www);
	for (i = 0; i < num_of_www; i++) 
	{
		if(i == 0) { field_val = ''; if(inp_val_0 != '') field_val = inp_val_0; } 
		else
		if(i == 1) { field_val = ''; if(inp_val_1 != '') field_val = inp_val_1; } 
		else
		if(i == 2) { field_val = ''; if(inp_val_2 != '') field_val = inp_val_2; } 
		else
		if(i == 3) { field_val = ''; if(inp_val_3 != '') field_val = inp_val_3; }
		else
		if(i == 4) { field_val = ''; if(inp_val_4 != '') field_val = inp_val_4; } 		
		if(field_val != '')
			$("#multiple_websites_form").append('<div class=page-text style=margin-top:10px;>Enter secondary website: <input value='+field_val+' type="text" name="secondary_websites[]"/></div>');
		else	
			$("#multiple_websites_form").append('<div class=page-text style=margin-top:10px;>Enter secondary website: <input type="text" name="secondary_websites[]"/></div>');
	}
}


function another_pattern()
{
    
    var first_name = document.getElementById("first_name").value;
    var middle_name = document.getElementById("middle_name").value;
    var last_name = document.getElementById("last_name").value;
    var company_email_domain = document.getElementById("company_email_domain").innerHTML;
    var company_website = document.getElementById("company_website").value;
    var selected_mail_pattern = document.getElementById("div_company_email_pattern").innerHTML;	
    var selected_mail_pattern_id = document.getElementById("company_email_pattern_id").value;
    
    var person_email = document.getElementById("person_email").value;
    
    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null)
    {
            alert ("Browser does not support HTTP Request");
            return;
    }
    // https://www.ctosonthemove.com/dataentry/getuser.php?type=ValidateEmail&person_email=faraz.aleem@nxb.com.pk&first_name=faraz&middle_name=&last_name=aleem&email_domain=nxb.com.pk&email_pattern=First%20name,%20dot,%20last%20name&company_website=www.faraztestc.com&email_pattern_id=2&sid=0.4422281130682677

    var url="getuser.php";
    url=url+"?type=enteredPattern&person_email="+person_email+"&first_name="+first_name+"&middle_name="+middle_name+"&last_name="+last_name+"&email_domain="+company_email_domain+"&email_pattern="+selected_mail_pattern+"&company_website="+company_website+"&email_pattern_id="+selected_mail_pattern_id;
    url=url+"&sid="+Math.random();
    console.log("ELSE URL: "+url);
    //return false;
    document.getElementById('DivValidatedEmail').innerHTML = '';
    document.getElementById('validation_wait').style.display='block';
    xmlhttp.onreadystatechange=recursivePattern;
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
    
    
    
}

function recursivePattern()
{
    if (xmlhttp.readyState==4)
    {
	 document.getElementById('DivValidatedEmail').style.display="inline";	
	 document.getElementById("DivValidatedEmail").innerHTML=xmlhttp.responseText;
         document.getElementById('validation_wait').style.display='none';
    }     
}


function chk_form_Add(){ 
    
    
    var submit_val = 1;
    $('input[name="job_title[]"]').each(function()
    {
        if($(this).val())
        {
            var e_job_site = document.getElementById("job_site");
            var selected_job_site = e_job_site.options[e_job_site.selectedIndex].value;
            if(selected_job_site == '')
            {
                submit_val = 0;
            }    
            //alert(selected_job_site);
        }    
    });
    
    if(submit_val == 0)
    {
        alert("Please select job site.");
        document.getElementById('job_site').focus();
        return false;
    }    
    
    
	var fname=document.getElementById('company_website').value;
	if(fname==''){
		alert("Please enter company website name.");
		document.getElementById('company_website').focus();
		return false;
	}
	
	if(fname.indexOf("http://") > -1)
	{
		alert("Format of company website should be www.domainname.com.");
		document.getElementById('company_website').focus();
		return false;
	}
	
}
function JobTiggerOnOff(){
	if(document.getElementById('demo_job').checked){
		document.getElementById('divWebsiteTigger').style.display="block";
	}else{
		document.getElementById('divWebsiteTigger').style.display="none";
	}
}


function chk_form(){  
    var cwebsite = document.getElementById('company_website').value;
    var cedomain = document.getElementById('hidden_email_domain').value;
	//alert("Cwebsite: "+cwebsite);
	
    
    var submit_val = 1;
    $('input[name="job_title[]"]').each(function()
    {
        if($(this).val())
        {
            var e_job_site = document.getElementById("job_site");
            var selected_job_site = e_job_site.options[e_job_site.selectedIndex].value;
            if(selected_job_site == '')
            {
                submit_val = 0;
            }    
            //alert(selected_job_site);
        }    
    });
    
    if(submit_val == 0)
    {
        alert("Please select job site.");
        document.getElementById('job_site').focus();
        return false;
    }  
    
        if(cwebsite==''){
		alert("Please enter company website name.");
		document.getElementById('company_website').focus();
		return false;
	}
        else
        {
            var e_fp = document.getElementById("personalForFunding");
            var selected_funding_personal_id = e_fp.options[e_fp.selectedIndex].value;
            //alert(selected_funding_personal_id);
            //return false;
            if(selected_funding_personal_id != '')
            {
                var selsite = 'HR';
                xmlhttp=GetXmlHttpObject();
                if (xmlhttp==null)
                {
                    alert ("Browser does not support HTTP Request");
                    return;
                }

                //var sval =document.getElementById(str).value;
                var url="getuser.php";
                url=url+"?type=SetFundingUser&site="+selsite+"&selected_funding_personal_id="+selected_funding_personal_id+"&company_domain="+cedomain;
                url=url+"&sid="+Math.random();
                console.log("URL: "+url); 
                xmlhttp.onreadystatechange=SetFundingUserAfter;
                xmlhttp.open("GET",url,true);
                xmlhttp.send(null);
            
            
            }    
                     
        }    
}

function SetFundingUserAfter()
{
    if (xmlhttp.readyState==4)
    {
        //alert("RESP:"+xmlhttp.responseText);
        document.getElementById("divFundingPersonal").innerHTML = xmlhttp.responseText;
    }
}


function populate_abt_person()
{
    
    var first_name = document.getElementById("first_name").value;
    var last_name = document.getElementById("last_name").value;
    var title = document.getElementById("title").value;
    var company_name = document.getElementById("company_name").innerHTML;
    
    //alert("First_name: "+first_name);
    //alert("Lirst_name: "+last_name);
    //alert("Title: "+title);
    //alert("Company_name: "+company_name);
    
    
    if(first_name != '' && last_name != '' && title != '' && company_name != '')
    {
        //alert("within setting");
        
        var abt_text_current = CKEDITOR.instances.about_person.getData();
        
        if(abt_text_current == '')
        {   
            var site = 'HR';
            title = title.toLowerCase();
            if(title.indexOf("ciso") > -1 || title.indexOf("chief information security officer") > -1 || title.indexOf("information security") > -1 || title.indexOf("cyber security") > -1 || title.indexOf("technology security") > -1 || title.indexOf("it security") > -1)
                site = 'Information Security';
            
            var abt_text = first_name+' '+last_name+' is '+title+' at '+company_name+'. Previously, '+first_name+' held various senior '+site+' leadership roles in the industry.';
            CKEDITOR.instances.about_person.insertText(abt_text); 
        }
        
        
        //document.getElementById("about_person").value = 'held various senior HR leadership roles in the industry.';
    
        var company_email_domain = document.getElementById("company_email_domain").innerHTML;
        var last_name = document.getElementById("last_name").value;
        var company_email_pattern_id = document.getElementById("company_email_pattern_id").value;
        
        if(company_email_domain != '' && company_email_pattern_id != '')
        {
            xmlhttp=GetXmlHttpObject();
            if (xmlhttp==null)
            {
                    alert ("Browser does not support HTTP Request");
                    return;
            }
            var url="getuser.php";
            url=url+"?type=OnlyGenerateEmailAddress&first_name="+first_name+"&middle_name="+middle_name+"&last_name="+last_name+"&email_domain="+company_email_domain+"&email_pattern="+company_email_pattern_id;
            url=url+"&sid="+Math.random();
            console.log("ELSE URL: "+url);
            //return false;
            xmlhttp.onreadystatechange=UpdateEmailField;
            xmlhttp.open("GET",url,true);
            xmlhttp.send(null);
        }    
        
    }    
    
}


function UpdateEmailField()
{
    if (xmlhttp.readyState==4)
    {
        //alert("Res: "+xmlhttp.responseText);
        if(xmlhttp.responseText != '')
        {
            var generated_email_address = xmlhttp.responseText;
            generated_email_address = generated_email_address.trim();
            
            var current_email_address = document.getElementById("person_email").value;
            if(current_email_address == '')
            {    
                document.getElementById("person_email").value = generated_email_address;
                document.getElementById("person_email").style.backgroundColor = "yellow";
            }    
        }    
	 //document.getElementById('DivValidatedEmail').style.display="inline";	
	 //document.getElementById("DivValidatedEmail").innerHTML=xmlhttp.responseText;
         //document.getElementById('validation_wait').style.display='none';
    }     
}