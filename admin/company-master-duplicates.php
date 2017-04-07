<?php
require('includes/include_top.php');

$action = $_REQUEST['action'];
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';
if($action == 'FindDuplicates'){
	
	$dup_opt = $_REQUEST['dup_opt'];		 // name , url
	$dup_text = $_REQUEST['dup_text'];
	
	if($dup_opt != '' && $dup_text != '')
	{
		$search_qry='';
		if($dup_opt == 'name'){
			$search_qry .= " c.company_name = '".$dup_text."'";
		}
		elseif($dup_opt == 'url'){
				$search_qry .= " c.company_website = '".$dup_text."'";
		}
		
		
		$sql_query = "select c.company_id,c.company_name,c.company_website,c.status,c.add_date from " . TABLE_COMPANY_MASTER . " as c where  ". $search_qry." order by c.company_id desc";
		//echo "<br>Q: ".$sql_query;	
		$exe_data=com_db_query($sql_query);
		$num_rows=com_db_num_rows($exe_data);
		//$total_data = $num_rows;	
		//echo "<br>Rows: ".$num_rows;
	}	
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
                  <td width="25%" align="left" valign="middle" class="heading-text">Duplicate Companies</td>
				  <td width="75%" valign="middle" class="message" align="left"><?=$msg?></td>
                  
                </tr>
              </table></td>
          </tr>
          <tr>
            <td align="left" valign="top" class="right-bar-content-border-box">
			
		  <form name="exportfile" method="post" action="company-master-duplicates.php?action=FindDuplicates">
		  
			<table width="90%" border="0" cellspacing="0" cellpadding="5">
			  <tr><td colspan="2" height="20">&nbsp;</td></tr>
			  
			  
			  <tr>
                <td width="90" align="left" valign="top">Enter Value:</td>
                <td align="left" valign="top">
                  <input type="text" name="dup_text" id="dup_text" size="30" value="" />
                </td>
              </tr>
			  
			  <tr>
                <td colspan="2" align="left" valign="top"><input type="radio" name="dup_opt" value="name">Company Name</td>
                
              </tr>
              <tr>
                <td colspan="2" align="left" valign="top"><input type="radio" name="dup_opt" value="url">Company URL</td>
                
              </tr>
             
			 
			   <tr>
			     <td>&nbsp;</td>
			     <td align="left" valign="top">&nbsp;</td>
			     </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td align="left" valign="top"><input type="submit" name="Submit" value="Find Duplicate Companies" class="submitButton" /></td>
			     </tr>
			   <tr>
			     <td>&nbsp;</td>
			     <td align="left" valign="top">&nbsp;</td>
			     </tr>
				 
				 <?PHP
				 //echo "<br>Num_rows:".$num_rows;
				  if($num_rows > 1)
				  {
					$sql_query_comp_ids = "select group_concat(c.company_id) as comp_ids from " . TABLE_COMPANY_MASTER . " as c where  ". $search_qry." order by c.company_id desc";
					//echo "<br>group_concat Q: ".$sql_query_comp_ids;	
					$exe_data_comp_ids = com_db_query($sql_query_comp_ids);
					$data_concat_comp_ids = com_db_fetch_array($exe_data_comp_ids);
					$comp_ids = $data_concat_comp_ids['comp_ids'];
					//echo "<br>comp_ids: ".$comp_ids;
					
				  ?>
				  <tr>
			<!-- <td>
				 <table width="90%" border="0" cellspacing="0" cellpadding="5">
				  <tr> -->
					<td colspan="2"><h2>Duplicate Companies</h2></td>
				  </tr>	
					
					<tr>
						<td colspan="2">
							<table width="100%">
								<tr>
									<td width="35%"><h3>Company Name</h3></td>
									<td><h3>Company Website</h3></td>
									<td width="20%"><h3>Action</h3></td>
								</tr>	
				 
		  
								<?PHP
								
								while ($data_sql = com_db_fetch_array($exe_data)) {
								
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
								<tr><td><?=$comp_name?></td><td><?=$comp_web?></td><td><a style="color:#064962;" href="company-master-duplicates.php?primary=<?=$comp_id?>&secondary=<?=$removed_this_id?>&action=primarySetup">Make it primary</a></td></tr>
								<?PHP
								}
								?> 
							</table>	
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
			</form>
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