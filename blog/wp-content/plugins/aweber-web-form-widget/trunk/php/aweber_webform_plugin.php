<?php
/**
    * AWeber Web Form Plugin object
    *
    * Main wordpress interface for integrating your AWeber Web Forms into
    * your blog.
    */
class AWeberWebformPlugin {
    var $adminOptionsName = 'AWeberWebformPluginAdminOptions';
    var $widgetOptionsName = 'AWeberWebformPluginWidgetOptions';
    var $oauthOptionsName = 'AWeberWebformOauth';
    var $messages = array();

    /**
        * Constructor
        */
    function AWeberWebformPlugin() {
        $aweber_settings_url = admin_url('options-general.php?page=aweber.php');
        $this->messages['auth_required'] = '<div id="aweber_auth_error" class="error">AWeber Web Form requires authentication. You will need you to update your <a href="' . $aweber_settings_url . '">settings</a> in order to continue to use AWeber Web Form.</div>';
        $this->messages['auth_error'] = '<div id="aweber_auth_error" class="error">AWeber Web Form authentication failed.  Please verify the <a href="' . admin_url('options-general.php?page=aweber.php') . '">settings</a> to continue to use AWeber Web Form.</div>';
        $this->messages['auth_failed'] = '<div id="aweber_auth_failed" class="error">AWeber Web Form authentication failed, <a href="' . admin_url('options-general.php?page=aweber.php') . '">please reconnect</a>.  </div>';
        $this->messages['signup_text_too_short'] = '<div id="aweber_signup_text_too_long" class="error">The signup text was too short. Please make sure it is at least 7 characters.</div>';
        $this->messages['no_list_selected'] = '<div id="aweber_no_list_selected" class="error">Your changes were not saved, as no list was selected.</div>';
        $this->messages['temp_error'] = '<div id="aweber_temp_error" class="error">Unable to connect to AWeber\'s API.  Please refresh the page, or <a href="' . admin_url('options-general.php?page=aweber.php&reauth=true') . '">attempt to reauthorize.</a></div>';

        $this->ensure_defaults();
    }

    /**
        * Plugin initializer
        *
        * Main plugin initialization hook.
        * @return void
        */
    function init() {
    }

    function ensure_defaults() {
        $pluginAdminOptions = get_option($this->adminOptionsName);
        update_option('AWeberWebformPluginAdminOptions', array(
            'consumer_key'    => $pluginAdminOptions['consumer_key'],
            'consumer_secret' => $pluginAdminOptions['consumer_secret'],
            'access_key'      => $pluginAdminOptions['access_key'],
            'access_secret'   => $pluginAdminOptions['access_secret'],
        ));
        $options = get_option($this->widgetOptionsName);
        $keys = array(
            'list',
            'webform',
            'form_snippet',
            'list_id_create_subscriber',
        );
        foreach ($keys as $key) {
            $options[$key] = $options[$key];
        }
        $keys = array(
            'create_subscriber_comment_checkbox' => 'ON',
            'create_subscriber_registration_checkbox' => 'ON',
            'create_subscriber_signup_text' => "Sign up to our newsletter!",
            'create_sub_comment_ids' => array(),
        );
        foreach ($keys as $key => $value) {
            if ($options[$key] == null)
                $options[$key] = $value;
        }
        update_option($this->widgetOptionsName, $options);
    }

    // Create the function to output the contents of our Dashboard Widget

