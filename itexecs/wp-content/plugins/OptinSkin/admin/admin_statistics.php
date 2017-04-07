<?php
function ois_statistics() {

	ois_section_title('Split Testing', 'Note: Only includes currently published skins.', '');
?>
	<style type="text/css">
		.ois_split_explain {
			background-color: #FFFEE7;
    		border: 1px solid #FFCC00;
			border-radius: 3px;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
			padding: 5px 15px 30px 15px;
			margin: 10px 0;
			width: 750px;
		}
		.ois_how_split li {
			font-size: 14px;
		}
		.ois_how_split {
			width: 700px;
		}
	</style>
	<?php
	$all_stats = get_option('ois_stats');
	$skins = get_option('ois_skins');
	$stats_range = 10;
	$uri = explode('?', $_SERVER['REQUEST_URI']);
	$page_url = $uri[0] . '?page=ois-';
?>
	<table class="widefat">
		<thead>
			<th>Skin Name</th>
			<th>Impressions</th>
			<th>Submits</th>
			<th>Conversion Rate</th>
		</thead>
	<?php
	if (!empty($all_stats)) {
		foreach ($skins as $skin) {
			if ($skin ['status'] == 'publish') {
				echo '<tr>';
				echo '<th><a href="' . $page_url . $skin['id'] . '" >' . $skin['title'] . '</a></th>';
				$impressions = array();
				$submits = array();
				
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
				$num_imp = count($impressions);
				$num_sub = count($submits);
				echo '<td>' . $num_imp . '</td>';
				echo '<td>' . $num_sub . '</td>';
				if (count($impressions) != 0) {
					echo '<td>' . round(100 * $num_sub/$num_imp, 2) . '%</td>';
				} else {
					echo '<td>Unknown</td>';
				}
				echo '</tr>';
			}
		}
	}
?>
	</table>
		<div class="ois_split_explain">
	<h3 class="ois_split_head" style="font-size:18px;">How Does Split-Testing Work?</h3>
	<h3>Split-Testing Within Content</h3>
		<ol class="ois_how_split">
			<li><h4>Create a skin, and select where you want it to appear</h4>
			<p>When you create a skin, you can select where you want it to appear - at the bottom of posts, floated to the right of posts, below the first paragraph, or at the top of posts. For the sake of this example, let's say that we called our skin 'Split-Test A'.</p>
			</li>
			<li><h4>Enable split-testing</h4>
			<p>Next, select that you want split-testing enabled for this skin. After you are happy with your skin's settings, and split-testing is enabled, click the button that says 'Create this Skin'. Your skin will now appear on your site wherever you previously specified.</p>
			</li>
			<li><h4>Create a second skin, positioned in the same area, and enable split-testing</h4>
			<p>Now, create your second skin that you want to split-test. You could call this skin, for example, 'Split-Test B'. Select the same position for this skin as 'Split-test A', and set the split-testing option to enabled. Create this skin when you are ready.</p>
			<p>On your website, only one of the two skins will appear, either 'Split-test A' or 'Split-test B'. These will display randomly, rather then A, B, A, B, and so on, so that you can be sure that your statistics are accurate over time. You can now create 'Split-Test C', and so on, for as many skins that you want to test in this area of your site, or create new skins to test in different areas.</p></li>
		</ol>

	<img src="<?php echo WP_PLUGIN_URL; ?>/OptinSkin/admin/images/widget_split_test.png" style="float:right; height: 230px; margin: 0 75px 0 45px; padding: 5px;" />
	<h3>Split-Testing in the Sidebar</h3>
		<ol class="ois_how_split">
			<li><h4>Add the OptinSkin Widget to your Sidebar</h4>
			<p>Simply drag the OptinSkin sidebar widget into your sidebar in the Wordpress Widget section. The settings there are very straightforward - use a title if you wish, and select your first skin to test using the drop-down menu.</p></li>
			<li>
			</p><h4>Enable Split-Testing and Select Your Second Skin</h4>
			<p>Enable split-testing for this widget, and select your second widget to split-test. As easy as that, you're all set for split-testing!</li>
		</ol>
	</div>
	<?php
	ois_section_end();
}
?>