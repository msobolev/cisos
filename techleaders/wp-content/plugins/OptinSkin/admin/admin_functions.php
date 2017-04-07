<?php
function ois_section_title($title, $subtitle, $helper) {
?>
	<style type="text/css">
		#ois_header {
			background-image: url(<?php echo WP_PLUGIN_URL; ?>/OptinSkin/admin/images/header_bg.jpg) !important;
			background-color: transparent;
			background-repeat: no-repeat;
			margin-top:-5px;
			width: 100%;
			margin-left: -19px;
			padding: 10px 2px 5px 30px;
			-webkit-box-shadow: rgba(0, 0, 0, 0.496094) 0px 1px 1px 0px;
			box-shadow: rgba(0, 0, 0, 0.496094) 0px 1px 1px 0px;
			border: 1px solid #333;
			color: #fff;
			background-color: #363636;
			border-radius:0px;
			-webkit-border-radius:0px;
			-moz-border-radius:0px;
			margin-bottom: 10px;
		}
	</style>
	<?php
	echo '<div class="wrap" style="position:relative;">
			<div id="ois_header" style="">
			<img src="' . WP_PLUGIN_URL . '/OptinSkin/front/images/optinskin.png" style="margin:0; height:60px; float:right; padding-top: 15px;" />
			<h2 style="text-shadow: none; color: #FFC000;font-family: \'Lobster\', Arial !important;">' . $title . '</h2>' .
		'<h3 style="color: #fff;">' . $subtitle . '</h3>' .
		'<p style="color: #fff;">' . $helper . '</p>
		</div><div style="clear:both;"></div>';
}
function ois_section_end() {
	echo '</div>';
}

function ois_option_label($data) {
	if (!empty($data['id'])) {
		$el_id = $data['id'];
	} else {
		$el_id = '';
	}
	if (!empty($data['class'])) {
		$el_class = 'class="' . $data['class'] . '"';
	} else {
		$el_class = '';
	}
	if (!empty($data['style'])) {
		$style = 'style="' . $data['style'] . '"';
	} else {
		$style = '';
	}
	if (!empty($data['inner_style'])) {
		$inner_style = $data['inner_style'];
	} else {
		$inner_style = '';
	}
	
	echo '<tr id="' . $el_id . '" ' . $el_class . ' ' . $style . '"';
	if (!empty($data['alternative']) && $data['alternative'] == 'yes') {
		echo ' class="alternate" ';
	}
	echo '>
			<td class="ois_label" style="font-family:\'Arial\';text-align:left !important;padding: 15px 5px 15 10px !important;text-shadow: #fff 0px 1px 0px !important;font-size:12px;min-width:170px;' . $inner_style . '">
				' . $data['title'] . '
				<p style="font-family: \'Arial\';">
					<small style="font-size:11px;">' . $data['description'] . '</small>
				</p>
			</td>
			<td class="ois_field">';

	if (!empty($data['image']) && trim($data['image']) != '') {
		if (!empty($data['image-right-padding']) 
			&& trim($data['image-right-padding']) != '') {
			$right_padding = $data['image-right-padding'];
		} else {
			$right_padding = '50px';
		}
		echo '<img src="' . WP_PLUGIN_URL . '/OptinSkin/admin/images/' . $data['image'] . '" style="float:right;" />';
	}
}

function ois_option_end() {
	echo '</td></tr>';
}

function ois_start_option_table($title, $multiform, $img) {
	if ($multiform) {
		$multiform = 'enctype="multipart/form-data"';
	} else {
		$multiform = '';
	}
	echo '<form method="post" ' . $multiform . ' >';
	ois_start_table ($title, $img);
}

function ois_start_table($title, $img) {
	if (empty($img)) {
		$img = '';
	}
	echo '
		<table class="widefat ois_table" style="margin-bottom: 10px !important;">
			<thead>
				<tr class="ois_header_row">
					<th class="ois_header_title" style="font-family: \'Voces\' !important;border:none;color:#333;font-size:14px;font-weight:normal;vertical-align:middle !important;max-width:250px;text-shadow: #fff 0px 1px 0px !important;">';
			
		if (trim($img) != '') {
			echo '<img src="' . WP_PLUGIN_URL . '/OptinSkin/admin/images/' . $img . '" style="height:16px;padding:0;margin:0;margin-bottom:-2px;padding-right:10px;" />';
		}
	echo $title . '</th>
					<th style="border:none;color:#333;vertical-align:middle !important;"><span style="float:right;"><a class="ois_header_min" data-closed="' . WP_PLUGIN_URL . '/OptinSkin/admin/images/plus.png" data-open="' . WP_PLUGIN_URL . '/OptinSkin/admin/images/minus.png" href="javascript:void();" ><img src="' . WP_PLUGIN_URL . '/OptinSkin/admin/images/minus.png" style="height:25px;margin-bottom:-5px;" /></a></span></th>
				</tr>
			</thead>';
}
function ois_table_end() {
	echo '</table>'; // Yes, really.
}

