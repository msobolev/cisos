// JavaScript Document
var xmlhttpindex;

function IndexPageResult(){
	var ind_num = document.getElementById('ind_num').value;
	var industry_list='';
	for(var ind=1; ind<=ind_num; ind++){
		var indstryID = "industry_"+ind;
		if(document.getElementById(indstryID).checked){
			if(industry_list==''){
				industry_list = document.getElementById(indstryID).value;
			}else{
				industry_list = industry_list +','+ document.getElementById(indstryID).value;
			}
		}
	}
	
	var revenue = document.getElementById('revenue').value;
	
	var employee = document.getElementById('employee').value;
	
	var state_num = document.getElementById('state_num').value;
	var state_list='';
	for(var st=1; st<=state_num; st++){
		var stateID = "state_"+st;
		if(document.getElementById(stateID).checked){
			if(state_list==''){
				state_list = document.getElementById(stateID).value;
			}else{
				state_list = state_list +','+ document.getElementById(stateID).value;
			}
		}
	}
	var islog = document.getElementById('islogin').value;
	xmlhttpindex=GetXmlHttpObject();
	if (xmlhttpindex==null)
	  {
	  alert ("Browser does not support HTTP Request");
	  return;
	  }
	var url="getuser-index.php";
	url=url+"?type=IPSR&ind=" + industry_list + "&rev=" + revenue + "&emp=" + employee + "&st=" + state_list + "&islog=" + islog;
	url=url+"&sid="+Math.random();
	xmlhttpindex.onreadystatechange=IndexPageContactResult;
	xmlhttpindex.open("GET",url,true);
	xmlhttpindex.send(null);
	
}

function IndexPageContactResult()
{
	if (xmlhttpindex.readyState==4)
	{
		var all_content = xmlhttpindex.responseText;
		var msgCont = all_content.split("###");
		document.getElementById("total_cnt_number").value = msgCont[0];
		document.getElementById("DivContactListing").innerHTML = msgCont[1];
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