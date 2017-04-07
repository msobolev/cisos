<div class="wrap">
    <h2>AWeber Web Form Options</h2>
    <form name="aweber_forms_import_form" method="post" action="options.php">
        <?php wp_nonce_field('update-options'); ?>
        <input type="hidden" name="aweber_forms_import_hidden" value="Y">
        <table class="form-table">
            <?php
                $pluginAdminOptions = get_option($this->adminOptionsName);
                $options = get_option($this->widgetOptionsName);

                settings_fields('AWeberWebformOauth');
                $oauth_removed = get_option('aweber_webform_oauth_removed');
                $oauth_id = get_option('aweber_webform_oauth_id');

                $authorize_success = False;
                $button_value = 'Make Connection';
                $temp_error = null;
                $error = null;

                // Check to see if they removed the connection
                $authorization_removed = False;
                if ($oauth_removed == 'TRUE' || (!empty($_GET['reauth']) && $_GET['reauth'] == True)) {
                    $authorization_removed = True;
                }
                if ($oauth_removed == 'FALSE') {
                    if (get_option('aweber_comment_checkbox_toggle') == 'OFF' and
                        get_option('aweber_registration_checkbox_toggle') == 'OFF')
                    {
                        $options['create_subscriber_comment_checkbox'] = 'OFF';
                        $options['create_subscriber_registration_checkbox'] = 'OFF';
                    }
                    else {
                        echo $this->messages['no_list_selected'];
                        $error = True;
                    }
                }

                if (is_numeric($oauth_removed)) {
                    $options['list_id_create_subscriber'] = $oauth_removed;
                    $options['create_subscriber_comment_checkbox'] = get_option('aweber_comment_checkbox_toggle');
                    $options['create_subscriber_registration_checkbox'] = get_option('aweber_registration_checkbox_toggle');
                    if (strlen(get_option('aweber_signup_text_value')) < 7)
                        echo $this->messages['signup_text_too_short'];
                    else {
                        $options['create_subscriber_signup_text'] = get_option('aweber_signup_text_value');
                    }
                    update_option($this->widgetOptionsName, $options);
                }

                if ($authorization_removed) {
                    $this->deauthorize();
                    $pluginAdminOptions = get_option($this->adminOptionsName);
                    $options = get_option($this->widgetOptionsName);
                    echo '<div id="message" class="updated"><p>Your connection to your AWeber account has been closed.</p></div>';
                    $error = $temp_error = null;
                }
                elseif ($oauth_id and !$pluginAdminOptions['access_secret']) {
                    // Then they just saved a key and didn't remove anything
                    // Check it's validity then save it for later use
                    $error_code = "";
                    try {
                        list($consumer_key, $consumer_secret, $access_key, $access_secret) = AWeberAPI::getDataFromAweberID($oauth_id);
                    } catch (AWeberAPIException $exc) {
                        list($consumer_key, $consumer_secret, $access_key, $access_secret) = null;
                        # make error messages customer friendly.
                        $descr = $exc->description;
                        $descr = preg_replace('/http.*$/i', '', $descr);     # strip labs.aweber.com documentation url from error message
                        $descr = preg_replace('/[\.\!:]+.*$/i', '', $descr); # strip anything following a . : or ! character
                        $error_code = " ($descr)";
                    } catch (AWeberOAuthDataMissing $exc) {
                        list($consumer_key, $consumer_secret, $access_key, $access_secret) = null;
                    } catch (AWeberException $exc) {
                        list($consumer_key, $consumer_secret, $access_key, $access_secret) = null;
                    }

                    if (!$access_secret) {
                        $msg =  '<div id="aweber_access_token_failed" class="error">';
                        $msg .= "Unable to connect to your AWeber Account$error_code:<br />";
                        $error = True;

                        # show oauth_id if it failed and an api exception was not raised
                        if ($error_code == "") { 
                            $msg .= "Authorization code entered was: $oauth_id <br />";
                        }
                        $msg .= "Please make sure you entered the complete authorization code and try again.</div>";
                        echo $msg;
                        $this->deauthorize();
                    } else {
                        $pluginAdminOptions = array(
                            'consumer_key' => $consumer_key,
                            'consumer_secret' => $consumer_secret,
                            'access_key' => $access_key,
                            'access_secret' => $access_secret,
                        );
                        update_option($this->adminOptionsName, $pluginAdminOptions);
                    }
                }
                if ($pluginAdminOptions['access_key']) {
                    extract($pluginAdminOptions);
                    $error_ = null;
                    try {
                        $aweber = $this->_get_aweber_api($consumer_key, $consumer_secret);
                        $account = $aweber->getAccount($access_key, $access_secret);
                    } catch (AWeberException $e) {
                        $error_ = get_class($e);
                        $account = null;
                    }
                    if (!$account) {
                        $pluginAdminOptions = get_option($this->adminOptionsName);
                        $options = get_option($this->widgetOptionsName);
                        if($error_ != 'AWeberOAuthException' && $error_ != 'AWeberOAuthDataMissing') {
                            echo $this->messages['temp_error'];
                            $temp_error = True;
                        } else {
                            $this->deauthorize();
                            echo $this->messages['auth_failed'];
                        }
                    }
                    else {
                        $authorize_success = True;
                        $button_value = 'Remove Connection';
                    }
                }

                if(empty($_GET['updated']) || $error || $temp_error) {
                    ?>
                    <script type="text/javascript">
                        jQuery("#setting-error-settings_updated").hide();
                    </script>
                    <?php
                }
                // Checks to see if the widget is installed
                $aweber_option_name = strtolower($this->widgetOptionsName);
                $installed_widget = false;

                foreach (get_option('sidebars_widgets') as $widget){
                    if (is_array($widget) and in_array($aweber_option_name, $widget)) {
                        $installed_widget = true;
                    }
                }
            ?>
        <?php if ($authorize_success) { ?>

        <p>You've successfully connected to your AWeber account!
                    <input type="submit" id="aweber-settings-button" class="button-primary" value="<?php _e($button_value) ?>" />
        </p>
        <h2> Sidebar Webform Settings </h2>
            <p>Go to the <a href="widgets.php">Widgets Page</a> and drag the AWeber Web Form widget into your widget area.</p>
        <h2> Subscribe By Commenting </h2>
        Allow readers to subscribe to your mailing list when they register or leave a comment</br></br>
        <?php
            $lists = $account->lists;
            if (!empty($lists)) {
                if ($lists->data['total_size'] == 1) {
                    $options['list_id_create_subscriber'] = $lists->data['entries'][0]['id'];
                    update_option('AWeberWebformPluginWidgetOptions', $options);
                }
                ?>
                <label for="<?php echo $this->widgetOptionsName; ?>-list">
                    Select the list you'd like people to subscribe to:
                </label>
                <select style="width:250px;display:block;margin-bottom:15px;margin-top:5px" class="widefat <?php echo $this->widgetOptionsName; ?>-list" name="<?php echo $this->widgetOptionsName; ?>[list]" id="<?php echo $this->widgetOptionsName; ?>-list">
<option value="FALSE">Select A List</option>
            <?php foreach ($lists as $this_list): ?>
            <option value="<?php echo $this_list->id; ?>"<?php echo ($this_list->id == $options['list_id_create_subscriber']) ? ' selected="selected"' : ""; ?>><?php echo $this_list->name; ?></option>
            <?php endforeach; ?>
</select>
            <?php } else { ?>
            This AWeber account does not currently have any lists.
            <?php } ?>
<p><input type="checkbox" name="aweber_comment_checkbox" id="aweber-create-subscriber-comment-checkbox"
<?php if($options['create_subscriber_comment_checkbox'] == 'ON') echo 'checked="checked"'; ?> value="">
<label for="aweber-create-subscriber-comment-checkbox">Allow subscriptions when visitors comment.</label></p>
<p><input type="checkbox" name="aweber_registration_checkbox" id="aweber-create-subscriber-registration-checkbox"
<?php if($options['create_subscriber_registration_checkbox'] == 'ON') echo 'checked="checked"'; ?> value="">
<label for="aweber-create-subscriber-registration-checkbox">Allow subscriptions when visitors register to your blog.</label></p>

<label for="aweber-create-subscriber-signup-text">
    Promotion text:
</label>
<input type="text" size="50" name="aweber_signup_text" id="aweber-create-subscriber-signup-text" value="<?php echo $options['create_subscriber_signup_text'];?>" />
</br>

</table>

<p class="submit">
                    <input type="submit" id="aweber-settings-save-button" class="button-primary" value="<?php _e('Save') ?>" />
                </p>


                <input type="hidden" id="aweber-settings-hidden-value" name="aweber_webform_oauth_removed" value="TRUE" />
                <input type="hidden" id="aweber-settings-hidden-comment-checkbox-value" name="aweber_comment_checkbox_toggle" value="<?php echo $options['create_subscriber_comment_checkbox'];?>" />
                <input type="hidden" id="aweber-settings-hidden-registration-checkbox-value" name="aweber_registration_checkbox_toggle" value="<?php echo $options['create_subscriber_registration_checkbox'];?>" />
                <input type="hidden" id="aweber-settings-hidden-signup-text-value" name="aweber_signup_text_value" value="<?php echo $options['create_subscriber_signup_text'];?>" />


            <?php } else if($temp_error || $error) { ?>
                <br />
                <br />
            <?php } else { ?>
                <tr valign="top">
                <th scope="row">Step 1:</th>
                <td><a target="_blank" 
                    href="https://auth.aweber.com/1.0/oauth/authorize_app/f49b1bcf">Click here to get your authorization code</a>.
                </tr>

                <tr valign="top">
                <th scope="row">Step 2: Paste in your authorization code:</th>
                <td><input type="text" name="aweber_webform_oauth_id"/></td>
                </table>
                <p class="submit">
                    <input type="hidden" name="_wp_http_referer" value="<?php echo admin_url('options-general.php?page=aweber.php'); ?>" />
                    <input type="submit" id="aweber-settings-button" class="button-primary" value="<?php _e($button_value) ?>" />
                </p>
            <?php } ?>
            <?php if ($authorization_removed or $authorize_success): ?>
                <script type="text/javascript" >
                    jQuery.noConflict();
                    jQuery("#aweber_auth_error").hide();
                </script>
            <?php endif ?>
        <input type="hidden" name="action" value="update" />
        <input type="hidden" name="page_options" value="aweber_webform_oauth_id" />

                <script type="text/javascript" >
                jQuery('#aweber-settings-save-button').live('click', function() {
                    jQuery('#aweber-settings-hidden-value').val(jQuery('#AWeberWebformPluginWidgetOptions-list').val());
                    jQuery('#aweber-settings-hidden-signup-text-value').val(jQuery('#aweber-create-subscriber-signup-text').val());
                });
                jQuery('#aweber-create-subscriber-comment-checkbox').live('change', function() {
                    if (jQuery(this).attr('checked') != undefined &&
                        jQuery(this).attr('checked') != false) {
                        jQuery('#aweber-settings-hidden-comment-checkbox-value').val('ON');
                    }
                    else {
                        jQuery('#aweber-settings-hidden-comment-checkbox-value').val('OFF');
                    }
                });
                jQuery('#aweber-create-subscriber-registration-checkbox').live('change', function() {
                    if (jQuery(this).attr('checked') != undefined &&
                        jQuery(this).attr('checked') != false) {
                        jQuery('#aweber-settings-hidden-registration-checkbox-value').val('ON');
                    }
                    else {
                        jQuery('#aweber-settings-hidden-registration-checkbox-value').val('OFF');
                    }
                });
                </script>
    </form>
</div>
