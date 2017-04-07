<?php

function ois_view_drafts() {

	ois_section_title('Draft Skins', 'Here you can view all of your uncompleted or unpublished skins.', '');
	$skins = get_option('ois_skins');

	if (isset($_GET['delete'])) {

		if (check_admin_referer('trash')) {
			$id = $_GET['delete'];
			$skins = get_option('ois_skins');
			foreach ($skins as $num=>$skin) {
				if ($skin['id'] == $id) {
					$skins[$num]['status'] = 'trash';
					break;
				}
			}
			update_option('ois_skins', $skins);
			ois_notification('Your Design has Been Successfully Moved to Trash!', '', 'trash');
		}
	}
?>
	<table class="widefat">
		<thead>
			<tr>
				<th scope="col" style="width:180px;">Title</th>
				<th scope="col" style="width:400px;">Description</th>
				<th scope="col">Optin Service</th>
				<th scope="col">Position</th>
				<th scope="col">Date</th>
			</tr>
		</thead>
		<tbody>



	<?php
	$i = 0;
	foreach ( $skins as $skin_code => $skin ) {
		if ($skin['status'] == 'draft') {

			if ($i % 2 != 0) {
				$row_class = 'class="alternate"';
			} else {
				$row_class = '';
			}
			$i++;
			if ($skin['position'] == 'post_bottom') {
				$position_nice = 'bottom of posts';
			} else if ($skin['position'] == 'post_top') {
					$position_nice = 'top of posts';
				} else if ($skin['position'] == 'page_top') {
					$position_nice = 'top of pages';
				} else if ($skin['position'] == 'page_bottom') {
					$position_nice = 'bottom of page';
				} else if ($skin['position'] == 'sidebar') {
					$position_nice = 'in sidebar';
				} else if ($skin['position'] == 'custom') {
					$position_nice = 'custom locations';
				}

			$uri = explode('?', $_SERVER['REQUEST_URI']);
			$edit_url = $uri[0] . '?page=addskin&id=' . $skin['id'];
			$delete_url = $uri[0] . '?page=ois-drafts';
?>
			<tr <?php echo $row_class; ?>>
				<td class="column-title">
					<strong>
						<a href="<?php echo $edit_url; ?>">
							<?php echo $skin['title']; ?>
						</a>
					</strong>
					<div class="row-actions">
						<a href="<?php echo $edit_url; ?>">
							Edit
						</a>
						 |
						<a href="<?php echo wp_nonce_url($delete_url, 'trash'); ?>&delete=<?php echo $skin['id'] ?>">Move to Trash</a>

					</div>
				</td>
				<td>
				<?php if (strlen($skin['description']) >= 130) {
				echo substr(stripslashes($skin['description']), 0, 130) . '...';
			} else {
				echo $skin['description'];
			}
?>
				</td>
				<td>
				<?php echo ucwords($skin['optin_service']); ?>
				</td>
				<td>
					<?php echo ucwords($position_nice); ?>
				</td>
				<td>
				<?php
			if (trim($skin['last_modified']) != '') {
				$date_added = explode(' ', $skin['last_modified']);
				echo $date_added[0] . '<br/>Last Modified';
			} else {
				$date_added = explode(' ', $skin['date_added']);
				echo $date_added[0] . '<br/>Date Created';
			}
?>
				</td>
			</tr>
			<?php
		}
	}
?>

	</tbody>
	</table>

	<?php
	ois_section_end();
}

