// JavaScript Document
var xmlhttpnew;

//Company at Movement Master
function CompanyInformationMovement(cid)
{
xmlhttpnew=GetXmlHttpObject();
if (xmlhttpnew==null)
  {
  alert ("Browser does not support HTTP Request");
  return;
  }
var url="getuser.php";
url=url+"?type=CompanyInformationMovementShow&q="+cid;
url=url+"&sid="+Math.random();
//console.log("URL:  "+url);
document.getElementById('DivGeneratedEmail').style.display='none';

document.getElementById('DivCompanyNameShowMovement').style.display='none';
document.getElementById('div_company_website').style.display='block';
xmlhttpnew.onreadystatechange=ChangeCompanyInformationMovement;
xmlhttpnew.open("GET",url,true);
xmlhttpnew.send(null);
}

function ChangeCompanyInformationMovement()
{
	if (xmlhttpnew.readyState==4)
	{
	 	var tot_result = xmlhttpnew.responseText;
		var result = tot_result.split("###");
		//alert("Result ELEVEN: "+result[11]);
		if(result.length > 6){ 
			 document.getElementById("company_website").value=result[0];	
			 document.getElementById("company_name").innerHTML=result[1];
			 //alert("Res Company Name: "+result[1]);
			 //alert("Company Name DIV VALUE AFTER INNER HTML: "+document.getElementById("company_name").value);
			// return false;
			 
			 document.getElementById("divComapnyLogo").innerHTML=result[2];
			 document.getElementById("div_company_revenue").innerHTML=result[3];
			 document.getElementById("div_company_employee").innerHTML=result[4];
			 document.getElementById("div_company_industry").innerHTML=result[5];
			 //alert("Leadership page Res 6: "+result[6]);
			 //alert("Div inner value before setting: "+document.getElementById("leadership_page").innerHTML);
			 document.getElementById("leadership_page").innerHTML=result[6];
			 //alert("Div inner value after setting: "+document.getElementById("leadership_page").innerHTML);
			 //document.getElementById("email_pattern").value=result[7];
			 document.getElementById("address").innerHTML=result[8];
			 document.getElementById("address2").innerHTML=result[9];
			 document.getElementById("city").innerHTML=result[10];
			 document.getElementById("div_country").innerHTML=result[11];
			// alert("DIV VALUE AFTER INNER HTML: "+document.getElementById("div_country").innerHTML);
			
			 document.getElementById("div_state").innerHTML=result[12];
			 document.getElementById("zip_code").innerHTML=result[13];
			 document.getElementById("phone").innerHTML=result[14];
			 document.getElementById("person_phone").innerHTML=result[14];
			 document.getElementById("fax").innerHTML=result[15];
			 document.getElementById("divAboutCompany").innerHTML=result[16];
			 document.getElementById("facebook_link").innerHTML=result[17];
			 document.getElementById("linkedin_link").innerHTML=result[18];
			 document.getElementById("twitter_link").innerHTML=result[19];
			 document.getElementById("googleplush_link").innerHTML=result[20];
			 document.getElementById("company_email_domain").innerHTML=result[21];
			 document.getElementById("div_company_email_pattern").innerHTML=result[22];
			 document.getElementById("div_company_mail_server_settings").innerHTML=result[23];
			 document.getElementById("company_email_pattern_id").value=result[24];
                         
                         
                        populate_abt_person();

                        //alert("Result 14: "+result[14]);
                        if(result[14] != '')
                        {
                            var person_phone = document.getElementById("person_phone").value;
                            //alert("Person phone: "+person_phone);
                            if(person_phone == '')
                                document.getElementById("person_phone").value = result[14];
                        } 
                         
                         
                         
			 //alert("Result 24: "+result[24]);
			 //alert("Result 24: "+result[24]);
				//var e_this = document.getElementById("company_email_pattern");
				//if(e_this.options[e_this.selectedIndex].value)
				//{
					//var this_company_email_pattern_id = e_this.options[e_this.selectedIndex].value;
					//if(this_company_email_pattern_id != 'none')
					//if(document.getElementById("div_company_email_pattern").innerHTML != '')
					//{
                                        if(result[21] != '' && result[22] != '')
                                        {    
						document.getElementById("generate_email_btn").disabled = false; 
						var entered_email = document.getElementById("person_email").value.length;
						//alert(entered_email); return;
						if(entered_email > 0)
						{
							document.getElementById("validate_email_btn").disabled = false; 
						}
                                        }	
						
					//}	
					//else	
					//	document.getElementById("generate_email_btn").disabled = true; 
				//}	
			 //if(result[22] != '')
			//	document.getElementById("generate_email_btn").disabled = false; 
		}else{ 
			 document.getElementById("company_website").value='';
			 document.getElementById("company_name").value='';
			 document.getElementById("divComapnyLogo").innerHTML=result[0];
			 document.getElementById("div_company_revenue").innerHTML=result[1];
			 document.getElementById("div_company_employee").innerHTML=result[2];
			 document.getElementById("div_company_industry").innerHTML=result[3];
			 document.getElementById("leadership_page").value='';
			 document.getElementById("email_pattern").value='';
			 document.getElementById("address").value='';
			 document.getElementById("address2").value='';
			 document.getElementById("city").value='';
			 document.getElementById("div_country").innerHTML=result[4];
			 document.getElementById("div_state").innerHTML=result[5];
			 document.getElementById("zip_code").value='';
			 document.getElementById("phone").value='';
			 document.getElementById("fax").value='';
			 document.getElementById("facebook_link").value='';
			 document.getElementById("linkedin_link").value='';
			 document.getElementById("twitter_link").value='';
			 document.getElementById("googleplush_link").value='';
		}
		document.getElementById('DivCompanyNameShowMovement').style.display='none';
		if(document.getElementById('DivCompanyNameShowMovement').style.display=='block'){
		document.getElementById('DivCompanyNameShowMovement').style.display='none';
		}
		 
		document.getElementById('div_company_website').style.display='none';
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