<?php
/*
Plugin Name: OptinSkin
Plugin URI: http://www.optinskin.com/
Description: OptinSkin allows you to quickly add beautiful opt-in forms and social share buttons anywhere on your blog.
Get more subscribers with unique customisation and split-testing functionality.
Version: 2.2
Author: ViperChill
Author URI: http://www.viperchill.com
*/

define( 'OptinSkin_URL', plugin_dir_url(__FILE__) );
define( 'OIS_PATH', plugin_dir_path(__FILE__) );

add_action( 'widgets_init', 'ois_load_widgets' );
// AJAX FUNCTIONS
add_action( 'wp_ajax_nopriv_ois_ajax', 'ois_submission_ajax' );
add_action( 'wp_ajax_ois_ajax', 'ois_submission_ajax' );

include_once OIS_PATH . 'skins/make_skin.php';

// ADMIN AND CHECK FOR STATS CLEANUP
if (is_admin()) {
	require OIS_PATH . 'admin/admin_main.php';
	$last_cleanup = get_option('ois_last_cleanup');
	if (strtotime($last_cleanup) < strtotime('-30 days')) {
		ois_clean_stats(); // clean those stats!
	}
} else {
	// Include the main front-end file.
	include_once OIS_PATH . 'front/front_main.php';
}

function ois_submission_ajax() {
	try {
		// Find out what kind of post it is.
		if (!empty($_POST['submit']) && $_POST['submit'] == 'yes') {
			$submission = 'yes';
		} else {
			$submission = 'no';
		}
		// Find out whether we should save stats about this event.
		$stats_disable = get_option('stats_disable');
		$stats_user_disable = get_option('stats_user_disable');
		if ($stats_user_disable == 'yes') {
			// admin user stats are disabled. If this is an admin, we're going
			// to set $stats_disabled to 'yes,' because it is equivalent to disabling stats.
			if (is_user_logged_in()) {
				$stats_disable = 'yes';
			}
		}

		if ($stats_disable != 'yes') { // then we should save stats.
			// Get the Skin ID.
			if (!empty($_POST['skin_id'])) { // get the skin ID.
				$skin_id = $_POST['skin_id'];
			} else {
				$skin_id = '';
			}
			// Find out which skin it is.
			$all_skins = get_option('ois_skins');
			if (!empty($all_skins)) {
				foreach ($all_skins as $skin) {
					if ($skin['id'] == $skin_id) {
						$this_skin = $skin;
					}
				}
			}
			// Find out if a redirect URL is set, and if so, what it is.
			if (isset($this_skin['redirect_url']) && trim($this_skin['redirect_url']) != '') {
				$redirect_url = $this_skin['redirect_url'];
			} else {
				$redirect_url = '';
			}
			// Since we are saving stats, set relevant data.
			$new_datum = array (
				's' => $skin_id, // which skin was this?
				't' => @date('Y-m-d'), // what time is it?
				'p' => $_POST['post_id'], // What post is the user current viewing?
			);
			if ($submission == 'yes') {
				$new_datum['m'] = 'yes'; // save as a submission, not just impression.
			}
			// Actually save the new stats.
			$ois_stats = get_option('ois_stats');
			if (!empty($ois_stats)) {
				@array_push($ois_stats, $new_datum);
			} else {
				$ois_stats = array($new_datum);
			}
			update_option('ois_stats', $ois_stats);
		} // Finished with saving stats.
		die(0);
	} catch (Exception $ex) {
		die(0);
	}
}

// SHORTCODE
add_shortcode('ois', 'ois_shortcode_skin');

function ois_shortcode_skin($attr) {
	$to_return = '';
	$skin_name = $attr['skin'];
	$skins = get_option('ois_skins');
	if (!empty($skins)) {
		foreach ($skins as $a_skin) {
			if ($a_skin['title'] == $skin_name) {
				$skin = $a_skin;
			}
		}
		$skin_design = $skin['design'];
		$designs = get_option('ois_designs');
		if (isset($designs[$skin_design])) {
			$design = $designs[$skin_design];
		}
		$to_return .= ois_make_skin($skin, $design);
	}
	return $to_return;
}

// ACTIVATION HOOK AND ACTIVATION FUNCTION
register_activation_hook( __FILE__, 'ois_activation' );
function ois_activation() {
	$designs = get_option('ois_designs');
	if (count($designs) == 0) {
		include_once 'admin/admin_data.php';
		ois_update_designs_code();
	}
}

