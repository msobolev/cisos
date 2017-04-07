if (navigator.platform == "Win32" && navigator.appName == "Microsoft Internet Explorer" && window.attachEvent) {
	window.onload = fnLoadPngs;
}

function fnLoadPngs() {
	var rslt = navigator.appVersion.match(/MSIE (\d+\.\d+)/, '');
	var itsAllGood = (rslt!=null && Number(rslt[1])>=5.0);
	var img = document.images;
	for (var i = img.length - 1; i>=0; i--) {
		if (itsAllGood && img[i].src.match(/\.png$/i)) {
			var src = img[i].src;
//			img[i].style.width = img[i].width + "px";
//			img[i].style.height = img[i].height + "px";
			img[i].style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + src + "', sizingMethod='scale')";
			img[i].src = "/images/1pix.gif";
		}
	}
}