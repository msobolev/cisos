function SignUpValidation(){var fname=document.getElementById('full_name').value;if(fname==''||fname=='Your Name'){document.getElementById('full_name').focus();return false;}
var email=document.getElementById('email').value;if(email==''||email=='Your Email'){document.getElementById('email').focus();return false;}}
function SearchSelectResult(serch_val){document.getElementById('txtsearch').value=serch_val;document.getElementById('txtLiveSearch').style.display='none';document.getElementById('frmSearch').submit();}
function FormValueSubmit(frmID){document.getElementById(frmID).submit();}
function question_mark_show(div_id){document.getElementById(div_id).style.display='block';}
function question_mark_close(div_id){document.getElementById(div_id).style.display='none';}
function FieldValidation(field_name){if(field_name=='first_name'){var fname=document.getElementById('first_name').value;if(fname==''||fname=='Type in the first name'){document.getElementById('div_first_name_ok').style.display='none';document.getElementById('div_first_name').style.display='block';document.getElementById('ok_first_name').value='';return false;}else{document.getElementById('div_first_name').style.display='none';document.getElementById('div_first_name_ok').style.display='block';document.getElementById('ok_first_name').value='ok';}}
if(field_name=='last_name'){var lname=document.getElementById('last_name').value;if(lname==''||lname=='Type in the last name'){document.getElementById('div_last_name_ok').style.display='none';document.getElementById('div_last_name').style.display='block';document.getElementById('ok_last_name').value='';return false;}else{document.getElementById('div_last_name_ok').style.display='block';document.getElementById('div_last_name').style.display='none';document.getElementById('ok_last_name').value='ok';}}
if(field_name=='company_name'){var cname=document.getElementById('company_name').value;if(cname==''||cname=='Type in the Company Name'){document.getElementById('div_company_name_ok').style.display='none';document.getElementById('div_company_name').style.display='block';document.getElementById('ok_company_name').value='';return false;}else{document.getElementById('div_company_name').style.display='none';document.getElementById('div_company_name_ok').style.display='block';document.getElementById('ok_company_name').value='ok';}}
/*if(field_name=='email'){var email=document.getElementById('email').value;if(email==''||email=='Type in the email'){document.getElementById('div_email_ok').style.display='none';document.getElementById('div_email').style.display='block';document.getElementById('ok_email').value='';return false;}else{var reg=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;if(reg.test(email)==false){document.getElementById('div_email').style.display='block';document.getElementById('div_email_ok').style.display='none';document.getElementById('div_email_err').innerHTML="Please verify  the email syntax format and try again";document.getElementById('ok_email').value='';return false;}else{AddUser(email);}}}
if(field_name=='retype_email'){var remail=document.getElementById('retype_email').value;var email=document.getElementById('email').value;if(remail==''||email!=remail){document.getElementById('div_retype_mail_ok').style.display='none';document.getElementById('div_retype_mail').style.display='block';document.getElementById('ok_retype_email').value='';document.getElementById('div_retype_mail_err').innerHTML='The email doesn’t match the one you typed in previously, please try again';return false;}else{AddUserRE(remail);}}
*/
if(field_name=='password'){var password=document.getElementById('password').value;if(password==''){document.getElementById('div_password_ok').style.display='none';document.getElementById('div_password').style.display='block';document.getElementById('ok_password').value='';return false;}else{document.getElementById('div_password').style.display='none';document.getElementById('div_password_ok').style.display='block';document.getElementById('ok_password').value='ok';}}
if(field_name=='retype_password'){var rpassword=document.getElementById('retype_password').value;var password=document.getElementById('password').value;if(rpassword==''||(rpassword!=password)){document.getElementById('div_retype_password_ok').style.display='none';document.getElementById('div_retype_password').style.display='block';document.getElementById('ok_retype_password').value='';return false;}else{document.getElementById('div_retype_password').style.display='none';document.getElementById('div_retype_password_ok').style.display='block';document.getElementById('ok_retype_password').value='ok';}}
if(field_name=='security_code'){var scode=document.getElementById('security_code').value;if(scode==''||scode=='Type in the confirmation code'){document.getElementById('div_security_code_ok').style.display='none';document.getElementById('div_security_code').style.display='block';document.getElementById('ok_security_code').value='';return false;}else{document.getElementById('div_security_code').style.display='none';document.getElementById('div_security_code_ok').style.display='block';document.getElementById('ok_security_code').value='ok';captchaCheck(scode);}}
if(field_name=='accept'){var acc=document.getElementById('accept').checked;if(!acc){document.getElementById('div_accept_ok').style.display='none';document.getElementById('div_accept').style.display='block';document.getElementById('ok_accept').value='';return false;}else{document.getElementById('div_accept').style.display='none';document.getElementById('div_accept_ok').style.display='block';document.getElementById('ok_accept').value='ok';}}
if((document.getElementById('ok_first_name').value=="ok")&&(document.getElementById('ok_last_name').value=="ok")&&(document.getElementById('ok_company_name').value=="ok")&&(document.getElementById('ok_email').value=="ok")&&(document.getElementById('ok_retype_email').value=="ok")&&(document.getElementById('ok_password').value=="ok")&&(document.getElementById('ok_retype_password').value=="ok")&&(document.getElementById('ok_security_code').value=="ok")&&(document.getElementById('ok_accept').value=="ok")){document.getElementById('div_pci_next_ok').style.display='block';document.getElementById('div_pci_next').style.display='none';}else{document.getElementById('div_pci_next_ok').style.display='none';document.getElementById('div_pci_next').style.display='block';}}
function pviValidation(){var fname=document.getElementById('first_name').value;if(fname==''||(fname=='Type in the first name')){document.getElementById('div_first_name_ok').style.display='none';document.getElementById('div_first_name').style.display='block';document.getElementById('ok_first_name').value='';document.getElementById('first_name').focus();return false;}else{document.getElementById('ok_first_name').value='ok';}
var lname=document.getElementById('last_name').value;if(lname==''||lname=='Type in the last name'){document.getElementById('div_last_name_ok').style.display='none';document.getElementById('div_last_name').style.display='block';document.getElementById('ok_last_name').value='';document.getElementById('last_name').focus();return false;}else{document.getElementById('ok_last_name').value='ok';}
var cname=document.getElementById('company_name').value;if(cname==''||(cname=='Type in the Company Name')){document.getElementById('div_company_name_ok').style.display='none';document.getElementById('div_company_name').style.display='block';document.getElementById('ok_company_name').value='';document.getElementById('company_name').focus();return false;}else{document.getElementById('ok_company_name').value='ok';}
var email=document.getElementById('email').value;if(email==''||email=='Type in the email'){document.getElementById('div_email_ok').style.display='none';document.getElementById('div_email').style.display='block';document.getElementById('ok_email').value='';return false;}else{document.getElementById('ok_email').value='ok';}
var remail=document.getElementById('retype_email').value;var email=document.getElementById('email').value;if(remail==''||email!=remail||remail=='re-type your email'){document.getElementById('div_remail_ok').style.display='none';document.getElementById('div_remail').style.display='block';document.getElementById('ok_retype_email').value='';return false;}else{document.getElementById('ok_retype_email').value='';}
var password=document.getElementById('password').value;if(password==''){document.getElementById('div_password_ok').style.display='none';document.getElementById('div_password').style.display='block';return false;}
var rpassword=document.getElementById('retype_password').value;var password=document.getElementById('password').value;if(rpassword==''||(rpassword!=password)){document.getElementById('div_retype_password_ok').style.display='none';document.getElementById('div_retype_password').style.display='block';return false;}
var scode=document.getElementById('security_code').value;if(scode==''||scode=='Type in the confirmation code'){document.getElementById('div_security_code_ok').style.display='none';document.getElementById('div_security_code').style.display='block';return false;}
var accept=document.getElementById('accept').checked;if(!accept){document.getElementById('div_accept_ok').style.display='none';document.getElementById('div_accept').style.display='block';document.getElementById('ok_accept').value='';return false;}else{document.getElementById('ok_accept').value='ok';}}
function Show_News(news,less,more){document.getElementById(news).style.display='block';document.getElementById(more).style.display='none';document.getElementById(less).style.display='block';}
function Hide_News(news,less,more){document.getElementById(news).style.display='none';document.getElementById(more).style.display='block';document.getElementById(less).style.display='none';}
function ForgotPasswordDivOn(){document.getElementById('ForgotPass').style.display='block';}
function DatePeriodControl(){if(document.getElementById('time_period').value=='Enter Date Range...'){document.getElementById('calender-bg').style.display='block';}else{document.getElementById('calender-bg').style.display='none';}}
function AllSearchResultDivClose(cnt){for(i=1;i<=cnt;i++){var div_headline='headline_'+i;document.getElementById(div_headline).style.display='none';var div_name='ResultName_'+i;document.getElementById(div_name).style.display='none';}}
function HeadLineShow(divID,cnt){for(i=1;i<=cnt;i++){var div_id='headline_'+i;document.getElementById(div_id).style.display='none';}
document.getElementById(divID).style.display='block';}
function HeadLineClose(divID){document.getElementById(divID).style.display='none';}
function ResultNameShow(divID,cnt){for(i=1;i<=cnt;i++){var div_id='ResultName_'+i;document.getElementById(div_id).style.display='none';}
document.getElementById(divID).style.display='block';}
function ResultNameClose(divID){document.getElementById(divID).style.display='none';}
function SearchResultDownloadShow(divID){document.getElementById(divID).style.display='block';}
function SearchResultDownloadClose(divID){document.getElementById(divID).style.display='none';}
function SearchResultRegister(){var url='provide-contact-information.php';window.location=url;}
function SearchResultSubscription(uid){var url='submit-payment.php?res_id='+uid;window.location=url;}
function RecordShowPerPage(){var per_page=document.getElementById('record_per_page').value;var url='search-result.php?p=1&items_per_page='+per_page;window.location=url;}
function SearchFieldEdit(){document.frmSearchEdit.submit();}
function SearchFieldEditBottom(){document.frmSearchEditBottom.submit();}
function ResultDownload(){document.frmResultDownload.submit();}
function ResultDownloadBottom(){document.frmResultDownloadBottom.submit();}
function SearchResultCheckBox(totRecord){var contactList;contactList='';if(document.getElementById('checkboxCtrl').checked){for(i=1;i<=totRecord;i++){var chkBoxID='resultCheckBox_'+i;document.getElementById(chkBoxID).checked=true;if(contactList!=''){contactList=contactList+','+document.getElementById(chkBoxID).value;}else{contactList=document.getElementById(chkBoxID).value;}}
document.getElementById('selected_contact_list').value='ALL';document.getElementById('selected_contact_list_bottom').value='ALL';}else{for(i=1;i<=totRecord;i++){var chkBoxID='resultCheckBox_'+i;document.getElementById(chkBoxID).checked=false;}
document.getElementById('selected_contact_list').value=contactList;document.getElementById('selected_contact_list_bottom').value=contactList;}}
function SelectedCheckBoxList(totRecord){var contactList;contactList='';for(i=1;i<=totRecord;i++){var chkBoxID='resultCheckBox_'+i;if(document.getElementById(chkBoxID).checked){if(contactList!=''){contactList=contactList+','+document.getElementById(chkBoxID).value;}else{contactList=document.getElementById(chkBoxID).value;}}}
if(contactList==''){document.getElementById('selected_contact_list').value='';document.getElementById('selected_contact_list_bottom').value='';}else{document.getElementById('selected_contact_list').value=contactList;document.getElementById('selected_contact_list_bottom').value=contactList;}}
function MySubscriptionChange(dID,id,fieldName,mod){if(mod=='Edit'){return false;}else{var url="my-subscription.php?mode=Edit&divID="+dID+"&id="+id+"&fieldName="+fieldName;window.location=url;}}
function DeleteCreditCard(card_id){var yn=confirm("Are you sure want to delete?");if(yn){var url="my-subscription.php?action=CreditCardDelete&card_id="+card_id;window.location=url;}}
function MyCardValidation(){var sp=false;var fname=document.getElementById('first_name').value;var iChars="!@#$%^&*()+=-[]\';,./{}|\":<>?1234567890";for(var i=0;i<fname.length;i++){if(iChars.indexOf(fname.charAt(i))!=-1)
{sp=true;}}
if(fname==''||(fname!='Type in the first name'&&sp==true)){alert('Please enter the first name');document.getElementById('first_name').focus();return false;}
var lname=document.getElementById('last_name').value;if(lname==''||lname=='Type in the last name'){alert('Please enter the last name');document.getElementById('last_name').focus();return false;}
var ctype=document.getElementById('card_type').value;if(ctype==''){alert('Please select the card type');document.getElementById('card_type').focus();return false;}
var cnum=document.getElementById('card_num').value;if(cnum==''||cnum=='Type in the card number'){alert('Please enter the card number');document.getElementById('card_num').focus();return false;}
var scode=document.getElementById('security_code').value;if(scode==''||scode=='Card Security Code'){alert('Please enter the security code');document.getElementById('security_code').focus();return false;}
var addname=document.getElementById('address').value;if(addname==''||addname=='Type in the Address'){alert('plaease enter the address');document.getElementById('address').focus();return false;}
var cityname=document.getElementById('city').value;if(cityname==''||cityname=='Type in the City'){alert('plaease enter the city');document.getElementById('city').focus();return false;}
var zip=document.getElementById('zip_code').value;if(zip==''||zip=='Type in the Zip code'){alert('plaease enter the zip code');document.getElementById('zip_code').focus();return false;}}
function AlertSubmit(){var title=document.getElementById('title').value;if(title==''||title=='Type in the title'){alert('Please type in the title');document.getElementById('title').focus();return false;}
var ds=document.getElementById('delivery_schedule').value;/*var mb=document.getElementById('monthly_budget').value;*/if((ds=='Any'||ds=='')/*&&(mb=='Any'||mb=='') or please select budget*/){alert("please select frequency");return false;}
FormValueSubmit('frm_alert');}
function AlertPaymentSubmit(){var scode=document.getElementById('security_code').value;if(scode==' '||scode==''){alert("3 digit security code on the back of your card");document.getElementById('security_code').focus();return false;}
FormValueSubmit('frmSubmitPay');}
function SubscriptionPaymentSubmit(){var scode=document.getElementById('security_code').value;if(scode==' '||scode==''){alert("3 digit security code on the back of your card");document.getElementById('security_code').focus();return false;}
FormValueSubmit('frmSubmitPay')}
function ChangePasswordSubmit(){var pass=document.getElementById('pass').value;if(pass==''){alert('Please type in your password');document.getElementById('pass').focus();return false;}
var rpass=document.getElementById('repass').value;if(rpass==''){alert('Please type in your Re-password');document.getElementById('repass').focus();return false;}
if(pass!=rpass){alert('The password you typed in should match. Please try again');document.getElementById('pass').focus();return false;}
FormValueSubmit('frmChangePassword')}
function AdvanceSearchValueSubmit(){FormValueSubmit('frmAdvSearch')}
function CardValidation(){var cnumber=document.getElementById('card_num').value;var ctype=document.getElementById('card_type').value;checkCreditCard(cnumber,ctype)
alert(ccErrors[ccErrorNo]);}
function SignUpValidation(){var fname=document.getElementById('full_name').value;if(fname==''||fname=='Your First Name and Last Name'){alert('Please enter your first name and last name');document.getElementById('full_name').focus();return false;}
var email=document.getElementById('email').value;if(email==''||email=='Your Email'){alert('Please enter your email');document.getElementById('email').focus();return false;}
if(email!=''){var reg=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;if(reg.test(email)==false){alert('Invalid E-Mail Address');document.getElementById('email').focus();return false;}}}
function Vigilant_Next_Submit(){FormValueSubmit('frmVNext');}
function DivDateShowImgOver(div_asc,div_desc,ad){if(ad=='asc'){document.getElementById(div_asc).style.display='block';document.getElementById(div_desc).style.display='none';}else if(ad=='desc'){document.getElementById(div_asc).style.display='none';document.getElementById(div_desc).style.display='block';}}
function DivDateShowImgOut(div_asc,div_desc,ad){if(ad=='desc'){document.getElementById(div_asc).style.display='block';document.getElementById(div_desc).style.display='none';}else if(ad=='asc'){document.getElementById(div_asc).style.display='none';document.getElementById(div_desc).style.display='block';}}