// SOCIAL MEDIA BUTTON SCRIPTS
function ois_fb_script() {
	$script = "<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = \"//connect.facebook.net/en_GB/all.js#xfbml=1\";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>";
	$script .= '<div id="fb-root"></div>';
	echo $script;
}
function ois_gplus_script() {
	$script = "<script type=\"text/javascript\">
			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>";
	echo $script;
}
function ois_twitter_script() {
	$script = '<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
	echo $script;
}

function ois_linkedin_script() {
	$script = '<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>';
	echo $script;
}
function ois_stumbleupon_script() {
	$script = "<script type=\"text/javascript\">
			(function() {
		     var li = document.createElement('script'); li.type = 'text/javascript'; li.async = true;
		      li.src = 'https://platform.stumbleupon.com/1/widgets.js';
		      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(li, s);
	 		})();
		</script>";
	echo $script;
}
function ois_pinterest_script() {
	$script = '<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>';
	echo $script;
}

// SOCIAL MEDIA BUTTONS, FB LIKE, GPLUS, RETWEET, etc.
class ois_social {
	function ois_fbLike() { // Facebook Like
		$content = '<iframe src="//www.facebook.com/plugins/like.php?href=%cur_url%&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;action=like&amp;colorscheme=light&amp;font&amp;height=21&amp;appId=155303851207793" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe>';
		return $content;
	}
	function ois_pinterest_box() {
		$content = '<a href="http://pinterest.com/pin/create/button/" class="pin-it-button" count-layout="vertical"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a>';
		return $content;
	}
	function ois_fb_box() {
		$content = '<div class="fb-like" style="width:50px !important;" data-send="false" sty data-layout="box_count" data-show-faces="false"></div>';
		return $content;
	}

	function ois_gplus_box() {
		$content = '<g:plusone size="tall"></g:plusone>';
		return $content;
	}

	function ois_twitter_box() {
		$content = '<a href="https://twitter.com/share" class="twitter-share-button" data-count="vertical">Tweet</a>';
		return $content;

	}

	function ois_gplus() { // Google Buzz
		$content = '<g:plusone size="medium"></g:plusone>';
		return $content;
	}

	function ois_linkedin() {
		$content = '<script type="IN/Share" data-counter="right"></script>';
		return $content;
	}
	function ois_retweet() { // Retweet Tweetmeme
		$content = '<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>';
		return $content;
	}

	function ois_reddit() { // Reddit
		$content = '<script type="text/javascript" src="http://www.reddit.com/static/button/button1.js"></script>';
		return $content;
	}

	function ois_stumbleupon() { // Stumbleupon
		$content = '<su:badge layout="2"></su:badge>';
		return $content;
	}
	function ois_stumbleupon_box() {
		$content = '<su:badge layout="5"></su:badge>';
		return $content;
	}
}

// FUNCTION TO CLEAR STATS
function ois_clean_stats() {
	// Every 30 days, we should clean the database
	$stats = get_option('ois_stats');
	$cleanup_period = get_option('ois_cleanup_period');
	if (!$cleanup_period) {
		$cleanup_period = 31; // default is 31 days
		update_option('ois_cleanup_period', $cleanup_period);
	}
	foreach ($stats as $num=>$stat) {
		if (!empty ($stat['time'])) {
			if (strtotime($stat['time']) < strtotime('-' . $cleanup_period . ' days')) {
				echo '<p>' . $stat['time'] . '</p>';
				unset($stats[$num]);
			}
		}
	}
	update_option('ois_stats', $stats);
	update_option('ois_last_cleanup', date('Y-m-d H:i:s'));
}

