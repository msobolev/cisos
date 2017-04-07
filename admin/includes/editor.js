function dis_editor(){
	var divshowfck = document.getElementById("fck").style;
	divshowfck.display = "block";
	var hidediv = document.getElementById("loading").style;
	 hidediv.display = "none";
	
	var divshow = document.getElementById("butt").style;
	divshow.display = "block";
}

 function execute_me(){
 	window.setInterval("dis_editor()" , 10000);
 
 }
 execute_me();