    function aweber_dashboard_widget_function() {
        $this->aweber_wp_dashboard_cached_rss_widget('aweber_dashboard_widget', 'wp_dashboard_rss_output');
        $pluginAdminOptions = get_option($this->adminOptionsName);
        $options = get_option($this->widgetOptionsName);
        if ($pluginAdminOptions['access_key']) {
            extract($pluginAdminOptions);
            try {
                $aweber = $this->_get_aweber_api($consumer_key, $consumer_secret);
                $account = $aweber->getAccount($access_key, $access_secret);
            } catch (AWeberException $e) {
                $account = null;
            }
            if (!$account) {
                $this->deauthorize();
                $pluginAdminOptions = get_option($this->adminOptionsName);
                $options = get_option($this->widgetOptionsName);
                echo $this->messages['auth_failed'];
            }
            else {
                try {
                    if (is_numeric($options['list_id_create_subscriber'])) {
                        $list = $account->loadFromUrl('/accounts/' . $account->id . '/lists/' . $options['list_id_create_subscriber']);
                    ?>
                    <ul>
                        <li>
                            <strong>List name: </strong><?php echo $list->name;?> <br>
                        </li>
                        <li>
                            <strong>Subscribed today to this list: </strong><?php echo $list->total_subscribers_subscribed_today;?> <br>
                        </li>
                        <li>
                            <strong>Subscribed yesterday to this list: </strong><?php echo $list->total_subscribers_subscribed_yesterday;?> <br>
                        </li>
                        <li>
                            <strong>Total subscribers on this list: </strong><?php echo $list->total_subscribed_subscribers;?> <br>
                        </li>
                    </ul>
                    <?php
                    }
                }
                catch (Exception $exc) {
                    #List ID was not in this account
                    if ($exc->type === 'NotFoundError') {
                        $options = get_option($this->widgetOptionsName);
                        $options['list_id_create_subscriber'] = null;
                        update_option($this->widgetOptionsName, $options);
                    }
                }
            }
        }
        else {
        }
        ?>
            </br>
            <a href="https://www.aweber.com/login.htm" target="_blank">Login to AWeber</a>
        <?php
    }

    /* Copied from WP code
    /  Modified to remove doing_AJAX global
    */
    function aweber_wp_dashboard_cached_rss_widget( $widget_id, $callback, $check_urls = array() ) {
        $loading = '<p class="widget-loading hide-if-no-js">' . __( 'Loading&#8230;' ) . '</p><p class="hide-if-js">' . __( 'This widget requires JavaScript.' ) . '</p>';

        if ( empty($check_urls) ) {
            $widgets = get_option( 'dashboard_widget_options' );
            if ( empty($widgets[$widget_id]['url']) ) {
                echo $loading;
                return false;
            }
            $check_urls = array( $widgets[$widget_id]['url'] );
        }

        $cache_key = 'dash_' . md5( $widget_id );
        if ( false !== ( $output = get_transient( $cache_key ) ) ) {
            echo $output;
            return true;
        }

        if ( $callback && is_callable( $callback ) ) {
            $args = array_slice( func_get_args(), 2 );
            array_unshift( $args, $widget_id );
            ob_start();
            call_user_func_array( $callback, $args );
            set_transient( $cache_key, ob_get_flush(), 43200); // Default lifetime in cache of 12 hours (same as the feeds)
        }

        return true;
    }

    // Create the function use in the action hook
    function aweber_add_dashboard_widgets() {
        $widget_options = get_option('dashboard_widget_options');
        if (!isset($widget_options['aweber_dashboard_widget'])) {
            $widget_options['aweber_dashboard_widget'] = array(
                'items' => 2,
                'show_summary' => 1,
                'show_author' => 0,
                'show_date' => 1,
            );
        }
        $widget_options['aweber_dashboard_widget']['link'] = apply_filters('aweber_dashboard_widget_link',  __('http://www.aweber.com/blog/'));
        $widget_options['aweber_dashboard_widget']['url'] = apply_filters('aweber_dashboard_widget_url',  __('http://www.aweber.com/blog/feed'));
        $widget_options['aweber_dashboard_widget']['title'] = apply_filters('aweber_dashboard_widget_title',  __('AWeber'));
        update_option('dashboard_widget_options', $widget_options);

        wp_add_dashboard_widget('aweber_dashboard_widget', $widget_options['aweber_dashboard_widget']['title'], array($this, 'aweber_dashboard_widget_function'), array($this, 'aweber_dashboard_widget_control'));
        // Globalize the metaboxes array, this holds all the widgets for wp-admin

        global $wp_meta_boxes;

        // Get the regular dashboard widgets array 
        // (which has our new widget already but at the end)

        $normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

        // Backup and delete our new dashbaord widget from the end of the array

        $example_widget_backup = array('aweber_dashboard_widget' => $normal_dashboard['aweber_dashboard_widget']);
        unset($normal_dashboard['aweber_dashboard_widget']);

        // Merge the two arrays together so our widget is at the beginning

        $sorted_dashboard = array_merge($example_widget_backup, $normal_dashboard);

        // Save the sorted array back into the original metaboxes 

        $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
    }

    function aweber_dashboard_widget_control() {
        wp_dashboard_rss_control( 'aweber_dashboard_widget' );
    }

