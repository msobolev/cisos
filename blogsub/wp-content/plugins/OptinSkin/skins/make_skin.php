<?php

function ois_make_skin($skin, $design) {

	if (!empty($skin['id'])) {
		$skin_id = $skin['id'];
	} else {
		$skin_id = '';
	}
	if (!empty($skin['optin_service'])) {
		$service = $skin['optin_service'];
	} else {
		$service = '';
	}
	if (!empty($skin['placeholder_type'])) {
		$placeholder_type = $skin['placeholder_type'];
	} else {
		$placeholder_type = 'placeholder';
	}
	if (!empty($design['optin_settings'])) {
		if (!empty($design['optin_settings']['enable_name'])) {
			$enable_name = $design['optin_settings']['enable_name'];
		} else {
			$enable_name = '';
		}
		if (!empty($design['appearance']['text']['Name Placeholder'])) {
			$placeholder_name = stripslashes('%name-placeholder%');
		} else {
			if (!empty($design['optin_settings']['placeholders']['name'])) {
				$placeholder_name = $design['optin_settings']['placeholders']['name'];
			} else {
				$placeholder_name = '';
			}
		}
		if (!empty($design['appearance']['text']['Email Placeholder'])) {
			$placeholder_email = stripslashes('%email-placeholder%');
		} else {
			if (!empty($design['optin_settings']['placeholders']['email'])) {
				$placeholder_email = $design['optin_settings']['placeholders']['email'];
			} else {
				$placeholder_email = '';
			}
		}

		if (!empty($design['appearance']['text']['Button Style'])) {
			$button_style = 'style="%button-style%"';
		} else {
			$button_style = '';

			if (!empty($design['appearance']['text']['Button Top Gradient'])
				&& !empty($design['appearance']['text']['Button Bottom Gradient'])) {
				$button_style .=  ois_vertical_gradient('%button-top-gradient%', '%button-bottom-gradient%');
			}
			if (!empty($design['appearance']['text']['Button Text Color'])) {
				$button_style .=  'color:%button-text-color%!important;';
			}
			if (!empty($design['appearance']['text']['Button Border Color'])) {
				$button_style .=  'border: 1px solid %button-border-color%!important;';
			}
			if (!empty($design['appearance']['text']['Button Shadow Color'])) {
				$button_style .=  '-webkit-box-shadow: 0px 1px 1px 0px %button-shadow-color%!important;-moz-box-shadow: 0px 1px 1px 0px %button-shadow-color%!important;box-shadow: 0px 1px 1px 0px %button-shadow-color%!important;';
			}

			if ($button_style != '') {
				$button_style = 'style="' . $button_style . '"';
			}
		}

		if (!empty($design['appearance']['text']['Name Width'])) {
			$name_width = stripslashes('%name-width%');
		} else {
			$name_width = '';
		}
		if (!empty($design['appearance']['text']['Email Width'])) {
			$email_width = stripslashes('%email-width%');
		} else {
			$email_width = '';
		}
		if (!empty($design['optin_settings']['labels']['name'])) {
			$label_name = $design['optin_settings']['labels']['name'];
		} else {
			$label_name = '';
		}
		if (!empty($design['optin_settings']['labels']['email'])) {
			$label_email = $design['optin_settings']['labels']['email'];
		} else {
			$label_email = '';
		}
		if (!empty($design['optin_settings']['force_break'])) {
			$force_break = $design['optin_settings']['force_break'];
		} else {
			$force_break = '';
		}
		if (!empty($design['optin_settings']['maintain_line'])) {
			$maintain_line = $design['optin_settings']['maintain_line'];
		} else {
			$maintain_line = '';
		}

		if (!empty($design['appearance']['text']['Button Text'])) {
			$button_value = stripslashes('%button-text%');
		} else {
			$button_value = $design['optin_settings']['button_value'];
		}
	} else {
		$enable_name = '';
		$placeholder_name = '';
		$placeholder_email = '';
		$email_width = '';
		$name_width = '';
		$label_name = '';
		$label_email = '';
		$force_break = '';
		if (!empty($design['optin_settings']['button_value'])) {
			$button_value = $design['optin_settings']['button_value'];
		} else {
			$button_value = 'Subscribe';
		}

	}

	if (!empty($skin['redirect_url'])) {
		$redirect_url = $skin['redirect_url'];
	} else {
		$redirect_url = home_url();
	}
	if (trim($skin['hidden_name_1']) != '') {
		$hidden_name_1 = $skin['hidden_name_1'];
		$hidden_value_1 = $skin['hidden_value_1'];
	}
	if (trim($skin['hidden_name_2']) != '') {
		$hidden_name_2 = $skin['hidden_name_2'];
		$hidden_value_2 = $skin['hidden_value_2'];
	}
	if (trim($skin['hidden_name_3']) != '') {
		$hidden_name_3 = $skin['hidden_name_3'];
		$hidden_value_3 = $skin['hidden_value_3'];
	}
	
	$basic_attr = array (
		'skin_id' => $skin_id,
		'design_id' => $design['id'],
		'enable_name' => $enable_name,
		'placeholder_name' => $placeholder_name,
		'placeholder_email' => $placeholder_email,
		'name_width' => $name_width,
		'email_width' => $email_width,
		'label_name' => $label_name,
		'label_email' => $label_email,
		'button_text' => 'Subscribe',
		'redirect_url' => $redirect_url,
		'hidden_name_1' => $hidden_name_1,
		'hidden_name_2' => $hidden_name_2,
		'hidden_name_3' => $hidden_name_3,
		'hidden_value_1' => $hidden_value_1,
		'hidden_value_2' => $hidden_value_2,
		'hidden_value_3' => $hidden_value_3,
		'button_value' => $button_value,
		'button_style' => $button_style,
		'force_break' => $force_break,
		'placeholder_type' => $placeholder_type,
		'maintain_line' => $maintain_line,
	);

	if ($service == 'aweber') {
		// Aweber
		$id = $skin['optin_settings']['aweber_id'];
		$form_attr = array (
			'id' => $id,
		);
		$form_attr = array_merge($form_attr, $basic_attr);
		$optin_form = ois_aweber_form($form_attr);
	} else if ($service == 'icontact') {
			// iContact
			$id = $skin['optin_settings']['icontact_id'];
			$client = $skin['optin_settings']['icontact_client'];
			$real = $skin['optin_settings']['icontact_real'];
			$double = $skin['optin_settings']['icontact_double'];
			$form = $skin['optin_settings']['icontact_form'];
			$special = $skin['optin_settings']['icontact_special'];
			$form_attr = array (
				'id' => $id,
				'client' => $client,
				'form' => $form,
				'real' => $real,
				'double' => $double,
				'special' => $special,
			);
			$form_attr = array_merge($form_attr, $basic_attr);
			$optin_form = ois_icontact_form($form_attr);
		} else if ($service == 'other') {
			$other_html = stripslashes(html_entity_decode($skin['optin_settings']['other_html']));
			$other_form = str_replace('type="email"', 'type="text"', $other_form);
			$optin_form = $other_html;
		} else if ($service == 'mailchimp') {
			if (!empty($skin['optin_settings']['mailchimp_action'])) {
				$mailchimp_action = $skin['optin_settings']['mailchimp_action'];
				$form_attr = array (
					'action' => $mailchimp_action,
				);
				$form_attr = array_merge($form_attr, $basic_attr);
				$optin_form = ois_mailchimp_form($form_attr);
			} else {
				$mailchimp_form = stripslashes(html_entity_decode($skin['optin_settings']['mailchimp_form']));
				$mailchimp_action = explode('<form action="', $mailchimp_form);
				if (!empty($mailchimp_action) && isset($mailchimp_action[1])) {
					$mailchimp_action = explode('"', $mailchimp_action[1]);
					if (!empty($mailchimp_action)) {
						$mailchimp_action = $mailchimp_action[0];
						$form_attr = array (
							'action' => $mailchimp_action,
						);
						$form_attr = array_merge($form_attr, $basic_attr);
						$optin_form = ois_mailchimp_form($form_attr);
					} else { // this is messy
						$mailchimp_form = stripslashes(html_entity_decode($skin['optin_settings']['mailchimp_form']));
						$mailchimp_form = str_replace('type="email"', 'type="text"', $mailchimp_form);
						$optin_form = $mailchimp_form;
					}
				} else {
					$mailchimp_form = stripslashes(html_entity_decode($skin['optin_settings']['mailchimp_form']));
					$mailchimp_form = str_replace('type="email"', 'type="text"', $mailchimp_form);
					$optin_form = $mailchimp_form;
				}
			}
		} else if ($service == 'getResponse') {
			if (!empty($skin['optin_settings']['getResponse_id'])) {
				$id = $skin['optin_settings']['getResponse_id'];
			} else {
				$id = '';
			}
			$form_attr = array (
				'id' => $id,
			);
			$form_attr = array_merge($form_attr, $basic_attr);
			$optin_form = ois_getResponse_form($form_attr);
		} else if ($service == 'infusionSoft') {
			if (!empty($skin['optin_settings']['infusionSoft_action'])) {
				$action = $skin['optin_settings']['infusionSoft_action'];
			} else {
				$action = '';
			}
			if (!empty($skin['optin_settings']['infusionSoft_name'])) {
				$name = $skin['optin_settings']['infusionSoft_name'];
			} else {
				$name = '';
			}
			if (!empty($skin['optin_settings']['infusionSoft_id'])) {
				$id = $skin['optin_settings']['infusionSoft_id'];
			} else {
				$id = '';
			}

			$form_attr = array (
				'id' => $id,
				'name' => $name,
				'action' => $action,
			);
			$form_attr = array_merge($form_attr, $basic_attr);
			$optin_form = ois_infusionSoft_form($form_attr);
		} else if ($service == 'custom') {
			if (!empty($skin['optin_settings']['custom_action'])) {
				$action = $skin['optin_settings']['custom_action'];
			} else {
				$action = '';
			}
			if (!empty($skin['optin_settings']['custom_email'])) {
				$email = $skin['optin_settings']['custom_email'];
			} else {
				$email = '';
			}
			if (!empty($skin['optin_settings']['custom_name'])) {
				$name = $skin['optin_settings']['custom_name'];
			} else {
				$name = '';
			}
			$form_attr = array (
				'action' => $action,
				'email' => $email,
				'name' => $name,
			);
			$form_attr = array_merge($form_attr, $basic_attr);
			$optin_form = ois_custom_form($form_attr);
			
		} else {
		// Feedburner
		if (!empty($skin['optin_settings']['feedburner_id'])) {
			$id = $skin['optin_settings']['feedburner_id'];
		} else {
			$id = '';
		}
		$form_attr = array(
			'id' => $id,
		);
		$form_attr = array_merge($form_attr, $basic_attr);
		$optin_form = ois_feedburner_form($form_attr);
	}

	$content = html_entity_decode(stripslashes($design['html']));
	if (trim($design['css']) != '') {
		$content .= trim('<style type="text/css">' . trim(html_entity_decode(stripslashes($design['css']))) . '</style>');
	}
	$content = str_replace('%optin_form%', $optin_form, $content);
	$content = str_replace('%cur_url%', get_permalink(), $content);

	$replacements = array (
		'[b]' => '<b>',
		'[/b]' => '</b>',
		'[i]' => '<i>',
		'[/i]' => '</i>',
	);

	// Now we need to replace the appearance attributes
	if (!empty($skin['appearance'])) {
		$app_sections = $skin['appearance'];
	} else {
		$app_sections = null;
	}
	if (!empty($app_sections)) {
		foreach ($app_sections as $name=>$value) {
			$name = explode(';', $name);
			if (!empty($replacements)) {
				foreach ($replacements as $replace=>$with) {
					$value = str_replace($replace, $with, $value);
				}
			}
			$content = str_replace('%' . $name[0] . '%', stripslashes($value), $content);
		}
	}

	if (!empty($skin['scrolled_past'])) {
		$popup_data = $skin['scrolled_past'];
	}
	if (!empty($skin['position'])) {
		if ($skin['position'] == 'popup') { // this skin is a popup
			$extra_classes = 'ois_popup';
		}
	}
	if (!empty($skin['aff_username'])) {
		$aff_username = $skin['aff_username'];
	} else {
		$aff_username = '';
	}
	if (!empty($skin['aff_enable'])) {
		$aff_enable = $skin['aff_enable'];
	} else {
		$aff_enable = '';
	}
	if (!empty($skin['margins'])) {
		$skin_margins = $skin['margins'];
	} else {
		$skin_margins = null;
	}
	if (!empty($skin['margin_type'])) {
		$margin_type = $skin['margin_type'];
	} else {
		$margin_type = 'margin';
	}
	$data = array (
		'skin_id' => $skin_id,
		'margins' => $skin_margins,
		'margin_type' => $margin_type,
		'aff_username' => $aff_username,
		'aff_enable' => $aff_enable,
		'extra_classes' => $extra_classes,
		'popup_data' => $popup_data,
	);
	$content = ois_wrapper($content, $data);
	return $content;
}

