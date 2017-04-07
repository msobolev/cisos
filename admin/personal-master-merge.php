<?php
require('includes/include_top.php');

$action = $_REQUEST['action'];
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
if($action == 'FindDuplicates')
{
    $personal_one = $_REQUEST['personal_one_first'];		 // name , url
    $personal_two = $_REQUEST['personal_two_first'];

    if($personal_one != '' && $personal_two != '')
    {
        $personal_one_arr = array();
        $personal_two_arr = array();
        
        $personal_one_arr = explode(" ", $personal_one);
        $personal_two_arr = explode(" ", $personal_two);
        
        $search_qry='';
        //if($dup_opt == 'name')
        //{
        //    $search_qry .= " c.company_name = '".$dup_text."'";
        //}
        //elseif($dup_opt == 'url')
        //{
        $search_qry .= " p.first_name in('".$personal_one_arr[0]."','".$personal_two_arr[0]."') and  p.last_name in('".$personal_one_arr[1]."','".$personal_two_arr[1]."')";
        //}

        $sql_query = "select * from " . TABLE_PERSONAL_MASTER . " as p where  ". $search_qry." order by p.personal_id desc";
        echo "<br>Q: ".$sql_query;	
        $exe_data=com_db_query($sql_query);
        $num_rows=com_db_num_rows($exe_data);
        $total_data = $num_rows;	
        //echo "<br>Rows: ".$num_rows;
        $comp_1 = array();
        $comp_2 = array();
        $c = 0;
        while ($data_sql = com_db_fetch_array($exe_data)) 
        {
            $arr_name = "comp_".$c;
            
            $comps[$c]['personal_id'] = $data_sql['personal_id'];
            $comps[$c]['first_name'] = $data_sql['first_name'];
            $comps[$c]['middle_name'] = $data_sql['middle_name'];
            $comps[$c]['last_name'] = $data_sql['last_name'];
            $comps[$c]['email'] = $data_sql['email'];
            $comps[$c]['phone'] = $data_sql['phone'];
            $comps[$c]['about_person'] = $data_sql['about_person'];
            
            $comps[$c]['personal_image'] = $data_sql['personal_image'];
            
            
            
            $comps[$c]['facebook_link'] = $data_sql['facebook_link'];
            $comps[$c]['linkedin_link'] = $data_sql['linkedin_link'];
            
            $comps[$c]['twitter_link'] = $data_sql['twitter_link'];
            $comps[$c]['googleplush_link'] = $data_sql['googleplush_link'];
            $comps[$c]['edu_ugrad_degree'] = $data_sql['edu_ugrad_degree'];
            $comps[$c]['edu_ugrad_specialization'] = $data_sql['edu_ugrad_specialization'];
            $comps[$c]['edu_ugrad_college'] = $data_sql['edu_ugrad_college'];
            $comps[$c]['edu_ugrad_year'] = $data_sql['edu_ugrad_year'];
            $comps[$c]['edu_grad_degree'] = $data_sql['edu_grad_degree'];
            $comps[$c]['edu_grad_specialization'] = $data_sql['edu_grad_specialization'];
            $comps[$c]['edu_grad_college'] = $data_sql['edu_grad_college'];
            
            $comps[$c]['edu_grad_year'] = $data_sql['edu_grad_year'];
            $comps[$c]['add_to_funding'] = $data_sql['add_to_funding'];

            
            $c++;
        }
    }	
}

