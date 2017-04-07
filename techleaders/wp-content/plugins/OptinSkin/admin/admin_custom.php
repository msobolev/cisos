<?php

function ois_custom() {

	ois_section_title('Create a Custom Design', 'This tool is for creating custom designs for your skins.', 'Enter  your HTML into the editor below, and preview your design as it instantly updates. Once you save, it will be available for you when you add new skins.');
	if ( empty($_POST) ) {
		// normal functioning.
	} else if( !check_admin_referer('ois_custom', 'custom_design') ) {
			print 'Sorry, your nonce did not verify.';
			exit;
	} else {
		$html = htmlentities($_POST['design_html']);
		$css = htmlentities($_POST['design_css']);
		if (trim($css) == 'CSS goes here...') {
			$css = '';
		}
		if (trim($html) == 'Add your custom HTML here...') {
			$html = '';		
		}
		$name = htmlentities($_POST['design_name']);
		$designs = get_option('ois_designs');

		if (isset($_POST['design_id'])
			&& trim($_POST['design_id']) != '') {
			$id = $_POST['design_id'];
			foreach ($designs as $ref=>$design) {
				if ($design['id'] == $id) { // find the design id.
					$new_design = $design; // set new design as this design.
					break;
				}
			}
			$update_message = 'Your Design has been Successfully Updated!';
		} else {
			$ref = (1 + count($designs));
			$update_message = 'Your Design has been Successfully Created!';
		}
		
		if (!empty($new_design)) {
			$new_design['name'] = $name;
			$new_design['html'] = $html;
			$new_design['css'] = $css;
			$new_design['last_modified'] = date('Y-m-d H:i:s');
		} else {
			$new_design = array (
				'title' => $name,
				'description' => '',
				'name' => $name,
				'html' => $html,
				'css' => $css,
				'css_url' => '',
				'date_added' => date('Y-m-d H:i:s'),
				'last_modified' => date('Y-m-d H:i:s'),
				'id' => $ref,
				'custom' => 'yes',
			);
		}

		$designs[$ref] = $new_design;
		
		update_option('ois_designs', $designs);

		ois_notification($update_message, '', '');


	}
	if (isset($_GET['id'])) {
		$id = trim($_GET['id']);
		$designs = get_option('ois_designs');
		//$cur_design = $designs[$id];
		
		foreach ($designs as $design) {
			if ($design['id'] == $id) {
				$cur_design = $design;
				break;
			}
		}

		$this_css = html_entity_decode(stripslashes($cur_design['css']));
		$this_html = html_entity_decode(stripslashes($cur_design['html']));
	}

	$designs = get_option('ois_designs');
	//print_r($designs);
?>


	<style>
	#ois_custom_update_area {

		margin-bottom: 10px;
		min-height: 150px;


	}
	#ois_custom_editor, #ois_custom_css_editor {
		width: 100%;
		height: 210px;
		padding: 15px;
		border-radius: 3px;
		-webkit-border-radius: 3px;
		-moz-border-radius: 3px;
		outline: none;
	}
	.ois_custom_waiting {
		text-align: center;
		margin: auto 0;
	}
	</style>

	<table class="widefat">
	<thead>
		<th>Your Design</th>
	</thead>
	<tbody>
		<tr class="alternate">
			<td>
				<style id="ois_custom_css_update_area">
					<?php
	if (isset($this_css) && trim($this_css) != '') {
		echo $this_css;
	}
?>
				</style>
				<div id="ois_custom_update_area">
					<?php
	if (isset($this_html) && trim($this_html) != '') {
		echo $this_html;
	} else {
		echo '<p style="padding-top: 20px;" class="ois_custom_waiting">Type into the Text Area Below...</p>';
	}