function ois_mailchimp_form($attr) {
	$data = $attr;
	
	if (!empty($attr['form_style'])) {
		$data['form_style'] = $attr['form_style'];
	} else {
		$data['form_style'] = '';
	}
	if (trim($attr['button_value']) == '') {
		$data['button_text'] = 'Subscribe';
	} else {
		$data['button_text'] = $attr['button_value'];
	}
	$data['enable_name'] = $attr['enable_name'];
	$data['placeholder_name'] = $attr['placeholder_name'];
	$data['placeholder_email'] = $attr['placeholder_email'];
	$data['name_width'] = $attr['name_width'];
	$data['email_width'] = $attr['email_width'];
	$data['force_break'] = $attr['force_break'];
	$data['button_style'] = $attr['button_style'];
	$data['design_id'] = $attr['design_id'];
	$data['skin_id'] = $attr['skin_id'];
	$data['action'] = trim($attr['action']);
	$data['placeholder_type'] = $attr['placeholder_type'];
	$data['maintain_line'] = $attr['maintain_line'];

	//$data['open_form_extras'] = 'target="_blank"'; // open in a new tab

	$data['service'] = 'mailchimp';
	$data['name_name'] = 'FNAME';
	$data['email_name'] = 'EMAIL';

	$mailchimp_form = ois_create_form_with_data($data);
	return $mailchimp_form;
}