elseif($action == 'merge')
{
    //echo "<pre>Merge Form data: ";   print_r($_POST);       echo "</pre>";  
    $personal_one_id = $_POST['personal_one_id'];
    $personal_two_id = $_POST['personal_two_id'];
    
    
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $about_person = $_POST['about_person'];
    $personal_image = $_POST['personal_image'];
    
     
    
    $facebook_link = $_POST['facebook_link'];
    $linkedin_link = $_POST['linkedin_link'];
    $twitter_link = $_POST['twitter_link'];
    $googleplush_link = $_POST['googleplush_link'];
    $edu_ugrad_degree = $_POST['edu_ugrad_degree'];
    $edu_ugrad_specialization = $_POST['edu_ugrad_specialization'];
    $edu_ugrad_college = $_POST['edu_ugrad_college'];
    $edu_ugrad_year = $_POST['edu_ugrad_year'];
    $edu_grad_degree  = $_POST['edu_grad_degree'];
    $edu_grad_specialization = $_POST['edu_grad_specialization'];
    $edu_grad_college = $_POST['edu_grad_college'];
    $edu_grad_year = $_POST['edu_grad_year'];
    $add_to_funding = $_POST['add_to_funding'];

    $add_date = date('Y-m-d');    
  
    $query = "insert into " . TABLE_PERSONAL_MASTER . "
        (first_name, middle_name, last_name, email, phone, about_person, personal_image,facebook_link,linkedin_link,twitter_link,googleplush_link, edu_ugrad_degree, edu_ugrad_specialization, edu_ugrad_college, edu_ugrad_year, edu_grad_degree, edu_grad_specialization, edu_grad_college, edu_grad_year, add_to_funding, add_date) 
        values ('$first_name', '$middle_name', '$last_name', '$email', '$phone', '$about_person', '$personal_image', '$facebook_link', '$linkedin_link','$twitter_link','$googleplush_link','$edu_ugrad_degree','$edu_ugrad_specialization', '$edu_ugrad_college', '$edu_ugrad_year', '$edu_grad_degree', '$edu_grad_specialization', '$edu_grad_college','$edu_grad_year','$add_to_funding','$add_date')";
    echo "<br>query: ".$query;
    com_db_query($query);
        //com_db_query("insert into ".TABLE_COMPANY_UPDATE_INFO."(page_name,query_string,add_date) values('admin-company-master','".com_db_input($query)."','".date("Y-m-d:H:i:s")."')");
    $insert_id = com_db_insert_id();
    
    //$comp_one_id = $_POST['personal_one_id'];
    //$comp_one_id = $_POST['personal_two_id'];
    
    echo "<br>Delete Q:";
    echo "delete from " . TABLE_PERSONAL_MASTER . " where personal_id in ('" . $personal_one_id . "','".$personal_two_id."')";
    //com_db_query("delete from " . TABLE_PERSONAL_MASTER . " where personal_id in ('" . $personal_one_id . "','".$personal_two_id."')";
    
    if(isset($_POST['awards']))    
    {
        $awards_count = count($_POST['awards']);
        
        for($j=0;$j<$awards_count;$j++)
        {
            //$old_company_job_id = substr($_POST['jobs'],4,strlen($_POST['jobs']));
            $old_personal_id = $_POST['awards'][$j];

            $merge_awards_query = "UPDATE " . TABLE_PERSONAL_AWARDS . " set personal_id = '" . $insert_id . "' WHERE personal_id = '" .$old_personal_id."'";
            //echo "<br><br>Updating jobs for merge: ".$merge_jobs_query;
            com_db_query($merge_awards_query);
        }    
    }
    
    
    if(isset($_POST['board']))    
    {
        $board_count = count($_POST['board']);
        $old_personal_id_board = "";
        for($j=0;$j<$board_count;$j++)
        {
            //$old_company_job_id = substr($_POST['jobs'],4,strlen($_POST['jobs']));
            $old_personal_id_board = $_POST['board'][$j];

            $merge_board_query = "UPDATE " . TABLE_PERSONAL_BOARD . " set personal_id = '" . $insert_id . "' WHERE personal_id = '" .$old_personal_id_board."'";
            //echo "<br><br>Updating jobs for merge: ".$merge_jobs_query;
            com_db_query($merge_board_query);
        }    
    }
    
    
    if(isset($_POST['speaking']))    
    {
        $speaking_count = count($_POST['speaking']);
        $old_personal_id_speaking = "";
        for($j=0;$j<$speaking_count;$j++)
        {
            //$old_company_job_id = substr($_POST['jobs'],4,strlen($_POST['jobs']));
            $old_personal_id_speaking = $_POST['speaking'][$j];

            $merge_speaking_query = "UPDATE " . TABLE_PERSONAL_SPEAKING . " set personal_id = '" . $insert_id . "' WHERE personal_id = '" .$old_personal_id_speaking."'";
            //echo "<br><br>Updating jobs for merge: ".$merge_jobs_query;
            com_db_query($merge_speaking_query);
        }    
    }
    
    
    if(isset($_POST['media']))    
    {
        $media_count = count($_POST['media']);
        $old_personal_id_media = "";
        for($j=0;$j<$media_count;$j++)
        {
            //$old_company_job_id = substr($_POST['jobs'],4,strlen($_POST['jobs']));
            $old_personal_id_media = $_POST['media'][$j];

            $merge_media_query = "UPDATE " . TABLE_PERSONAL_MEDIA_MENTION . " set personal_id = '" . $insert_id . "' WHERE personal_id = '" .$old_personal_id_media."'";
            //echo "<br><br>Updating jobs for merge: ".$merge_jobs_query;
            com_db_query($merge_media_query);
        }    
    }
    
    
    if(isset($_POST['publication']))    
    {
        $pub_count = count($_POST['publication']);
        $old_personal_id_pub = "";
        for($j=0;$j<$pub_count;$j++)
        {
            //$old_company_job_id = substr($_POST['jobs'],4,strlen($_POST['jobs']));
            $old_personal_id_pub = $_POST['publication'][$j];

            $merge_pub_query = "UPDATE " . TABLE_PERSONAL_PUBLICATION . " set personal_id = '" . $insert_id . "' WHERE personal_id = '" .$old_personal_id_pub."'";
            //echo "<br><br>Updating jobs for merge: ".$merge_jobs_query;
            com_db_query($merge_pub_query);
        }    
    }
    
    
    
    com_redirect("personal-master-merge.php?p=" . $p . "&msg=" . msg_encode("Personal merged successfully"));
    
}