// WIDGETS - LOAD AND WIDGET CLASS
function ois_load_widgets() {
	register_widget( 'OptinSkin_Widget' );
}
class OptinSkin_Widget extends WP_Widget {
	function OptinSkin_Widget() {
		$homeurl = get_option('home');
		$widget_ops = array( 'classname' => 'OptinSkin', 'description' => __('Load your skins in your sidebar!', 'OptinSkin') );
		$control_ops = array( 'id_base' => 'optinskin-widget' );
		$this->WP_Widget( 'optinskin-widget', __('OptinSkin', 'OptinSkin'), $widget_ops, $control_ops );
	}
	function widget( $args, $instance ) {
		extract( $args );
		//$title = apply_filters('widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		$skin_id = $instance['skin'];
		$split_testing = $instance['split-test'];
		if ($split_testing == 'yes') {
			$skin_b_id = $instance['skin-b'];
		}
		$skins = get_option('ois_skins');
		foreach ($skins as $s) {
			if ($s['id'] == $skin_id) {
				$skin = $s;
				break;
			}
		}
		if ($split_testing == 'yes') {
			foreach ($skins as $s) {
				if ($s['id'] == $skin_b_id) {
					$skin_b = $s;
					break;
				}
			}

			$skin_ar = array ($skin, $skin_b);
			$rand_key = array_rand($skin_ar, 1);
			$skin = $skin_ar[$rand_key];
		}

		if (!empty($skin)) {
			$design = $skin['design'];
			$all_designs = get_option('ois_designs');
			echo ois_make_skin($skin, $all_designs[$design]);
		}
		echo '<div style="clear:both;"></div>';
		echo $after_widget;
	}
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['skin'] = strip_tags( $new_instance['skin'] );
		$instance['split-test'] = strip_tags( $new_instance['split-test'] );
		$instance['skin-b'] = strip_tags( $new_instance['skin-b'] );
		return $instance;
	}

	function form( $instance ) {
		$defaults = array( 'title' => __('OptinSkin', 'OptinSkin'));
		$instance = wp_parse_args( (array) $instance, $defaults );
		$instance_key = uniqid();
?>
	<div class="ois_admin_widget">
		<h3 style="padding-top: 0;margin-top:0px;">Basic Settings</h3>
		<p>
			<div class="ois_admin_widget_title">Skin to Display:</div>
			<select class="ois_widget_selection" name="<?php echo $this->get_field_name( 'skin' ); ?>">
				<?php
		$skins = get_option('ois_skins');
		foreach ($skins as $skin) {
			if ($skin['status'] == 'publish') {
				echo '<option value="' . $skin['id'] . '"';
				if ($instance['skin'] == $skin['id']) {
					echo ' selected="selected" ';
				}
				echo '>' . $skin['title'] . '</option>';
			}
		}
?>
			</select>
		</p>
		<p><hr /></p>
		<h3>Split-Testing <span style="font-weight:normal;">(Optional)</span></h3>
		<p>
			<input class="ois_widget_split" id="<?php echo $instance_key; ?>_split" type="checkbox" name="<?php echo $this->get_field_name( 'split-test' ); ?>"
			<?php if ($instance['split-test'] == 'yes') {
			echo ' checked="checked" ';
		}?>
			value="yes" /> <span style="font-size:13px;">I want to split-test this widget</span>
		</p>
		<div id="<?php echo $instance_key; ?>_selection" style="padding: 2px 0 8px 0;">
		<div class="ois_admin_widget_title">Alternate Skin:</div>
		<select class="ois_widget_selection" name="<?php echo $this->get_field_name( 'skin-b' ); ?>" >
		<?php
		foreach ($skins as $skin) {
			if ($skin['status'] == 'publish') {
				echo '<option value="' . $skin['id'] . '"';
				if ($instance['skin-b'] == $skin['id']) {
					echo ' selected="selected" ';
				}
				echo '>' . $skin['title'] . '</option>';
			}
		}
?>
		</select>
		</div>
		<p style="border: 1px solid #e0e0e0; border-radius: 3px; -webkit-border-radius:3px; -moz-border-radius: 3px; padding: 8px 7px; margin: 5px 0; background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#fafafa), to(#e0e0e0)) !important; background-image: -moz-linear-gradient(top,  #fafafa,  #e0e0e0) !important;<?php
		?>" id="<?php echo $instance_key; ?>_info">If split-testing is enabled, the widget will either show the first or second skin, based on a random algorithm.</p>
		</div>
		<style type="text/css">
			.ois_admin_widget_title {
				font-size:15px;
				padding: 0 0 7px 0px;
			}
			.ois_admin_widget {
				font-family: 'Asap';
				max-width: 250px;
			}
			.ois_widget_selection {
				min-width: 200px;
			}
			.ois_admin_widget p {
				max-width: 250px;
			}
		</style>
	<?php
	}
}

// Provides cross-browser css code for gradients, based on top and bottom colors - Graeme Boy (graemeboy@gmail.com)
function ois_vertical_gradient($top, $bottom) {
	
	if ($top == $bottom) {
		$content = 'background-color:' . $top . '!important;';
	} else {
		$content = 'background: ' . $top . ' !important;background: -moz-linear-gradient(top, ' . $top . ' 0%, ' . $bottom . ' 100%) !important;background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,' . $top . '), color-stop(100%,' . $bottom . ')) !important;background: -webkit-linear-gradient(top, ' . $top . ' 0%,' . $bottom . ' 100%) !important;background: -o-linear-gradient(top, ' . $top . ' 0%,' . $bottom . ' 100%) !important;background: -ms-linear-gradient(top, ' . $top . ' 0%,' . $bottom . ' 100%) !important;background: linear-gradient(top, ' . $top . ' 0%,' . $bottom . ' 100%) !important;filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'' . $top . '\', endColorstr=\'' . $bottom . '\',GradientType=0 ) !important;';
	}

	return $content;

}
?>