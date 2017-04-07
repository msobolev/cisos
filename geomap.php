<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
<script>
var geocoder2 = new google.maps.Geocoder();

var geocoder;
var map;
var marker;  
  
 /* function initialize() {
    geocoder = new google.maps.Geocoder();
    var latlng = new google.maps.LatLng(35.6894875, 139.69170639999993);
    var myOptions = {
      zoom: 8,
      center: latlng,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  }*/

function initialize() { 


	var latLng = new google.maps.LatLng('40.761998', '-73.97254599999997'); 


//GoogleMap type
    var googlemaps_type = google.maps.MapTypeId.ROADMAP;
   
  

  map = new google.maps.Map(document.getElementById('map_canvas'), {
    zoom: 15,
    center: latLng,
	scrollwheel: false,
		
	
	mapTypeId: googlemaps_type
    //mapTypeId: google.maps.MapTypeId.ROADMAP
	//mapTypeId: google.maps.MapTypeId.SATELLITE
	//mapTypeId: google.maps.MapTypeId.HYBRID
	//mapTypeId: google.maps.MapTypeId.TERRAIN
  });
 
   //GEOCODER
  geocoder = new google.maps.Geocoder();

  marker = new google.maps.Marker({
    position: latLng,
    map: map,
    draggable: true
  });

  
  // Update current position info.
  updateMarkerPosition(latLng);
  geocodePosition(latLng);
  
  // Add dragging event listeners.
  google.maps.event.addListener(marker, 'dragstart', function() {
    updateMarkerAddress('Dragging...');
  });
  
  google.maps.event.addListener(marker, 'drag', function() {
    updateMarkerStatus('Dragging...');
    updateMarkerPosition(marker.getPosition());
  });
  
  google.maps.event.addListener(marker, 'dragend', function() {
    updateMarkerStatus('Drag ended');
    geocodePosition(marker.getPosition());
  });


}


function updateMarkerStatus(str) {
  document.getElementById('markerStatus').innerHTML = str;
}

function updateMarkerPosition(latLng) {

    
	jQuery('#lat').val(latLng.lat());
	jQuery('#lng').val(latLng.lng());
	
}

function updateMarkerAddress(str) {
  document.getElementById('address').innerHTML = str;
}



  function codeAddress() {
    var address = document.getElementById("address").value;
	 geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
	  //alert(results[0].geometry.location);
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location,
            draggable: true
        });
		
		/*var point;
		var tar;
		document.getElementById("mappoint").value = results[0].geometry.location; 
		point = document.getElementById("mappoint").value;
		var pnt = point.substr(1,point.length-2);
		tar = pnt.split(", ");
		document.getElementById("maplat").value = tar[0];
		document.getElementById("maplng").value = tar[1];*/
		
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
  }
  
  function CheckEnter(e){
	var val=e.keyCode;
	if(val==13){
		alert("Please press button to continue.");
		return false;
	}
  }
  function doPopup() {
		delay = 1;    // time in seconds before popup opens
		timer = setTimeout("codeAddress();", delay*500);
		}
  </script>
</head>

<body onLoad="initialize();" onfocus="doPopup();">
<table width="100%" align="left" cellpadding="0" cellspacing="0">
    <tr>
    <!--<td width="4%" align="left" valign="top"><p><?//=LOCATION?></p>&nbsp;</td>-->
<!--    <td width="94%" align="left" valign="top"><input  id="address" name="address" type="textbox" onblur="codeAddress()" onkeyup="CheckEnter(event);" style="width:442px; height:22px; border:1px solid #c6def1; padding-left:5px;" value="<?php if($gmapaddress=='') echo 'San Juan, Puerto Rico'; else echo $gmapaddress;?>" size="62" /></td>
-->  
	<td width="94%" align="left" valign="top"><input  id="address" name="address" type="hidden" onblur="codeAddress()" style="width:442px; height:22px; border:1px solid #c6def1; padding-left:5px;" value="451 Industrial Ln, AL USA 35211" size="62" /></td>  
	<td width="6%" align="left" valign="top"><img src="images/post-add-arrow.gif" alt="" title="" /></td>
    </tr>
    <tr><td align="left" valign="top"><p><?=GMAPADDRESS?></p></td><td>&nbsp;</td></tr>
    <tr><td align="left" valign="top" colspan="2"><br /><br /><div id="map_canvas" style="width: 480px; height: 350px;"></div><br />
    </td></tr>
</table>
</body>
</html>