function ois_inner_label($data) {
	if (!empty($data['style'])) {
		$style = $data['style'];
	} else {
		$style = '';
	}
	if (!empty($data['inner_style'])) {
		$inner_style = $data['inner_style'];
	} else {
		$inner_style = '';
	}
	if (!empty($data['title'])) {
		$title = $data['title'];
	} else {
		$title = '';
	}
	echo '<table class="ois_table_inner" style="' . $style . '">
			<tr>';
			
			if (trim($title) != '') {
				echo '<th scope="row" style="min-width:100px;border:none;">
					' . $title . '
				</th>';
			}
			echo '<td class="ois_field_inner" style="' . $inner_style . '">';
}

function ois_validate_message($data) {
	
	if (!empty($data['style'])) {
		$style = $data['style'];
	} else {
		$style = '';
	}
	if (!empty($data['value'])) {
		$value = $data['value'];
	} else {
		$value = '';
	}
	
	if (!$data['show']) {
		$style = 'style="display:none; ' . $style . '"';
	} else {
		$style = 'style="' . $style . '"';
	}
	$content = '<span class="ois_valid_message_' . $value . '" ' .
		$style . ' id="' . $data['id'] . '">' . $data['text'] . '</span>';
	if (!empty($data['paragraph']) && trim($data['paragraph']) != '') {
		echo '<p>' . $content . '</p>';
	} else {
		echo $content;
	}
}

function ois_create_steps($steps) {

	$content = '<div class="ois_steps">';
	foreach ($steps as $name => $step) {
		$content .= '
		<div class="ois_step_wrap">
			<div class="ois_ui_box">
					<h3 class="ois_' . $name . '">
						<div class="ois_step_title">
							' . $step['title'] . '
						</div>
					</h3>
				<div class="ois_step_description">
					' . $step['description'] . '
				</div>
			</div>
		</div>';
	}
	$content .= '</div>

	<div style="clear:both;"></div>';

	echo trim($content);
}

function ois_notification($message, $style, $link) {
	$content = '<div class="ois_notification" style="' . $style . '">';
	$content .= $message;

	if ($link == 'drafts') {
		$uri = explode('?', $_SERVER['REQUEST_URI']);
		$drafts_url = $uri[0] . '?page=ois-drafts';
		$content .= ' <a href="'.$drafts_url.'">View Drafts</a>';
	} else if ($link == 'trash') {
			$uri = explode('?', $_SERVER['REQUEST_URI']);
			$trash_url = $uri[0] . '?page=ois-trash';
			$content .= ' <a href="'.$trash_url.'">View Trash</a>';
		}
	$content .= '</div>';
	echo $content;
}

function ois_end_option_and_table() {
	ois_option_end();
	ois_table_end();
}

function ois_super_button($attr) {
	if (!empty($attr['id'])) {
		$id = $attr['id'];
	} else {
		$id = '';
	}
	if (!empty($attr['value'])) {
		$value = $attr['value'];
	} else {
		$value = '';
	}
	if (!empty($attr['style'])) {
		$style = $attr['style'];
	} else {
		$style = '';
	}
	echo '<input	type="submit"
					class="ois_super_button"
					id="' . $id . '"
					value="' . $value . '"
					style="' . $style . '" />';
}
function ois_secondary_button($attr) {
	if (!empty($attr['id'])) {
		$id = $attr['id'];
	} else {
		$id = '';
	}
	if (!empty($attr['value'])) {
		$value = $attr['value'];
	} else {
		$value = '';
	}
	if (!empty($attr['style'])) {
		$style = $attr['style'];
	} else {
		$style = '';
	}
	echo '<input 	type="submit"
					class="ois_secondary_button"
					id="' . $id . '"
					value="' . $value . '"
					style="' . $style . '" />';
}

add_shortcode('ois_show_all', 'ois_test_all');

function ois_test_all () {
	$skin_designs = get_option('ois_designs');

	foreach ($skin_designs as $n=>$design) {
		$ex_skin = array ('optin-service' => 'feedburner');
		
		$default_app = array();
		foreach ($design['appearance'] as $section=>$items) {
			foreach ($items as $value) {
				$default_app[$value['attr']] = $value['default'];
			}
		}
		$ex_skin = array_merge($ex_skin, array('appearance' => $default_app));
		
		if (trim($design['css_url']) != '') {
			$to_return .= "<link rel='stylesheet' id='ois_design_" . $design['id'] . "-css'  href='" . $design['css_url'] . "' type='text/css' media='all' />";
		} else {
			$to_return .= '<!-- no css for this skin -->';
		}
		if (!empty($ex_skin['google_fonts'])) {
			foreach($ex_skin['google_fonts'] as $val) {
				$val_explode = explode(' ', $val);
				$fam = implode('+', $val_explode);
				$title = implode('_', $val_explode); 
				$to_return .= "<link rel='stylesheet' id='google_font_" . $title . "' href='http://fonts.googleapis.com/css?family=" . $fam . "' type='text/css' media='all' />";
			}
       }
       
		$to_return .= '<div style="margin-bottom:10px;clear:both;">' . $design['id'] . ': <br/>' . ois_make_skin($ex_skin, $design) . '</div>';
		
	}
	return $to_return;

}
?>