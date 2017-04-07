jQuery(document).ready(function($){
$(window).load(function() {
	$('#ois_add_loader').hide('slow');
});
$('#ois_save_draft').click(function() {
	$('#newskin_status').val('draft');
});

function ois_calc_completion() {
	// Depreciated.
}

$('.ois_optin_account_input').blur(function() {
	var number = $(this).attr('number');
	var account = $(this).attr('account');
	var specific = $(this).attr('specific');
	if ($(this).val().trim() != '') {
		$(this).removeClass('ois_textbox_error');
		$(this).addClass('ois_textbox_approve');
		$('#ois_account_approve_' + number + '_' + account + '_' + specific).show();
		$('#ois_account_disapprove_' + number + '_' + account + '_' + specific);
	} else {
		$(this).addClass('ois_textbox_error');
		$(this).removeClass('ois_textbox_approve');
		$('#ois_account_disapprove_' + number + '_' + account + '_' + specific).show();
		$('#ois_account_approve_' + number + '_' + account + '_' + specific).hide();
	}
});
$('#ois_skin_name').blur(function() {
	if ($(this).val().length == 1) {
		$('#ois_name_approve').hide();
		$('#ois_name_disapprove').text('May I suggest you be a tad more descriptive?');
		$('#ois_name_disapprove').show();
		$(this).addClass('ois_textbox_error');
		$(this).removeClass('ois_textbox_approve');
	} else if ($(this).val().trim() != '') {
		$('#ois_name_disapprove').hide();
		$('#ois_name_approve').show();
		$(this).removeClass('ois_textbox_error');
		$(this).addClass('ois_textbox_approve');
	} else {
		$('#ois_name_approve').hide();
		$('#ois_name_disapprove').show();
		$(this).removeClass('ois_textbox_approve');
		$(this).addClass('ois_textbox_error');
	}
});
$('.ois_textbox').focus(function() {
	$(this).parent().parent().css({
		'background-color': '#f7f7f7'
	});
	if ($(this).attr('id') != 'ois_skin_name' && $('#ois_skin_name').val().trim() == '') {
		$('#ois_name_approve').hide();
		$('#ois_skin_name').addClass('ois_textbox_error');
		$('#ois_name_disapprove').show();
	} else {
		$('#ois_name_disapprove').hide();
	}
});
$('.ois_textbox').blur(function() {
	$(this).parent().parent().css({
		'background-color': '#f9f9f9',
		'box-shadow': 'none'
	});
});
$('#new_skin_description').blur(function() {
	if ($(this).val().trim() != '') {
		$('#ois_description_approve').show();
		$(this).addClass('ois_textbox_approve');
	} else {
		$('#ois_description_approve').hide();
		$(this).removeClass('ois_textbox_approve');
	}
});
$('.ois_optin_choice').change(function() {
	$('.ois_optin_account').hide();
	$('.ois_optin_' + $(this).val()).show();
});
var original_design = $('#ois_original_design_0').html();
var cur_design = original_design;

$('.ois_add_appearance').keyup(function() {
	ois_update_preview(this);
});
$('select.ois_add_appearance').change(function() {
	ois_update_preview(this);
});
	
function ois_update_preview(self) {
	var val_for = $(self).attr('name');
	var data = val_for.split('newskin_appearance_');
	data = data[1].split('_');
	var design_id = data[0];
	var insigma = data[0] + '_' + data[1];
	original_design = $('#ois_original_design_' + design_id).html();
	cur_design = original_design;
	$('.ois_app_' + design_id).each(function() {
		var new_val = $(this).val();
		var val_for = $(this).attr('name');
		var data = val_for.split('newskin_appearance_');
		data = data[1].split('_');
		var design_attr = '%' + data[1] + '%';
		cur_design = cur_design.replace(new RegExp(design_attr, 'g'), new_val);
	});
	$('#link-color_example_' + insigma).css("background-color", $(self).val());
	$('#ois_actual_design_' + design_id).html(cur_design);
}

$('.ois_color_picker').each(function() {
	var id = $(this).attr('id');
	var id_parts = id.split('_');
	var insigma = id_parts[2] + '_' + id_parts[3];
	$(this).farbtastic(function() {
		$('#newskin_appearance_' + insigma).val($.farbtastic($('#' + id)).color);
		$('#link-color_example_' + insigma).css("background-color", $.farbtastic($('#' + id)).color);
		ois_update_preview($('#newskin_appearance_' + insigma));
	});
	$.farbtastic($('#' + id)).setColor($('#newskin_appearance_' + insigma).val());
	$(this).click(function() {
		return false;
	});
});

$('.ois_picker_a, .ois_pickcolor').click(function() {
	var id = $(this).attr('id');
	var id_parts = id.split('_');
	var insigma = id_parts[2] + '_' + id_parts[3];
	if ($('#ois_picker_' + insigma).val() == 'Select a Color') {
		$('#ois_picker_' + insigma).val('Hide Picker');
		$.farbtastic($('#ois_colorpicker_' + insigma)).setColor($('#newskin_appearance_' + insigma).val());
		$('#ois_colorpicker_' + insigma).show();
	} else {
		$('#ois_picker_' + insigma).val('Select a Color');
		ois_update_preview($('#newskin_appearance_' + insigma));
		$('#ois_colorpicker_' + insigma).hide();
	}
	if ($('#newskin_appearance_' + insigma).val() == '') {
		$('#newskin_appearance_' + insigma).val('#fff');
	}
	return false;
});
$('#ois_select_page').change(function() {
	$('#ois_redirect_url').val($(this).val());
});

$(document).click(function() {
	$('.ois_color_picker').each(function() {
		if ($(this).is(':visible')) {
			var id = $(this).attr('id');
			var id_parts = id.split('_');
			var insigma = id_parts[2] + '_' + id_parts[3];
			$(this).hide();
			ois_update_preview($('#newskin_appearance_' + insigma));
		}
	});
	$('.ois_picker_a').val('Select a Color');
});

$('.ois_header_min').click(function() {
	var self = $(this);
	$(this).parent().parent().parent().parent().parent().find('tr').each(function() {
		if ($(this).attr('class') != 'ois_minimized_row') {
			var closeUrl = self.attr('data-closed');
			self.html('<img src="' + closeUrl + '" style="height:25px;margin-bottom:-5px;" />');
			if ($(this).attr('class') != 'ois_header_row') {
				$(this).slideUp('slow');
				$(this).attr('class', 'ois_minimized_row');
			}
		} else {
			self.text('Minimize');
			var openUrl = self.attr('data-open');
			self.html('<img src="' + openUrl + '" style="height:25px;margin-bottom:-5px;" />');
			$(this).slideDown('slow');
			$(this).attr('class', '');
		}
	});
});
});