elseif($action == 'primarySetup')
{
    $primary_comp = $_GET['primary'];
    $secondary_comp = $_GET['secondary'];
    //echo "===Here";

    $updateExecsQuery = "update ".TABLE_MOVEMENT_MASTER." set company_id = '".$primary_comp."'  where company_id in(".$secondary_comp.")";
    //echo "<br>Q: ".$updateQuery; die();
    com_db_query($updateExecsQuery);

    $updateJobQuery = "update ".TABLE_COMPANY_JOB_INFO." set company_id = '".$primary_comp."'  where company_id in(".$secondary_comp.")";
    //echo "<br>Q: ".$updateQuery; die();
    com_db_query($updateJobQuery);

    $msg = "Made the selected company as primary.";
    com_redirect("company-master-duplicates.php?selected_menu=master&msg=" . msg_encode($msg));	
}
//echo "<pre>comps: ";   print_r($comps);   echo "</pre>";
include("includes/header.php");
?>
<tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

        <tr>
            <?php
            include("includes/menu_left.php");
            ?>
            <td width="10" align="left" valign="top">&nbsp;</td>
            <td width="769" align="left" valign="top">
	
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="middle" class="right">
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="25%" align="left" valign="middle" class="heading-text">Duplicate Personal</td>
                                    <td width="75%" valign="middle" class="message" align="left"><?=$msg?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                    <td align="left" valign="top" class="right-bar-content-border-box">
                        
                            <table width="90%" border="0" cellspacing="0" cellpadding="5">
                                <form name="exportfile" method="post" action="personal-master-merge.php?action=FindDuplicates">
                                
                                
                                    
                                <tr><td colspan="2" height="20">&nbsp;</td></tr>
                                <tr>
                                    <td width="220" align="left" valign="top">Enter Person 1 Full Name:</td>
                                    <td align="left" valign="top">
                                        <input type="text" name="personal_one_first" id="personal_one_first" size="30" value="<?=$_REQUEST['personal_one_first']?>" />
                                    </td>
                                </tr>


                                <tr>
                                    <td align="left" valign="top">Enter Person 2 Full Name:</td>
                                    <td align="left" valign="top">
                                        <input type="text" name="personal_two_first" id="personal_two_first" size="30" value="<?=$_REQUEST['personal_two_first']?>" />
                                    </td>
                                </tr>

                                <tr>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="top"><input type="submit" name="Submit" value="Find Personal" class="submitButton" /></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td align="left" valign="top">&nbsp;</td>
                                </tr>
                                </form>
                                <?PHP
                                //echo "<br>Num_rows:".$num_rows;
                                if($num_rows > 1)
                                {
                                    //$sql_query_comp_ids = "select group_concat(c.company_id) as comp_ids from " . TABLE_COMPANY_MASTER . " as c where  ". $search_qry." order by c.company_id desc";
                                    //echo "<br>group_concat Q: ".$sql_query_comp_ids;	
                                    //$exe_data_comp_ids = com_db_query($sql_query_comp_ids);
                                    //$data_concat_comp_ids = com_db_fetch_array($exe_data_comp_ids);
                                    //$comp_ids = $data_concat_comp_ids['comp_ids'];
                                    //echo "<br>comp_ids: ".$comp_ids;

                                ?>
                                <tr>
                                <!-- <td>
                                         <table width="90%" border="0" cellspacing="0" cellpadding="5">
                                          <tr> -->
                                    <td colspan="2"><h2>Persons</h2></td>
                                </tr>	

                                <tr>
                                    <td colspan="2">
                                        <form method="post" action="personal-master-merge.php?action=merge">
                                        
                                        <input type="hidden" name="personal_one_id" id="comp_one_id" value="<?=$comps[0]['personal_id']?>">    
                                        <input type="hidden" name="personal_two_id" id="comp_two_id" value="<?=$comps[1]['personal_id']?>">    
                                            
                                        <table width="100%" cellpadding="5">
                                            
                                            <?PHP
                                            //while ($data_sql = com_db_fetch_array($exe_data)) 
                                            //for($r=0;$r<2;$r++)        
                                            //{

                                                //echo "<pre>data_sql ARR:";	print_r($data_sql); echo "</pre>";
                                            $removed_this_id = "";
                                            $comp_id = $data_sql['company_id'];
                                            $comp_name = $data_sql['company_name'];
                                            $comp_web = $data_sql['company_website'];
                                            //echo "<br><br><br>comp_id: ".$comp_id;
                                            //echo "<br>comp_ids".$comp_ids;
                                            $removed_this_id = str_replace($comp_id,"",$comp_ids);
                                            $removed_this_id = str_replace(",,",",",$removed_this_id);
                                            $removed_this_id = trim($removed_this_id,",");
                                            //echo "<br>After this removal: ".$removed_this_id;
                                            ?>

                                            <tr>
                                                <td width="285">First Name</td>
                                                <td><?=$comps[0]['first_name']?></td>
                                                <td><input type="radio" name="first_name" value="<?=$comps[0]['first_name']?>"></td>
                                                <td><?=$comps[1]['first_name']?></td>
                                                <td><input type="radio" name="first_name" value="<?=$comps[1]['first_name']?>"></td>
                                            </tr>
                                            
                                            <tr>
                                                <td>Middle Name</td>
                                                <td><?=$comps[0]['middle_name']?></td>
                                                <td><input type="radio" name="middle_name" value="<?=$comps[0]['middle_name']?>"></td>
                                                <td><?=$comps[1]['middle_name']?></td>
                                                <td><input type="radio" name="middle_name" value="<?=$comps[1]['middle_name']?>"></td>
                                            </tr>

                                                                                            <tr>
                                            <td>Last Name</td>
                                                <td><?=$comps[0]['last_name']?></td>
                                                <td><input type="radio" name="last_name" value="<?=$comps[0]['last_name']?>"></td>
                                                <td><?=$comps[1]['last_name']?></td>
                                                <td><input type="radio" name="last_name" value="<?=$comps[1]['last_name']?>"></td>
                                            </tr>
                                           
                                            
                                            
                                            <td>Personal Photo</td>
                                            <td>
                                                <img src="<?=HTTPS_SITE_URL?>personal_photo/thumb/<?=$comps[0]['personal_image']?>" alt="" />
                                            </td>
                                                <td><input type="radio" name="personal_image" value="<?=$comps[0]['personal_image']?>"></td>
                                                <td>
                                                    <img src="<?=HTTPS_SITE_URL?>personal_photo/thumb/<?=$comps[1]['personal_image']?>" alt="" />
                                                </td>
                                                <td><input type="radio" name="personal_image" value="<?=$comps[1]['personal_image']?>"></td>
                                            </tr>
                                            
           
                                            
                                            <td>Email</td>
                                                <td><?=$comps[0]['email']?></td>
                                                <td><input type="radio" name="email" value="<?=$comps[0]['email']?>"></td>
                                                <td><?=$comps[1]['email']?></td>
                                                <td><input type="radio" name="email" value="<?=$comps[1]['email']?>"></td>
                                            </tr>

                                            
                                            <td>Phone</td>
                                                <td><?=$comps[0]['phone']?></td>
                                                <td><input type="radio" name="phone" value="<?=$comps[0]['phone']?>"></td>
                                                <td><?=$comps[1]['phone']?></td>
                                                <td><input type="radio" name="phone" value="<?=$comps[1]['phone']?>"></td>
                                            </tr>
                                            
                                            
                                            <td>About Person</td>
                                                <td><?=$comps[0]['about_person']?></td>
                                                <td><input type="radio" name="about_person" value="<?=$comps[0]['about_person']?>"></td>
                                                <td><?=$comps[1]['about_person']?></td>
                                                <td><input type="radio" name="about_person" value="<?=$comps[1]['about_person']?>"></td>
                                            </tr>
                                            
                                           
                                            <td>Facebook Link</td>
                                                <td><?=$comps[0]['facebook_link']?></td>
                                                <td><input type="radio" name="facebook_link" value="<?=$comps[0]['facebook_link']?>"></td>
                                                <td><?=$comps[1]['facebook_link']?></td>
                                                <td><input type="radio" name="facebook_link" value="<?=$comps[1]['facebook_link']?>"></td>
                                            </tr>
                                            
                                            <td>LinkedIn Link</td>
                                                <td><?=$comps[0]['linkedin_link']?></td>
                                                <td><input type="radio" name="linkedin_link" value="<?=$comps[0]['linkedin_link']?>"></td>
                                                <td><?=$comps[1]['linkedin_link']?></td>
                                                <td><input type="radio" name="linkedin_link" value="<?=$comps[1]['linkedin_link']?>"></td>
                                            </tr>
                                            
                                            
                                            <td>Googleplush Link</td>
                                                <td><?=$comps[0]['googleplush_link']?></td>
                                                <td><input type="radio" name="googleplush_link" value="<?=$comps[0]['googleplush_link']?>"></td>
                                                <td><?=$comps[1]['googleplush_link']?></td>
                                                <td><input type="radio" name="googleplush_link" value="<?=$comps[1]['googleplush_link']?>"></td>
                                            </tr>
                                            
                                            
                                            <td>Twitter Link</td>
                                                <td><?=$comps[0]['twitter_link']?></td>
                                                <td><input type="radio" name="twitter_link" value="<?=$comps[0]['twitter_link']?>"></td>
                                                <td><?=$comps[1]['twitter_link']?></td>
                                                <td><input type="radio" name="twitter_link" value="<?=$comps[1]['twitter_link']?>"></td>
                                            </tr>
                                            
                                            
                                            
                                            <td>Education (Undergrad) Degree</td>
                                                <td><?=$comps[0]['edu_ugrad_degree']?></td>
                                                <td><input type="radio" name="edu_ugrad_degree" value="<?=$comps[0]['edu_ugrad_degree']?>"></td>
                                                <td><?=$comps[1]['edu_ugrad_degree']?></td>
                                                <td><input type="radio" name="edu_ugrad_degree" value="<?=$comps[1]['edu_ugrad_degree']?>"></td>
                                            </tr>
                                            

                                            
                                            <td>Education (Undergrad) Specialization</td>
                                                <td><?=$comps[0]['edu_ugrad_specialization']?></td>
                                                <td><input type="radio" name="edu_ugrad_specialization" value="<?=$comps[0]['edu_ugrad_specialization']?>"></td>
                                                <td><?=$comps[1]['address']?></td>
                                                <td><input type="radio" name="edu_ugrad_specialization" value="<?=$comps[1]['edu_ugrad_specialization']?>"></td>
                                            </tr>
                                            
                                            <td>Education (Undergrad) College</td>
                                                <td><?=$comps[0]['edu_ugrad_college']?></td>
                                                <td><input type="radio" name="edu_ugrad_college" value="<?=$comps[0]['edu_ugrad_college']?>"></td>
                                                <td><?=$comps[1]['edu_ugrad_college']?></td>
                                                <td><input type="radio" name="edu_ugrad_college" value="<?=$comps[1]['edu_ugrad_college']?>"></td>
                                            </tr>
                                            
                                            
                                            <td>Education (Undergrad) Graduation Year</td>
                                                <td><?=$comps[0]['edu_ugrad_year']?></td>
                                                <td><input type="radio" name="edu_ugrad_year" value="<?=$comps[0]['edu_ugrad_year']?>"></td>
                                                <td><?=$comps[1]['edu_ugrad_year']?></td>
                                                <td><input type="radio" name="edu_ugrad_year" value="<?=$comps[1]['edu_ugrad_year']?>"></td>
                                            </tr>
                                            
                                            <td>Education (Grad) Degree</td>
                                                <td><?=$comps[0]['edu_grad_degree']?></td>
                                                <td><input type="radio" name="edu_grad_degree" value="<?=$comps[0]['edu_grad_degree']?>"></td>
                                                <td><?=$comps[1]['edu_grad_degree']?></td>
                                                <td><input type="radio" name="edu_grad_degree" value="<?=$comps[1]['edu_grad_degree']?>"></td>
                                            </tr>
                                            

                                            
                                            <td>Education (Grad) Specialization</td>
                                                <td><?=$comps[0]['address']?></td>
                                                <td><input type="radio" name="edu_grad_specialization" value="<?=$comps[0]['edu_grad_specialization']?>"></td>
                                                <td><?=$comps[1]['address']?></td>
                                                <td><input type="radio" name="edu_grad_specialization" value="<?=$comps[1]['edu_grad_specialization']?>"></td>
                                            </tr>
                                            
                                            <td>Education (Grad) College</td>
                                                <td><?=$comps[0]['edu_grad_college']?></td>
                                                <td><input type="radio" name="edu_grad_college" value="<?=$comps[0]['edu_grad_college']?>"></td>
                                                <td><?=$comps[1]['edu_grad_college']?></td>
                                                <td><input type="radio" name="edu_grad_college" value="<?=$comps[1]['edu_grad_college']?>"></td>
                                            </tr>
                                            
                                            
                                            <td>Education (Grad) Graduation Year</td>
                                                <td><?=$comps[0]['edu_grad_year']?></td>
                                                <td><input type="radio" name="edu_grad_year" value="<?=$comps[0]['edu_grad_year']?>"></td>
                                                <td><?=$comps[1]['edu_grad_year']?></td>
                                                <td><input type="radio" name="edu_grad_year" value="<?=$comps[1]['edu_grad_year']?>"></td>
                                            </tr>
                                            
                                            <td>add_to_funding</td>
                                                <td><?=$comps[0]['add_to_funding']?></td>
                                                <td><input type="radio" name="add_to_funding" value="<?=$comps[0]['add_to_funding']?>"></td>
                                                <td><?=$comps[1]['add_to_funding']?></td>
                                                <td><input type="radio" name="add_to_funding" value="<?=$comps[1]['add_to_funding']?>"></td>
                                            </tr>
                                            
                                            
                                            
                                            <td>Awards</td>
                                                <td>of personal <?=$comps[0]['first_name']?>  <?=$comps[0]['last_name']?></td>
                                                <td><input type="checkbox" name="awards[]" value="<?=$comps[0]['personal_id']?>"></td>
                                                <td>of personal <?=$comps[1]['first_name']?>  <?=$comps[1]['last_name']?></td>
                                                <td><input type="checkbox" name="awards[]" value="<?=$comps[1]['personal_id']?>"></td>
                                            </tr>
                                            
                                            <td>Board</td>
                                                <td>of personal <?=$comps[0]['first_name']?>  <?=$comps[0]['last_name']?></td>
                                                <td><input type="checkbox" name="board[]" value="<?=$comps[0]['personal_id']?>"></td>
                                                <td>of personal <?=$comps[1]['first_name']?>  <?=$comps[1]['last_name']?></td>
                                                <td><input type="checkbox" name="board[]" value="<?=$comps[1]['personal_id']?>"></td>
                                            </tr>
                                            
                                            <td>Speaking</td>
                                                <td>of personal <?=$comps[0]['first_name']?>  <?=$comps[0]['last_name']?></td>
                                                <td><input type="checkbox" name="speaking[]" value="<?=$comps[0]['personal_id']?>"></td>
                                                <td>of personal <?=$comps[1]['first_name']?>  <?=$comps[1]['last_name']?></td>
                                                <td><input type="checkbox" name="speaking[]" value="<?=$comps[1]['personal_id']?>"></td>
                                            </tr>
                                            
                                            
                                            <td>Media</td>
                                                <td>of personal <?=$comps[0]['first_name']?>  <?=$comps[0]['last_name']?></td>
                                                <td><input type="checkbox" name="media[]" value="<?=$comps[0]['personal_id']?>"></td>
                                                <td>of personal <?=$comps[1]['first_name']?>  <?=$comps[1]['last_name']?></td>
                                                <td><input type="checkbox" name="media[]" value="<?=$comps[1]['personal_id']?>"></td>
                                            </tr>
                                            
                                            
                                            <td>Publication</td>
                                                <td>of personal <?=$comps[0]['first_name']?>  <?=$comps[0]['last_name']?></td>
                                                <td><input type="checkbox" name="publication[]" value="<?=$comps[0]['personal_id']?>"></td>
                                                <td>of personal <?=$comps[1]['first_name']?>  <?=$comps[1]['last_name']?></td>
                                                <td><input type="checkbox" name="publication[]" value="<?=$comps[1]['personal_id']?>"></td>
                                            </tr>
                                           
                                            
                                            
                                            <tr>
                                                <td style="text-align:center;padding:20px;" colspan="4"><input type="submit" value="Merge" ></td>
                                            </tr>
                                                
                                            <?PHP
                                            //}
                                            ?> 
                                        </table>
                                        </form>
                                    </td>
                                </tr>	
                                      <!-- </table>

                                </td>
                          </tr> -->

                                <?PHP
                                }
                                elseif(isset($num_rows) && $num_rows == 0)
                                {
                                ?>
                                      <td colspan="2">No duplicates found.</td>
                                <?PHP
                                }
                                ?>
                            </table>
                        
                    </td>
                </tr>
		  
	  
		  
        </table>
		
        </td>
      </tr>
    </table></td>
  </tr>	 
		
 <?php
include("includes/footer.php");
?> 