function ois_feedburner_form($attr) {
	$data = $attr;
	
	if (!empty($attr['id'])) { // for the Feedburner ID.
		$id = trim($attr['id']);
	} else {
		$id = '';
	}
	if (!empty($attr['form_style'])) {
		$data['form_style'] = $attr['form_style'];
	} else {
		$data['form_style'] = '';
	}
	if (trim($attr['button_value']) == '') {
		$data['button_text'] = 'Subscribe';
	} else {
		$data['button_text'] = $attr['button_value'];
	}
	$data['enable_name'] = $attr['enable_name'];
	$data['placeholder_name'] = $attr['placeholder_name'];
	$data['placeholder_email'] = $attr['placeholder_email'];
	$data['name_width'] = $attr['name_width'];
	$data['email_width'] = $attr['email_width'];
	$data['force_break'] = $attr['force_break'];
	$data['button_style'] = $attr['button_style'];
	$data['design_id'] = $attr['design_id'];
	$data['skin_id'] = $attr['skin_id'];
	$data['placeholder_type'] = $attr['placeholder_type'];
	$data['maintain_line'] = $attr['maintain_line'];

	$data['action'] = 'http://feedburner.google.com/fb/a/mailverify';
	$data['service'] = 'feedburner';
	$data['name_name'] = 'fname';
	$data['email_name'] = 'email';
	$data['open_form_extras'] = 'target="popupwindow" onsubmit = "window.open(\'http://feedburner.google.com/fb/a/mailverify?uri=' . $id . '\', \'popupwindow\', \'scrollbars=yes,width=550,height=520\');return true"';
	$data['hidden_values'] =
		'<input type="hidden" value="' . $id . '" name="uri"/>
		<input type="hidden" name="loc" value="en_US"/>';

	$feedburner_form = ois_create_form_with_data($data);
	return $feedburner_form;

}

