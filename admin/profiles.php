<?php
require('includes/include_top.php');
include('includes/include_editor.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from hre_profiles order by p_id desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'profiles.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$nID = (isset($_GET['nID']) ? $_GET['nID'] : $select_data[0]);

switch ($action) 
{
    case 'delete':

        com_db_query("delete from hre_profiles where news_id = '" . $nID . "'");
        com_redirect("profiles.php?p=" . $p . "&selected_menu=profile&msg=" . msg_encode("News deleted successfully"));
		
    break;
		
    case 'alldelete':
        $news_id = $_POST['nid'];
        for($i=0; $i< sizeof($news_id) ; $i++)
        {
                com_db_query("delete from hre_profiles where news_id = '" . $news_id[$i] . "'");
        }
        com_redirect("profiles.php?p=" . $p . "&selected_menu=profile&msg=" . msg_encode("News deleted successfully"));

    break;	
		
    case 'edit':
        $query_edit=com_db_query("select * from hre_profiles where news_id = '" . $nID . "'");
        $data_edit=com_db_fetch_array($query_edit);
        $details=com_db_output($data_edit['news_details']);
        $title=com_db_output($data_edit['news_title']);
        $adt = explode('-',$data_edit['add_date']);
        if(sizeof($adt)==3)
        {
            $add_date = $adt[1].'/'.$adt[2].'/'.$adt[0];
        }
        else
        {
            $add_date ='';
        }

    break;	
		
    case 'editsave':

        $title=com_db_input($_POST['title']);
        $detailes=com_db_input($_POST['detailes']);
        $add_date = $_POST['add_date'];
        if($add_date==''){
                $added=date('Y-m-d');
        }else{
                $adt = explode('/',$add_date);//mm/dd/yyyy
                $added=$adt[2].'-'.$adt[0].'-'.$adt[1];
        }
        $query = "update hre_profiles set news_title = '" . $title . "',  news_details = '" . $detailes . "', add_date='".$added."' where news_id = '" . $nID . "'";
        com_db_query($query);
        com_redirect("profiles.php?p=". $p ."&nID=" . $nID . "&selected_menu=profile&msg=" . msg_encode("News update successfully"));

    break;		

    case 'addsave':

        $email = com_db_input($_POST['email']);
        $f_name = com_db_input($_POST['f_name']);
        $l_name = com_db_input($_POST['l_name']);
        $title = com_db_input($_POST['title']);
        $add_date = date('Y-m-d');
        

        $query = "insert into hre_profiles (first_name,last_name,title,email, add_date) values ('$f_name','$l_name','$title','$email', '$add_date')";
        //echo "<br>First insert Q: ".$query;	
        com_db_query($query);
        
        $insert_id = com_db_insert_id();
        
        $image = $_FILES['image']['tmp_name'];
	echo "<br>Image: ".$image;		
        //echo "<br>Insert_id: ".$insert_id;	
        echo "<pre>FILES:";   print_r($_FILES);   echo "</pre>";
        if($image != '')
        {
            echo "<br>within if";		
            if(is_uploaded_file($image))
            {
                $org_img = $_FILES['image']['name'];
                $exp_file = explode("." , $org_img);
                $get_ext = $exp_file[count($exp_file) - 1];
                if(strtolower($get_ext) == "jpg" || strtolower($get_ext) == "gif" || strtolower($get_ext) == "jpeg" || strtolower($get_ext) == "png")
                {
                    //echo "<br>Within ext check";		
                    $new_exp_file = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$exp_file[0]);
                    $org_image_name = $new_exp_file.'-'.time().'.'.$get_ext;
                    $destination_image = '../profile_photo/' . $org_image_name;
                    if(move_uploaded_file($image , $destination_image))
                    {
                        echo "<br>Within move uploaded file";
                        
                        //$thumb_image='../personal_photo/thumb/' . $org_image_name;
                        //make_thumb($destination_image, $thumb_image,200,200);

                        //$small_image='../personal_photo/small/' . $org_image_name;
                        //make_thumb($destination_image, $small_image,80,80);

                        $query = "UPDATE hre_profiles SET personal_image = '" . $org_image_name . "' WHERE p_id = '" . $insert_id ."'";
                        echo "<br>Setting personal profile query: ".$query;
                        com_db_query($query);
                    }
                }	
            }	
        }
        
        $pr_image = $_FILES['pr_image']['tmp_name'];
			  
        if($pr_image!='')
        {
            if(is_uploaded_file($pr_image))
            {
                $org_img_pr = $_FILES['pr_image']['name'];
                $exp_file_pr = explode("." , $org_img_pr);
                $get_ext_pr = $exp_file_pr[count($exp_file_pr) - 1];
                if(strtolower($get_ext_pr)=="jpg" || strtolower($get_ext_pr)=="gif" || strtolower($get_ext_pr)=="jpeg" || strtolower($get_ext_pr)=="png")
                {
                    $new_exp_file_pr = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$exp_file_pr[0]);
                    $org_image_name_pr = $new_exp_file_pr.'-'.time().'.'.$get_ext_pr;
                    $destination_image_pr = '../profile_photo/' . $org_image_name_pr;
                    if(move_uploaded_file($pr_image , $destination_image_pr))
                    {
                        //$thumb_image='../personal_photo/thumb/' . $org_image_name;
                        //make_thumb($destination_image, $thumb_image,200,200);

                        //$small_image='../personal_photo/small/' . $org_image_name;
                        //make_thumb($destination_image, $small_image,80,80);

                        $query_pr = "UPDATE hre_profiles SET press_release_image = '" . $org_image_name_pr . "' WHERE p_id = '" . $insert_id ."'";
                        //echo "<br>Setting press release image query: ".$query_pr;
                        com_db_query($query_pr);
                    }
                }	
            }	
        }
        //com_redirect("profiles.php?p=" . $p . "&selected_menu=profile&msg=" . msg_encode("New profile added successfully"));

    break;	
		
    case 'detailes':

        $query_edit=com_db_query("select * from hre_profiles where news_id = '" . $nID . "'");
        $data_edit=com_db_fetch_array($query_edit);

        $details=com_db_output($data_edit['news_details']);
        $title=com_db_output($data_edit['news_title']);
        $add_date =explode('-',$data_edit['add_date']);
        $post_date = date('d, M Y',mktime(0,0,0,date($add_date[1]),date($add_date[2]),date($add_date[0])));

    break;	
    case 'activate':

        $status=$_GET['status'];
        if($status==0)
        {
            $query = "update hre_profiles set status = '1' where news_id = '" . $nID . "'";
        }
        else
        {
            $query = "update hre_profiles set status = '0' where news_id = '" . $nID . "'";
        }	
        com_db_query($query);
        com_redirect("profiles.php?p=". $p ."&nID=" . $nID . "&selected_menu=profile&msg=" . msg_encode("Profile update successfully"));

    break;
}
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("News will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "profiles.php?selected_menu=profile&nID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "profiles.php?selected_menu=profile&nID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var news_id='news_id-'+ i;
			document.getElementById(news_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var news_id='news_id-'+ i;
			document.getElementById(news_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var news_id='news_id-'+ i;
			if(document.getElementById(news_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('news_id-1').focus();
		return false;
	} else {
		var agree=confirm("News will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "news.php?selected_menu=news";
	}	

}

function confirm_artivate(nid,p,status){
	if(status=='1'){
		var msg="News will be active. \n Do you want to continue?";
	}else{
		var msg="News will be Inactive. \n Do you want to continue?";
	}
	var agree=confirm(msg);
	if (agree)
		window.location = "news.php?selected_menu=profile&nID=" + nid + "&p=" + p + "&status=" + status + "&action=activate";
	else
		window.location = "news.php?selected_menu=profile&nID=" + nid + "&p=" + p ;
}



</script>

 <tr>
    <td align="left" valign="top" bgcolor="#FFFFFF"><table width="975" border="0" align="center" cellpadding="0" cellspacing="0">

      <tr>
		<?php
		include("includes/menu_left.php");
		?>
		<td width="10" align="left" valign="top">&nbsp;</td>
        <td width="769" align="left" valign="top">

<?php 
if(($action == '') || ($action == 'save'))
{	
?>			

    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="30%" align="left" valign="middle" class="heading-text">Profile Manager</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Profile" title="Add News" onclick="window.location='profiles.php?action=add&selected_menu=profile'"  /></a></td>
                  <td width="8%" align="left" valign="middle" class="nav-text">Add New </td>
                  <td width="4%" align="right" valign="middle">
                    <!-- <a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Profile" title="Delete Profile" onclick="AllDelete('<?=$numRows?>');"  /></a> -->
                    </td>
                  <td width="8%" align="left" valign="middle" class="nav-text">
                    <!--  Delete -->
                  </td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="profiles.php?action=alldelete&selected_menu=profile" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="23" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="32" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="333" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Email</span> </td>
				<td width="210" height="30" align="center" valign="middle" class="right-border"></td>
				<td width="116" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
				<!-- <td width="247" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td> -->
			  </tr>
			<?php
			
			if($total_data>0) 
                        {
                            $i=1;
                            while ($data_sql = com_db_fetch_array($exe_data)) 
                            {
                                $added_date = $data_sql['add_date'];
                                //$status = $data_sql['status'];
				
			?>          
                            <tr>
                                <td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="news_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['p_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['email'])?></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a target="_blank" href="http://www.cisosonthemove.com/ed/inner.php?i=<?=$data_sql['p_id']?>">Link</a></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=$added_date;?></td>
				
                                <!--
                                <td height="30" align="center" valign="middle" class="left-border">
                                    <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                                        <tr> 
                                        <?php 
                                        //if($status==0)
                                        //{ 
                                        ?>
                                            <td width="29%" align="center" valign="middle"><a href="#"><img src="images/icon/active-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['news_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
                                                Status
                                            </td>
                                        <?php 
                                        //} 
                                        //elseif($status==1)
                                        //{ 
                                        ?>
                                            <td width="24%" align="center" valign="middle"><a href="#"><img src="images/icon/inactive-icon.gif" width="16" height="16" alt="" title="" border="0" onclick="confirm_artivate('<?=$data_sql['news_id'];?>','<?=$p;?>','<?=$status;?>');" /></a><br />
                                                Status
                                            </td>
                                        <?php 
                                        //}  
                                        ?>
                                            <td width="23%" align="center" valign="middle"><a href="#"><img src="images/small-edit-icon.gif" width="16" height="16" alt="Edit" title="Edit" border="0" onclick="window.location='news.php?selected_menu=news&p=<?=$p;?>&nID=<?=$data_sql['news_id'];?>&action=edit'" /></a><br />
                                                Edit
                                            </td>
                                            <td width="24%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$data_sql['news_id'];?>','<?=$p;?>')" /></a><br />
                                                Delete
                                            </td>
                                        </tr>
                                    </table>				
                                </td>
                                -->
                            </tr> 
                            <?php
                            $i++;
                            }
			}
			?>     
                    </table> 
		</form>
		</td>
          </tr>
        </table>
</td>
      </tr>
    </table></td>
  </tr>
 <tr>
    <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
     
      <tr>
        <td width="666" align="right" valign="top"><table width="200" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
		<?php echo number_pages($main_page, $p, $total_data, 8, $items_per_page);?>		  
          </tr>
        </table></td>
        <td width="314" align="center" valign="bottom">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
<?php } elseif($action=='edit'){ ?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">News Manager :: Edit News </td>
				  
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top"  class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top">
		 <!--start iner table  -->
			<table width="95%" align="left" cellpadding="5" cellspacing="5" border="0">
			<form name="DateTest" method="post" action="news.php?action=editsave&selected_menu=news&nID=<?=$nID;?>&p=<?=$p;?>" onsubmit="return chk_form();">
			<tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp;Title:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="title" id="title" size="80" value="<?=$title;?>" />
			  </td>	
			</tr>
			<tr><td  class="page-text" align="left" valign="top">&nbsp;&nbsp;&nbsp;Details:</td>
			<td align="left" valign="top">
			
			<div id="loading"><font face="Verdana, Arial, Helvetica, sans-serif" size="-1">Please wait<br><br>
			  </font><strong><font color="#993300" face="Verdana, Arial, Helvetica, sans-serif" >Editor 
			  Loading......</font></strong><br>
			  <br></div> <div id="fck" style="">  
		  <!---------------------------->
		  
			<?php
			$oFCKeditor = new FCKeditor('detailes') ;
			$oFCKeditor->BasePath	= $sBasePath ;
			$oFCKeditor->ToolbarSet = ''; // Basic
			$oFCKeditor->Width  = '100%';
			$oFCKeditor->Height  = '400';       
			$oFCKeditor->Value		= $details ;
			$oFCKeditor->Create() ;
			
			?>
				</div>
			</td></tr>
			<tr>
			  <td width="18%" align="left" class="page-text" valign="top">&nbsp;&nbsp;&nbsp; Date:</td>
			  <td width="77%" align="left" valign="top">
				<input type="text" name="add_date" id="add_date" value="<?=$add_date;?>" />
				<a href="javascript:NewCssCal('add_date','mmddyyyy','arrow')"><img src="images/calender-icon.gif" alt="" width="22" height="14" border="0" title="" /></a>	
			  </td>	
			</tr>
			<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><div id="butt" style="display:none;"><input type="submit" value="Update news" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='news.php?p=<?=$p;?>&nID=<?=$nID;?>&selected_menu=news'" /></div></td></tr>
			</form>
			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
            </table></td>
		 </tr>
        </table></td>
          </tr>
        </table>
		
<?php		
} 
elseif($action=='add')
{
?>		
<script language="javascript" type="text/javascript">
function chk_form(){
	var title=document.getElementById('title').value;
	if(title==''){
	alert("Please enter news title.");
	document.getElementById('title').focus();
	return false;
	}

}
</script>
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Profile Manager :: Add Profile </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
                <td align="left" valign="top" class="right-border-box">
                <!--start iner table  -->
                <table width="95%" align="left" cellpadding="5" cellspacing="5" border="0">
		<form name="DateTest" method="post" action="profiles.php?action=addsave&p=<?=$p;?>" onsubmit="return chk_form();"  enctype = "multipart/form-data">
                    
                <tr>
                    <td width="20%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;&nbsp;First Name:</td>
                    <td width="75%" align="left" valign="top">
                        <input type="text" name="f_name" id="f_name" size="40" />
                    </td>	
		</tr>
                
                <tr>
                    <td width="20%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;&nbsp;Last Name:</td>
                    <td width="75%" align="left" valign="top">
                        <input type="text" name="l_name" id="l_name" size="40" />
                    </td>	
		</tr>
                
                
                <tr>
                    <td width="20%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;&nbsp;Title:</td>
                    <td width="75%" align="left" valign="top">
                        <input type="text" name="title" id="title" size="40" />
                    </td>	
		</tr>
                    
		<tr>
                    <td width="20%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;&nbsp;Email:</td>
                    <td width="75%" align="left" valign="top">
                        <input type="text" name="email" id="email" size="40" />
                    </td>	
		</tr>
                
                
                <tr>
                    <td align="left" valign="top"  class="page-text">&nbsp;&nbsp;&nbsp;Personal Image:</td>
                    <td align="left" valign="top">
                        <input type="file" name="image" id="image" />&nbsp;(Dimension: 277px * 277px)
                    </td>	
		</tr>
		
                <tr>
                    <td align="left" valign="top"  class="page-text">&nbsp;&nbsp;&nbsp;Press Release:</td>
                    <td align="left" valign="top">
                        <input type="file" name="pr_image" id="image" />&nbsp;(Dimension: 687px * 433px)
                    </td>	
		</tr>
                
                
		<tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top">
                        <input type="submit" value="Add new Profile" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="button" class="submitButton" value="cancel" onclick="window.location='profiles.php?p=<?=$p;?>&nID=<?=$nID;?>&selected_menu=profile'" />
                    </td>
                </tr>
		</form>
		</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
            </table></td>
		 </tr>
        </table></td>
          </tr>
        </table>		
<?php
} elseif($action=='detailes'){
?>		
  	  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">News Manager :: News Details </td>
				  <td width="50%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box"><table width="100%" align="center" cellpadding="0" cellspacing="0">
           <tr>
		  <td align="left" valign="top" class="right-border">
		 <!--start iner table  -->
			  <table width="98%" align="center" cellpadding="5" cellspacing="5" border="0">
			<tr>
			  <td align="left" valign="top" class="page-text"><strong><?=$title;?></strong><br /><br /><?=$post_date?></td>
			</tr>
			<tr>
				<td align="left" valign="top" class="page-text"><?=$details;?></td>
			</tr>
			<tr>
				<!--<td align="left" valign="top">&nbsp;</td> -->
				<td align="left" valign="top"><input type="button" class="submitButton" value="Back" onclick="window.location='profiles.php?p=<?=$p;?>&nID=<?=$nID;?>&selected_menu=news'" /></td>
			</tr>
			
			</table>
		 <!-- end inner table -->
		  </td>
		 </tr>
            </table></td>
		 </tr>
        </table></td>
          </tr>
     </table>		
<?php
}
include("includes/footer.php");
?>