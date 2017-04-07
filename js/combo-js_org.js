// JavaScript Document
function MyCombo_Open(divID){
	if(document.getElementById(divID).style.display=='block'){
		document.getElementById(divID).style.display='none';
	}else{
		document.getElementById(divID).style.display='block';
	}	
}

function TextboxValueChange(txtbox,divID,val){
	document.getElementById(txtbox).value=val;
	document.getElementById(divID).style.display='none';
}
function AllComboDivCloseADV(divID){
	document.getElementById('div_management').style.display='none';
	document.getElementById('div_country').style.display='none';
	document.getElementById('div_state').style.display='none';
	document.getElementById('div_revenue_size').style.display='none';
	document.getElementById('div_employee_size').style.display='none';
	document.getElementById('div_time_period').style.display='none';
	document.getElementById('div_industry').style.display='none';
	if(divID !=''){
		document.getElementById(divID).style.display='block';
	}
}
function AllComboDivClosePCI(divID){
	document.getElementById('div_email_update').style.display='none';
	
	if(divID !=''){
		document.getElementById(divID).style.display='block';
	}
}
function AllComboDivClosePayment(divID){
	document.getElementById('div_card_type').style.display='none';
	document.getElementById('div_exp_month').style.display='none';
	document.getElementById('div_exp_year').style.display='none';
	document.getElementById('div_state').style.display='none';
	if(divID !=''){
		document.getElementById(divID).style.display='block';
	}
}
function AllComboDivCloseAlert(divID){
	document.getElementById('div_title').style.display='none';
	document.getElementById('div_management').style.display='none';
	document.getElementById('div_country').style.display='none';
	document.getElementById('div_state').style.display='none';
	document.getElementById('div_industry').style.display='none';
	document.getElementById('div_revenue_size').style.display='none';
	document.getElementById('div_employee_size').style.display='none';
	document.getElementById('div_delivery_schedule').style.display='none';
	document.getElementById('div_monthly_budget').style.display='none';
	if(divID !=''){
		document.getElementById(divID).style.display='block';
	}
}
function AllComboDivCloseAlertEdit(divID){
	document.getElementById('div_industry').style.display='none';
	document.getElementById('div_country').style.display='none';
	document.getElementById('div_state').style.display='none';
	document.getElementById('div_revenue_size').style.display='none';
	document.getElementById('div_employee_size').style.display='none';
	document.getElementById('div_delivery_schedule').style.display='none';
	if(divID !=''){
		document.getElementById(divID).style.display='block';
	}
}