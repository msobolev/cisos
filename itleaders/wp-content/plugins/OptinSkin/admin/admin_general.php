<?php

function ois_general_settings() {
	if ( !empty($_POST) ) {
		if (!empty($_POST['stats_disable']) || !empty($_POST['stats_cleanup'])) {
			if ( !check_admin_referer('ois_general_field', 'save_data')) {
				echo 'Sorry, your nonce did not verify.';
				exit;
			} else {
				if (!empty($_POST['stats_impressions_disable'])) {
					$stats_impressions_disable = $_POST['stats_impressions_disable'];
				} else {
					$stats_impressions_disable = '';
				}
				if (!empty($_POST['stats_submissions_disable'])) {
					$stats_submissions_disable = $_POST['stats_submissions_disable'];
				} else {
					$stats_submissions_disable = '';
				}
				if (!empty($_POST['stats_user_disable'])) {
					$stats_user_disable = $_POST['stats_user_disable'];
				} else {
					$stats_user_disable = '';
				}
				if (!empty($_POST['stats_cleanup'])) {
					$stats_cleanup = $_POST['stats_cleanup'];
				} else {
					$stats_cleanup = '';
				}
				update_option('stats_impressions_disable', $stats_impressions_disable);
				update_option('stats_submissions_disable', $stats_submissions_disable);
				update_option('stats_user_disable', $stats_user_disable);
				update_option('ois_cleanup_period', $stats_cleanup);
				ois_notification('Your General Settings Have Been Updated!', '', '');
			}
		} else if (!empty($_POST['ois_reset'])) {
			if ($_POST['ois_reset'] == 'designs') {
				if (!check_admin_referer('ois_reset_designs', 'reset')) {
					echo 'Sorry, your nonce did not verify.';
					exit;
				} else {
					ois_update_designs_code();
					ois_notification('Your Designs Have Been Reset to Default', '', '');
				}
			} else if ($_POST['ois_reset'] == 'stats') {
				if (!check_admin_referer('ois_reset_stats', 'reset')) {
					echo 'Sorry, your nonce did not verify.';
					exit;
				} else {
					update_option('ois_stats', '');
					ois_notification('Your Stats Have Been Successfully Cleared', '', '');
				}
			}
		}
	}


	ois_section_title('General Settings', 'Here you can update your general settings', '');
	ois_start_option_table('Configure Stats', 'no', '');
	$stats_submissions_disable = get_option('stats_submissions_disable');
	$stats_impressions_disable = get_option('stats_impressions_disable');
	$stats_user_disable = get_option('stats_user_disable');
	$cleanup_period = get_option('ois_cleanup_period');
	if (trim($cleanup_period) == '') {
		$cleanup_period = 90;
	}
?>
	<tr>
		<th scope="row" style="width:280px;">
			Disable Impression Statistics <br/>
		</th>
		<td>
			<p>
				<input	type="checkbox"
						name="stats_impressions_disable"
						value="yes"
				<?php if ($stats_impressions_disable == 'yes') { echo 'checked="checked"'; } ?> /> Disable
			</p>
		</td>
	</tr>
	<tr>
		<th scope="row">
			Disable Submission Statistics <br/>
		</th>
		<td>
			<p>
				<input	type="checkbox"
						name="stats_submissions_disable"
						value="yes"
				<?php if ($stats_submissions_disable == 'yes') { echo 'checked="checked"'; } ?> /> Disable
			</p>
		</td>
	</tr>
	<tr>
		<th scope="row">
			Stats from Admin Members (Based on IP) <br/>
		</th>
		<td>
			<p>
				<input	type="checkbox"
						name="stats_user_disable"
						value="yes"
				<?php if ($stats_user_disable == 'yes') { echo 'checked="checked"'; } ?> /> Don't count members' impressions and submissions
			</p>
		</td>
	</tr>
	<tr>
		<th scope="row">
			<p>Stats Cleanup Period</p>
		</th>
		<td style="vertical-align:middle;">
			<p>
			<p>OptinSkin will not save statistical data past this date.</p>
			<input	type="text"
						name="stats_cleanup"
						value="<?php echo $cleanup_period; ?>" style="width:40px;" /> Days
			</p>
		</td>
	</tr>
	<tr>
		<th scope="row">
			Save Options
		</th>
		<td>
			<?php wp_nonce_field('ois_general_field', 'save_data'); ?>
			<input type="submit" class="ois_super_button" value="Save Options" />
		</td>
	</tr>
	</table>
	</form>
	
	<?php
	ois_start_option_table('Reset Stats', 'no', '');
	?>
	<tr>
		<th scope="row" style="width:280px;">
			Reset Stats <br/>
		</th>
		<td>
			<p>
				<input type="hidden" name="ois_reset" value="stats" />
				<?php wp_nonce_field('ois_reset_stats', 'reset'); ?>
				<input	type="submit"
				 		class="ois_super_button"
						value="Clear All Stats" />
			</p>
		</td>
	</tr>
	</table>
	</form>
	
	<?php
	ois_start_option_table('Reset Designs', 'no', '');
	?>
	<tr>
		<th scope="row" style="width:280px;">
			Reset Designs <br/>
		</th>
		<td>
			<p>
				<input type="hidden" name="ois_reset" value="designs" />
				<?php wp_nonce_field('ois_reset_designs', 'reset'); ?>
				<input	type="submit"
				 		class="ois_super_button"
						value="Reset to Default Designs" />
			</p>
			<p>Note: This will overwrite any custom changes you have made, or designs you have added.</p>
		</td>
	</tr>
	</table>
	</form>


<?php
	ois_section_end();	
}

?>