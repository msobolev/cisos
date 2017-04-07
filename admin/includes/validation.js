function ShowMenu(page,id){
	var url=page + "?selected_menu=" + id;
	window.location = url;
}

function validateField(field, msg) {
	if (!field.value || field.value == "") {
		alert(msg);
		field.focus();
		return false;
	}
	
	return true;
}
	
function isValidEmail(theField) {
  var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  if(reg.test(theField.value) == false) {
	  return false;
   }
	return true;
}

function ContactDivControl(divName){
	 if(document.getElementById(divName).style.display == 'block'){
 		 document.getElementById(divName).style.display = 'none';
	 }else{	
	 	document.getElementById(divName).style.display = 'block';
	 }
 }
 
function popupDownload(url) {
	  window.open(url,'popupDownload','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=900,height=500,screenX=100,screenY=100,top=100,left=100')
	}
function popupSearch(url) {
	  window.open(url,'popupSearch','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=400,height=500,screenX=100,screenY=100,top=100,left=100')
	}	
function popupAlert(url) {
	  window.open(url,'popupAlert','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=800,height=500,screenX=100,screenY=100,top=100,left=100')
	}		
