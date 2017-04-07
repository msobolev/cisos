<?php
/*
Plugin Name: Drafts Scheduler
Plugin URI: http://www.installedforyou.com/draftscheduler
Contributors: talus, beezeee
Description: Allows WordPress admins to bulk schedule posts currently saved as drafts
Author: Jeff Rose
Version: 1.8
Author URI: http://www.installedforyou.com
Tags: drafts, schedule, posts
License: GPL2

*/

/*  Copyright 2010  Jeff Rose  (email : info@installedforyou.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if (!class_exists('DraftScheduler')) {

    define ('IFDS_VERSION', '1.8');
    define('DraftScheduler_root', WP_PLUGIN_URL . '/drafts-scheduler/');

    class DraftScheduler {

        private $ifds_option = 'IFDS_UNDO';

        /*
         * function DraftScheduler
         * Constructor for the class
         * Primarily connects the WP hooks
         */
        function DraftScheduler() {

            add_action('admin_menu', array(&$this,'draftScheduler_Admin'));
        }

        /*
         * function draftScheduler_Admin
         * Sets up the Admin page for the user to schedule draft posts
         */
        function draftScheduler_Admin() {
            add_posts_page('Draft Scheduler', 'Draft Scheduler', 'administrator', 'draft_scheduler', array(&$this, 'draftScheduler_manage_page'));
        }

        /*
         * function draftScheduler_Scheduler
         * The supposed workhorse - this applies the chosen parameters
         * to the posts
         */
        function draftScheduler_Scheduler(){
            GLOBAL $wpdb;

            $draftList = $wpdb->get_results("SELECT * from $wpdb->posts WHERE status='draft'");
        }

        /*
         * function draft_manage_page
         * Check to see if page was posted, display messages, then display page
         */
        function draftScheduler_manage_page() {
		$ifds_msg = '';
		$ifds_msg = $this->ifdsManagePg();
		if ( trim($ifds_msg) != '' ) {
			echo '<div id="message" class="updated fade"><p><strong>'.$ifds_msg.'</strong></p></div>';
		}
		echo '<div class="wrap">';
		$this->draftScheduler_admin_page();
		echo '</div>';
        }

        /*
         * function ifdsManagePg
         * Process the form post and do the work.
         */
        function ifdsManagePg() {
            global $wpdb;
            if ( (!empty( $_POST["action"] ) && $_POST["action"] ==="undo" ) && check_admin_referer( 'do-undo-schedule' ) ){
                $undoList = get_option( $this->ifds_option );
                if ( !empty( $undoList ) ){
                    foreach ($undoList as $undoPost) {
                        $thisPost = get_post( $undoPost );
                        if ( "future" == $thisPost->post_status){
                            $wpdb->update( $wpdb->posts, array( 
                                    'post_status' => 'draft'
                                    ),
                                array( 'ID' => $undoPost )
                            );
                            wp_transition_post_status("draft", "future" , $thisPost );
                        }
                    }
                }
                delete_option( $this->ifds_option );
                $msg = "Posts un-scheduled.";
            }

            if ( !empty( $_POST ) && $_POST["action"] !="undo" && check_admin_referer( 'do-schedule-drafts' ) ) {
                $msg = '';
                if ( !$_POST["action"] == "schedule_drafts" ) {
                    /*
                     * No action set, so just return
                     */
                    return $msg;
                } else {
                    if ( !j_is_date( $_POST['startDate'] ) ) {
                        $msg = 'Please enter a valid date to start posting';
                        return $msg;
                    }

                    $startDate = $_POST['startDate'];
                    $startTime = $_POST['startTime'];
                    $endTime = $_POST['endTime'];
		    $dayweekmonth = $_POST['dayweekmonth'];

                    $dailyMax = $_POST['postsperday'];
                    $exactPosts = $_POST['exactPosts'];

                    $intHours = $_POST['intHours'];
                    $intMins = $_POST['intMins'];

                    if ( $_POST['randomness'] == "sequential" || $_POST['randomness'] == "random" ) {
                        if ( !is_numeric( $intHours ) || ( $intHours =='' ) || ( 24 < $intHours ) || (0 > $intHours ) ) {
                            $msg = 'Please enter a valid Post Interval';
                            return $msg;
                        }
                        if ( !is_numeric( $intMins ) || ( $intMins =='' ) || ( 60 < $intMins ) || 0 > $intMins ) {
                            $msg = 'Please enter a valid Post Interval';
                            return $msg;
                        }
                    } else {

                        if ( !j_is_date( $startTime ) || ( $startTime == '' ) ) {
                            $msg = 'Please enter a valid start time';
                            return $msg;
                        }
                        if ( !j_is_date( $endTime ) || ( $endTime == '' ) ) {
                            $msg = 'Please enter a valid end time';
                            return $msg;
                        }

                        if ( strtotime( $startTime ) > strtotime( $endTime ) ) {
                            $msg = 'Ensure the start time is before the end time.';
                            return $msg;
                        }
                    }

                    if ( $_POST['randomness'] == "sequential" ){

                        $msg = $this->draftScheduler_sequential_post_by_interval( $startDate, $intHours, $intMins );

                    } else if ( $_POST['randomness'] == "random" )  {

                        $msg = $this->draftScheduler_random_post_by_interval( $startDate, $intHours, $intMins );

                    } else {

                        $msg = $this->draftScheduler_randomize_drafts( $startDate, $startTime, $endTime, $dailyMax, $exactPosts, $dayweekmonth );
                    }

                    return $msg;
                } // end check for post action
            } // end check admin referrer
        }

        /*
         * function print_admin_page
         * Display the amdin options page
         */
        function draftScheduler_admin_page() {
            ?>
            <script type="text/javascript" src="<?php echo DraftScheduler_root ?>js/jquery-ui-1.7.2.custom.min.js"></script>
            <link rel="stylesheet" type="text/css" href="<?php echo DraftScheduler_root ?>css/sunny/jquery-ui-1.7.2.custom.css" />
            <script type="text/javascript">
                jQuery(document).ready(function(jQuery) {
                        jQuery("#datepicker").datepicker({dateFormat: 'yy-mm-dd', altField: '#startDate', altFormat: 'MM d, yy', defaultDate: '<?php echo $startDate; ?>'});
                });
            </script>

                <h2>Draft Scheduler</h2>
                <?php
                    $undoavail = get_option( $this->ifds_option );
                    if ( isset ( $undoavail ) && "" != $undoavail ){
                ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Undo last schedule?</th>
                        <td>
                            <form method="post">
                                <input type="submit" name="undoNow" value="Undo schedule" />
                                <input type="hidden" name="action" value="undo" />
                                <?php wp_nonce_field('do-undo-schedule'); ?>
                            </form>
                            This will allow you to un-schedule any posts from your most recent schedule that have NOT yet been posted.
                        </td>
                    </tr>
                </table>
                <?php
                    }
                    $draftCount = $this->draftScheduler_check_for_drafts();
                    if ( 0 != $draftCount ){
                ?>
                <form method="post">
                    <?php wp_nonce_field('do-schedule-drafts'); ?>
                    <table class="form-table">
                        <tr valign="top">
                            <th scope="row">Schedule Start Date</th>
                            <td>
                                <div id="datepicker"></div>
                                <input type="text" name="startDate" id="startDate" size="31" value="<?php if( isset( $_POST['startDate'] ) ) echo $_POST['startDate']; ?>" />
                                <br />
                                Note: if you schedule starts "Today" then posting will start from midnight, including before "now."<br />You may wish to start tomorrow.
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">Posting order</th>
                            <td>
                                <input type="radio" name="randomness" value="random" <?php if ($_POST['randomness'] == "random" || $_POST['randomness'] == "") echo " checked " ?>> Randomly grab any draft in any order<br />
                                <input type="radio" name="randomness" value="sequential" <?php if ($_POST['randomness'] == "sequential") echo " checked " ?>> Sequentially schedule drafts from oldest to newest in order
                            </td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">Post interval</th>
                            <td>
                                <input type="text" name="intHours" id="intHours" size="4" maxlength="2" value="<?php echo $_POST['intHours']; ?>" /><strong>hrs</strong>
                                <input type="text" name="intMins" id="intMins" size="4" maxlength="2" value="<?php echo $_POST['intMins']; ?>" /><strong>mins</strong>
                            </td>
                        </tr>

                        <tr valign="top">
                            <th scope="row">&nbsp;&nbsp;&nbsp; - OR -</th>
                            <td><hr style="width:400px; float: left;"/></td>
                        </tr>
                        <tr valign="top">
                            <th scope="row">Post Randomly</th>
                            <td>
                                <input type="radio" name="randomness" value="fullrandom" <?php if ($_POST['randomness'] == "fullrandom") echo " checked " ?>> Surprise me <em>(posts entirely randomly after the date above, but within the times below)</em><br />
                                Post up to <input type="text" name="postsperday" id="postsperda" value="<?php echo $_POST['postsperday']; ?>" size="3" maxlength="3" /> posts per
				<select name="dayweekmonth">
				    <option value="day">day</option>
				    <option value="week">week</option>
				    <option value="month">month</option>
				</select> <strong>OR</strong>
                                Post exactly <input type="text" name="exactPosts" id="exactPosts" value="<?php echo $_POST['exactPosts']; ?>" size="3" maxlength="3" /> posts per day<br />
                                Randomly after: 
                                <select name="startTime" id="startTime">
                                    <option value="">Choose a time</option>
                                <?php echo self::createDateTimeDropDowns($_POST['startTime']); ?>
                                </select><br />
                                And before:
                                <select name="endTime" id="endTime">
                                    <option value="">Choose a time</option>
                                <?php echo self::createDateTimeDropDowns($_POST['endTime']); ?>
                                </select><br />
                            </td>
                        </tr>

                    </table>
                    <input type="hidden" name="action" value="schedule_drafts">
                    <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Schedule Drafts') ?>" />
                    </p>
                </form>
<?php
                    } else {
?>
<div id="message" class="updated fade"><p>Sorry, there are no posts in DRAFT status</p></div>
<?php
                    }
        } // End Function print_admin_page

        /*
         * function draftScheduler_randomize_drafts
         *
         */
        function draftScheduler_randomize_drafts($startDate, $startTime, $endTime, $dailyMax = "", $exactPosts = "", $dayweekmonth ) {

            global $wpdb;

            if ( "" == $exactPosts ){
                $postsToday = rand( 0, $dailyMax * 100 ) / 100;
            } else {
                $postsToday = $exactPosts;
            }

            $startPosts = date_i18n( 'Y-n-j G:i:s', strtotime($startDate . ' ' . $startTime));

            $randInterval = (strtotime($endTime) - strtotime($startTime));

            $findDrafts = "SELECT ID FROM " .$wpdb->prefix . "posts WHERE post_status = 'draft' AND post_type = 'post' ORDER BY rand()";

            $draftList = $wpdb->get_results($findDrafts);

            $this->draftScheduler_add_undo( $draftList );

            if ( empty($draftList) ) {
                return "No drafts were found";
            }

            $finished = false;

            while ( ! $finished ):
		if ( $dayweekmonth == 'month' ) {
		    $weekSplit = floor( 30/$dailyMax );
		    $weightedAdd = rand( 0, 3 );
		    if ( $weightedAdd != 3 ) $weekSplit = $weekSplit + $weightedAdd;
		    $weekSplit <= 1 ? $incrementDays = '+1 day' : $incrementDays = "+$weekSplit days";
		    $startPosts = date_i18n( 'Y-n-j G:i:s', strtotime( $incrementDays, strtotime( $startPosts ) ) );   
		} elseif ($dayweekmonth == 'week') {
		    $weekSplit = floor( 7/$dailyMax );
		    $weekSplit = $weekSplit + rand( 0, 1 );
		    $weekSplit <= 1 ? $incrementDays = '+1 day' : $incrementDays = "+$weekSplit days";
		    $startPosts = date_i18n( 'Y-n-j G:i:s', strtotime( $incrementDays, strtotime( $startPosts ) ) );   
		} else {
		    if ( 0 >= $postsToday ){
			if ( "" <> $dailyMax ){
			    $postsToday = rand( 0, $dailyMax * 100 ) / 100;
			    $startPosts = date_i18n( 'Y-n-j G:i:s', strtotime( "+1 day", strtotime( $startPosts ) ) );
			} else {
			    $postsToday = $exactPosts;
			    $startPosts = date_i18n( 'Y-n-j G:i:s', strtotime( "+1 day", strtotime( $startPosts ) ) );
			}
		    }
		}

                $thisDraft = array_pop( $draftList );

                $postRandom = rand( 0, $randInterval );
                $postTime = date_i18n( 'Y-n-j G:i:s', strtotime( "+" . $postRandom . " seconds", strtotime( $startPosts ) ) );

                $this->update_post_details( strtotime( $postTime ), $thisDraft->ID );
                $whole_post = get_post( $thisDraft->ID );
                wp_transition_post_status( 'draft', 'future', $whole_post );
                check_and_publish_future_post( $thisDraft->ID );

                if ( 0 == count( $draftList ) ){
                    $finished = true;
                }
                $postsToday --;
            endwhile;

            return "Drafts updated!";
            //return $query;
        }

        /*
         * function draftScheduler_random_post_by_interval
         * Schedule drafts in random order, based on an interval
         */
        function draftScheduler_random_post_by_interval( $startDate, $intvHours, $intvMins) {
            global $wpdb;

            /*
             * $intvSecs, convert hours and minutes to seconds for the
             * sql query
             */

            $intvSecs = ( $intvHours * 60 * 60 ) + ( $intvMins * 60 );

            $findDrafts = "SELECT * FROM " .$wpdb->posts . " WHERE post_status = 'draft' AND post_type = 'post' ORDER BY rand()";

            $draftList = $wpdb->get_results( $findDrafts );

            $this->draftScheduler_add_undo( $draftList );

            if ( empty( $draftList ) ) {
                return "No drafts were found";
            }

            $startDate = $startDate;

            $ds_postDate = strtotime( $startDate );
            
            foreach ( $draftList as $thisDraft ){

                $this->update_post_details( $ds_postDate, $thisDraft->ID );
                $whole_post = get_post( $thisDraft->ID );
                wp_transition_post_status( 'draft', 'future', $whole_post );
                check_and_publish_future_post( $thisDraft->ID );

                $ds_postDate += $intvSecs;
            }
            //$query = "update";
            return "Drafts updated!";
        } // End Function draftScheduler_random_post_by_interval

        /*
         * function draftScheduler_sequential_post_by_interval
         * Schedule drafts in sequential order, based on an interval
         */
        function draftScheduler_sequential_post_by_interval( $startDate, $intvHours, $intvMins) {
            global $wpdb;

            /*
             * $intvSecs, convert hours and minutes to seconds for the
             * sql query
             */
            $intvSecs = ( $intvHours * 60 * 60 ) + ( $intvMins * 60 );

            $findDrafts = "SELECT ID FROM " .$wpdb->posts . " WHERE post_status = 'draft' AND post_type = 'post' ORDER BY id ASC";

            $draftList = $wpdb->get_results( $findDrafts );
            $this->draftScheduler_add_undo( $draftList );
            if ( empty( $draftList ) ) {
                return "No drafts were found";
            }

            $ds_postDate = strtotime( $startDate );

            foreach ( $draftList as $thisDraft ){

                $this->update_post_details( $ds_postDate, $thisDraft->ID );
                $whole_post = get_post( $thisDraft->ID );
                wp_transition_post_status( 'draft', 'future', $whole_post );
                check_and_publish_future_post( $thisDraft->ID );

                $ds_postDate += $intvSecs;
            }
            return "Drafts updated!";

        } // End Function draftScheduler_sequential_post_by_interval

        function update_post_details( $ds_postDate, $draftID ){
            global $wpdb;
            $ds_gmt = get_gmt_from_date( date( 'Y-n-j G:i:s', $ds_postDate ) );
            
            $update_date = array(
                    'ID' => $draftID,
                    'post_date' => date_i18n( 'Y-n-j G:i:s', $ds_postDate ),
                    'post_date_gmt' => $ds_gmt,
                    'post_status' => 'future',
                    'edit_date' => true
                    );

            wp_update_post( $update_date );
        }

        /*
         * function createDateTimeDropDowns
         * generate a dropdown select list for 30 minute intervals
         */
        function createDateTimeDropDowns ( $selected ) {
            //$outputHTML = '<option value=""></option>';
            for ($i = 0; $i <= 23; $i ++) {
                if($i < 10 ) {
                    $hourTime = "0" . $i;
                } else {
                    $hourTime = $i;
                }
                $outputHTML .= '<option value="'.$hourTime.':00"';
                    if ($hourTime . ":00" == $selected) {
                        $outputHTML .= " selected='selected' ";
                    }
                $outputHTML .= '>'.$hourTime.':00</option>';
                $outputHTML .= '<option value="'.$hourTime.':30"';
                    if ($hourTime . ":30" == $selected) {
                        $outputHTML .= " selected='selected' ";
                    }
                $outputHTML .= '>'.$hourTime.':30</option>';
            }
            return $outputHTML;
        } // End Function createDateTimeDropDowns

        function draftScheduler_add_undo( $draftList ){
            if ( is_array( $draftList ) ){
                foreach ( $draftList as $draft ){
                    $undoList[] = $draft->ID;
                }
                update_option( $this->ifds_option, $undoList );
            }
        }

        function draftScheduler_check_for_drafts(){
            global $wpdb;
            
            $findDrafts = "SELECT COUNT(ID) FROM " .$wpdb->prefix . "posts WHERE post_status = 'draft' AND post_type = 'post'";

            $draftCount = $wpdb->get_var( $findDrafts );

            return $draftCount;
        }
    } // End Class DraftScheduler
} // End If

$draftScheduler = new DraftScheduler();

    function j_is_date( $str )
    {
      $stamp = strtotime( $str );

      if (!is_numeric($stamp))
      {
         return FALSE;
      }
      $month = date( 'm', $stamp );
      $day   = date( 'd', $stamp );
      $year  = date( 'Y', $stamp );

      if (checkdate($month, $day, $year))
      {
         return TRUE;
      }

      return FALSE;
    }

?>