function ois_manage_designs() {

	ois_section_title('Manage Designs', 'Here you can view all of your OptinSkin designs.', '');

	if (isset($_GET['delete'])) {
		if (check_admin_referer('delete')) {
			$id = $_GET['delete'];
			$designs = get_option('ois_designs');
			unset($designs[$id]);
			update_option('ois_designs', $designs);
			ois_notification('Your Design has Been Successfully Deleted!', '', '');
		}
	}

	$designs = get_option('ois_designs');

?>
	<style>
		.ois_manage_designs_option {
			padding: 0 5px;
		}
	</style>
	<table class="widefat">
		<thead>
			<th scope="col" style="width:400px;">Title</th>
			<th scope="col">Edit Design</th>
			<th scope="col">Delete Design</th>
			<th scope="col">Last Modified</th>
			<th scope="col">Quick Preview</th>
		</thead>
		<tbody>
		<?php
	$url = $_SERVER['REQUEST_URI'];
	$url = explode('?page=', $url);
	$edit_url = $url[0] . '?page=create-design&id=';
	$delete_url = wp_nonce_url( $_SERVER['REQUEST_URI'], 'delete') . '&delete=';
	if (!empty($designs)) {
		foreach ($designs as $design) {
			if (trim($design['title']) != '') {
				$title = $design['title'];
			} else if (trim($design['name']) != '') {
					$title = $design['name'];
				} else {
				$title = 'Untitled Design';
			}
			$created = $design['date_added'];
			$modified = explode(' ', $design['last_modified']);
			$id = $design['id'];
	
	
			echo '<tr>';
			echo '<th scope="row">' . stripslashes($title) . '</th>';
			echo '<td>
							<a href="' . $edit_url . $id . '" >Edit</a>
						</td>
						<td>
							<a href="' . $delete_url . $id . '" >Delete</a>
						</td>';
			echo '<td>' . $modified[0] . '</td>';
			echo '<td>
				<a style="background: transparent url(images/arrows.png) no-repeat right 3px; background-color: transparent;background-origin: padding-box;font-size: 12px;margin: 0;padding: 3px 16px 0 6px;text-decoration: none;width: 84px;z-index: auto;" href="javascript:void();" class="ois_manage_preview" id="design_' . $id . '">Preview <img id="ois_preview_img" /></a></td>';
			echo '</tr>';
			echo '<tr id="' . $id . '" style="display:none;">';
			echo '<td style="width:400px; overflow:visible;">';
			$ex_skin = array ('optin-service' => 'feedburner');
			$default_app = array();
			if (!empty($design['appearance'])) {
				foreach ($design['appearance'] as $section=>$items) {
					foreach ($items as $value) {
						$default_app[$value['attr']] = $value['default'];
					}
				}
			}
			$ex_skin = array_merge($ex_skin, array('appearance' => $default_app));
	
			echo ois_make_skin($ex_skin, $design);
			echo '</td>';
			echo '</tr>';
		}
	}
?>
		</tbody>
	</table>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$('.ois_manage_preview').click(function () {
				var prev_id = $(this).attr('id');
				var design_id = prev_id.split('_');
				var id = design_id[1];
				if ($('#' + id).is(':visible')) {
					$('#' + id).hide('fast');
					$(this).css('background', 'transparent url(images/arrows.png) no-repeat right 3px');
				} else {
					$('#' + id).show();
					$(this).css('background', 'transparent url(images/arrows.png) no-repeat right -33px');
				}

			});
		});
	</script>
	<?php
	ois_section_end();
}