function ois_aweber_form($attr) { // Always a pleasure.
	$data = $attr;
	
	if (!empty($attr['id'])) { // for the Aweber ID.
		$id = trim($attr['id']);
	} else {
		$id = '';
	}
	if (!empty($attr['redirect_url'])) { // Aweber Redirect
		$redirect_url = $attr['redirect_url'];
	} else {
		$redirect_url = home_url();
	}
	if (!empty($attr['form_style'])) {
		$data['form_style'] = $attr['form_style'];
	} else {
		$data['form_style'] = '';
	}
	if (trim($attr['button_value']) == '') {
		$data['button_text'] = 'Subscribe';
	} else {
		$data['button_text'] = $attr['button_value'];
	}
	$data['enable_name'] = $attr['enable_name'];
	$data['placeholder_name'] = $attr['placeholder_name'];
	$data['placeholder_email'] = $attr['placeholder_email'];
	$data['name_width'] = $attr['name_width'];
	$data['email_width'] = $attr['email_width'];
	$data['force_break'] = $attr['force_break'];
	$data['button_style'] = $attr['button_style'];
	$data['design_id'] = $attr['design_id'];
	$data['skin_id'] = $attr['skin_id'];
	$data['placeholder_type'] = $attr['placeholder_type'];
	$data['maintain_line'] = $attr['maintain_line'];

	$data['action'] = 'http://www.aweber.com/scripts/addlead.pl'; // Trusty Aweber URI.
	$data['service'] = 'aweber';
	$data['name_name'] = 'name';
	$data['email_name'] = 'email';
	$data['open_form_extras'] = '';
	$data['hidden_values'] =
		'<input type="hidden" name="listname" value="' . $id . '" />' .
		'<input type="hidden" name="meta_message"  value="1" />' .
		'<input type="hidden" name="redirect"  value="' . $redirect_url . '" />';

	$aweber_form = ois_create_form_with_data($data);
	return $aweber_form;
}

