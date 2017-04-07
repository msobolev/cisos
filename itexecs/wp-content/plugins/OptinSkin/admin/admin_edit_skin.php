<?php

function ois_edit_skin($skin) {
	if (isset($_GET['delete'])) {
		if (check_admin_referer('trash')) {
			// Now we can delete the skin!
			$all_skins = get_option('ois_skins');
			$id = $_GET['delete'];
			if (!empty($all_skins)) {
				foreach ($all_skins as $num=>$la_skin) {
					if ($la_skin['id'] == $id) {
						$all_skins[$num]['status'] = 'trash';
						break;
					}
				}
				update_option('ois_skins', $all_skins);
				$cur_location = explode("?", $_SERVER['REQUEST_URI']);
				$new_location =
					'http://' . $_SERVER["HTTP_HOST"] . $cur_location[0] . '?page=addskin&update=trash';
				echo '<script type="text/javascript">
						window.location = "' . $new_location . $updated_message . '";
					</script>';
			}
		}

	} else if (isset($_GET['draft'])) {
			if (check_admin_referer('draft')) {
				// Now we can delete the skin!
				$all_skins = get_option('ois_skins');
				$id = $_GET['draft'];
				if (!empty($all_skins)) {
					foreach ($all_skins as $num=>$la_skin) {
						if ($la_skin['id'] == $id) {
							$all_skins[$num]['status'] = 'draft';
							break;
						}
					}
					update_option('ois_skins', $all_skins);
					$cur_location = explode("?", $_SERVER['REQUEST_URI']);
					$new_location =
						'http://' . $_SERVER["HTTP_HOST"] . $cur_location[0] . '?page=addskin&update=draft';
					echo '<script type="text/javascript">
						window.location = "' . $new_location . $updated_message . '";
					</script>';
				}
			}
		} else {
		if (isset($_GET['range'])) {
			$stats_range = $_GET['range'];
		} else {
			$stats_range = 20;
		}

		if (isset($_POST['newskin_design_section'])) {
			ois_handle_edit_skin();
		}
		if (isset($_GET['updated']) && $_GET['updated'] == 'true') {
			ois_notification('Successfully Updated Your Skin!', 'margin: 5px 0 0 0 ;', '');
		} else if (isset($_GET['created']) && $_GET['created'] == 'true') {
				$uri = explode('?', $_SERVER['REQUEST_URI']);
				$stats_url = $uri[0] . '?page=stats';
				ois_notification('Your new skin is now live on your site. If you enabled split-testing, you can view how it is performing <a href="' . $stats_url . '">here</a>.', 'margin: 5px 0 0 0 ;', '');
			}
		ois_section_title(stripslashes($skin['title']), stripslashes($skin['description']), '');

		$feedburner_id = get_option('ois_feedburner_id');
		$mailchimp_id = get_option('ois_mailchimp_id');
		$mailchimp_api = get_option('ois_mailchimp_api');
		$aweber_id = get_option('ois_aweber_id');
		$optin_accounts = array (
			'FeedburnerID' => $feedburner_id,
			'MailChimpID' => $mailchimp_id,
			'MailChimpAPI' => $mailchimp_api,
			'AweberID' => $aweber_id,
		);

		$all_stats = get_option('ois_stats');
		//print_r($all_stats);
		$impressions = array();
		$submits = array();

		if (!empty($all_stats)) {
			foreach ($all_stats as $stats) {
				if (!empty($stats['s'])) {
					if ($stats['s'] == $skin['id']) {
						if (!empty($stats['m']) && $stats['m'] == 'yes') {
							array_push($submits, $stats);
						} else {
							array_push($impressions, $stats);
						}
					}
				}
			}
		}
		$uri = explode('?', $_SERVER['REQUEST_URI']);
		$edit_url = $uri[0] . '?page=addskin&id=' . $skin['id'];
		$dup_url = $uri[0] . '?page=addskin&duplicate=' . $skin['id'];
?>
	<div class="ois_rolo_description"></div>
	<div>
	<h2 class="nav-tab-wrapper">
		<a href="<?php echo $_SERVER['REQUEST_URI']; ?>" class="nav-tab nav-tab-active">Skin Performance</a>
		<a href="<?php echo $edit_url; ?>" class="nav-tab">Edit Skin</a>
		<a href="<?php echo $dup_url; ?>" class="nav-tab">Duplicate Skin</a>
	</h2>
	</div>

		<style>
			.ois_stats_option, .ois_stats_days_option {
				padding: 5px 9px;;
				border-radius: 4px;
				-moz-border-radius: 4px;
				-webkit-border-radius: 4px;
				-moz-box-shadow:    1px 1px 1px 1px #f1f5f9;
	 			-webkit-box-shadow: 1px 1px 1px 1px #f1f5f9;
	  			box-shadow:         1px 1px 1px 1px #f1f5f9;
	  			border: 1px solid #e3e9f0;
	  			margin: 5px;
			}
			.ois_stats_option:hover, .ois_stats_days_option:hover {
				background-color: #f7f9fb;
				-moz-box-shadow:    1px 1px 1px 1px #eee;
	 			-webkit-box-shadow: 1px 1px 1px 1px #eee;
	  			box-shadow:         1px 1px 1px 1px #eee;

			}
			div.ois_stat_options{
				padding: 15px 0 15px 5px;
			}
			.ois_plotarea {
				margin: 12px 8px 10px 8px;
				height: 255px;
			}
			.ois_vis_a_active, .ois_stats_days_a_active {
				padding: 5px 12px;
				background-color: #f0f4f8 !important;
			}
			.ois_code_snippet {
				padding: 5px;
				background-color: #fffeee;
				border: 1px dashed #fff222;
				font-family: "Georgia";
			}
			.ois_stats_table {
				margin-top: 10px !important;
			}
		</style>
			<table class="widefat" style="width:95%; margin: 10px 0;">
			<tbody>
				<tr class="alternate">
					<td>
			<h3 style="margin:5px 0;">Custom Positioning</h3>
			<p style="line-height:20px;">
				To use this skin as a shortcode, simply put
				<span class="ois_code_snippet" id="ois_use_shortcode">[ois skin="<?php echo $skin['title']; ?>"]</span> into any of your posts.<br/>To use it on a php page, such as <em>header.php</em> or <em>footer.php</em>, use the php code
				<span class="ois_code_snippet" id="ois_do_shortcode">echo do_shortcode( '[ois skin="<?php echo $skin['title']; ?>"]' );</span>.
			</p>
		</div>
		</td>
				</tr>
				</tbody>
				</table>

					<style>
			.ois_column_left {
				float:left;
				width:45%;
				padding-right: 5%;
			}
			.ois_column_right {
				float:right;
				width:45%;
				padding-right: 5%;
			}
			.ois_skin_action {
				margin: 0 5px;
			}
		</style>

	<?php
		// STATISTICS //
		$stats_disable = get_option('stats_disable');
		if ($stats_disable != 'yes') { ?>
		<script src="<?php echo WP_PLUGIN_URL; ?>/OptinSkin/admin/special_includes/flot/jquery.flot.js" language="javascript" type="text/javascript"></script>
		<!--[if IE]><script language="javascript" type="text/javascript" src="<?php echo WP_PLUGIN_URL; ?>/OptinSkin/admin/special_includes/flot/excanvas.pack.js"></script><![endif]-->


		<script language="javascript" type="text/javascript">

		jQuery(function ($) {
			// For signups

		var signups_data = [
			{
				color: '#5793c3',
				label: "Number of Signups",
				data:
					[
				<?php
			// Data for Submits
			$submits_data = array();
			for ($i = 0; $i < $stats_range; $i++) {
				$x = 0;
				// for each day
				if (!empty($submits)) {
					foreach ($submits as $submit) {
						// go through all impressions
						if (strtotime($submit['t']) < strtotime('-' . $i . ' days')
							&& strtotime($submit['t']) > strtotime('-' . ($i + 1) . ' days')) {
							// if within this day
							$x++;
						}
					}
				}
				array_unshift($submits_data, $x);
			}
			foreach ($submits_data as $i=>$quantity) {
				echo '[' . $i . ', ' . $quantity . '],';
			}
?>
					]
			}
		];
			var signups_options = {
			yaxis: {
				color: "#000",
				tickColor: "#e6eff6",
				tickDecimals: 0,
				min: 0,
			},
			xaxis: {
				color: "#000",
				tickColor: "#e6eff6",
				min: 0,
				tickSize: 30,
			    ticks: [
			    	<?php
			
			if ($stats_range <= 60) {
				for ($i = 0; $i < $stats_range; $i++) {
					$date = explode('-', date('Y-m-d', strtotime('-' . $i . ' days')));
					echo '[' . (($stats_range - 1) - $i) . ', \'' . $date[1] . '/' . $date[2] . '\'],';
				}
			}
?>
			    	]
		  	},
			legend: {
				show: true,
				margin: 10,
				backgroundOpacity: 0.5,
			},
			grid: {
				hoverable: true,
				clickable: true,
				aboveData: false,
				backgroundColor: null,
				color: "rgba(87, 147, 195, 0.5)",
				borderColor: "#444",
			},
			interaction: {
			},
			points: {
				show: true,
				radius: 3,
			},
			lines: {
				show: true,
				fill: true,
				fillColor: "rgba(87, 147, 195, 0.4)",
			},
		};
			var ois_signups_plot = $("#ois_signups_plot");
			$.plot( ois_signups_plot , signups_data, signups_options );

			// For impressions

			var impressions_data = [
			{
				color: '#5793c3',
				label: "Number of Impressions",
				data:
					[
				<?php
			// Data for Impressions
			$impression_data = array();
			for ($i = 0; $i < $stats_range; $i++) {
				$x = 0;
				// for each day
				if (!empty($impressions)) {
					foreach ($impressions as $impression) {
						// go through all impressions
						if (strtotime($impression['t']) < strtotime('-' . $i . ' days')
							&& strtotime($impression['t']) > strtotime('-' . ($i + 1) . ' days')) {
							// if within this day
							$x++;
						}
					}
				}
				array_unshift($impression_data, $x);
			}
			foreach ($impression_data as $i=>$quantity) {
				echo '[' . $i . ', ' . $quantity . '],';
			}
?>
					]
			}
		];
			var impressions_options = {
			yaxis: {
				tickDecimals: 0,
				min: 0,
				color: "#000",
				tickColor: "#e6eff6",
			},
			xaxis: {
				color: "#000",
				tickColor: "#e6eff6",
				min: 0,
		    	ticks: [
		    	<?php
			if ($stats_range <= 60) {
				for ($i = 0; $i < $stats_range; $i++) {
					$date = explode('-', date('Y-m-d', strtotime('-' . $i . ' days')));
					echo '[' . (($stats_range - 1) - $i) . ', \'' . $date[1] . '/' . $date[2] . '\'],';
				}
			}
?>
		    	]
		  	},
			legend: {
				show: true,
				margin: 10,
				backgroundOpacity: 0.5,
			},
			grid: {
				hoverable: true,
				clickable: true,
				aboveData: false,
			},
			interaction: {
			},
			points: {
				show: true,
				radius: 3,
			},
			lines: {
				show: true,
				fill: true,
				fillColor: "rgba(87, 147, 195, 0.4)",
			},

		};
			var ois_impressions_plot = $("#ois_impressions_plot");
			$.plot( ois_impressions_plot , impressions_data, impressions_options );

			// For Conversions

			var conversions_data = [
			{
				color: '#5793c3',
				label: "Conversion Rates",
				data:
					[
				<?php
			// Data for Conversions
			if (!empty($impression_data)) {
				foreach ($impression_data as $i=>$quantity) {
					if ($quantity > 0) {
						$rate = $submits_data[$i]/$quantity;
						echo '[' . $i . ', ' . ($rate * 100) . '],';;
					} else {
						echo '[' . $i . ', 0],';
					}
				}
			}
?>
					]
			}
		];
			var conversions_options = {
			yaxis: {
				min: 0,
				color: "#000",
				tickColor: "#e6eff6",
				tickDecimals: 2,
			},
			xaxis: {
				color: "#000",
				tickColor: "#e6eff6",
				min: 0,
		    	ticks: [
		    	<?php
			if ($stats_range <= 60) {
				for ($i = 0; $i < $stats_range; $i++) {
					$date = explode('-', date('Y-m-d', strtotime('-' . $i . ' days')));
					echo '[' . (($stats_range - 1) - $i) . ', \'' . $date[1] . '/' . $date[2] . '\'],';
				}
			}
?>
		    	]
		  	},
			legend: {
				show: true,
				margin: 10,
				backgroundOpacity: 0.5,
			},
			grid: {
				hoverable: true,
				clickable: true,
				aboveData: false,
			},
			interaction: {
			},
			points: {
				show: true,
				radius: 3,
			},
			lines: {
				show: true,
				fill: true,
				fillColor: "rgba(87, 147, 195, 0.4)",
			},
		};
			var ois_conversions_plot = $("#ois_conversions_plot");
			$.plot( ois_conversions_plot , conversions_data, conversions_options );

				 function ois_stat_showTooltip(x, y, contents) {
		        $('<div id="tooltip">' + contents + '</div>').css( {
		            position: 'absolute',
		            display: 'none',
		            top: y + 5,
		            left: x + 5,
		            border: '1px solid #fdd',
		            padding: '2px',
		            'background-color': '#fee',
		            opacity: 0.80
		        }).appendTo("body").fadeIn(200);
		    }
		    var previousPoint = null;
		    $("#ois_plotarea").bind("plothover", function (event, pos, item) {
		        $("#x").text(pos.x);
		        $("#y").text(pos.y);

		        if (item) {
		            if (previousPoint != item.dataIndex) {
		                previousPoint = item.dataIndex;

		                $("#tooltip").remove();
		                var x = item.datapoint[0],
		                    y = item.datapoint[1];

		                ois_stat_showTooltip(item.pageX, item.pageY, y);
		            }
		        }
		        else {
		            $("#tooltip").remove();
		            previousPoint = null;
		        }
		    });

		    $('#ois_a_impressions').click(function() {
		    	$('#ois_chart_title').text('Impressions in the Last <?php echo $stats_range; ?> Days');
		    	$('.ois_plotarea').hide();
		    	$('#ois_impressions_plot').show();
		    });
		     $('#ois_a_signups').click(function() {
		     	$('#ois_chart_title').text('Signups in the Last <?php echo $stats_range; ?> Days');
		    	$('.ois_plotarea').hide();
		    	$('#ois_signups_plot').show();
		    });
		     $('#ois_a_conversions').click(function() {
		     	$('#ois_chart_title').text('Conversion Rates in the Last <?php echo $stats_range; ?> Days');
		    	$('.ois_plotarea').hide();
		    	$('#ois_conversions_plot').show();
		    });


		    $('.ois_plotarea').hide();
			$('#ois_signups_plot').show();

			$('.ois_vis_a').click(function () {
				$('.ois_vis_a_active').removeClass('ois_vis_a_active');
				$(this).parent().addClass('ois_vis_a_active');
			});


			$('.ois_code_snippet').click(function () {

				selectText($(this).attr('id'));

			});

			function selectText(element) {
			    var doc = document;
			    var text = doc.getElementById(element);
			    if (doc.body.createTextRange) {
			        var range = document.body.createTextRange();
			        range.moveToElementText(text);
			        range.select();
			    } else if (window.getSelection) {
			        var selection = window.getSelection();
			        var range = document.createRange();
			        range.selectNodeContents(text);
			        selection.removeAllRanges();
			        selection.addRange(range);
			    }
			}

		});
		</script>
		<table class="widefat" style="width:95%; margin-bottom:10px;">
			<thead>
				<th id="ois_chart_title">Signups in the Last <?php echo $stats_range; ?> Days</th>
			</thead>
			<tbody>
			<tr class="alternate">
				<td>
			<div id="ois_signups_plot" class="ois_plotarea">
				<div style="text-align:center;">
					<p>
						<img	style="width: 80px;"
								src="<?php
			echo WP_PLUGIN_URL; ?>/OptinSkin/admin/images/circle_load.gif" />
					</p>
					<p>Loading a Visualization of Your Data...</p>
				</div>
			</div>
			<div id="ois_impressions_plot" class="ois_plotarea">
			</div>
			<div id="ois_conversions_plot" class="ois_plotarea">
			</div>
		</td>
			</tr>
			<tr>
				<td>
				<div class="ois_stat_options">
					<strong>Visualize Statistics: </strong>
					<span class="ois_stats_option ois_vis_a_active">
						<a href="javascript:void();" id="ois_a_signups" class="ois_vis_a">Signups</a>
					</span>
					<span class="ois_stats_option">
						<a href="javascript:void();" id="ois_a_impressions" class="ois_vis_a">Impressions</a>
					</span>
					<span class="ois_stats_option">
						<a href="javascript:void();" id="ois_a_conversions" class="ois_vis_a">Conversion Rate</a>
					</span>
					<?php
			$useable_uri = explode('&range=', $_SERVER['REQUEST_URI']);
			$days = array(20, 30, 60, 90);
			$days = array_reverse($days);
			foreach ($days as $day) {
				echo '<span 	class="ois_stats_days_option ';
				if ($stats_range == $day) {
					echo 'ois_stats_days_a_active';
				}
				echo '" style="float:right;margin-top:-7px;">
							<a 	href="' . $useable_uri[0] . '&range=' . $day . '"
								id="ois_a_lol" class="ois_stats_days_a ">' . $day . ' Days</a>
							</span>';
			}
?>

				</div>
				</td>
			</tr>
			</tbody>
			</table>
			<div class="wrapper">
			<div class="ois_column_left">
			<?php
			/*
			ois_start_stat_table(array
				('title' => '10 Ten Referring Websites',
					'first_sub_style' => 'style="width:150px;"',
					'subs' => array ('Domain', '1 Day', '7 Days', '30 Days', 'All Time'),
					'data' => array (
						'google.com' => array(2, 3, 2, 4),
					),
				) );

			</tbody>
			</table>*/


			// Top Posts
			$post_stats_submits = array();
			$post_stats_impressions = array();
			$all_posts = get_posts();
			if (!empty($all_posts)) {
				foreach ($all_posts as $post) {
					$post_id = $post->ID;
					$post_stats_submits[$post_id] = 0;
					$post_stats_impressions[$post_id] = 0;
					foreach ($submits as $submit) {
						if ($submit['p'] == $post_id) {
							$post_stats_submits[$post_id]++;
						}
					}
					foreach ($impressions as $impression) {
						if ($impression['p'] == $post_id) {
							$post_stats_impressions[$post_id]++;
						}
					}
				}
			}

			asort($post_stats_impressions);
			$post_stats_impressions =  array_reverse($post_stats_impressions, true);
			asort($post_stats_submits);
			$post_stats_submits = array_reverse($post_stats_submits, true);
?>
			<table class="widefat ois_stats_table">
				<thead>
					<th>Top 10 Posts</th>
					<th>Signups</th>
					<th>Impressions</th>
					<th>Conversion Rate</th>
				</thead>
				<tbody>
				<?php
			$count = 0;
			$max_count = 10;
			if (!empty($post_stats_submits)) {
				foreach ($post_stats_submits as $post_num=>$stats) {
					if ($count < $max_count) {
						$this_post = get_post($post_num);
						if (strlen($this_post->post_title) > 26) {
							$title = substr($this_post->post_title, 0, 26) . '...';
						} else {
							$title = $this_post->post_title;
						}

						if ($post_stats_impressions[$post_num]) {
							$num_imp = $post_stats_impressions[$post_num];
						} else {
							$num_imp = 0;
						}
						// conversion rate
						if ($num_imp > 0) {
							$rate = round(($stats/$num_imp * 100), 1);
						} else {
							$rate = 0;
						}
						echo '<tr>';
						echo '<th scope="row"><a href="' . $this_post->guid . '">' . $title . '</a></th>';
						echo '<td>' . $stats . '</td>';
						echo '<td>' . $num_imp . '</td>';
						echo '<td>' . $rate . '%</td>';
						echo '</tr>';
						$count++;
					} else {
						break;
					}
				}
			}
?>
				</tbody>
			</table>
			</td>
			</tr>
			</tbody>
			</table>
			</div>

			<div class="ois_column_right">
			<table class="widefat" style="margin-bottom: 10px; margin-top: 10px;">
				<thead>
					<tr>
						<th>Actions for Skin</th>
					</tr>
				</thead>
				<tbody>
					<tr class="alternate">
						<td>
							<p style="padding-top:5px;">
								<a 	class="ois_skin_action"
									href="<?php echo $edit_url; ?>">Edit Skin</a>
							 | 	<a 	class="ois_skin_action"
							 		href="<?php echo wp_nonce_url( $_SERVER['REQUEST_URI'], 'trash'); ?>&delete=<?php echo $skin['id']; ?>">Move to Trash</a>
							 |
							<a href="<?php echo wp_nonce_url( $_SERVER['REQUEST_URI'], 'draft'); ?>&draft=<?php echo $skin['id']; ?>">Move to Drafts</a></p>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
			<?php
			$num_data = get_option('ois_cleanup_period');
			if (!$num_data) {
				$num_data = 31; // 31 is default.
				update_option('ois_cleanup_period', $num_data);
			}
?>

			</div>

			<?php
			ois_section_end();
?>
			<div style="clear:both"></div>
			<p	style="padding: 8px; text-align:center; margin: 45px 0 0 0;
						-webkit-box-shadow: rgba(0, 0, 0, 0.199219) 1px 2px 3px 1px;
		box-shadow: rgba(0, 0, 0, 0.199219) 1px 2px 3px 1px; background-color: #FCFCFC;">
				<em>Note:</em> statistics are only kept in the database for <?php echo $num_data; ?> days, so as not to slow down the system. You can change this option in your OptinSkin&trade; settings.
			</p>
			<?php
		}

		function ois_start_stat_table($attr) {

?>

		<table class="widefat" style="margin-top:15px;">
			<thead>
				<tr>
					<th <?php $title_style; ?>>
						<?php echo $attr['title']; ?>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
					<table>
						<thead>
							<tr>
							<?php
			$i;
			foreach ($attr['subs'] as $sub) {
				if ($i == 0) {
					echo '<th ' . $attr['first_sub_style'] . ' >';
				} else {
					echo '<th>';
				}
				echo $sub . '</th>';
				$i++;
			}
?>
							</tr>
						</thead>
						<tbody>
						<?php
			foreach ($attr['data'] as $name=>$data) {
				echo '<tr>';
				echo '<th scope="row">' . $name . '</th>';

				foreach ($data as $datum) {
					echo '<td>' . $datum . '</td>';
				}
				echo '</tr>';
			}
?>
						</tbody>
					</table>
					</td>
				</tr>
			</tbody>
		</table>
	<?php
		}
	}
}
?>