?>
				</div>
			</td>
		</tr>
	</tbody>
	</table>

	<form method="post">
	<table class="widefat">
	<thead>
		<th>Code Editor</th>
	</thead>
	<tbody>

	<tr>

	<td>
	<div>
	<h3>HTML Code</h3>
	<textarea id="ois_custom_editor" name="design_html"><?php
	if (isset($this_html) && trim($this_html) != '') {
		echo $this_html;
	} else {
		echo 'Add your custom HTML here...';
	}
	?></textarea>
	</div>
	<div>
	<h3>CSS Code</h3>
	<textarea id="ois_custom_css_editor" name="design_css"><?php
	if (isset($this_css) && trim($this_css) != '') {
		echo $this_css;
	} else {
		echo 'CSS goes here...';
	}
	?></textarea>
	</div>

	<script type="text/javascript">

	jQuery(document).ready(function ($) {
		$('#ois_custom_editor').focus(function () {
			if ($(this).val() == 'Add your custom HTML here...') {
				$(this).val('');
			}
		});
		$('#ois_custom_css_editor').focus(function () {
			if ($(this).val() == 'CSS goes here...') {
				$(this).val('');
			}
		});

		$('#ois_custom_editor, #ois_custom_css_editor').keydown(function (event) {

			if (event.keyCode == 9) {
				var tab = "    ";
				var t = event.target;
			    var ss = t.selectionStart;
			    var se = t.selectionEnd;
				event.preventDefault();

		        if (ss != se && t.value.slice(ss,se).indexOf("n") != -1) {
		            var pre = t.value.slice(0,ss);
		            var sel = t.value.slice(ss,se).replace(/n/g,"n"+tab);
		            var post = t.value.slice(se,t.value.length);
		            t.value = pre.concat(tab).concat(sel).concat(post);

		            t.selectionStart = ss + tab.length;
		            t.selectionEnd = se + tab.length;
				} else {
		            t.value = t.value.slice(0,ss).concat(tab).concat(t.value.slice(ss,t.value.length));
		            if (ss == se) {
		                t.selectionStart = t.selectionEnd = ss + tab.length;
		            }
		            else {
		                t.selectionStart = ss + tab.length;
		                t.selectionEnd = se + tab.length;
		            }
		        }
			}

		});

		$('#ois_custom_editor').keyup(function (event) {
			$('#ois_custom_update_area').html($('#ois_custom_editor').val());
		});
		$('#ois_custom_css_editor').keyup(function (event) {
			$('#ois_custom_css_update_area').html($('#ois_custom_css_editor').val());
		});
	});

	</script>
	<?php
	if (!empty($cur_design['name'])) {
		$design_title = $cur_design['name'];
	} else if (!empty($cur_design['title'])) {
			$design_title = $cur_design['title'];
		} else {
			$design_title = 'Untitled Design';
	}
?>
	<p>
		Your Design's Name:
		<input	type="text"	name="design_name"	class="ois_textbox"	value="<?php echo $design_title; ?>" />
	</p>
	<?php
	if (isset($this_html) && trim($this_html) != '')  {
?>
			<input type="hidden" name="design_id" value="<?php echo $cur_design['id']; ?>" />
			<?php
	}
?>
	<p><input type="submit" class="button-primary" value="Save Design" /></p>
	<?php
	wp_nonce_field('ois_custom', 'custom_design');
	?>
	</td></tr>
	</tbody>
	</table>
	</form>
	
	
	<div class="ois_custom_title" style="font-size:15px;text-align:left;padding: 17px;">How to use the HTML/CSS Editor</div>
	<table class="widefat">
		<tr>
			<td class="ois_custom_info_sec">
				<div class="ois_custom_title">Step 1. Go to Custom Design Editor</div>
				<div>The editor provides a basic way to create your own designs, and still have OptinSkin power your stats and split-testing.</div>
			</td>
			
			<td>
				<img class="ois_custom_screen" src="<?php echo OptinSkin_URL . 'admin/images/custom_start.png'; ?>" />
			</td>
		</tr>
		<tr>
			<td class="ois_custom_info_sec">
				<div class="ois_custom_title">Step 2. Enter HTML Code</div>
				 <div>All you need to do is write some HTML code (or copy and paste it from your service provider) into the first box on the page. Notice how the preview updates as you do so.</div>
			</td>
			<td>
				<img class="ois_custom_screen" src="<?php echo OptinSkin_URL . 'admin/images/custom_html.png'; ?>" />
			</td>
		</tr>
		<tr>
			<td class="ois_custom_info_sec">
				<div class="ois_custom_title">Step 3. Create CSS Code</div>
				<div>You can also write some CSS in the box below, which will help you to style your design the way that you want it.</div>
			</td>
			<td>
				<img class="ois_custom_screen" src="<?php echo OptinSkin_URL . 'admin/images/custom_css.png'; ?>" />
			</td>
		</tr>
		<tr>
			<td class="ois_custom_info_sec">
				<div class="ois_custom_title">Step 4. View Final Product and Save</div>
				<div>Once you save a design, you can go over to the <em>Add Skin</em> page, and find your custom design by clicking through the slider in the <em>Customize Your Design</em> section. Once you've chosen this design, go ahead and create your skin wherever you want, and your design will appear in your posts.</div>
			</td>
			<td>
				<img class="ois_custom_screen" src="<?php echo OptinSkin_URL . 'admin/images/custom_prefinal.png'; ?>" />
			</td>
		</tr>
	</table>
	<div>
		
		
	</div>
	
	
	<style type="text/css">
		.ois_custom_screen {
			padding: 2px;
			border: 1px solid #ccc;
			max-height: 450px;
			max-width: 660px;
		}
		.ois_custom_info_sec {
			min-width:200px;
			width:34% !important;
			padding:5px 5px 15px 5px;
		}
		.ois_custom_title {
			font-size: 14px;
			font-weight: bold;
			padding: 10px 0 5px 0;
		}
	</style>
	<?php
	
	ois_section_end();

}

?>