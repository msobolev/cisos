<?php

function ois_oib_save($post) {
	// Background Style:
	
	$background_style = array (
		'background_top_gradient' => $post['oib_top_gradient'],
		'background_bottom_gradient' => $post['oib_bottom_gradient'],
		'background_border_color' => $post['oib_border_color'],
		'background_border_size' => $post['oib_border_size'],
	);
	
	$button_style = array (
		'button_top_gradient' => $post['oib_button_top_gradient'],
		'button_bottom_gradient' => $post['oib_button_bottom_gradient'],
	);
	
}

function ois_optinbar() {
	if (!empty($_POST)) {
		ois_oib_save($_POST);
	}
	
	// OptinBar Settings
	$oib = get_option('ois_oib');
	// If there are no settings yet, then we need to make some up.
	$oib_defaults = array (
		'service' => 'feedburner', // just for fun
		'bg_top_gradient' => '#f7f2f2',
		'bg_bottom_gradient' => '#f5f1ea',
		'edge_color' => '#fff',
		'edge_size' => '1px',
		'btn_top_gradient' => '#fff',
		'btn_bottom_gradient' => '#fff',
		'btn_text_color' => '#000',
		'text_color' => '#9f2828',
		'font_size' => '15px',
		'font_family' => 'Lobster',
		'spacing' => '15px',
		'content_before' => 'Subscribe for Free Updates',
		'content_after' => 'No Spam, Gauranteed',
	);
	
	
if (empty($oib)) {
		$oib = $oib_defaults;
	} else {
		foreach ($oib as $attr=>$val) {
			if (empty($attr)) {
				$oib[$attr] = $oib_defaults[$attr];
			}
		}
	}
	
	print_r($oib);
	
	echo "<script type='text/javascript' src='" . admin_url() . "/js/farbtastic.js?ver=3.3.1'></script>";
	echo "<link rel='stylesheet' href='" . admin_url() . "/css/farbtastic.css?ver=3.3.1' type='text/css' media='all' />";
	echo "<link rel='stylesheet' href='" . WP_PLUGIN_URL . "/OptinSkin/front/css/optinbar.css' type='text/css' media='all' />";
	
	$ex_skin = array ('optin-service' => 'feedburner', 'id' => 'optinbar');
	$form_design = array('html' => '%optin_form%', 'title' => '', 'description' => '', 'date_added' => date('Y-m-d H:i:s'), 'last_modified' => date('Y-m-d H:i:s'), 'css' => '', 'css_url' => '', 'id' => 'optinbar', 'custom' => 'no', 'optin_settings' => array ( 'enable_name' => 'no', 'placeholders' => array ( 'email' => 'enter your email', ), 'labels' => array (), 'button_value' => 'Submit', 'force_break' => 'no', ), 'appearance' => array ( 'text' => array (),),);

	$oib_options = get_option('oib_options');
	if (!empty($oib_options['oib_active'])) {
		$oib_active = $oib_options['oib_active'];
	} else {
		$oib_active = 'no';
	}
	if (!empty($oib_options['oib_homepage'])) {
		$oib_homepage = $oib_options['oib_homepage'];
	} else {
		$oib_homepage = 'no';
	}
	
	ois_section_title('OptinBar', 'Add an OptinBar to the top of your pages', '');
	ois_start_table('OptinBar Preview', 'mantra/Designs.png');
	echo '<td class="alternate" style="width:100%;padding: 10px 0;">';
	echo '<div id="oib_unrefined_wrapper" style="display:none!important;">
		<div class="oib_preview" style="text-align:center!important;height:40px;width:90%;margin:0 auto;border-bottom-width:2px!important;border-bottom-color:%border_color%!important;' . ois_vertical_gradient('%top_gradient%', '%bottom_gradient%') . '">';
	echo '<div class="oib_inner" style="margin:auto 0!important;">
		<span class="oib_pre" style="font-family:\'%font_type%\'!important;padding-right:%spacing%!important;color:%text_color%!important;font-size:%font_size%!important;">%pre_form%</span>';
	echo '<span class="oib_form" style="">';
	echo ois_make_skin($ex_skin, $form_design);
	echo '</span>';
	echo '<span class="oib_post" style="font-family:\'%font_type%\'!important;padding-left:%spacing%!important;color:%text_color%!important;font-size:%font_size%!important;">%post_form%</span></div>';
	echo '</div></div>';

	echo '<div id="oib_preview_wrapper">';
	echo '</div>';
	echo '</td>';
	ois_end_option_and_table();
	
	ois_start_option_table('Appearance Settings', true, 'mantra/Colours.png');
	ois_option_label(array('title' => 'Background', 'description' => '', 'inner_style' => 'width:300px;'));
	ois_inner_label(array('title' => 'Top color'));
	/*
echo '<input type="text" id="oib_top_gradient" rel="top_gradient" class="ois_textbox oib_preview_item" style="width:100px;" name="oib_top_gradient" value="' . $oib['bg_top_gradient'] . '"';
	if (!empty($oib['bg_top_gradient']) && trim($oib_top_gradient) != '') {
		echo ' value="' . $oib_top_gradient . '"';
	} else {
		echo 'value="#f7f2f2"';
	}

	echo ' />';*/
	echo '<div id="oib_colorpicker_top_gradient" class="oib_color_picker" style="z-index: 100; background-image: initial; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: rgb(238, 238, 238); border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-top-color: rgb(204, 204, 204); border-right-color: rgb(204, 204, 204); border-bottom-color: rgb(204, 204, 204); border-left-color: rgb(204, 204, 204); border-image: initial; position: absolute; display:none; background-position: initial initial; background-repeat: initial initial;"> </div> <fieldset style="display:inline"> <p style="padding-top: 5px;">';
	echo '<a href="javascript:void();" class="oib_pickcolor" id="link-color_example_top_gradient" style="background-color:';
	if (!empty($gradient_top) && trim($gradient_top) != '') {
		echo $gradient_top;
	} else {
		echo '#f7f2f2';
	}
	echo ';min-height:14px; min-width:4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #DFDFDF;margin: 0 7px 0 3px;padding: 4px 14px;line-height: 20px;font-size: 12px;"> &nbsp</a> <input	type="button" id="oib_picker_top_gradient" class="oib_picker_a pickcolor button" value="Select a Color" />';
	ois_table_end();
	ois_inner_label(array('title' => 'Bottom color'));
	echo '<input type="text" id="oib_bottom_gradient" rel="bottom_gradient" class="ois_textbox oib_preview_item" style="width:100px;" name="oib_bottom_gradient"';
	if (!empty($oib_bottom_gradient) && trim($oib_bottom_gradient) != '') {
		echo ' value="' . $oib_bottom_gradient . '"';
	} else {
		echo 'value="#f5f1ea"';
	}
	echo ' />';
	echo '<div id="oib_colorpicker_bottom_gradient" class="oib_color_picker" style="z-index: 100; background-image: initial; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: rgb(238, 238, 238); border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-top-color: rgb(204, 204, 204); border-right-color: rgb(204, 204, 204); border-bottom-color: rgb(204, 204, 204); border-left-color: rgb(204, 204, 204); border-image: initial; position: absolute; display:none; background-position: initial initial; background-repeat: initial initial;"> </div> <fieldset style="display:inline"> <p style="padding-top: 5px;">';
	echo '<a href="javascript:void();" class="oib_pickcolor" id="link-color_example_bottom_gradient" style="background-color:';
	if (!empty($oib_bottom_gradient) && trim($gradient_top) != '') {
		echo $oib_bottom_gradient;
	} else {
		echo '#f5f1ea';
	}
	echo ';min-height:14px; min-width:4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #DFDFDF;margin: 0 7px 0 3px;padding: 4px 14px;line-height: 20px;font-size: 12px;"> &nbsp</a> <input	type="button" id="oib_picker_bottom_gradient" class="oib_picker_a pickcolor button" value="Select a Color" />';
	ois_end_option_and_table();
	ois_inner_label(array('title' => 'Bottom Edge'));
	echo '<table>
	<tr>
		<td style="font-size:13px;font-family:\'Georgia\';vertical-align:middle!important;width:50px!important;">Color</td>
		<td>';
	echo '<input type="text" id="oib_border_color" rel="border_color" class="ois_textbox oib_preview_item" style="width:100px;" name="oib_border_color"';
	if (!empty($oib_border_color) && trim($oib_border_color) != '') {
		echo ' value="' . $oib_border_color . '"';
	} else {
		echo 'value="#fff"';
	}
	echo ' />';
	echo '<div id="oib_colorpicker_border_color" class="oib_color_picker" style="z-index: 100; background-image: initial; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: rgb(238, 238, 238); border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-top-color: rgb(204, 204, 204); border-right-color: rgb(204, 204, 204); border-bottom-color: rgb(204, 204, 204); border-left-color: rgb(204, 204, 204); border-image: initial; position: absolute; display:none; background-position: initial initial; background-repeat: initial initial;"> </div> <fieldset style="display:inline"> <p style="padding-top: 5px;">';
	echo '<a href="javascript:void();" class="oib_pickcolor" id="link-color_example_border_color" style="background-color:';
	if (!empty($oib_border_color) && trim($oib_border_color) != '') {
		echo $oib_border_color;
	} else {
		echo '#fff';
	}
	echo ';min-height:14px; min-width:4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #DFDFDF;margin: 0 7px 0 3px;padding: 4px 14px;line-height: 20px;font-size: 12px;"> &nbsp</a> <input	type="button" id="oib_picker_border_color" class="oib_picker_a pickcolor button" value="Select a Color" />';
	echo '</td>
	</tr>
	<tr>
		<td style="font-size:13px;font-family:\'Georgia\';vertical-align:middle!important;">Size</td>
		<td><input type="text" class="ois_textbox oib_preview_item" rel="border_width" style="width:100px" name="oib_border_size"';
	if (!empty($oib_border_width) && trim($oib_border_width) != '') {
		echo ' value="' . $oib_border_width . '"';
	} else {
		echo ' value="1px"';
	}
	echo ' /></td>
	</tr>
	</table>';
	ois_end_option_and_table();
	// Button Style
	ois_option_label(array('title' => 'Button Style', 'description' => '', 'inner_style' => 'width:300px;'));
	// Background Color
	ois_inner_label(array('title' => 'Top Gradient Color'));
	echo '<input type="text" id="oib_buttontop_color" rel="buttontop_color" class="ois_textbox oib_preview_item" style="width:100px;" name="oib_buttontop_color"';
	if (!empty($oib_button_top_color) && trim($oib_button_top_color) != '') {
		echo ' value="' . $oib_button_top_color . '"';
	} else {
		echo 'value="#fff"';
	}
	echo ' />';
	echo '<div id="oib_colorpicker_buttontop_color" class="oib_color_picker" style="z-index: 100; background-image: initial; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: rgb(238, 238, 238); border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-top-color: rgb(204, 204, 204); border-right-color: rgb(204, 204, 204); border-bottom-color: rgb(204, 204, 204); border-left-color: rgb(204, 204, 204); border-image: initial; position: absolute; display:none; background-position: initial initial; background-repeat: initial initial;"> </div> <fieldset style="display:inline"> <p style="padding-top: 5px;">';
	echo '<a href="javascript:void();" class="oib_pickcolor" id="link-color_example_buttontop_color" style="background-color:';
	if (!empty($oib_button_top_color) && trim($oib_button_top_color) != '') {
		echo $oib_button_top_color;
	} else {
		echo '#fff';
	}
	echo ';min-height:14px; min-width:4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #DFDFDF;margin: 0 7px 0 3px;padding: 4px 14px;line-height: 20px;font-size: 12px;"> &nbsp</a> <input	type="button" id="oib_picker_buttonbg_color" class="oib_picker_a pickcolor button" value="Select a Color" />';
	echo '</td>';
	ois_inner_label(array('title' => 'Bottom Gradient Color'));
	echo '<input type="text" id="oib_buttonbottom_color" rel="buttonbottom_color" class="ois_textbox oib_preview_item" style="width:100px;" name="oib_buttonbottom_color"';
	if (!empty($oib_button_bottom_color) && trim($oib_button_bottom_color) != '') {
		echo ' value="' . $oib_button_bottom_color . '"';
	} else {
		echo 'value="#fff"';
	}
	echo ' />';
	echo '<div id="oib_colorpicker_buttonbottom_color" class="oib_color_picker" style="z-index: 100; background-image: initial; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: rgb(238, 238, 238); border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-top-color: rgb(204, 204, 204); border-right-color: rgb(204, 204, 204); border-bottom-color: rgb(204, 204, 204); border-left-color: rgb(204, 204, 204); border-image: initial; position: absolute; display:none; background-position: initial initial; background-repeat: initial initial;"> </div> <fieldset style="display:inline"> <p style="padding-top: 5px;">';
	echo '<a href="javascript:void();" class="oib_pickcolor" id="link-color_example_buttonbottom_color" style="background-color:';
	if (!empty($oib_button_bottom_color) && trim($oib_button_bottom_color) != '') {
		echo $oib_button_bottom_color;
	} else {
		echo '#fff';
	}
	echo ';min-height:14px; min-width:4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #DFDFDF;margin: 0 7px 0 3px;padding: 4px 14px;line-height: 20px;font-size: 12px;"> &nbsp</a> <input	type="button" id="oib_picker_buttonbottom_color" class="oib_picker_a pickcolor button" value="Select a Color" />';
	echo '</td>';
	// Text Color
	ois_inner_label(array('title' => 'Text Color'));
	echo '<input type="text" id="oib_buttontext_color" rel="buttontext_color" class="ois_textbox oib_preview_item" style="width:100px;" name="oib_buttontext_color"';
	if (!empty($oib_button_text_color) && trim($oib_button_text_color) != '') {
		echo ' value="' . $oib_button_text_color . '"';
	} else {
		echo 'value="#fff"';
	}
	echo ' />';
	echo '<div id="oib_colorpicker_buttontext_color" class="oib_color_picker" style="z-index: 100; background-image: initial; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: rgb(238, 238, 238); border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-top-color: rgb(204, 204, 204); border-right-color: rgb(204, 204, 204); border-bottom-color: rgb(204, 204, 204); border-left-color: rgb(204, 204, 204); border-image: initial; position: absolute; display:none; background-position: initial initial; background-repeat: initial initial;"> </div> <fieldset style="display:inline"> <p style="padding-top: 5px;">';
	echo '<a href="javascript:void();" class="oib_pickcolor" id="link-color_example_buttontext_color" style="background-color:';
	if (!empty($oib_button_text_color) && trim($oib_button_text_color) != '') {
		echo $oib_button_text_color;
	} else {
		echo '#fff';
	}
	echo ';min-height:14px; min-width:4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #DFDFDF;margin: 0 7px 0 3px;padding: 4px 14px;line-height: 20px;font-size: 12px;"> &nbsp</a> <input	type="button" id="oib_picker_buttontext_color" class="oib_picker_a pickcolor button" value="Select a Color" />';
	ois_end_option_and_table();
	// Text Style and Format
	ois_option_label(array('title' => 'Text Style and Format', 'description' => '', 'inner_style' => 'width:300px;'));
	// Text Color
	ois_inner_label(array('title' => 'Text color'));
	echo '<input type="text" id="oib_text_color" rel="text_color" class="ois_textbox oib_preview_item" style="width:100px;" name="oib_text_color"';
	if (!empty($oib_text_color) && trim($oib_text_color) != '') {
		echo ' value="' . $oib_text_color . '"';
	} else {
		echo 'value="#9f2828"';
	}
	echo ' />';
	echo '<div id="oib_colorpicker_text_color" class="oib_color_picker" style="z-index: 100; background-image: initial; background-attachment: initial; background-origin: initial; background-clip: initial; background-color: rgb(238, 238, 238); border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; border-top-style: solid; border-right-style: solid; border-bottom-style: solid; border-left-style: solid; border-top-color: rgb(204, 204, 204); border-right-color: rgb(204, 204, 204); border-bottom-color: rgb(204, 204, 204); border-left-color: rgb(204, 204, 204); border-image: initial; position: absolute; display:none; background-position: initial initial; background-repeat: initial initial;"> </div> <fieldset style="display:inline"> <p style="padding-top: 5px;">';
	echo '<a href="javascript:void();" class="oib_pickcolor" id="link-color_example_text_color" style="background-color:';
	if (!empty($oib_text_color) && trim($oib_text_color) != '') {
		echo $oib_text_color;
	} else {
		echo '#9f2828';
	}
	echo ';min-height:14px; min-width:4px;-moz-border-radius: 4px;-webkit-border-radius: 4px;border-radius: 4px;border: 1px solid #DFDFDF;margin: 0 7px 0 3px;padding: 4px 14px;line-height: 20px;font-size: 12px;"> &nbsp</a> <input	type="button" id="oib_picker_text_color" class="oib_picker_a pickcolor button" value="Select a Color" />';
	ois_table_end();
	ois_inner_label(array('title' => 'Font Size'));
	echo '<input type="text" class="ois_textbox oib_preview_item" rel="font_size" style="width:100px" name="oib_font_size"';
	if (!empty($oib_font_size) && trim($oib_font_size) != '') {
		echo ' value="' . $oib_font_size . '"';
	} else {
		echo ' value="15px"';
	}
	echo ' />';
	ois_table_end();
	
	// Google Fonts
	ois_inner_label(array('title' => 'Font Type'));
	$google_fonts = get_option('ois_google_fonts');
	$regular_fonts = get_option('ois_regular_fonts');
	echo '<select name="oib_font_type" rel="font_type" class="oib_preview_list oib_preview_item" >';
	foreach ($regular_fonts as $font) {
		echo '<option value="' . $font . '"';
		if ($font == $saved_data) {
			echo ' selected="selected" ';
		}
		echo '>' . $font . '</option>';
	}
	foreach ($google_fonts as $font) {
		echo '<option value="' . $font . '"';
		if ($font == $saved_data) {
			echo ' selected="selected" ';
		}
		echo '>' . $font . '</option>';
	}
	echo '</select>';
	ois_table_end();
	
	ois_inner_label(array('title' => 'Spacing'));
	echo '<input type="text" class="ois_textbox oib_preview_item" rel="spacing" style="width:100px" name="oib_spacing"';
	if (!empty($oib_spacing) && trim($oib_spacing) != '') {
		echo ' value="' . $oib_spacing . '"';
	} else {
		echo ' value="15px"';
	}
	echo ' />';
	ois_end_option_and_table();
	ois_option_label(array('title' => 'Content', 'description' => 'The text you would like to appear around your form'));
	ois_inner_label(array('title' => 'Before Form'));
	echo '<input type="text" class="ois_textbox oib_preview_item" rel="pre_form" style="width:320px" name="oib_text_before"';
	if (!empty($ois_text_before) && trim($ois_text_before) != '') {
		echo ' value="' . $ois_text_before . '"';
	} else {
		echo ' value="Subscribe for Free Updates"';
	}
	echo ' />';
	ois_table_end();
	ois_inner_label(array('title' => 'After Form'));
	echo '<input type="text" class="ois_textbox oib_preview_item" rel="post_form" style="width:320px" name="oib_text_after"';
	if (!empty($ois_text_before) && trim($ois_text_before) != '') {
		echo ' value="' . $ois_text_before . '"';
	} else {
		echo ' value="No Spam, Gauranteed"';
	}
	echo ' />';
	
	ois_end_option_and_table();
	ois_end_option_and_table();
	
	ois_start_table('Optin Form Settings', 'mantra/Mail.png');
	ois_option_label(array('title' => 'Optin Service for this Skin', 'description' => '', 'id' => 'ois_selection_' . $number,));
	$optin_services = array (
		'feedburner' => array (
			'ID' => 'feedburner-id',
		),
		'aweber' => array (
			'List Name (e.g. \'viperchill\')' => 'aweber-id',
		),
		'mailchimp' => array (
			'Naked Form HTML' => 'mailchimp-form',
		),
		'icontact' => array (
			'Form HTML' => 'icontact-html',
		),
		'getResponse' => array (
			'Webform ID' => 'getResponse-id',
			'Form HTML' => 'getResponse-html',
		),
		'infusionSoft' => array (
			'Form HTML' => 'infusionSoft-html',
		),
		'other' => array (
			'Form HTML' => 'other-html',
		),
	);
	foreach ($optin_services as $name=>$data) { ?>
		<span style="padding: 2px 8px 2px 3px;">
			<input class="ois_optin_choice" type="radio" name="newskin_optin_choice"
						<?php
		if (!empty($this_skin['optin_service']) && trim($this_skin['optin_service']) == $name) {
			echo 'checked="checked"';
		} ?>
				value="<?php echo $name; ?>" />
			<img style="padding:0 2px;margin-bottom:-3px;width:18px!important;" src="<?php echo OptinSkin_URL . 'admin/images/' . strtolower($name) . '.png'; ?>" />
							<?php
		if ($name != 'icontact') {
			echo ucwords($name);
		} else {
			echo 'iContact';
		}
		echo '</span>';
	} ?>
		<span style="padding: 2px 12px 2px 5px;">
			<input
				class="ois_optin_choice"
				type="radio"
				name="newskin_optin_choice"
				value="none"
			<?php
		if (trim($this_skin['optin_service']) == '' ||
			trim($this_skin['optin_service']) == 'none') {
			echo 'checked="checked"';
		} ?>
		/> None </span>
	<?php
	ois_option_end();
	foreach ($optin_services as $name=>$data) {
		if ($name != 'icontact') {
			$ser_title = ucwords($name);
		} else {
			$ser_title = 'iContact';
		}
			if (empty($this_skin['optin_service']) || trim($this_skin['optin_service']) != $name) {
				$inner_st = 'display:none';
			} else {
				$inner_st = '';
			}
			ois_option_label(array( 'title' => 'Optin Info for ' . $ser_title, 'description'=>'', 'class' => 'ois_optin_account ois_optin_' . $name,  'style' => $inner_st));
			
			foreach ($data as $nice=>$item) { 
				ois_inner_label(array('title' => $nice));
				if ($name != 'other' && $name != 'mailchimp' && $nice != 'Form HTML') {
			echo '<input type="text"
				style="width:200px;"
				class="ois_textbox ois_optin_account_input"
				name="newskin_' . $item . '"
				account="' . $name . '"';
			if (!empty($this_skin['optin_settings'][str_replace('-', '_', $item)])
				&& trim($this_skin['optin_settings'][str_replace('-', '_', $item)]) != '') {
				$potential_val = trim($this_skin['optin_settings'][str_replace('-', '_', $item)]);
			} else {
				$potential_val = '';
			}
			if ($potential_val != '') {
				echo 'value="' . $potential_val . '"';
			} else {
				if (!empty($optin_accounts[$item])) {
					$potential_val = $optin_accounts[$item];
				} else {
					$potential_val = '';
				}
				if (trim($potential_val) != '') {
					echo 'value="' . $potential_val . '"';
				}
			}
			echo '/>';
		} else if ($nice == 'Form HTML' || $name == 'other' || $name == 'mailchimp' || $name == 'getResponse') { 
			if ($name == 'getResponse') {
				echo '<p style="padding:10px 0;text-decoration:underline;font-weight:bold;">OR</p>';
			}
			echo '<textarea type="text"
						style="width:500px; height: 200px;"
						class="ois_add_appearance ois_textbox ois_optin_account_input"
						name="newskin_' . $item . '"
						account="' . $name . '" >';
			if (!empty($this_skin['optin_settings'][str_replace('-', '_', $item)])) {
				$potential_val = trim($this_skin['optin_settings'][str_replace('-', '_', $item)]);
			} else {
				$potential_val = '';
			}
			if ($potential_val != '') {
				echo stripslashes($potential_val);
			} else {
				if (!empty($optin_accounts[$item])) {
					$potential_val = $optin_accounts[$item];
				} else {
					$potential_val = '';
				}
				if (trim($potential_val) != '') {
					echo stripslashes($potential_val);
				}
			}
			echo '</textarea>';
		}
		ois_end_option_and_table();			
	}
				
	}
	ois_option_end();
	ois_option_label(array('title' => 'Redirect Option', 'description' => 'Where will users go after they have subscribed?<br/><br/>Leave blank for no redirect.'));
	ois_inner_label(array('title' => 'Full Redirect URL',
			'description' => ''));
?>
			<input type="text" class="ois_textbox" id="ois_redirect_url" name="newskin_redirect" style="width:420px;" <?php if (!empty($this_skin)) { echo 'value="' . $this_skin['redirect_url'] . '"'; } ?> />
			<select id="ois_select_page">
			<option>Select from all Pages</option>
			<?php
	$pages = get_pages();
	foreach ( $pages as $pagg ) {
		$option = '<option value="' . get_page_link( $pagg->ID ) . '">';
		$option .= $pagg->post_title;
		$option .= '</option>';
		echo $option;
	}
?>
			</select>

	<?php
	ois_end_option_and_table();
	ois_end_option_and_table();
	
	ois_start_table('General Settings', 'mantra/Comments.png');
	ois_option_label(array('title' => 'Placement Options', 'description' => 'Where do you want your OptinBar to be displayed?', 'inner_style' => 'width:300px;' ));
	echo '<p><input type="checkbox" name="oib_active"';
	if ($oib_active == 'yes') {
		echo ' checked="checked"';
	}
	echo ' /> Activate the OptinBar</p>';
	echo '<p style="margin:10px 0;"><input type="checkbox" name="oib_homepage"';
	if ($oib_homepage == 'yes') {
		echo ' checked="checked"';
	}
	echo ' /> Display Bar on Homepage</p>';
	ois_option_label(array('title' => 'Post/Page Exceptions', 'description' => 'Do not place my bar on these posts'));
	ois_inner_label(array('title' => 'Post IDs<br/><small>e.g. <em>15,27,32</em>.</small>'));
	echo '<input type="text" style="width:300px;" class="ois_textbox" name="oib_exclude_posts"';
	if (!empty($this_skin['exclude_posts'])) {
		echo ' value="' . $this_skin['exclude_posts'] . '"';
	}
	echo ' /><small style="margin-left:15px;"><a href="http://optinskin.com/faq/">Need to know how to find the post ID?</a></small>';
	ois_table_end();
	ois_inner_label(array('title' => 'Page IDs<br/><small>e.g. <em>15,27,32</em>.</small>'));
	echo '<input type="text" style="width:300px;" class="ois_textbox" name="oib_exclude_page"';
	if (!empty($this_skin['exclude_page'])) {
		echo ' value="' . $this_skin['exclude_page'] . '"';
	}
	echo ' />';
	ois_table_end();
	ois_option_end();

	ois_option_label(array('title' => 'Category Exceptions', 'description' => 'Do not place my bar on posts in these categories'));
	ois_inner_label(array('title' => 'Category IDs<br/><small>e.g. <em>1,3,4</em></small>'));
	echo '<input type="text" class="ois_textbox" id="ois_exclude_cats" name="newskin_exclude_cats" style="width:240px;"';
	if (!empty($this_skin['exclude_categories'])) { 
		echo ' value="' . $this_skin['exclude_categories'] . '"'; 
	}
	echo ' />';
	echo '<select id="ois_select_cat" name="newskin_exclude_cats">';
	echo '<option>Select from all Categories</option>';
	$cats = get_categories();
	foreach ( $cats as $cat ) {
		$option = '<option value="' . $cat->cat_ID . '">';
		$option .= $cat->cat_name;
		$option .= '</option>';
		echo $option;
	}
	
?>
	</select>
	<a href="javascript:void();" id="ois_excl_cat" class="ois_secondary_button" >Add To List</a>
	<script type="text/javascript" >
		jQuery(document).ready(function ($) {
			$('#ois_excl_cat').click(function () {
				var cur_cats = $('#ois_exclude_cats').val();
				if (cur_cats != '') {
					cur_cats = cur_cats + ',' + $('#ois_select_cat').val();
				} else {
					cur_cats = $('#ois_select_cat').val();
				}
				$('#ois_exclude_cats').val(cur_cats);
			});
		});
	</script>
	<?php
	ois_end_option_and_table();
	ois_end_option_and_table();
	echo '</form>';
	ois_end_option_and_table();
	
	?>
	<script type="text/javascript">
	jQuery(document).ready(function ($) {
		oib_update_preview();
		$('.ois_optin_choice').change(function() {
			$('.ois_optin_account').hide();
			$('.ois_optin_' + $(this).val()).show();
		});
		$('.oib_color_picker').each(function() {
			var id = $(this).attr('id');
			var id_parts = id.split('_');
			var insigma = id_parts[2] + '_' + id_parts[3];
			$(this).farbtastic(function() {
				$('#oib_' + insigma).val($.farbtastic($('#' + id)).color);
				$('#link-color_example_' + insigma).css("background-color", $.farbtastic($('#' + id)).color);
			});
			$.farbtastic($('#' + id)).setColor($('#oib_' + insigma).val());
			$(this).click(function() {
				return false;
			});
		});
		$('.oib_picker_a, .oib_pickcolor').click(function() {
			var id = $(this).attr('id');
			var id_parts = id.split('_');
			var insigma = id_parts[2] + '_' + id_parts[3];
			if ($('#oib_picker_' + insigma).val() == 'Select a Color') {
				$('#oib_picker_' + insigma).val('Hide Picker');
				$.farbtastic($('#oib_colorpicker_' + insigma)).setColor($('#oib_' + insigma).val());
				$('#oib_colorpicker_' + insigma).show();
			} else {
				$('#oib_picker_' + insigma).val('Select a Color');
				$('#oib_colorpicker_' + insigma).hide();
				oib_update_preview();
			}
			if ($('#oib_' + insigma).val() == '') {
				$('#oib_' + insigma).val('#fff');
			}
			return false;
		});
		$(document).click(function() {
			$('.oib_color_picker').each(function() {
				if ($(this).is(':visible')) {
					var id = $(this).attr('id');
					var id_parts = id.split('_');
					var insigma = id_parts[2] + '_' + id_parts[3];
					$(this).hide();
					oib_update_preview();
				}
			});
			$('.oib_picker_a').val('Select a Color');
		});
		$('.oib_preview_item').blur(function () {
			oib_update_preview();
		});
		$('.oib_preview_list').change(function() {
			oib_update_preview();
		});
		
		function oib_update_preview() {
			var cur_design = $('#oib_unrefined_wrapper').html();
			$('.oib_preview_item').each(function () {
				var new_val = $(this).val();
				var design_attr = '%' + $(this).attr('rel') + '%';
				cur_design = cur_design.replace(new RegExp(design_attr, 'g'), new_val);
			});
			$('#oib_preview_wrapper').html(cur_design);
		}
	});
	</script>
	<?php
	ois_section_end();

}