function ois_view_trash() {

	ois_section_title('Trashed Skins', '', 'Here you can view all of your discarded skins.');
	$skins = get_option('ois_skins');

	if (isset($_GET['delete'])) {
		if (check_admin_referer('trash')) {
			$id = $_GET['delete'];
			$skins = get_option('ois_skins');
			foreach ($skins as $num=>$skin) {
				if ($skin['id'] == $id) {
					unset($skins[$num]);
					break;
				}
			}
			update_option('ois_skins', $skins);
			ois_notification('Your Design has Been Successfully Deleted Forever!', '', '');
		}
	}
	if (isset($_GET['revive'])) {
		if (check_admin_referer('revive')) {
			$id = $_GET['revive'];
			$skins = get_option('ois_skins');
			foreach ($skins as $num=>$skin) {
				if ($skin['id'] == $id) {
					$skins[$num]['status'] = 'draft';
					break;
				}
			}
			update_option('ois_skins', $skins);
			ois_notification('Your Design has Been Successfully Revived as a Draft! ', '', 'drafts');
		}
	}
?>
	<table class="widefat">
		<thead>
			<tr>
				<th scope="col" style="width:250px;">Title</th>
				<th scope="col" style="width:400px;">Description</th>
				<th scope="col">Optin Service</th>
				<th scope="col">Position</th>
				<th scope="col">Date</th>
			</tr>
		</thead>
		<tbody>



	<?php
	$i = 0;
	foreach ( $skins as $skin_code => $skin ) {
		if ($skin['status'] == 'trash') {
			if ($i % 2 != 0) {
				$row_class = 'class="alternate"';
			} else {
				$row_class = '';
			}
			$i++;
			if ($skin['position'] == 'post_bottom') {
				$position_nice = 'bottom of posts';
			} else if ($skin['position'] == 'post_top') {
					$position_nice = 'top of posts';
				} else if ($skin['position'] == 'page_top') {
					$position_nice = 'top of pages';
				} else if ($skin['position'] == 'page_bottom') {
					$position_nice = 'bottom of page';
				} else if ($skin['position'] == 'sidebar') {
					$position_nice = 'in sidebar';
				} else if ($skin['position'] == 'custom') {
					$position_nice = 'custom locations';
				}

			$uri = explode('?', $_SERVER['REQUEST_URI']);
			$revive_url = $uri[0] . '?page=ois-trash';
			$delete_url = $uri[0] . '?page=ois-trash';
?>
			<tr <?php echo $row_class; ?>>
				<td class="column-title">
					<strong>
						<a href="javascript:void(0);">
							<?php echo $skin['title']; ?>
						</a>
					</strong>
					<div class="row-actions">
						<a href="<?php
			echo wp_nonce_url($revive_url, 'revive'); ?>&revive=<?php echo $skin['id'] ?>">
							Revive as Draft
						</a>
						 |
						<a href="<?php
			echo wp_nonce_url($delete_url, 'trash'); ?>&delete=<?php echo $skin['id'] ?>">Delete Forever</a>

					</div>
				</td>
				<td>
				<?php if (strlen($skin['description']) >= 130) {
				echo substr(stripslashes($skin['description']), 0, 130) . '...';
			} else {
				echo $skin['description'];
			}
?>
				</td>
				<td>
				<?php echo ucwords($skin['optin_service']); ?>
				</td>
				<td>
					<?php echo ucwords($position_nice); ?>
				</td>
				<td>
				<?php
			if (trim($skin['last_modified']) != '') {
				$date_added = explode(' ', $skin['last_modified']);
				echo $date_added[0] . '<br/>Last Modified';
			} else {
				$date_added = explode(' ', $skin['date_added']);
				echo $date_added[0] . '<br/>Date Created';
			}
?>
				</td>
			</tr>
			<?php
		}
	}
?>

	</tbody>
	</table>

	<?php
	ois_section_end();

}

function ois_error_log() {
	ois_section_title('Error Log', 'Here you can view all errors that the plugin has encountered.', 'We\'re sorry about these.');
	if (isset($_POST['clear'])) {
		if ($_POST['clear'] == 'yes') {
			update_option('ois_error_log', '');
			ois_notification('Your Errors have been Cleared', '', '');
		}
	}
	$error_cats = get_option('ois_error_log');
?>

	<table class="widefat">
		<thead>
			<th>Error Message</th>
			<th>Connected to</th>
		</thead>
		<tbody>
		<?php
	foreach ($error_cats as $cat=>$val) {
		foreach ($val as $error) {
			echo '<tr>';
			echo '<td>' . $error . '</td>';
			echo '<td>' . ucwords($cat) . '</td>';
			echo '</tr>';
		}
	}
?>
		</tbody>
	</table>
	<div style="padding: 5px;">
		<form method="post">
			<input type="hidden" name="clear" value="yes" />
			<input type="submit" class="ois_super_button" value="Clear Log" />
		</form>
	</div>
	<?php

	ois_section_end();
}

?>