function SignUpEmailFieldValidation(old_email){
	var email=document.getElementById('email').value;
	if(email==''||email=='Type in the email'){
		document.getElementById('div_email_ok').style.display='none';
		document.getElementById('div_email').style.display='block';
		document.getElementById('ok_email').value='';
		return false;
	}else{
		var reg=/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		if(reg.test(email)==false){
			document.getElementById('div_email').style.display='block';
			document.getElementById('div_email_ok').style.display='none';
			document.getElementById('div_email_err').innerHTML="Please verify  the email syntax format and try again";
			document.getElementById('ok_email').value='';
			return false;
		}else if(email != old_email){
			EditUserEmail(email,old_email);
		}else if(old_email ==''){
			AddUser(email);
		}
	}
}
function SignUpReEmailFieldValidation(old_email){
	var remail = document.getElementById('retype_email').value;
	var email = document.getElementById('email').value;
	if(remail=='' || email != remail){
		document.getElementById('div_retype_mail_ok').style.display='none';
		document.getElementById('div_retype_mail').style.display='block';
		document.getElementById('ok_retype_email').value='';
		document.getElementById('div_retype_mail_err').innerHTML ='The email doesn&rsquo;t match the one you typed in previously, please try again';
		return false;
	}else if(remail != old_email){
		EditUserRE(remail,old_email);
	}else if(old_email ==''){
		AddUserRE(remail);
	}
}