<form action="" method="post">
    <?php wp_nonce_field( $namespace . "_options", $namespace . '_update_wpnonce' ); ?>
    <input type="hidden" name="form_action" value="update_options" />
    <div class="wrap">
        <h2><?php echo $page_title; ?></h2>
        <div class="tool-box">
            <h3 class="title">Your Hello Bar Code</h3>
			<p>Fetch your HelloBar code from <a href="https://www.hellobar.com/login">www.hellobar.com</a> and paste it below.</p>
			<textarea rows="10" cols="70" name="hellobar_code"><?php echo $hellobar_code; ?></textarea>
            
			<h4>Load the Hello Bar code in your site's:</h4>
			<input id="<?php echo $namespace; ?>-load-code-in-header" type="radio" name="load_hellobar_in" value="header"<?php echo $load_hellobar_in == 'header' ? ' checked="checked"' : ''; ?> /><label for="<?php echo $namespace; ?>-load-code-in-header">Header (before &lt;/head&gt;)</label><br />
			<input id="<?php echo $namespace; ?>-load-code-in-footer"  type="radio" name="load_hellobar_in" value="footer"<?php echo $load_hellobar_in == 'footer' ? ' checked="checked"' : ''; ?> /><label for="<?php echo $namespace; ?>-load-code-in-footer">Footer (before &lt;/body&gt;)</label>
        </div>
        <p class="submit">
            <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
        </p>
    </div>
</form>