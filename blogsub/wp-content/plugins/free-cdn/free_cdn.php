<?php
/*
Plugin Name: Free CDN
Plugin URI: http://www.phoenixheart.net/wp-plugins/free-cdn
Description: This plugin rewrites your static files' URL's (JavaScripts, CSS, images etc.) so that they are served from <a href="http://www.coralcdn.org/">CoralCDN</a> - a free P2P Content Delivery Network - instead of your own server, thus saves lots of bandwidth and improves availability. REQUIRES PHP >= 5
Version: 1.1.2
Author: Phoenixheart
Author URI: http://www.phoenixheart.net
*/

if (!class_exists('FCDN'))
{
    class FCDN
    {
        var $name = 'free-cdn';
        var $version = '1.0.2';
        var $default_options = array(
            'version'   => '1.0.2',
            'apply' => array(
                'css'   => true,
                'js'    => true,
                'img'   => true,
                'bgr'   => true,
                'embed' => true,
            ),
            'excluded'  => array(),
            'included'  => array(),
            'powered'   => true,
            'debug'     => false,
        );
        
        var $options;
        var $plugin_url = 'http://www.phoenixheart.net/wp-plugins/free-cdn';
        var $document;
        var $debug_result = array();
        
        function __construct()
        {
            $this->options = get_option($this->name);
            if (!$this->options)
            {
                $this->options = $this->default_options;
                $this->reset_options();
            }
        }
        
        /**
        * @desc 
        */
        function pre_content()
        {
            ob_start();
        }
        
        /**
        * @desc 
        */
        function post_content()
        {
            $content = ob_get_contents();
            ob_end_clean();
            
            $this->parse($content);
        }
        
        /**
        * @desc 
        */
        function register_menu()
        {
            add_options_page(
                __('Free CDN', $this->name),
                __('Free CDN', $this->name),
                8,
                basename(__FILE__),
                array($this, 'build_options_form')
            );
        }
        
        /**
        * @desc 
        */
        function build_options_form()
        {
            printf('
            <style type="text/css">
                #fCDNForm input {margin-right: 5px;}
                #otherSupport {list-style-type: disc; padding-left: 30px; margin-top: 15px;}
                code{font-weight: normal !important;}
                .wrap label, .wrap li, .wrap p{font-size: 11px;}
            </style>
            <div class="wrap">
                <div id="icon-options-general" class="icon32"><br /></div>
                <h2>Free CDN Options</h2>
                <div id="message" class="updated fade" style="display:none"></div>
                <form action="index.php" method="post" id="fCDNForm" autocomplete="off" style="width: 750px; float: left;">
                <h3>Using CDN on these contents</h3>
                <ul>
                    <li><input type="checkbox" %s name="apply[css]" id="applyCss"><label for="applyCss">External CSS includes (<code>&lt;link rel=&quot;stylesheet&quot; tyle=&quot;text/css&quot; href=&quot;<strong>link/to/style.css</strong>&quot; /&gt;</code>)</label></li>
                    <li><input type="checkbox" %s name="apply[js]" id="applyJS"><label for="applyJS">External JavaScript includes (<code>&lt;script type=&quot;text/javascript&quot; src=&quot;<strong>link/to/javascript.js</strong>&quot;&gt;&lt;/script&gt;</code>)</label></li>
                    <li><input type="checkbox" %s name="apply[img]" id="applyImg"><label for="applyImg">Images (<code>&lt;img alt=&quot;alternate text&quot; src=&quot;<strong>link/to/photo.jpg</strong>&quot; /&gt;</code>)</label></li>
                    <li><input type="checkbox" %s name="apply[bgr]" id="applyBgr"><label for="applyBgr">Inline background images (<code>&lt;div style=&quot;background:url(\'<strong>link/to/background.png</strong>\') top left repeat-y&quot;&gt;&lt;/div&gt;</code>)</label></li>
                    <li><input type="checkbox" %s name="apply[embed]" id="applyEmbed"><label for="applyEmbed">Embeded contents (<code>&lt;param filename=&quot;<strong>link/to/track.mp3</strong>&quot; /&gt;</code> and <code>&lt;object src=&quot;<strong>link/to/flash.swf</strong>&quot; /&gt;</code>)</label></li>
                 </ul>
                 <h3>Include, exclude, and debug</h3>
                 <ul>
                    <li>
                        <label for="included">Include these <strong><em>absolute</em></strong> URL\'s or those start with one of them (one each line)</label><br />
                        <small>Example: <code>http://sub.domain.com</code>, <code>http://www.external-domain.com</code>, <code>http://example.com/a-specific-file.ogg</code></small><br />
                        <textarea name="included" id="included" style="width: 600px; height: 150px">%s</textarea>
                    </li>
                    <li>
                        <label for="excluded">Exclude these <strong><em>absolute</em></strong> URL\'s or those start with one of them (one each line, too)</label><br />
                        <textarea name="excluded" id="excluded" style="width: 600px; height: 150px">%s</textarea>
                    </li>
                    <li><input type="checkbox" %s name="debug" id="debug" /><label for="debug">Debug mode (only list down to-be-rewritten URL\'s, not applying them)</label></li>
                 </ul>
                 <h3>Support this plugin (Thanks!)</h3>
                 <ul>
                    <li><input type="checkbox" %s name="powered" id="powered"><label for="powered">Show &quot;%s&quot; message on page footer</label></li>
                    <li>Other ways to show the love:
                        <ul id="otherSupport">
                            <li>Blog or <a href="http://twitter.com/home/?status=I+am+using+this+awesome+WordPress+Free+CDN+plugin+by+%%40Phoenixheart+http%%3A%%2F%%2Fbit.ly%%2FMZo0i" target="_blank">Tweet about it</a>.
                            You can also <a href="http://twitter.com/Phoenixheart" target="_blank">follow me on Twitter</a></li>
                            <li>Give this plugin a good rating on <a href="http://wordpress.org/extend/plugins/free-cdn/" target="_blank">WordPress Codex</a></li>
                            <li>Check out <a href="http://www.phoenixheart.net/wp-plugins/" target="_blank">my other plugins</a></li>
                            <li><a href="http://feeds.feedburner.com/phoenixheart" target="_blank">Subscribe</a> to my RSS</li>
                            <li>Send me at phoenixheart (Gmail) an email telling that you like my plugin ;)</li>
                        </ul>
                    </li>
                 </ul>
                 <input type="hidden" name="_nonce" value="%s" />
                 <input type="hidden" name="fcdn_action" value="save_options" />
                 <p class="submit">
                    <input class="button-primary" type="submit" value="Save Changes" name="submit"/>
                 </p>
            </form>
            <div style="width: 200px; background: #fff; float: right; padding: 2px 10px; border: 1px solid #ccc">
            <p>Free CDN is totally free, but if you think it worths some love, please consider a donation.</p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
            </div>
        </div>', 
                $this->options['apply']['css'] ? 'checked="checked"' : '',
                $this->options['apply']['js'] ? 'checked="checked"' : '',
                $this->options['apply']['img'] ? 'checked="checked"' : '',
                $this->options['apply']['bgr'] ? 'checked="checked"' : '',
                $this->options['apply']['embed'] ? 'checked="checked"' : '',
                implode(PHP_EOL, $this->options['included']),
                implode(PHP_EOL, $this->options['excluded']),
                $this->options['debug'] ? 'checked="checked"' : '',
                $this->options['powered'] ? 'checked="checked"' : '',
                $this->powered_message(),
                wp_create_nonce($this->name)
            );
        }
        
        function powered_message()
        {
            return sprintf('Powered by <a href="%s" target="_blank">Free CDN WordPress plugin</a>', $this->plugin_url);
        }
        
        /**
        * @desc 
        */
        function parse($html)
        {   
            require_once(dirname(__FILE__) . '/simple_html_dom.php');
            $this->document = str_get_html($html);
            
            // external stylesheets
            if ($this->options['apply']['css'])
            {
                $tags = $this->document->find("link[rel='stylesheet']");
                foreach ($tags as $css)
                {
                    $css->href = $this->rewrite_url($css->href);
                    
                    // we don't need to parse CSS
                    // because most images in css are relative
                    // so if the css file in on nyud.net then
                    // the images are on nyud.net too
                }
            }
            
            // external javascripts
            if ($this->options['apply']['js'])
            {
                $tags = $this->document->find('script[src]');
                foreach ($tags as $js)
                {
                    $js->src = $this->rewrite_url($js->src);
                }
            }
            
            // images
            if ($this->options['apply']['img'])
            {
                $tags = $this->document->find('img');
                foreach ($tags as $img)
                {
                    $img->src = $this->rewrite_url($img->src);
                }
            }
            
            // embeded
            if ($this->options['apply']['embed'])
            {
                // 1. <object> tag
                $tags = $this->document->find("param[name='filename']");
                foreach ($tags as $param)
                {
                    $param->value = $this->rewrite_url($param->value);
                }
                
                // 2. embed tag
                $tags = $this->document->find('embed[src]');
                foreach ($tags as $embed)
                {
                    $embed->src = $this->rewrite_url($embed->src);
                }
            }
            
            
            // background images
            $regex = '/style\s*=\s*(?:".*?\s*\(\s*\'(.*?)\'\s*\).*?")/si';
            
            $html = $this->document->save();
            preg_match_all($regex, $html, $matches);
            
            foreach ($matches[1] as $url)
            {
                $html = str_replace($matches[1], $this->rewrite_url($matches[1]), $html);
            }
            
            echo $html;
            
            if ($this->debug_result)
            {
                echo PHP_EOL . '<!-- START FREE CDN PLUGIN DEBUG DATA' . PHP_EOL;
                foreach ($this->debug_result as $orgin => $rewritten)
                {
                    echo "$orgin
will be written into
$rewritten
------------------------------------------
";
                }
                printf('TOTAL: %s URL\'s to be rewritten', count($this->debug_result));
                echo PHP_EOL . 'END FREE CDN PLUGIN DEBUG DATA -->' . PHP_EOL;
            }
        }

        /**
        * @desc 
        */
        function rewrite_url($original_url)
        {
            if (is_array($original_url))
            {
                // some recursions
                $ret = array();
                foreach ($original_url as $single_url)
                {
                    $ret[] = $this->rewrite_url($single_url);
                }
                return $ret;
            }
            
            $rewritten_url = $this->rel_to_abs($original_url);
            
            if (($this->is_internal($rewritten_url) || $this->is_included($rewritten_url)) && !$this->is_excluded($rewritten_url))
            {
                // a candidate to rewrite
                $parts = parse_url($rewritten_url);
    
                if (isset($parts['port']))
                {
                    $parts['host'] .= ".$parts[port].nyud.net";
                    unset($parts['port']);
                }
                else
                {
                    $parts['host'] .= '.nyud.net';
                }
                
                $rewritten_url = $this->glue_url($parts);
                
                if ($this->options['debug'])
                {
                    // if we are in debug mode, just show the changes, just collect
                    $this->debug_result[$original_url] = $rewritten_url;
                    // don't apply it
                    return $original_url;
                }
                
                return $rewritten_url; // we're not in debug mode
            }
                        
            return $original_url; // the url is not a candidate
        }
        
        
        /**
        * @desc 
        */
        function rel_to_abs($relative) 
        {
            $p = parse_url($relative);
            if($p['scheme'])return $relative;
            
            extract(parse_url($this->get_current_url()));
            
            $path = dirname($path); 

            if($relative{0} == '/') 
            {
                $cparts = array_filter(explode('/', $relative));
            }
            else 
            {
                $aparts = array_filter(explode('/', $path));
                $rparts = array_filter(explode('/', $relative));
                $cparts = array_merge($aparts, $rparts);
                foreach($cparts as $i => $part) {
                    if($part == '.') {
                        $cparts[$i] = null;
                    }
                    if($part == '..') {
                        $cparts[$i - 1] = null;
                        $cparts[$i] = null;
                    }
                }
                $cparts = array_filter($cparts);
            }
            $path = implode('/', $cparts);
            $url = '';
            if($scheme) {
                $url = "$scheme://";
            }
            if($user) {
                $url .= "$user";
                if($pass) {
                    $url .= ":$pass";
                }
                $url .= '@';
            }
            if($host) {
                $url .= "$host/";
            }
            $url .= $path;
            return $url;
        }
        
        /**
        * @author ilja at radusch dot com
        * @param mixed $parsed
        */
        function glue_url($parsed) 
        {
            if (!is_array($parsed)) 
            {
                return false;
            }

            $uri = isset($parsed['scheme']) ? $parsed['scheme'].':'.((strtolower($parsed['scheme']) == 'mailto') ? '' : '//') : '';
            $uri .= isset($parsed['user']) ? $parsed['user'].(isset($parsed['pass']) ? ':'.$parsed['pass'] : '').'@' : '';
            $uri .= isset($parsed['host']) ? $parsed['host'] : '';
            $uri .= isset($parsed['port']) ? ':'.$parsed['port'] : '';

            if (isset($parsed['path'])) 
            {
                $uri .= (substr($parsed['path'], 0, 1) == '/') ?
                    $parsed['path'] : ((!empty($uri) ? '/' : '' ) . $parsed['path']);
            }

            $uri .= isset($parsed['query']) ? '?'.$parsed['query'] : '';
            $uri .= isset($parsed['fragment']) ? '#'.$parsed['fragment'] : '';

            return $uri;
        } 
        
        /**
        * @desc Determines if an (absolute) url is internal
        */
        function is_internal($abs_url)
        {
            if (strpos($abs_url, $this->get_current_host()) === 0) return true;
            
            // subdomains? leave them to "included" options
        }
        
        function is_excluded($abs_url)
        {
            foreach ($this->options['excluded'] as $base)
            {
                if (trim($base) == '') continue;
                if (strpos($abs_url, $base) === 0) return true;
            }
            
            return false;
        }
        
        function is_included($abs_url)
        {
            foreach ($this->options['included'] as $base)
            {
                if (strpos($abs_url, $base) === 0) return true;
            }
            
            return false;
        }
        
        function get_current_url() 
        {
            static $current_url;
            if (isset($current_url)) return $current_url;
            
            $current_url = $this->get_current_host();

            if ($_SERVER['SERVER_PORT'] != 80) 
            {
                $current_url .=  $_SERVER['SERVER_PORT'];
            } 
            
            $current_url .= $_SERVER['REQUEST_URI'];

            return $current_url;
        }
        
        function get_current_host()
        {
            static $current_host;
            if (isset($current_host)) return $current_host;
            
            $current_host = (empty($_SERVER['HTTPS']) && $_SERVER['SERVER_PORT'] != 443) ? 'http://' : 'https://';
            $current_host .= $_SERVER['SERVER_NAME'];
            return $current_host;
        }
        
        function activate()
        {
            if (!$current_options = get_option($this->name))
            {
                $this->reset_options();
                return;
            }
            
            $current_options['version'] = $this->version;
            foreach ($this->default_options as $key => $value)
            {
                if (!isset($current_options[$key])) $current_options[$key] = $value;
            }
            
            update_option($this->name, $current_options);            
        }
        
        function deactivate()
        {
        }
        
        function reset_options()
        {
            delete_option($this->name);
            add_option($this->name, $this->default_options);
        }
        
        function show_powered()
        {
            if ($this->options['powered'])
            {
                echo '<p class="fcdn_powered" style="text-align: right; padding-right: 10px;"><small>' . $this->powered_message() . '</small></p>';
            }
        }
        
        function wp_init()
        {
            if (is_admin())
            {
                wp_enqueue_script('fcdn_admin_onload', '/' . PLUGINDIR . '/free-cdn/admin.js', array('jquery'), $this->version);
            }
            
            if (!isset($_POST['fcdn_action'])) return false;
            
            if (!wp_verify_nonce($_POST['_nonce'], $this->name))
            {
                die('Security check failed. Please try refreshing.');
            }
            
            switch ($_POST['fcdn_action'])
            {
                case 'save_options':
                default:
                    $this->save_options();
                    break;
            }
            
            exit();
        }
        
        function save_options()
        {        
            $new_options = array(
                'apply' => array(
                    'css'   => $_POST['apply']['css'] == 'on',
                    'js'    => $_POST['apply']['js'] == 'on',
                    'img'   => $_POST['apply']['img'] == 'on',
                    'bgr'   => $_POST['apply']['bgr'] == 'on',
                    'embed' => $_POST['apply']['embed'] == 'on',
                ),
                'powered'   => $_POST['powered'] == 'on',
                'debug'     => $_POST['debug'] == 'on',
            );
                        
            $excluded = explode(PHP_EOL, $_POST['excluded']);
            foreach ($excluded as $key=>$value)
            {
                if (!trim($excluded[$key])) unset($excluded[$key]);
            }
            
            $included = explode(PHP_EOL, $_POST['included']);
            foreach ($included as $key=>$value)
            {
                if (!trim($included[$key])) unset($included[$key]);
            }
            
            $new_options['excluded'] = $excluded;
            $new_options['included'] = $included;

            foreach ($new_options as $key => $value)
            {
                $this->options[$key] = $value;
            }
            
            update_option($this->name, $this->options);
            echo '<p>Options saved.</p>';
        }
    }
}

$fcdn = new FCDN();

if (!is_admin()) 
{
    add_action('get_header', array($fcdn, 'pre_content'), PHP_INT_MAX);
    add_action('wp_footer', array($fcdn, 'show_powered'));
    add_action('wp_footer', array($fcdn, 'post_content'), PHP_INT_MAX);
}


add_action('admin_menu', array($fcdn, 'register_menu'));
add_action('init', array($fcdn, 'wp_init'));

register_activation_hook(__FILE__, array($fcdn, 'activate'));
register_deactivation_hook(__FILE__, array($fcdn, 'deactivate'));