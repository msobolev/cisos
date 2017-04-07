<?php
/*
Copyright (C) 2008 Halmat Ferello

Released under the GPL v.2, http://www.gnu.org/copyleft/gpl.html

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
*/

function wp_js_files_display() {
    global $post;
	
	?>
	<style type="text/css" media="screen">
		div#wp_js {
			position: relative;
				margin-bottom: 12px;
				padding: 12px;
		}
		div#wp_js h4 {
			font-size: 14px;
		}
		div#wp_js form {
		}
		div#wp_js legend {
			font-size: 14px;
			font-weight: bold;
		}
		div#wp_js label {
			display: block;
			float: left;
			font-size: 12px;
			width: 80px;
		}
		div.wp_js_panel {
			border: 1px solid #999;
			font-size: 12px;
			float: left;
			padding: 12px;
			overflow-y: scroll;
			top: 22px; right: 22px;
			width: 310px; height: 350px;
		}
		div#wp_js_files_added_panel {
			float: right;
		}
		div#wp_js_files_panel {
		}
		div.wp_js_panel h4 {
			font-size: 12px;
			margin-top: 0;
		}
		div.wp_js_panel ul {
			padding: 0 0 0 14px; margin: 0;
		}
		div.wp_js_panel strong {
			display: block;
		}
		div#wp_js_files_list ul, div#wp_js_course_dates_list ul {
			list-style-type: none;
			margin: 0; padding: 0;
		}
		div#wp_js_files_list ul ul {
			padding-left: 15px;
		}
		div#wp_js_files_list ul ul li {
			margin: 0; padding: 0;
		}
		div#wp_js_files_list a, div#wp_js_course_dates_list a {
			padding: 8px 0 8px 20px;
			display: block;
			text-decoration: none;
		}
		div#wp_js_files_list a.add-file, div#wp_js_course_dates_list a {
			background: url('<?php echo WP_JS_URL; ?>/images/js-file.png') no-repeat center left; 
		}
		div#wp_js_files_list a.add-file:hover {
			background: url('<?php echo WP_JS_URL; ?>/images/add.png') no-repeat center left;
			color: #1CCD00;
		}
		 div#wp_js_course_dates_list a:hover {
			background: url('<?php echo WP_JS_URL; ?>/images/delete.png') no-repeat center left;
			color: #f00;
		}
		
		div#wp_js_files_list a.folder {
			background: url('<?php echo WP_JS_URL; ?>/images/folder.png') no-repeat center left;
			margin: 12px 0; padding: 0;
		}
		div#wp_js_files_list a.folder span.sign {
			padding: 0 12px 0 6px;
		}
		
		div#wp_js_loading {
			background: #fff;
			display: block;
			position: absolute;
			padding: 12px 12px 12px 12px;
			border: 1px solid #ccc;
			width: 310px; height: 352px;
			text-align: center;
			z-index: 99;
		}
		.spinner, div#wp_js_loading span {
			background: url('<?php echo WP_JS_URL; ?>/images/spinner.gif') no-repeat center left;
			padding-left: 20px;
		}
		div#wp_js_loading span {
			display: block;
			font-size: 18px;
			font-weight: bold;
			margin: 150px auto 0px auto;
			width: 210px;
		}
		div.wp_js_loading_remove {
			left: 362px !important
		}
		div.wp_js_loading_remove span {
			width: 240px !important
		}
		p#wp_js_apply_to_children span {
			padding-top: 2px; padding-bottom: 2px;
			margin-left: 8px;
		}
		
	</style>
	<script type="text/javascript" charset="utf-8">
	
		var wp_js = {};
		wp_js.toogleFolderVar = new Array();
		
		wp_js.add = function (a) {
			
			jQuery.ajax({
				url: a.href+'&ajax=true&action=add',
				type: 'GET',
				
				beforeSend: function() {
					jQuery('#wp_js_loading').removeClass('wp_js_loading_remove').html('<span>Adding JavaScript file</span>').fadeIn();
				},

				complete: function() {
					jQuery('#wp_js_loading').fadeOut();
				},

				success: function(txt) {
					jQuery('#wp_js_files_added_panel div').html(txt);
					jQuery(a).parent().remove();
				},

				error: function() {
				//called when there is an error
				}
			});
			
			return false;
			
		};
		
		wp_js.remove = function (a) {
			jQuery.ajax({
				url: a.href+'&ajax=true&action=delete',
				type: 'GET',

				beforeSend: function() {
					jQuery('#wp_js_loading').addClass('wp_js_loading_remove').html('<span>Removing CSS file</span>').fadeIn();
				},

				complete: function() {
					jQuery('#wp_js_loading').fadeOut();
					jQuery('div#wp_js_files_list ul ul').hide();
				},

				success: function(txt) {
					jQuery('#wp_js_files_panel div').html(txt);
					jQuery(a).parent().remove();
				},

				error: function() {
				//called when there is an error
				}
			});
		}
		
		wp_js.attachFolders = function() {
			jQuery('div#wp_js a.folder').each(function(i){
				wp_js.toogleFolderVar[this.href] = false;
			});
		}
		
		wp_js.toogleFolder = function (a) {
			var ul = jQuery(jQuery(a).next('ul'));
			var span = jQuery(jQuery(a).children('span.sign'));
			if (wp_js.toogleFolderVar[a] == false) {
				ul.show();
				span.html('-');
				wp_js.toogleFolderVar[a] = true;
			} else {
				ul.hide();
				span.html('+');
				wp_js.toogleFolderVar[a] = false;
			}
		}
		
	</script>
	<div id="wp_js" class="postbox closed">
	<h3>WP JS</h3>
	<div class="inside">
		
    <h4>Add a JavaScript file to this <?php echo $post->post_type; ?></h4>
	<p>Theme path: <?php echo get_theme_root_uri().'/'.get_stylesheet(); ?>/</p>
	
      	<div id="wp_js_files_panel" class="wp_js_panel">
		<h4>JavaScript files in your theme</h4>
		<div><?php wp_js_files($post->ID, FALSE); ?></div>
	</div>
	
	<div id="wp_js_files_added_panel" class="wp_js_panel">
		<h4>JavaScript files added</h4>
		<div><?php wp_js_files($post->ID); ?></div>
	</div>
	
	<script type="text/javascript" charset="utf-8">
	
		jQuery('#wp_js_files_panel').before('<div id="wp_js_loading"></div>');
		jQuery('#wp_js_loading').hide();		
		jQuery('div#wp_js_files_list ul ul').hide();	
		
	</script>
	
	<br clear="all" />
	</div></div>
	
	<?php
}