    function add_checkbox()
    {
        $options = get_option($this->widgetOptionsName);
        ?>
        <p>
        <input value="1" id="aweber_checkbox" type="checkbox" style="width:inherit;" name="aweber_signup_checkbox"/>
            <label for="aweber_checkbox">
            <?php echo $options['create_subscriber_signup_text'];?>
            </label>
        </p>
        </br>
        <?php
    }

    function deauthorize()
    {
        $admin_options = get_option($this->adminOptionsName);
        $admin_options = array(
            'consumer_key' => null,
            'consumer_secret' => null,
            'access_key' => null,
            'access_secret' => null,
        );
        update_option($this->adminOptionsName, $admin_options);
        $options = get_option($this->widgetOptionsName);
        $options['list_id_create_subscriber'] = null;
        update_option($this->widgetOptionsName, $options);
        delete_option('aweber_webform_oauth_id');
        delete_option('aweber_webform_oauth_removed');
    }

    function create_subscriber($email, $ip, $list_id, $name)
    {
        $admin_options = get_option($this->adminOptionsName);
        try {
            $aweber = $this->_get_aweber_api($admin_options['consumer_key'], $admin_options['consumer_secret']);
            $account = $aweber->getAccount($admin_options['access_key'], $admin_options['access_secret']);
            $subs = $account->loadFromUrl('/accounts/' . $account->id . '/lists/' . $list_id . '/subscribers');
            return $subs->create(array(
                                    'email' => $email,
                                    'ip_address' => $ip,
                                    'name' => $name,
                                    'ad_tracking' => 'Wordpress',
                                ));
        }
        catch (Exception $exc) {
            #List ID was not in this account
            if ($exc->type === 'NotFoundError') {
                $options = get_option($this->widgetOptionsName);
                $options['list_id_create_subscriber'] = null;
                update_option($this->widgetOptionsName, $options);
            }
            #Authorization is invalid
            if ($exc->type === 'UnauthorizedError')
                $this->deauthorize();
        }
    }

    function comment_approved($comment)
    {
        $options = get_option($this->widgetOptionsName);
        $send_coi = $this->find_comment_id($comment->comment_ID);
        if ($send_coi) {
            $this->create_from_comment($comment);
        }
    }

    function find_comment_id($comment_id)
    {
        $options = get_option($this->widgetOptionsName);
        $index = array_search($comment_id, $options['create_sub_comment_ids']);
        if ($index) {
            unset($options['create_sub_comment_ids'][$index]);
            #re-index the array
            $options['create_sub_comment_ids'] = array_values($options['create_sub_comment_ids']);
            update_option($this->widgetOptionsName, $options);
            return true;
        }
        else {
            return false;
        }
    }

    function comment_deleted($comment_id)
    {
        $this->find_comment_id($comment_id);
    }

    function create_from_comment($comment) {
        $options = get_option($this->widgetOptionsName);

        $email = $comment->comment_author_email;
        $name = $comment->comment_author;
        $ip = $comment->comment_author_IP;

        $sub = $this->create_subscriber($email, $ip, $options['list_id_create_subscriber'], $name);
    }

    function grab_email_from_comment($comment_id, $comment = null)
    {
        if ($_POST['aweber_signup_checkbox'] != 1)
            return;

        $comment_id = (int) $comment_id;
        $comment = get_comment($comment_id);
        if(!$comment)
            return;

        $options = get_option($this->widgetOptionsName);

        if ($comment->comment_approved == 1)
            $this->create_from_comment($comment);
        else {
            if(count($options['create_sub_comment_ids']) >= 10000) {
                array_shift($options['create_sub_comment_ids']);
            }
            array_push($options['create_sub_comment_ids'], $comment->comment_ID);
            update_option($this->widgetOptionsName, $options);
        }
    }

