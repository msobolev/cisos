<?php
require('includes/include_top.php');
include('includes/include_editor.php');

$items_per_page = isset($_REQUEST["items_per_page"]) ? $_REQUEST["items_per_page"] : 20;
$p = isset($_REQUEST["p"]) ? $_REQUEST["p"] : 1;
$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';


$sql_query = "select * from " . TABLE_SITEMAP . " order by sitemap_id desc";
/***************** FOR PAGIN ***********************/
$starting_point = $items_per_page * ($p - 1);
/****************** END PAGIN ***********************/
$main_page = 'create-sitemap.php';

$exe_query=com_db_query($sql_query);
$num_rows=com_db_num_rows($exe_query);
$total_data = $num_rows;

/************ FOR PAGIN **************/
$sql_query .= " LIMIT $starting_point,$items_per_page";
$exe_data = com_db_query($sql_query);

$numRows = com_db_num_rows($exe_data);
/************ END ********************/


$fID = (isset($_GET['fID']) ? $_GET['fID'] : $select_data[0]);

    switch ($action) {
		
	  case 'delete':
	   		$file_name = com_db_GetValue("select sitemap_name from " . TABLE_SITEMAP . " where sitemap_id = '" . $fID . "'");
			if(file_exists("../".$file_name)){
				unlink("../".$file_name);
			}
			com_db_query("delete from " . TABLE_SITEMAP . " where sitemap_id = '" . $fID . "'");
		 	com_redirect("create-sitemap.php?p=" . $p . "&selected_menu=sitemap&msg=" . msg_encode("Sitemap deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$sitemap_id = $_POST['nid'];
			for($i=0; $i< sizeof($sitemap_id) ; $i++){
				$file_name = com_db_GetValue("select sitemap_name from " . TABLE_SITEMAP . " where sitemap_id = '" . $sitemap_id[$i] . "'");
				if(file_exists("../".$file_name)){
					unlink("../".$file_name);
				}
				com_db_query("delete from " . TABLE_SITEMAP . " where sitemap_id = '" . $sitemap_id[$i] . "'");
			}
		 	com_redirect("create-sitemap.php?p=" . $p . "&selected_menu=sitemap&msg=" . msg_encode("Sitemap deleted successfully"));
		
		break;	
		
	
	case 'addsave':
			com_db_query("delete from " . TABLE_SITEMAP . " where 1");
			$added=date('Y-m-d');
			$url_query = "select page_name,sitemap_order from " .TABLE_META_TAG ." where sitemap_order <>'' order by sitemap_order";
			$url_result = com_db_query($url_query);
			if($url_result){
				$file_name = '../sitemapallpage.xml';
				$sitemap_name = 'sitemapallpage.xml';
				$fp=fopen($file_name,"w");
				$tot_url = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
							'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
				$tot_url .= "<url>
								<loc>".HTTP_SITE_URL."</loc>
								<lastmod>".date('Y-m-d')."</lastmod>
								<changefreq>monthly</changefreq>
								<priority>0.0</priority>
							 </url>\n";
				while($url_row = com_db_fetch_array($url_result)){
					$tot_url .= "<url>
									<loc>".HTTP_SITE_URL.$url_row['page_name']."</loc>
									<lastmod>".date('Y-m-d')."</lastmod>
									<changefreq>monthly</changefreq>
									<priority>".$url_row['sitemap_order']."</priority>
								 </url>\n";
				}
				//reminder priority
				$url_query1 = "select page_name,sitemap_order from " .TABLE_META_TAG ." where page_name <>'Default' and sitemap_order=''";
				$url_result1 = com_db_query($url_query1);
				while($url_row = com_db_fetch_array($url_result1)){
					$tot_url .= "<url>
									<loc>".HTTP_SITE_URL.$url_row['page_name']."</loc>
									<lastmod>".date('Y-m-d')."</lastmod>
									<changefreq>monthly</changefreq>
								 </url>\n";
				}			
				$tot_url .= '</urlset>';
				fwrite($fp, $tot_url);
				fclose($fp);
				$query = "insert into " . TABLE_SITEMAP . " (sitemap_name, add_date) values ('$sitemap_name', '$added')";
				com_db_query($query);
			}
			$url_query = "select contact_url from " .TABLE_CONTACT ." where status='0' order by first_name";
			$url_result = com_db_query($url_query);
			$count_url = 1;
			$num_of_file = 1;
			$file_name = '../sitemapfile'.$num_of_file.'.xml';
			$sitemap_name = 'sitemapfile'.$num_of_file.'.xml';
			$fp=fopen($file_name,"w");
			$tot_url = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
						'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
						

			$num_of_file++;
			while($url_row = com_db_fetch_array($url_result)){
				if($count_url == '1000'){
					$count_url = 1;	
					$file_name = '../sitemapfile'.$num_of_file.'.xml';
					$sitemap_name = 'sitemapfile'.$num_of_file.'.xml';
					$fp=fopen($file_name,"w");
					$num_of_file++;
					
				}
				$tot_url .= '<url><loc>'.HTTP_SITE_URL.$url_row['contact_url']."</loc><changefreq>monthly</changefreq></url>\n";
				$count_url++;
				if($count_url >= 1000){
					$tot_url .= '</urlset>';
					fwrite($fp, $tot_url);
					fclose($fp);
					$query = "insert into " . TABLE_SITEMAP . " (sitemap_name, add_date) values ('$sitemap_name', '$added')";
					com_db_query($query);
					$tot_url = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
						'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
				}
				
			}
			if($count_url < 1000){
				$tot_url .= '</urlset>';
				fwrite($fp, $tot_url);
				fclose($fp);
				$query = "insert into " . TABLE_SITEMAP . " (sitemap_name, add_date) values ('$sitemap_name', '$added')";
				com_db_query($query);
			}
			
			//main sitemap create
			$url_query = "select sitemap_name from " .TABLE_SITEMAP ;
			$url_result = com_db_query($url_query);
			if($url_result){
				$file_name = '../sitemap.xml';
				$sitemap_name = 'sitemap.xml';
				$fp=fopen($file_name,"w");
				

				$tot_url = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
							'<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
				while($url_row = com_db_fetch_array($url_result)){
					$tot_url .= '<sitemap><loc>'.HTTP_SITE_URL.$url_row['sitemap_name']."</loc><lastmod>".date('Y-m-d')."</lastmod></sitemap>"."\n";
				}			
				$tot_url .= '</sitemapindex>';
				fwrite($fp, $tot_url);
				fclose($fp);
				$query = "insert into " . TABLE_SITEMAP . " (sitemap_name, add_date) values ('sitemap.xml', '$added')";
				com_db_query($query);
			}
			
	  		com_redirect("create-sitemap.php?p=" . $p . "&selected_menu=sitemap&msg=" . msg_encode("Sitemap create successfully"));
		break;	
		
				
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(nid,p){
	var agree=confirm("Sitemap will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "create-sitemap.php?selected_menu=sitemap&fID=" + nid + "&p=" + p + "&action=delete";
	else
		window.location = "create-sitemap.php?selected_menu=sitemap&fID=" + nid + "&p=" + p ;
}

function CheckAll(numRows){
	if(document.getElementById('all').checked){
		for(i=1; i<=numRows; i++){
			var sitemap_id='sitemap_id-'+ i;
			document.getElementById(sitemap_id).checked=true;
		}
	} else {
		for(i=1; i<=numRows; i++){
			var sitemap_id='sitemap_id-'+ i;
			document.getElementById(sitemap_id).checked=false;
		}
	}
}

function AllDelete(numRows){

	var flg=0;
	for(i=1; i<=numRows; i++){
			var sitemap_id='sitemap_id-'+ i;
			if(document.getElementById(sitemap_id).checked){
				flg=1;
			}	
		}
	if(flg==0){
		alert("Please checked atlist one checkbox for delete.");
		document.getElementById('sitemap_id-1').focus();
		return false;
	} else {
		var agree=confirm("Sitemap will be deleted. \n Do you want to continue?");
		if (agree)
			 document.topicform.submit();
		else
			window.location = "create-sitemap.php?selected_menu=sitemap";
	}	

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

<?php if(($action == '') || ($action == 'save')){	?>			

		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
          <tr>
            <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="32%" align="left" valign="middle" class="heading-text">Sitemap Manager</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <td width="8%" align="right" valign="middle"><a href="#"><img src="images/add-icon.jpg" border="0" width="25" height="28" alt="Add Sitemap" question="Add Sitemap" onclick="window.location='create-sitemap.php?action=addsave&selected_menu=sitemap'"  /></a></td>
                  <td width="14%" align="left" valign="middle" class="nav-text">Create Sitemap  </td>
                  <td width="3%" align="right" valign="middle"><a href="#"><img src="images/delete-icon.jpg" border="0" width="25" height="28"  alt="Delete Sitemap" question="Delete Sitemap" onclick="AllDelete('<?=$numRows?>');"  /></a></td>
                  <td width="9%" align="left" valign="middle" class="nav-text">Delete</td>
                </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="create-sitemap.php?action=alldelete&selected_menu=sitemap" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="23" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-question-text">#</span></td>
				<td width="32" height="30" align="center" valign="middle" class="right-border">
				<input type="checkbox" name="all" id="all" onclick="CheckAll('<?=$numRows?>');" /></td>
				<td width="543" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">File Name </span> </td>
				
				<td width="256" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
				<td width="107" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			
			if($total_data>0) {
				$i=1;
				while ($data_sql = com_db_fetch_array($exe_data)) {
				$added_date = $data_sql['add_date'];
			
			?>          
			  <tr>
				<td height="30" align="center" valign="middle" class="right-border-left"><?=$i;?></td>
				<td height="30" align="center" valign="middle" class="right-border"><input type="checkbox" id="sitemap_id-<?=$i;?>" name="nid[]" value="<?=$data_sql['sitemap_id'];?>" /></td>
				<td height="30" align="left" valign="middle" class="right-border-text"><a href="../<?=com_db_output($data_sql['sitemap_name'])?>" target="_blank"><?=com_db_output($data_sql['sitemap_name'])?></a></td>
				
				<td height="30" align="center" valign="middle" class="right-border"><?=$added_date;?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	
						<td width="24%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" question="Delete" border="0" onclick="confirm_del('<?=$data_sql['sitemap_id'];?>','<?=$p;?>')" /></a><br />
						  Delete</td>
					  </tr>
					</table>				</td>
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
  
<?php } 

include("includes/footer.php");
?>