function ois_icontact_form($attr) {
	$data = $attr;
	
	if (!empty($attr['id'])) { // for the iContact ID.
		$id = trim($attr['id']);
	} else {
		$id = '';
	}
	// Various iContact attributes
	$client = trim($attr['client']);
	$skin_id = $attr['skin_id'];
	$double = $attr['double'];
	$real =  $attr['real'];
	$form = $attr['form'];
	$special = $attr['special'];

	if (!empty($attr['form_style'])) {
		$data['form_style'] = $attr['form_style'];
	} else {
		$data['form_style'] = '';
	}
	if (trim($attr['button_value']) == '') {
		$data['button_text'] = 'Subscribe';
	} else {
		$data['button_text'] = $attr['button_value'];
	}
	if (!empty($attr['redirect_url'])) { // iContact redirect
		$redirect_url = $attr['redirect_url'];
	} else {
		$redirect_url = home_url();
	}
	$data['enable_name'] = $attr['enable_name'];
	$data['placeholder_name'] = $attr['placeholder_name'];
	$data['placeholder_email'] = $attr['placeholder_email'];
	$data['name_width'] = $attr['name_width'];
	$data['email_width'] = $attr['email_width'];
	$data['force_break'] = $attr['force_break'];
	$data['button_style'] = $attr['button_style'];
	$data['design_id'] = $attr['design_id'];
	$data['skin_id'] = $attr['skin_id'];
	$data['placeholder_type'] = $attr['placeholder_type'];
	$data['maintain_line'] = $attr['maintain_line'];

	$data['action'] = 'http://app.icontact.com/icp/signup.php'; // Trusty iContact URI.
	$data['service'] = 'icontact';
	$data['name_name'] = 'fields_fname';
	$data['email_name'] = 'fields_email';
	$data['open_form_extras'] = '';
	$data['hidden_values'] =
		'<input type="hidden" name="listid" value="' . $id . '" />' .
		'<input type="hidden" name="specialid:' . $id . '" value="' . $special . '">' .
		'<input type="hidden" name="redirect" value="' . $redirect_url . '"/>' .
		'<input type="hidden" name="clientid" value="' . $client . '" />' .
		'<input type="hidden" name="formid" value="' . $form . '" />' .
		'<input type="hidden" name="reallistid" value="' . $real . '"/>' .
		'<input type="hidden" name="doubleopt" value="' . $double . '" />';

	$icontact_form = ois_create_form_with_data($data);
	return $icontact_form;
}

function ois_getResponse_form($attr) {
	$data = $attr;
	
	if (!empty($attr['id'])) { // for the GetResponse ID.
		$id = trim($attr['id']);
	} else {
		$id = '';
	}
	if (!empty($attr['form_style'])) {
		$data['form_style'] = $attr['form_style'];
	} else {
		$data['form_style'] = '';
	}
	if (trim($attr['button_value']) == '') {
		$data['button_text'] = 'Subscribe';
	} else {
		$data['button_text'] = $attr['button_value'];
	}
	$data['enable_name'] = $attr['enable_name'];
	$data['placeholder_name'] = $attr['placeholder_name'];
	$data['placeholder_email'] = $attr['placeholder_email'];
	$data['name_width'] = $attr['name_width'];
	$data['email_width'] = $attr['email_width'];
	$data['force_break'] = $attr['force_break'];
	$data['button_style'] = $attr['button_style'];
	$data['design_id'] = $attr['design_id'];
	$data['skin_id'] = $attr['skin_id'];
	$data['placeholder_type'] = $attr['placeholder_type'];
	$data['maintain_line'] = $attr['maintain_line'];

	$data['action'] = 'https://app.getresponse.com/add_contact_webform.html'; // GetResponse URI.
	$data['service'] = 'getResponse';
	$data['name_name'] = 'name';
	$data['email_name'] = 'email';
	$data['open_form_extras'] = '';
	$data['hidden_values'] = '<input type="hidden" name="webform_id" value="' . $id . '" />';

	$gr_form = ois_create_form_with_data($data);
	return $gr_form;
}

function ois_infusionSoft_form($attr) {
	$data = $attr;
	
	if (!empty($attr['id'])) { // for the InfusionSoft ID.
		$id = trim($attr['id']);
	} else {
		$id = '';
	}
	if (!empty($attr['form_style'])) {
		$data['form_style'] = $attr['form_style'];
	} else {
		$data['form_style'] = '';
	}
	if (trim($attr['button_value']) == '') {
		$data['button_text'] = 'Subscribe';
	} else {
		$data['button_text'] = $attr['button_value'];
	}
	if (!empty($attr['redirect_url'])) {
		$redirect_url = $attr['redirect_url'];
	} else {
		$redirect_url = home_url();
	}
	$data['enable_name'] = $attr['enable_name'];
	$data['placeholder_name'] = $attr['placeholder_name'];
	$data['placeholder_email'] = $attr['placeholder_email'];
	$data['name_width'] = $attr['name_width'];
	$data['email_width'] = $attr['email_width'];
	$data['force_break'] = $attr['force_break'];
	$data['button_style'] = $attr['button_style'];
	$data['design_id'] = $attr['design_id'];
	$data['skin_id'] = $attr['skin_id'];
	$data['placeholder_type'] = $attr['placeholder_type'];
	$data['maintain_line'] = $attr['maintain_line'];

	$data['action'] = trim($attr['action']); // infusionSoft URI.
	$data['service'] = 'infusionSoft';
	$data['name_name'] = 'inf_field_FirstName';
	$data['email_name'] = 'inf_field_Email';
	$data['open_form_extras'] = '';
	$data['hidden_values'] = '<input name="inf_form_xid" type="hidden" value="' . $id . '" /><input name="inf_form_name" type="hidden" value="' . $data['email_name'] . '" /><input name="infusionsoft_version" type="hidden" value="1.22.10.32">';

	$is_form = ois_create_form_with_data($data);
	return $is_form;
}