    function grab_email_from_registration()
    {
        if ($_POST['aweber_signup_checkbox'] != 1)
            return;
        if(isset($_POST['user_email'])) {
            $email = $_POST['user_email'];
            $user = $_POST['user_login'];
            $ip = ($_SERVER['X_FORWARDED_FOR']) ? $_SERVER['X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
            $options = get_option($this->widgetOptionsName);
            $sub = $this->create_subscriber($email, $ip, $options['list_id_create_subscriber'], '');
        }
    }

    /**
        * Add content to the header tag.
        *
        * Hook for adding additional tags to the document's HEAD tag.
        * @return void
        */
    function addHeaderCode() {
        if (function_exists('wp_enqueue_script')) {
            // Admin page scripts
            if (is_admin()) {
                wp_enqueue_script('jquery');
            }
        }
    }

    /**
        * Get admin panel options.
        *
        * Retrieve admin panel settings variables as stored within wordpress.
        * @return array
        */
    function getAdminOptions() {
        $pluginAdminOptions = array(
            'consumer_key'    => null,
            'consumer_secret' => null,
            'access_key'      => null,
            'access_secret'   => null,
        );
        $options = get_option($this->adminOptionsName);
        if (!empty($options)) {
            foreach ($options as $key => $option) {
                $pluginAdminOptions[$key] = $option;
            }
        }
        update_option($this->adminOptionsName, $pluginAdminOptions);
        return $pluginAdminOptions;
    }

    /**
        * Print admin panel settings page.
        *
        * Echo the HTML for the admin panel settings page.
        * @return void
        */
    function printAdminPage() {
        $options = get_option($this->adminOptionsName);
        include(dirname(__FILE__) . '/aweber_forms_import_admin.php');
    }

    /**
        * Get widget options.
        *
        * Retrieve widget control settings variables as stored within wordpress.
        * @return array
        */
    function getWidgetOptions() {
        $pluginWidgetOptions = array(
            'list'         => null,
            'webform'      => null,
            'form_snippet' => null,
            'list_id_create_subscriber' => null,
            'create_subscriber_comment_checkbox' => 'ON',
            'create_subscriber_registration_checkbox' => 'ON',
            'create_subscriber_signup_text' => "Sign up to our newsletter!",
            'create_sub_comment_ids' => array(),
        );
        $options = get_option($this->widgetOptionsName);
        if (!empty($options)) {
            foreach ($options as $key => $option) {
                $pluginWidgetOptions[$key] = $option;
            }
        }
        update_option($this->widgetOptionsName, $pluginWidgetOptions);
        return $pluginWidgetOptions;
    }

    /**
        * Print widget in sidepanel.
        *
        * Echo the HTML for the widget handle.
        * @return void
        */
    function printWidget($args) {
        extract($args, EXTR_SKIP);

        if (isset($before_widget) && !empty($before_widget)) {
            echo $before_widget;
        }

        if (isset($before_title) && !empty($before_title)) {
            echo $before_title;
        }
        if (isset($title) && !empty($title)) {
            echo $title;
        }
        if (isset($after_title) && !empty($after_title)) {
            echo $after_title;
        }

        echo $this->getWebformSnippet();

        if (isset($after_widget) && !empty($after_widget)) {
            echo $after_widget;
        }
    }

    /**
        * Get a new AWeber API object
        *
        * Wrapper for AWeber API generation
        * @return AWeberAPI
        */
    function _get_aweber_api($consumer_key, $consumer_secret) {
        return new AWeberAPI($consumer_key, $consumer_secret);
    }

    /**
        * Print widget settings control in admin panel.
        *
        * Store settings and echo HTML for the widget control.
        * @return void
        */
    function printWidgetControl() {
        if (isset($_POST[$this->widgetOptionsName])) {
            $options = get_option($this->widgetOptionsName);
            $widget_data = $_POST[$this->widgetOptionsName];
            if (isset($widget_data['submit']) && $widget_data['submit']) {
                $options['list'] = $widget_data['list'];
                $options['webform'] = $widget_data[$widget_data['list']]['webform'];
                if ($options['webform']) {
                    $admin_options = get_option($this->adminOptionsName);
                    $aweber = $this->_get_aweber_api($admin_options['consumer_key'], $admin_options['consumer_secret']);
                    try {
                        $account = $aweber->getAccount($admin_options['access_key'], $admin_options['access_secret']);
                    } catch (AWeberException $e) {
                        $account = null;
                    }
                    if ($account) {
                        $this_form = $account->loadFromUrl($options['webform']);
                        $options['form_snippet'] = '<div class="AW-Form-'.$this_form->id.'"></div>
                        <script type="text/javascript">(function(d,s,id) {
                            var js;
                            var fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return; js = d.createElement(s);
                            js.id = id; js.src = "'.$this->_getWebformJsUrl($this_form).'";
                            fjs.parentNode.insertBefore(js, fjs);
                            }(document, "script", "aweber-wjs-'.(string)rand().'"));
                        </script>';
                    }
                } else {
                    $options['form_snippet'] = '';
                }

                update_option($this->widgetOptionsName, $options);
            }
        } else {
            ?>
            <div id="<?php echo $this->widgetOptionsName; ?>-content" class="<?php echo $this->widgetOptionsName; ?>-content"><img src="images/loading.gif" height="16" width="16" id="aweber-webform-loading" style="float: left; padding-right: 5px" /> Loading...</div>
            <script type="text/javascript" >

            jQuery(document).ready(function($) {
                if (typeof(<?php echo $this->widgetOptionsName; ?>) != 'undefined') { return; }
                <?php echo $this->widgetOptionsName; ?> = true;

                var data = {
                    action: 'get_widget_control'
                };

                // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                jQuery.post(ajaxurl, data, function(response) {
                    var primary_content = jQuery('.<?php echo $this->widgetOptionsName; ?>-content');
                    primary_content.each(function() { jQuery(this).html(response); });
                });
            });
            </script>
            <?php
        }
    }

    /**
        * Get Web Form javascript url
        *
        * Returns hosted javascript url of a given form.
        * @param AWeberEntry
        * @return string
        */
    function _getWebformJsUrl($webform) {
        $form_hash = $webform->id % 100;
        $form_hash = (($form_hash < 10) ? '0' : '') . $form_hash;
        $prefix = ($this->_isSplitTest($webform)) ? 'split_' : '';
        return 'http://forms.aweber.com/form/' . $form_hash . '/' . $prefix . $webform->id . '.js';
    }

    /**
        * Is a split test?
        *
        * Returns whether form object is a splittest.
        * @param AWeberEntry
        * @return bool
        */
    function _isSplitTest($webform) {
        return $webform->type == 'web_form_split_test';
    }

    function _end_response() {
        die();
    }

    /**
        * Response to be given to print action via AJAX.
        *
        * Echo HTML for widget control form asynchronously.
        * @return void
        */
    function printWidgetControlAjax() {
        $options = get_option($this->widgetOptionsName);
        $admin_options = get_option($this->adminOptionsName);

        // Render form
        $list = $options['list'];
        $webform = $options['webform'];

        try {
            $aweber = $this->_get_aweber_api($admin_options['consumer_key'], $admin_options['consumer_secret']);
            $account = $aweber->getAccount($admin_options['access_key'], $admin_options['access_secret']);
        } catch (AWeberException $e) {
            $account = null;
        }
        if (!$account) {
            echo $this->messages['auth_error'];
            return $this->_end_response();
        }

        $list_web_forms = array();
        foreach ($account->getWebForms() as $this_webform) {
            $link_parts = explode('/', $this_webform->url);
            $list_id = $link_parts[4];
            if (!array_key_exists($list_id, $list_web_forms)) {
                $list_web_forms[$list_id] = array(
                    'web_forms' => array(),
                    'split_tests' => array()
                );
            }
            $list_web_forms[$list_id]['web_forms'][] = $this_webform;
        }
        foreach ($account->getWebFormSplitTests() as $this_webform) {
            $link_parts = explode('/', $this_webform->url);
            $list_id = $link_parts[4];
            if (!array_key_exists($list_id, $list_web_forms)) {
                $list_web_forms[$list_id] = array(
                    'web_forms' => array(),
                    'split_tests' => array()
                );
            }
            $list_web_forms[$list_id]['split_tests'][] = $this_webform;
        }
        $lists = $account->lists;
        foreach ($lists as $this_list) {
            if (array_key_exists($this_list->id, $list_web_forms)) {
                $list_web_forms[$this_list->id]['list'] = $this_list;
            }
        }

        // The HTML form will go here
?>
<?php if (!empty($list_web_forms)): ?>
<select class="widefat <?php echo $this->widgetOptionsName; ?>-list" name="<?php echo $this->widgetOptionsName; ?>[list]" id="<?php echo $this->widgetOptionsName; ?>-list">
    <option value="">Step 1: Select A List</option>
    <?php foreach ($list_web_forms as $this_list_data): ?>
    <?php $this_list = $this_list_data['list']; ?>
    <option value="<?php echo $this_list->id; ?>"<?php echo ($this_list->id == $list) ? ' selected="selected"' : ""; ?>><?php echo $this_list->name; ?></option>
    <?php endforeach; ?>
</select>

<br />
<br />
<?php foreach ($list_web_forms as $this_list_id => $forms): ?>
<select class="widefat <?php echo $this->widgetOptionsName; ?>-form-select <?php echo $this->widgetOptionsName; ?>-<?php echo $this_list_id; ?>-webform" name="<?php echo $this->widgetOptionsName; ?>[<?php echo $this_list_id; ?>][webform]" id="<?php echo $this->widgetOptionsName; ?>-<?php echo $this_list_id; ?>-webform">
    <option value="">Step 2: Select A Web Form</option>
    <?php foreach ($forms['web_forms'] as $this_form): ?>
    <option value="<?php echo $this_form->url; ?>"<?php echo ($this_form->url == $webform) ? ' selected="selected"' : ''; ?>><?php echo $this_form->name; ?></option>
    <?php endforeach; ?>
    <?php foreach ($forms['split_tests'] as $this_form): ?>
    <option value="<?php echo $this_form->url; ?>"<?php echo ($this_form->url == $webform) ? ' selected="selected"' : ''; ?>>Split test: <?php echo $this_form->name; ?></option>
    <?php endforeach; ?>
</select>
<?php endforeach; ?>

<input type="hidden"
    name="<?php echo $this->widgetOptionsName; ?>[submit]"
    value="1"/>

<br /><br />
<a id="<?php echo $this->widgetOptionsName; ?>-form-preview" class="<?php echo $this->widgetOptionsName; ?>-form-preview" href="#" target="_blank">preview form</a>
<?php else: ?>
This AWeber account does not currently have any completed web forms.
<br /><br />
Please <a href="https://www.aweber.com/users/web_forms/index">create a web
form</a> in order to place it on your Wordpress blog.
<?php endif; ?>
<script type="text/javascript">
    jQuery(document).ready(function() {
        function hideFormSelectors() {
            jQuery('.<?php echo $this->widgetOptionsName; ?>-form-select').each(function() {
                jQuery(this).hide();
            });
        }

        function listDropDown() {
            return jQuery('.<?php echo $this->widgetOptionsName; ?>-list');
        }

        function currentFormDropDown() {
            var list;
            listDropDown().each(function() {
                list = jQuery(this).val();
            });
            if (list != "") {
                return jQuery('.<?php echo $this->widgetOptionsName; ?>-' + list + '-webform');
            }
            return undefined;
        }

        function updateViewableFormSelector() {
            hideFormSelectors();
            var dropdown = currentFormDropDown();
            if (dropdown != undefined) {
                dropdown.each(function() {
                    jQuery(this).show();
                });
            }
        }

        function updatePreviewLink() {
            var form_url = "";
            var preview = jQuery('.<?php echo $this->widgetOptionsName; ?>-form-preview');
            var form_dropdown = currentFormDropDown();
            if (form_dropdown != undefined) {
                form_dropdown.each(function() {
                    form_url = jQuery(this).val();
                });
            }
            if (form_url == "") {
                preview.each(function() {
                    jQuery(this).attr('href', '#');
                    jQuery(this).hide();
                });
            } else {
                form_url = form_url.split('/');
                var form_id = form_url.pop();
                var form_type = form_url.pop();
                if (form_type == 'web_form_split_tests') {
                    preview.each(function() {
                        jQuery(this).attr('href', '#');
                        jQuery(this).hide();
                    });
                } else {
                    preview.each(function() { jQuery(this).show(); });
                    var hash = form_id % 100;
                    hash = ((hash < 10) ? '0' : '') + hash;
                    preview.each(function() {
                        jQuery(this).attr('href', 'http://forms.aweber.com/form/' + hash + '/' + form_id + '.html');
                    });
                }
            }
        }

        updateViewableFormSelector();
        updatePreviewLink();

        listDropDown().each(function() {
            jQuery(this).change(function() {
                updateViewableFormSelector();
                var form_dropdown = currentFormDropDown();
                if (form_dropdown != undefined) {
                    form_dropdown.val('');
                }
                updatePreviewLink();
            });
        });
        jQuery('.<?php echo $this->widgetOptionsName; ?>-form-select').each(function() {
            jQuery(this).change(function() {
                updatePreviewLink();
            });
        });
    });
</script>

<?php
        $this->_end_response();
    }

    /**
        * Get web form snippet
        *
        * Retrieve webform snippet to be inserted in blog page.
        * @return string
        */
    function getWebformSnippet() {
        $options = get_option($this->widgetOptionsName);
        return $options['form_snippet'];
    }
}
?>
