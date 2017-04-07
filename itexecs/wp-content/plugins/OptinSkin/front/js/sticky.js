jQuery(document).ready(function($) {
	if (window.ois_stick !== undefined) {
		for (x in ois_stick) {
			var id = x.split('_');
			$('#ois_' + id[1]).addClass('ois_sticky');
			$('#ois_' + id[1]).before('<div id="' + id[1] + '_anchor" style="position:static;display:inline;"></div>');
			$.waypoints.settings.scrollThrottle = 30;
			$('#' + id[1] + '_anchor').waypoint(function(event,direction) {
				$('#ois_' + id[1]).toggleClass('ois_stick', direction === "down");
				event.stopPropagation();
			});
		}
	}
});