function ois_custom_form($attr) {
	$data = $attr;
	
	if (!empty($attr['form_style'])) {
		$data['form_style'] = $attr['form_style'];
	} else {
		$data['form_style'] = '';
	}
	if (trim($attr['button_value']) == '') {
		$data['button_text'] = 'Subscribe';
	} else {
		$data['button_text'] = $attr['button_value'];
	}

	$data['enable_name'] = $attr['enable_name'];
	$data['placeholder_name'] = $attr['placeholder_name'];
	$data['placeholder_email'] = $attr['placeholder_email'];
	$data['name_width'] = $attr['name_width'];
	$data['email_width'] = $attr['email_width'];
	$data['force_break'] = $attr['force_break'];
	$data['button_style'] = $attr['button_style'];
	$data['design_id'] = $attr['design_id'];
	$data['skin_id'] = $attr['skin_id'];
	$data['placeholder_type'] = $attr['placeholder_type'];
	$data['maintain_line'] = $attr['maintain_line'];

	$data['action'] = trim($attr['action']);
	$data['service'] = 'custom';
	$data['name_name'] = trim($attr['name']);
	$data['email_name'] = trim($attr['email']);
	$data['open_form_extras'] = '';
	$data['hidden_values'] = '';

	$is_form = ois_create_form_with_data($data);
	return $is_form;
}

