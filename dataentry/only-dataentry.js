// JavaScript Document
function PersonalID(pid,full_name){
	document.getElementById('personal_id').value=pid;
	document.getElementById('DivPersonalCompanyNameShow').style.display="none";
	document.getElementById('first_last_name').value=full_name;
}
function CompanyID(cid,company_url){
	document.getElementById('company_id').value=cid;
	document.getElementById('DivCompanyNameShow').style.display="none";
	document.getElementById('company_url').value=company_url;
}
function PersonalInformation(pid,full_name,email,phone){
	document.getElementById('personal_id').value=pid;
	document.getElementById('DivPersonalCompanyNameShow').style.display="none";
	document.getElementById('first_last_name').value=full_name;
	document.getElementById('person_email').value=email;
	document.getElementById('person_phone').value=phone;
	document.getElementById("company_website").value='';
	document.getElementById("company_name").value='';
	document.getElementById("divComapnyLogo").innerHTML='';
	document.getElementById("leadership_page").value='';
	document.getElementById("email_pattern").value='';
	document.getElementById("address").value='';
	document.getElementById("address2").value='';
	document.getElementById("city").value='';
	document.getElementById("zip_code").value='';
	document.getElementById("phone").value='';
	document.getElementById("fax").value='';
	document.getElementById("facebook_link").value='';
	document.getElementById("linkedin_link").value='';
	document.getElementById("twitter_link").value='';
	document.getElementById("googleplush_link").value='';
}