function oib_create_form($settings) {

/*
	$service = $settings['service'];
	
	if ($service != 'other') {
		$form = '<form method="post" action="';
		$form_action = '';
		$email_name = '';
		$hidden = '';
		$button_text = $settings['button_text'];
		if ($service == 'feedburner') {
			// Feedburner
			$form_action = 'http://feedburner.google.com/fb/a/mailverify';
			$email_name = 'email';
			if (!empty($settings['feedburner_id'])) {
				$id = $settings['feedburner_id'];
			} else {
				$id = '';
			}
			$hidden .= '<input type="hidden" value="' . $id . '" name="uri"/>'; // user's id
			$hidden .= '<input type="hidden" name="loc" value="en_US"/>'; // location: English US (fine for now.)
		} else if ($service == 'aweber') {
			// Aweber
			$form_action = 'http://www.aweber.com/scripts/addlead.pl';
			$email_name = 'email';
			if (!empty($settings['aweber_id'])) {
				$list_id = $settings['aweber_id']; // get list id.
			} else {
				$list_id = '';
			}
			if (!empty($settings['aweber_redirect'])) {
				$redirect_url = $settings['aweber_redirect']; // redirect to specified.
			} else {
				$redirect_url = get_option('home_url'); // if no redirect, go home.
			}
			$hidden .= '<input type="hidden" name="listname" value="' . $list_id . '" />';
			$hidden .= '<input type="hidden" name="meta_message"  value="1" />';
			$hidden .= '<input type="hidden" name="redirect"  value="' . $redirect_url . '" />';
		} else if ($service == 'mailchimp') {
			// MailChimp
			if (!empty($settings['mailchimp_action'])) {
				$form_action = $settings['mailchimp_action'];
			} else {
				$form_action = '';
			}
		} else if ($service == 'icontact') {
			// iContact
			$form_action = 'http://app.icontact.com/icp/signup.php';
			$email_name = 'fields_email';
			if (!empty($settings['iContact_id'])) {
				$hidden .= '<input type="hidden" name="listid" value="' . $settings['iContact_id'] . '" />';
				if (!empty($settings['iContact_special'])) {
					$hidden .= '<input type="hidden" name="specialid:' . $settings['iContact_id'] . '" ' .
					'value="' . $settings['iContact_special'] . '">';
			}
			if (!empty($settings['iContact_redirect'])) {
				$hidden .= '<input type="hidden" name="redirect" value="' . $settings['iContact_redirect'] . '"/>';
			}
			if (!empty($settings['iContact_client'])) {
				$hidden .= '<input type="hidden" name="clientid" value="' . $settings['iContact_client'] . '" />';
			}
			if (!empty($settings['iContact_form'])) {
				$hidden .= '<input type="hidden" name="formid" value="' . $settings['iContact_form'] . '" />';
			}
			if (!empty($settings['iContact_real'])) {
				$hidden .= '<input type="hidden" name="reallistid" value="' . $settings['iContact_real'] . '"/>';
			}
			if (!empty($settings['iContact_double'])) {
				$hidden .= '<input type="hidden" name="doubleopt" value="' . $settings['iContact_double'] . '" />';
			}
		} else if ($service == 'getResponse') {
			// GetResponse
			$form_action = 'https://app.getresponse.com/add_contact_webform.html';
			$email_name = 'email';
			$hidden .= '<input type="hidden" name="webform_id" value="' . $id . '" />';
		} else if ($service == 'infusionsoft') {
			// InfusionSoft
			if (!empty($settings['is_action'])) {
				$form_action = $settings['is_action'];
			}
			$email_name = 'inf_field_Email';
			$hidden .= '<input name="inf_form_xid" type="hidden" value="' . $is_id . '" />;';
			$hidden .= '<input name="inf_form_name" type="hidden" value="' . $is_name . '" />';
			$hidden .= '<input name="infusionsoft_version" type="hidden" value="1.22.10.32">';
		}
	
		$form .= $form_action . '" >';
		$form .= '<input type="text" name="' . $email_name . '" id="oib_email" />';
		$form .= '<input type="submit" value="'. $settings .'"';
	}
*/
	
}


?>