/*
	Function name: Create Form with Data
	Ergon: Using the data attributes provided, this function should
		be able to create any form. So for instance, given certain
		data from Aweber, Feedburner, etc., it should always build an appropriate form.
	Telos: We can change just this function if we need the form to be designed differently.
		So, for instance, if we want to add Facebook functionality, then we just need to change this,
		rather than a form creater for Aweber, a creater for Feedburner, etc. Since it's only the data
		which is going to vary.
*/
function ois_create_form_with_data($data) {
	
	$service = $data['service'];

	if (!empty($data['form_style']) && $data['form_style'] != '') {
		$form_style = $data['form_style'];
	} else {
		$form_style = '';
	}

	$design_id = $data['design_id'];
	$skin_id = $data['skin_id'];
	$action = $data['action'];
	$open_form_extras = $data['open_form_extras']; // target, onsubmit, etc.
	$placeholder_name = $data['placeholder_name'];
	$placeholder_email = $data['placeholder_email'];
	$enable_name = $data['enable_name'];
	$placeholder_name = $data['placeholder_name'];
	$placeholder_email = $data['placeholder_email'];
	$name_width = $data['name_width'];
	$email_width = $data['email_width'];
	$label_name = $data['label_name'];
	$label_email = $data['label_email'];
	$name_name = $data['name_name'];
	$email_name = $data['email_name'];
	$button_style = $data['button_style'];
	$button_text = $data['button_text'];
	$force_break = $data['force_break'];
	$hidden_values = $data['hidden_values'];
	$placeholder_type = $data['placeholder_type'];
	$maintain_line = $data['maintain_line'];
	
	$hidden_name_1 = $data['hidden_name_1'];
	$hidden_name_2 = $data['hidden_name_2'];
	$hidden_name_3 = $data['hidden_name_3'];
	$hidden_value_1 = $data['hidden_value_1'];
	$hidden_value_2 = $data['hidden_value_2'];
	$hidden_value_3 = $data['hidden_value_3'];

	$form = '<form ';
	$form .= 'id="' . $skin_id . '" ';
	$form .= 'service="' . $service . '" ';
	$form .= 'class="ois_form ois_form_' . $design_id;
	if ($maintain_line == 'yes') {
		$form .= ' form-inline';
	} else {
		$form .= ' form-horizontal';
	}
	$form .= '" ';
	$form .= 'style="' . $form_style . '" ';
	$form .= 'action="' . $action . '" ';
	$form .= 'method="post" ';
	$form .= $open_form_extras;
	$form .= ' >';

	if ($placeholder_type == 'javascript') {
		$name_value = 'value="' . $placeholder_name . '" onfocus="if (this.value == \'' . $placeholder_name . '\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \'' . $placeholder_name . '\';}"';
		$email_value = 'value="' . $placeholder_email . '" onfocus="if (this.value == \'' . $placeholder_email . '\') {this.value = \'\';}" onblur="if (this.value == \'\') {this.value = \'' . $placeholder_email . '\';}"';
	} else {
		$name_value = 'placeholder="' . $placeholder_name . '"';
		$email_value = 'placeholder="' . $placeholder_email . '"';
	}
	
	/* 	A cautionary note here:
			force_break refers to line between text inputs and buttons.
			maintain_line refers to text inputs being on the same line
	*/
	$form .= '<div class="row-fluid">'; // opens 1 div.
	$form .= '<div class="span12">'; // opens 2 div.
	// 2 divs open.

	if ($force_break != 'yes') {
		$form .= '<div class="span8">'; // opens 1 conditional div.
	} else {
		$form .= '<div class="span12">'; // opens 1 conditional div.
	}
	// 3 open divs

	if ($enable_name && trim($enable_name) == 'yes') { // Name field
		if ($maintain_line == 'yes') {
			$form .= '<div class="span6">';
		} else {
			$form .= '<div class="span12">';
		}
		// 1 sub-conditional div has been opened
		// 4 open divs.
		
		if ($label_name && trim($label_name) != '') { // Label, if necessary.
			$form .= '<label for="' . $skin_id . '_name" >' . $label_name . '</label> ';
		}
		$form .= '<input type="text" name="' . $name_name . '" ' . $name_value . ' class="span12 ois_textbox_' . $design_id . ' ois_textbox_name_' . $design_id . '" id="' . $skin_id . '_name"';
		if (trim($name_width) != '') {
			$form .= ' style="width: ' . $name_width . ' !important;"';
		}
		$form .= ' />'; // closes the text input.
		$form .= '</div>'; // .span6 or span12, depending on maintain_line
		// the sub-conditional div has been closed.
		// 3 open divs.

		if ($maintain_line != 'yes') { // then we're going to close up this row.
			$form .= '</div>'; // the 1st conditional div: span12 or span 8.
			// but we're also going to close up the rest of it.
			$form .= '</div>'; // 2nd div: span12
			$form .= '</div>'; // 1st div: row-fluid

			$form .= '<div class="row-fluid">'; // opens a new row-fluid, new 1st div.
			$form .= '<div class="span12">'; // opens a new span12, new 2nd div.
			$form .= '<div class="span12">'; // reopens 1st conditional div.
			$form .= '<div class="span12">'; // reopens the subconditional div.
		} else {
			$form .= '<div class="span6">'; // the subconditional div has been reopened.
		}
		// 4 divs open now.
	} else {
		$form .= '<div class="span12">'; // trace of subconditional div.
	}
	// 4 open divs.

	// Email field
	if ($label_email && trim($label_email) != '') { // Label, if necessary
		$form .= '<label for="' . $skin_id . '_email" >' . $label_email . '</label> ';
	}

	$form .= '<input type="text" ' . $email_value . ' name="' . $email_name . '" id="' . $skin_id . '_email" class="span12 ois_textbox_' . $attr['design_id'] . ' ois_textbox_email_' . $attr['design_id'] . '"';
	if ($email_width && trim($email_width) != '') {
		$form .= ' style="width: ' . $email_width . ' !important;"';
	}
	$form .= ' />'; // closes the text input.

	$form .= '</div>'; // the subconditional div has been closed.
	// 3 divs open now: 1 conditional, 1st and 2nd divs.

	// Button
	if ($force_break != 'yes') {
		$form .= '</div>'; // conditional div has been closed: always span8 in this case.
		// 2 open divs.
		$form .= '<div class="span4">'; // conditional div has been reopened.
		// 3 divs open now.
	} else { // else we're breaking up this line.
		$form .= '</div>'; // .span12, closes conditional div.
		$form .= '</div>'; // .span12, closes 2nd div.
		$form .= '</div>'; // .row-fluid, closes 1st div.
		// 0 open divs.
		$form .= '<div class="row-fluid">'; // reopens 1st div.
		$form .= '<div class="span12">';  // reopens 2nd div.
		$form .= '<div class="span12">';  // reopens conditional div.
	}
	// 3 open divs: conditional, 2nd, 1st.

	// Hidden values; most services require some hidden values.
	$form .= $hidden_values;

	// Signup button.
	$form .= '<input type="submit" ' . $button_style . ' value="' . $button_text . '" class="ois_button_' . $design_id . '" />';

	$form .= '</div>'; // closes conditional div: span4 or span12.
	$form .= '</div>'; // .span12, closes 2nd div.
	$form .= '</div>'; // .row-fluid, closes 1st div.
	// 0 open divs.
	
	if (trim($hidden_name_1) != '') {
		$form .= '<input type="hidden" name="' . $hidden_name_1 . '" value="' . $hidden_value_1 . '" />';
	}
	if (trim($hidden_name_2) != '') {
		$form .= '<input type="hidden" name="' . $hidden_name_2 . '" value="' . $hidden_value_2 . '" />';
	}
	if (trim($hidden_name_3) != '') {
		$form .= '<input type="hidden" name="' . $hidden_name_2 . '" value="' . $hidden_value_3 . '" />';
	}
	
	$form .= '</form>';


	/*
$form .= '<div class="row-fluid">'; //1
	if ($force_break != 'yes') {
		$form .= '<div class="span8">';
	}
	if ($enable_name && trim($enable_name) == 'yes') { // The "Name" field of the form, if necessary.
		if ($maintain_line == 'yes') {
			$form .= '<div class="span6">'; //2
		} else {
			$form .= '<div class="span12">'; //2
		}
		if ($label_name && trim($label_name) != '') { // Label, if necessary.
			$form .= '<label for="' . $skin_id . '_name" >' . $label_name . '</label> ';
		}
		$form .= '<input type="text" name="' . $name_name . '" ' . $name_value . ' class="span12 ois_textbox_' . $design_id . ' ois_textbox_name_' . $design_id . '" id="' . $skin_id . '_name"';
		if (trim($name_width) != '') {
			$form .= ' style="width: ' . $name_width . ' !important;"';
		}
		$form .= ' />';
		$form .= '</div>'; //1

		if ($maintain_line != 'yes') { // close the row
			$form .= '</div>';
			$form .= '<div class="row-fluid">'; // open new row
		}
	} else {
		$form .= '<div class="span12">'; //2
	}


	// The "Email" field of the form.
	if ($maintain_line == 'yes') {
		if ($enable_name && trim($enable_name) == 'yes') {
			$form .= '<div class="span6">'; //2
		} else {
			$form .= '<div class="span12">'; //2
		}
	} else {
		$form .= '<div class="span12">'; //2
	}
	if ($label_email && trim($label_email) != '') { // Label, if necessary
		$form .= '<label for="' . $skin_id . '_email" >' . $label_email . '</label> ';
	}

	$form .= '<input type="text" ' . $email_value . ' name="' . $email_name . '" id="' . $skin_id . '_email" class="span12 ois_textbox_' . $attr['design_id'] . ' ois_textbox_email_' . $attr['design_id'] . '"';
	if ($email_width && trim($email_width) != '') {
		$form .= ' style="width: ' . $email_width . ' !important;"';
	}
	$form .= ' /></div>'; //close the .span


	if ($force_break == 'yes') { // If we're breaking the button from the other inputs.
		$form .= '</div>'; // close the row.
	} else {
		$form .= '</div><div class="span4">';
	}

	// Hidden values; most services require some hidden values.
	$form .= $hidden_values;

	// Signup button.
	$form .= '<input type="submit" ' . $button_style . ' value="' . $button_text . '" class="ois_button_' . $design_id . '" />
	</form>';
	if ($force_break != 'yes') {
		$form .= '</div>';
	}
	$form .= '</div>'; // close the row
*/

	return $form;

}