function wp_js_list($id, $array, $folder = NULL, $trail = NULL)
{
	if (!empty($array) && count($array) > 0) {
	$meta = get_post_meta($id, 'wp_js_file');
?>
	<ul>
		<?php foreach ($array as $key => $value): ?>
			<?php if (is_array($value) && count($value) > 0) : ?>
			<li>
				<a href="#<?php echo uniqid(rand(), true) ?>" onclick="wp_js.toogleFolder(this);" class="folder"><span class="sign">+</span> /<?php echo $key; ?>/</a>
				<?php wp_js_list($id, $value, $key, $trail.'/'.$key); ?>
			</li>
			<?php elseif ( count($value) > 0 ) : ?>
				<?php $file_path = ($trail) ? $trail.'/'.$value : $value; ?>
				<?php if ( !@in_array($file_path, $meta) ) : ?>
					<li>
						<a href="<?php echo WP_JS_URL; ?>/wp-js-ajax.php?id=<?php echo $id; ?>&amp;file=<?php echo urlencode($file_path); ?>" onclick="wp_js.add(this);return false;" class="add-file"><?php echo $value; ?></a>
					</li>
				<?php endif; ?>
			<?php endif; ?>
		<?php endforeach ?>
	</ul>
	<script type="text/javascript" charset="utf-8">
		wp_js.attachFolders();
	</script>
<?php
	}
}

function wp_js_files($id, $meta = TRUE)
{
	if ( $meta == TRUE ) {
		$meta = get_post_meta($id, 'wp_js_file');
		if (!empty($meta) && count($meta) > 0) {
			echo '<div id="wp_js_course_dates_list"><ul>';
			foreach ($meta as $value) {
				$remove_string = 'delete=true&amp;'.'id='.$id.'&amp;string='.$value;
				echo '<li><a href="'.WP_JS_URL.'/wp-js-ajax.php?'.$remove_string.'" class="remove-file" onclick="wp_js.remove(this);return false;">'.$value.'</a></li>';
			}
			echo '</ul></div>';
		} else {
			echo '<div id="wp_js_files_list">No JavaScript files.</div>';
		}
	} else {
		$files = wp_js_directory_map(TEMPLATEPATH.'/', '.js$', FALSE);
	?>
		<?php if (count($files) > 0): ?>
			<div id="wp_js_files_list">
				<?php wp_js_list($id, $files); ?>
			</div>
		<?php endif ?>
	
	<?php
	}
}

function wp_js_files_for_post()
{
	global $post;
	
	$array = get_post_meta($post->ID, 'wp_js_file');

	if (!empty($array) && count($array) > 0) {
		$string = '';
		$string .= "<!-- WP JS -->\n";

		if (function_exists('wp_js')) {
			$string .=  '<script src="'.wp_js(implode(',', $array), false).'" type="text/javascript" charset="utf-8"></script>'."\n";
		} else {
			foreach ($array as $value) {
				$string .=  '<script src="'.get_stylesheet_directory_uri().$value.'" type="text/javascript" charset="utf-8"></script>'."\n";
			}
		}

		$string .= "<!-- WP JS closes -->\n";
		echo $string;
	}
}

if (wp_js_activation() == 'on' && wp_js_within_posts_activation() == 'on') {
	add_action('wp_footer', 'wp_js_files_for_post');
}

add_action('edit_form_advanced', 'wp_js_files_display');
add_action('edit_page_form', 'wp_js_files_display');

?>