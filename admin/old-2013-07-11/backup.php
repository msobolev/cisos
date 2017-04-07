<?php
require('includes/include_top.php');

$action = (isset($_GET['action']) ? $_GET['action'] : '');
$msg = (isset($_GET['msg'])) ? msg_decode($_GET['msg']) : '';



    switch ($action) {
		
	  case 'Backup':
			
				//com_set_time_limit(0);
				set_time_limit(0);
				
				$backup_file = 'db_ctou2-' . date('YmdHis') . '.sql';
				$fp = fopen('backup/' . $backup_file, 'w');
		
				$schema = '# http://www.ctosonthemove.com' . "\n" .
						  '#' . "\n" .
						  '# Database Backup For CTOsOnTheMove.com' . "\n" .
						  '# Copyright (c) ' . date('Y') . ' CTOsOnTheMove.com ' . "\n" .
						  '#' . "\n" .
						  '# Database: ' . 'ctou2' . "\n" .
						  '#' . "\n" .
						  '# Backup Date: ' . date('YmdHis') . "\n\n";
				fputs($fp, $schema);
				$tables_query = com_db_query('show tables');
					 
					 while ($tables = com_db_fetch_array($tables_query)) {
					  list(,$table) = each($tables);
			
					  $schema = 'drop table if exists ' . $table . ';' . "\n" .
								'create table ' . $table . ' (' . "\n";
			
					  $table_list = array();
					  $fields_query = com_db_query("show fields from " . $table);
					 while ($fields = com_db_fetch_array($fields_query)) {
						$table_list[] = $fields['Field'];
			
						$schema .= '  ' . $fields['Field'] . ' ' . $fields['Type'];
			
						if (strlen($fields['Default']) > 0) $schema .= ' default \'' . $fields['Default'] . '\'';
			
						if ($fields['Null'] != 'YES') $schema .= ' not null';
			
						if (isset($fields['Extra'])) $schema .= ' ' . $fields['Extra'];
			
						$schema .= ',' . "\n";
					  }
			
					  $schema = ereg_replace(",\n$", '', $schema);
			
					// add the keys
					  $index = array();
					  $keys_query = com_db_query("show keys from " . $table);
					  while ($keys = com_db_fetch_array($keys_query)) {
						$kname = $keys['Key_name'];
			
						if (!isset($index[$kname])) {
						  $index[$kname] = array('unique' => !$keys['Non_unique'],
												 'fulltext' => ($keys['Index_type'] == 'FULLTEXT' ? '1' : '0'),
												 'columns' => array());
						}
			
						$index[$kname]['columns'][] = $keys['Column_name'];
					  }
			
					  while (list($kname, $info) = each($index)) {
						$schema .= ',' . "\n";
			
						$columns = implode($info['columns'], ', ');
			
						if ($kname == 'PRIMARY') {
						  $schema .= '  PRIMARY KEY (' . $columns . ')';
						} elseif ( $info['fulltext'] == '1' ) {
						  $schema .= '  FULLTEXT ' . $kname . ' (' . $columns . ')';
						} elseif ($info['unique']) {
						  $schema .= '  UNIQUE ' . $kname . ' (' . $columns . ')';
						} else {
						  $schema .= '  KEY ' . $kname . ' (' . $columns . ')';
						}
					  }
			
					  $schema .= "\n" . ');' . "\n\n";
					  fputs($fp, $schema);
						
						
						
						
					$rows_query = com_db_query("select " . implode(',', $table_list) . " from " . $table);
					while ($rows = com_db_fetch_array($rows_query)) {
					  $schema = 'insert into ' . $table . ' (' . implode(', ', $table_list) . ') values (';
		
					  reset($table_list);
					  while (list(,$i) = each($table_list)) {
						if (!isset($rows[$i])) {
						  $schema .= 'NULL, ';
						} elseif (com_not_null($rows[$i])) {
						  $row = addslashes($rows[$i]);
						  $row = ereg_replace("\n#", "\n".'\#', $row);
		
						  $schema .= '\'' . $row . '\', ';
						} else {
						  $schema .= '\'\', ';
						}
					  }
		
					  $schema = ereg_replace(', $', '', $schema) . ');' . "\n";
					  fputs($fp, $schema);
				   }
				  }
			fclose($fp);
			if(isset($_POST['only_download'])=='OnlyDownload'){
				header('Content-type: application/x-octet-stream');
				header('Content-disposition: attachment; filename=' . $backup_file);
				readfile('backup/' . $backup_file);
				unlink('backup/' . $backup_file);
			}
	
			com_redirect("backup.php?selected_menu=others");
	
		break;	
		
	  case 'RestoreNow':
	  	   $restore_file_name = $_POST['rfname'];
		   
		   $file_path = 'backup/';
		   if(file_exists($file_path.$restore_file_name)){
		   	$restore_query = fread(fopen($file_path.$restore_file_name, 'r'), filesize($file_path.$restore_file_name));
		   }	
        
		  set_time_limit(0); 
          $sql_array = array();
          $drop_table_names = array();
          $sql_length = strlen($restore_query);
          $pos = strpos($restore_query, ';');
          for ($i=$pos; $i<$sql_length; $i++) {
            if ($restore_query[0] == '#') {
              $restore_query = ltrim(substr($restore_query, strpos($restore_query, "\n")));
              $sql_length = strlen($restore_query);
              $i = strpos($restore_query, ';')-1;
              continue;
            }
            if ($restore_query[($i+1)] == "\n") {
              for ($j=($i+2); $j<$sql_length; $j++) {
                if (trim($restore_query[$j]) != '') {
                  $next = substr($restore_query, $j, 6);
                  if ($next[0] == '#') {
					// find out where the break position is so we can remove this line (#comment line)
                    for ($k=$j; $k<$sql_length; $k++) {
                      if ($restore_query[$k] == "\n") break;
                    }
                    $query = substr($restore_query, 0, $i+1);
                    $restore_query = substr($restore_query, $k);
					// join the query before the comment appeared, with the rest of the dump
                    $restore_query = $query . $restore_query;
                    $sql_length = strlen($restore_query);
                    $i = strpos($restore_query, ';')-1;
                    continue 2;
                  }
                  break;
                }
              }
              if ($next == '') { // get the last insert query
                $next = 'insert';
              }
              if ( (eregi('create', $next)) || (eregi('insert', $next)) || (eregi('drop t', $next)) ) {
                $query = substr($restore_query, 0, $i);

                $next = '';
                $sql_array[] = $query;
                $restore_query = ltrim(substr($restore_query, $i+1));
                $sql_length = strlen($restore_query);
                $i = strpos($restore_query, ';')-1;

                if (eregi('^create*', $query)) {
                  $table_name = trim(substr($query, stripos($query, 'table ')+6));
                  $table_name = substr($table_name, 0, strpos($table_name, ' '));

                  $drop_table_names[] = $table_name;
                }
              }
            }
          }

          com_db_query('drop table if exists ' . implode(', ', $drop_table_names));
		 //var_dump($sql_array);
          for ($i=0, $n=sizeof($sql_array); $i<$n; $i++) {
            com_db_query($sql_array[$i]);
          }

          //if (isset($remove_raw) && ($remove_raw == true)) {
            //unlink($restore_from);
          //}

           com_redirect("backup.php?selected_menu=others&msg=" . msg_encode("Backup file restore successfully"));       
		break;
		
	  case 'delete':
	   		$file_name = $_REQUEST['fname'];
			$file_path = "backup/";
			if(file_exists($file_path.$file_name)){
				unlink($file_path.$file_name);
			}
			//com_db_query("delete from " . TABLE_NEWS . " where news_id = '" . $nID . "'");
		 	com_redirect("backup.php?selected_menu=others&msg=" . msg_encode("File deleted successfully"));
		
		break;
		
	  case 'alldelete':
	   		$news_id = $_POST['nid'];
			for($i=0; $i< sizeof($news_id) ; $i++){
				com_db_query("delete from " . TABLE_NEWS . " where news_id = '" . $news_id[$i] . "'");
			}
		 	com_redirect("backup.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("News deleted successfully"));
		
		break;	
		
	  case 'edit':
     		
	   		$query_edit=com_db_query("select * from " . TABLE_NEWS . " where news_id = '" . $nID . "'");
	  		$data_edit=com_db_fetch_array($query_edit);
			$details=com_db_output($data_edit['news_details']);
			$title=com_db_output($data_edit['news_title']);
			$adt = explode('-',$data_edit['add_date']);
			if(sizeof($adt)==3){
				$add_date = $adt[1].'/'.$adt[2].'/'.$adt[0];
			}else{
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
			$query = "update " . TABLE_NEWS . " set news_title = '" . $title . "',  news_details = '" . $detailes . "', add_date='".$added."' where news_id = '" . $nID . "'";
			com_db_query($query);
	  		com_redirect("backup.php?p=". $p ."&nID=" . $nID . "&selected_menu=others&msg=" . msg_encode("News update successfully"));
		 
		break;		
		
	  
		
	case 'addsave':
			
			$title=com_db_input($_POST['title']);
			$detailes=com_db_input($_POST['detailes']);
			$add_date = $_POST['add_date'];
			if($add_date==''){
				$added=date('Y-m-d');
			}else{
				$adt = explode('/',$add_date);//mm/dd/yyyy
				$added=$adt[2].'-'.$adt[0].'-'.$adt[1];
			}	
			
			$query = "insert into " . TABLE_NEWS . " (news_title, news_details, add_date, status) values ('$title', '$detailes', '$added', '0')";
			com_db_query($query);
	  		com_redirect("backup.php?p=" . $p . "&selected_menu=others&msg=" . msg_encode("New news added successfully"));
		 
		break;	
		
	
    }
	


include("includes/header.php");
?>
<script type="text/javascript">
function confirm_del(fname){
	var agree=confirm("Backup file will be deleted. \n Do you want to continue?");
	if (agree)
		window.location = "backup.php?selected_menu=others&fname=" + fname + "&action=delete";
	else
		window.location = "backup.php?selected_menu=others" ;
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
                  <td width="30%" align="left" valign="middle" class="heading-text">Backup Manager</td>
                  <td width="34%" align="left" valign="middle" class="message"><?=$msg?></td>
                  <td width="8%" align="right" valign="middle"><input type="button" value="Backup" onclick="window.location='backup.php?selected_menu=others&action=Add'" /></td>
                  
                  </tr>
              </table></td>
          </tr>
       
          <tr>
            <td align="left" valign="top" class="right-bar-content-border">
			<form name="topicform" action="backup.php?action=alldelete&selected_menu=others" method="post">
			<table width="100%" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="415" height="30" align="center" valign="middle" class="right-border-left"><span class="right-box-title-text">File Name </span> </td>
				<td width="228" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Size</span> </td>
				<td width="169" height="30" align="center" valign="middle" class="right-border"><span class="right-box-title-text">Date</span> </td>
				<td width="149" height="30" align="center" valign="middle" class="left-border"><div align="center"><span class="right-box-title-text">Action</span></div></td>
			  </tr>
			<?php
			$backup_path = 'backup/';
			$dir = dir($backup_path);
			$contents = array();
			while ($file = $dir->read()) {
			  if (!is_dir(backup_path . $file) && in_array(substr($file, -3), array('zip', 'sql', '.gz'))) {
				$contents[] = $file;
			  }
			}
			sort($contents);

			for ($i=0, $n=sizeof($contents); $i<$n; $i++) {
			  $entry = $contents[$i];
				
			?>          
			  <tr>
				<td height="30" align="left" valign="middle" class="right-border-left"><?=$entry?></td>
				<td height="30" align="center" valign="middle" class="right-border"><?= number_format(filesize($backup_path . $entry)) . ' bytes';?></td>
				<td height="30" align="center" valign="middle" class="right-border"><?=date('Y-m-d H:i:s', filemtime($backup_path . $entry))?></td>
				<td height="30" align="center" valign="middle" class="left-border">
					<table width="83%" border="0" align="center" cellpadding="0" cellspacing="0">
					  <tr> 
					  	<td width="24%" align="center" valign="middle"><a href="backup.php?selected_menu=others&action=Restore&fname=<?=$entry?>"><img src="images/icon/restore-icongif.gif" width="16" height="16" alt="" title="" border="0"/></a><br />
						  Restore</td>
						<td width="24%" align="center" valign="middle"><a href="#"><img src="images/small-delet-icon.gif" width="16" height="16" alt="Delete" title="Delete" border="0" onclick="confirm_del('<?=$entry?>')" /></a><br />
						  Delete</td>
					  </tr>
					</table>				</td>
         	</tr> 
			<?php
			}
			$dir->close();
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

  
<?php } elseif($action=='Add'){?>		

			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Backup Manager :: Backup Now </td>
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
		<form name="DateTest" method="post" action="backup.php?action=Backup">
		<tr>
		  <td width="24%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;&nbsp;Backup Instruction :</td>
		  <td width="76%" align="left" valign="top" class="page-text">Do not interrupt the backup process which might take a couple of minutes.<br />
		    <br />
		    <input type="radio" name="pure_sql" id="pure_sql" value="1" checked="checked" /> No Compression (Pure SQL)<br />
		    <br />
		    <input type="checkbox" name="only_download" id="only_download" value="OnlyDownload" />Download only (do not store server side)<br /><br />
		   </td>	
		</tr>
		<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Backup Now" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='backup.php?selected_menu=others'" /></td></tr>
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
} else if($action=='Restore'){ ?>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
              <td align="center" valign="middle" class="right"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="50%" align="left" valign="middle" class="heading-text">Backup Manager :: Backup Now </td>
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
		<form name="frmRestore" method="post" action="backup.php?action=RestoreNow">
		<tr>
		  <td width="24%" align="left" valign="top"  class="page-text">&nbsp;&nbsp;&nbsp;Restore Instruction :</td>
		  <td width="76%" align="left" valign="top" class="page-text">
		  <input type="hidden" name="rfname" if="rfname" value="<?=$_REQUEST['fname'];?>" />
		  Do not interrupt the restoration process.<br /><br />
		   The larger the backup, the longer this process takes!<br /><br />

			If possible, use the mysql client.<br /><br />
		   </td>	
		</tr>
		<tr><td align="left" valign="top">&nbsp;</td><td align="left" valign="top"><input type="submit" value="Restore Now" class="submitButton" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" class="submitButton" value="cancel" onclick="window.location='backup.php?selected_menu=others'" /></td></tr>
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

<?
}
include("includes/footer.php");
?>