function ois_wrapper($ois, $data) {

	if (!empty($data['skin_id'])) {
		$skin_id = $data['skin_id'];
	}
	if (!empty($data['margins'])) {
		$skin_margins = $data['margins'];
	}
	if (!empty($data['margin_type'])) {
		$margin_type = $data['margin_type'];
	}
	if (!empty($data['aff_username'])) {
		$aff_username = $data['aff_username'];
	}
	if (!empty($data['aff_enable'])) {
		$aff_enable = $data['aff_enable'];
	}
	if (!empty($data['extra_classes'])) {
		$extra_classes = $data['extra_classes'];
	}
	if (!empty($data['popup_data'])) {
		$popup_data = $data['popup_data'];
	}

	if (!empty($skin_margins)) {
		//
	} else {
		$skin_margins = array (
			'top' => '0px',
			'right' => '0px',
			'bottom' => '0px',
			'left' => '0px',
		);
	}
	if (is_home()) {
		$post_id = 'homepage';
	} else {
		$post_id = get_the_ID();
	}
	$wrapper = '<!-- OptinSkin -->
	<div align="center" class="ois_wrapper ' . $extra_classes . '" data="' . $skin_id . '"';
	if (trim($popup_data) != '') {
		$wrapper .= ' data-popup-scroll="' . $popup_data .'"';
	}
	if (!empty($skin_margins)) {
		$wrapper .= ' style="';

		foreach ($skin_margins as $pos=>$margin) {
			$margin = trim($margin);
			if ($margin != '' && $margin != '0' && $margin != '0px') {
				$wrapper .= $margin_type . '-' . $pos . ':' . $margin . ';';
			}
		}
		$wrapper .= '" ';
	}
	$wrapper .= 'id="ois_' . $skin_id . '" rel="' . $post_id . '">'; // 1 open div.
	$wrapper .= $ois;

	// Affiliate Options
	if ($aff_enable) {
		if (trim($aff_username) != '') {
			if (!is_admin()) {
				$wrapper .= '<div style="float:right;padding-right:5px;padding-top:7px;"><a href="http://'  . $aff_username . '.optinskin.hop.clickbank.net" style="border:none;"><img style="border:none;" src="' . WP_PLUGIN_URL . '/OptinSkin/front/images/poweredby.png" /></a></div>';
			}
		}
	}

	$wrapper .= '<div style="clear:both;"></div>
		</div><!-- End OptinSkin -->'; // closes 1 div.
	return $wrapper;

}

?>