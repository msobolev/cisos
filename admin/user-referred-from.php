<?php
require('includes/include_top.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 30;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';

$sql_query = "select concat(first_name,' ',last_name) as full_name,user_id,email,res_date,referring_links,move_id from " . TABLE_USER ." order by res_date desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'user-referred-from.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$sID = (isset($_GET['sID']) ? $_GET['sID'] : $select_data[0]);

  
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

<?php if($action == ''){	?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="30%" align="left" valign="middle" class="heading-text">User Referred Page</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                 
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">

			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="39" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">#</span></td>
				<td width="171" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">User Name</span></td>
				<td width="236" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">E-mail</span> </td>
				<td width="195" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Page Name</span> </td>
				<td width="92" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span></td>
			  </tr>
			<?php
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$adddate = explode('-',$data_sql['res_date']);
				$add_date = $adddate[1].'/'.$adddate[2].'/'.$adddate[0];
				$page_name = $data_sql['referring_links'];
				if($page_name=='movement.php'){
					$pcname = com_db_GetValue("select concat(pm.first_name,' ',pm.last_name,' at ',cm.company_name) as person_company from ".TABLE_MOVEMENT_MASTER." mm,".TABLE_PERSONAL_MASTER." pm, ".TABLE_COMPANY_MASTER." cm where mm.personal_id=pm.personal_id and mm.company_id=cm.company_id and mm.move_id='".$data_sql['move_id']."'");
				}
				if((trim($pcname)!='') && ($page_name=='movement.php')){
					$page_name = $pcname;
				}else{
					$page_name = $page_name;
				}
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['full_name']);?></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><?=com_db_output($data_sql['email']);?></td>
				<td height="30" align="left" valign="middle" class="right-border-text">&nbsp;<?=$page_name;?></td>
				<td height="30" align="center" valign="middle" class="right-border-text"><?=$add_date;?></td>
         	</tr> 
			<?php
			$i++;
				}
			
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
 <tr>
    <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
     
      <tr>
        <td width="666" align="right" valign="top"><table width="200" border="0" align="right" cellpadding="0" cellspacing="0">
          <tr>
		<?php echo number_pages($main_page, $p, $total_data, 8, $items_per_page,'&selected_menu=user');?>		  
          </tr>
        </table></td>
        <td width="314" align="center" valign="bottom">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
<?php }
include("includes/footer.php");
?>