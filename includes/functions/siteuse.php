<?php
function Left_Menu_Show($count){
		$query_menu = "SELECT menu_id, title from " . TABLE_MENU . " WHERE parent_id='0' and status='0' order by menuorder limit 0, $count";
		$menu_result = com_db_query($query_menu);
		$menu_list = '';
		while($menu_row = com_db_fetch_array($menu_result)){
			$is_chield = com_db_GetValue("select menu_id from " . TABLE_MENU . " where parent_id ='".$menu_row['menu_id']."'");
			if($is_chield > 0 ){
				$ch='yes';
			}else{
				$ch='no';
			}
			
			if($_GET['mID']==$menu_row['menu_id']) {
				$menu_list .= '<tr>
                <td align="left" valign="top" class="menu"><a class="active" href="menu-details.php?ch='.$ch.'&pID=0&mID='.$menu_row['menu_id'].'">'.com_db_output($menu_row['title']).'</a></td></tr>';
			} else {
			$menu_list .= '<tr>
                <td align="left" valign="top" class="menu"><a href="menu-details.php?ch='.$ch.'&pID=0&mID='.$menu_row['menu_id'].'">'.com_db_output($menu_row['title']).'</a></td></tr>';
			}
		}
		return $menu_list;
	}
	
function Left_Menu_Show_other($count){	
		
		$query = com_db_query("SELECT menu_id, title from " . TABLE_MENU . " WHERE parent_id='0' and status='0'");
		$num_row = com_db_num_rows($query);
		$end=($num_row-$count);
		
		$query_menu = "SELECT menu_id, title from " . TABLE_MENU . " WHERE parent_id='0' and status='0' order by menuorder limit $count, $end";
		$menu_result = com_db_query($query_menu);
		$menu_list = '';
		while($menu_row = com_db_fetch_array($menu_result)){
			$is_chield = com_db_GetValue("select menu_id from " . TABLE_MENU . " where parent_id ='".$menu_row['menu_id']."'");
			if($is_chield > 0 ){
				$ch='yes';
			}else{
				$ch='no';
			}
			
			if($_GET['mID']==$menu_row['menu_id']) {
				$menu_list .= '<tr>
                <td align="left" valign="top" class="menu"><a class="active" href="menu-details.php?ch='.$ch.'&pID=0&mID='.$menu_row['menu_id'].'">'.com_db_output($menu_row['title']).'</a></td></tr>';
			} else {
			$menu_list .= '<tr>
                <td align="left" valign="top" class="menu"><a href="menu-details.php?ch='.$ch.'&pID=0&mID='.$menu_row['menu_id'].'">'.com_db_output($menu_row['title']).'</a></td></tr>';
			}
		}
		return $menu_list;
	}
	
	
	
	
	
function Sub_Menu_Show($pID){
		$query_menu = "SELECT menu_id,parent_id, title from " . TABLE_MENU . " WHERE parent_id='".$pID."' and status='0' order by menuorder";
		$menu_result = com_db_query($query_menu);
		$num_rows = com_db_num_rows($menu_result);
		$flag=$num_rows%2;
		
		
		
		$submenu_list='';
		$submenu_list .='<table width="460" border="0" align="left" cellpadding="0" cellspacing="0">';
		
		$i=0;
		while($submenu_row = com_db_fetch_array($menu_result)){
		if($i==0){
			$submenu_list .= '<tr>';	
		}
		
		$submenu_list .= '<td width="230" align="left" valign="top"  class="information-link-text"><a href="menu-details.php?ch=yes&pID='.$submenu_row['parent_id'].'&mID='.$submenu_row['menu_id'].'">'.com_db_output($submenu_row['title']).'</a></td>'; 
			if($i==1){
				$submenu_list .= '</tr>';
				$i=0;	
			} else{
				$i++;
			}
		}
		
		if($flag!=0){
			$submenu_list .= '</tr>';
		}
		
		$submenu_list .= '</table>';
		
		
		
		return $submenu_list;
	}
	
function what_we_treat_Menu_Show(){
		$wid = $_REQUEST['wid'];
		$query_menu = "SELECT what_id, title from " . TABLE_WHAT_WE_TREAT . " WHERE status='0'";
		$menu_result = com_db_query($query_menu);
		$num_rows = com_db_num_rows($menu_result);
		$flag=$num_rows%2;
		
		$what_list='';
		$what_list .='<table width="460" border="0" align="left" cellpadding="0" cellspacing="0">';
		
		$i=0;
		while($what_row = com_db_fetch_array($menu_result)){
		if($i==0){
			$what_list .= '<tr>';	
		}
		
		if($wid==$what_row['what_id']){
			$what_list .= '<td width="230" align="left" valign="top" class="information-link-text"><a href="what-we-treat.php?wid='.$what_row['what_id'].'" class="active">'.com_db_output($what_row['title']).'</a></td>';
		} else {
			$what_list .= '<td width="230" align="left" valign="top" class="information-link-text"><a href="what-we-treat.php?wid='.$what_row['what_id'].'">'.com_db_output($what_row['title']).'</a></td>';
		}
		 
			if($i==1){
				$what_list .= '</tr>';
				$i=0;	
			} else{
				$i++;
			}
		}
		
		if($flag!=0){
			$what_list .= '</tr>';
		}
		
		$what_list .= '</table>';
		
		return $what_list;
	}
		
function Left_Menu_News(){
		$query_news = "SELECT news_id, news_title, short_desc from " . TABLE_NEWS . " WHERE status='0' order by rand() limit 0, 3";
		$news_result = com_db_query($query_news);
		$news_list = '';
		$news_list = '<table width="252" border="0" align="right" cellpadding="0" cellspacing="0">
					  <tr>
						<td width="252" align="center" valign="top"><img src="images/spacer.gif" width="1" height="25" alt="" title="" /></td>
					  </tr>
					  <tr>
						<td align="left" valign="top"><h1>Acupuncture news</h1></td>
					  </tr>';
		
		while($news_row = com_db_fetch_array($news_result)){
			$news_list .= '<tr>
							<td align="center" valign="top"><img src="images/spacer.gif" width="1" height="30" alt="" title="" /></td>
						  </tr>';
			$news_list .= ' <tr>
							<td align="left" valign="top" class="acupuncture-news-text"><b>'.com_db_output($news_row['news_title']).'</b>'.com_db_output($news_row['short_desc']).'</td>
						  </tr>';
		}
		
		$news_list .= '<tr>
						<td align="center" valign="top"><img src="images/spacer.gif" width="1" height="33" alt="" title="" /></td>
					  </tr>
					  <tr>
						<td align="right" valign="top" class="read-more-text"><a href="news.php">Read more news</a></td>
					  </tr>
					  <tr>
						<td align="center" valign="top"><img src="images/spacer.gif" width="1" height="15" alt="" title="" /></td>
					  </tr>
					</table>';
		
		return $news_list;
	}
	
function Left_Menu_Blog(){
		$btime = mktime(0,0,0,date('m')-1,date('d'),date('Y'));
		$query_blog = "SELECT blog_id, blog_title, blog_short, author, add_date from " . TABLE_BLOG . " WHERE status='0' and add_date > $btime order by add_date desc";
		$blog_result = com_db_query($query_blog);
		$blog_list = '';
		
		$blog_list = '<table width="252" border="0" align="right" cellpadding="0" cellspacing="0">
						  <tr>
							<td width="252" align="center" valign="top"><img src="images/spacer.gif" width="1" height="25" alt="" title="" /></td>
						  </tr>
						  <tr>
							<td align="left" valign="top"><h3>Topic of the month</h3></td>
						  </tr>
						  <tr>
							<td align="center" valign="top"><img src="images/spacer.gif" width="1" height="30" alt="" title="" /></td>
						  </tr>';
		
		while($blog_row = com_db_fetch_array($blog_result)){
			
			
			 $blog_list .= '<tr>
							 <td align="left" valign="top" class="acupuncture-news-text"><b>'.com_db_output($blog_row['blog_title']).'</b></td>
							</tr>';
			$blog_list .= '<tr>
							<td align="left" valign="middle" class="spoken-link-text"><table width="252" border="0" align="center" cellpadding="0" cellspacing="0">
								<tr>
								  <td align="left" valign="top" class="date-box">'. date('d', $blog_row['add_date']).'</td>
								  <td align="left" valign="middle" class="comment-box-text">Posted by '.com_db_output($blog_row['author']).' <em></td>
								</tr>
							</table></td>
						  </tr>
						  <tr>
						  <td  align="center" valign="top"><img src="images/spacer.gif" width="1" height="5" alt="" title="" /></td>
						  </tr>
						  <tr>
							<td align="left" valign="top" class="acupuncture-news-text">'.com_db_output($blog_row['blog_short']).'.....</td>
						  </tr>';
			
		}
		
		$blog_list .= '<tr>
						<td align="left" valign="top">&nbsp;</td>
					  </tr>
					  <tr>
					   <td align="right" valign="top" class="read-more-text"><a href="blog.php">Read more post</a></td>
					  </tr>
					  <tr>
						<td align="left" valign="top">&nbsp;</td>
					  </tr>
					</table>';
		
		return $blog_list;
	}
function Left_Menu_FAQ(){
		$query_faq = "SELECT faq_id, faq_que from " . TABLE_FAQ . " WHERE status='0' order by add_date desc limit 0,1";
		$faq_result = com_db_query($query_faq);
		$faq_row = com_db_fetch_array($faq_result);
		$faq_list = '<a href="faq.php?fID='.$faq_row['faq_id'].'">'.com_db_output($faq_row['faq_que']).'</a><br>';
		$faq_list .= '<a href="faq.php">More >></a><br>';
		return $faq_list;
	}
	
function HomePagePhoto(){
		$i=0;
		$photo_list = '';
		$photo_list .= '<table width="688" border="0" align="center" cellpadding="0" cellspacing="0">
                		  <tr>';
		$sql_photo=com_db_query("select * from " . TABLE_PHOTO . " order by photo_id desc");
		while($data_sql=com_db_fetch_array($sql_photo)){	
			$photo='uploade-image/thumb/' . $data_sql['image'];
			if($i==0){
				$photo_list .= '<td width="228" align="left" valign="top"><table width="183" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
						  <td align="left" valign="top"><table width="183" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="17" height="13" align="left" valign="top"><img src="images/box1-top-left.jpg" width="17" height="14" alt=""  title=""/></td>
							  <td height="13" align="left" valign="top" class="box1-top-border"><img src="images/spacer.gif" width="1" height="13" alt="" title="" /></td>
							 <td width="17" height="13" align="left" valign="top"><img src="images/box1-top-right.jpg" width="17" height="14" alt=""  title=""/></td>
							</tr>
						  </table></td>
						</tr>
						<tr>
						  <td align="left" valign="top" class="box1-border">' . com_db_output($data_sql['title']) . '</td>
						</tr>
						<tr>
						  <td align="left" valign="top"><img src="images/box1-inner-top.jpg" width="183" height="11" alt="" title="" /></td>
						</tr>
						<tr>
						  <td align="center" valign="top" class="box1-inner-box"><table width="169" border="0" align="center" cellpadding="0" cellspacing="0">
							<tr>
							  <td align="left" valign="top" class="box1-inner-box-pic-border">' . com_setImage($photo,'167','','') . '</td>
							</tr>
							<tr>
							  <td align="left" valign="top">&nbsp;</td>
							</tr>
							<tr>
							  <td align="left" valign="top">' . com_db_output($data_sql['short_desc']) . '</td>
							</tr>
						  </table></td>
						</tr>
						<tr>
						  <td align="left" valign="top"><img src="images/box1-inner-bottom.jpg" width="183" height="11" alt="" title="" /></td>
						</tr>
						<tr>
						  <td align="left" valign="top"><table width="183" border="0" cellspacing="0" cellpadding="0">
							<tr>
							  <td width="32" height="32" align="left" valign="top"><img src="images/box1-bottom-left.jpg" width="32" height="32" alt=""  title=""/></td>
	
							  <td height="13" align="center" valign="middle" class="box1-bottom-border"><img src="images/spacer.gif" width="1" height="13" alt="" title="" /><a href="foto.php?pid='. $data_sql['photo_id'] .'"><img src="images/box1-readmore-buttn.jpg"  alt="" width="99" height="22" border="0" title="" /></a></td>
							  <td width="32" height="32" align="left" valign="top"><img src="images/box1-bottom-right.jpg" width="32" height="32" alt=""  title=""/></td>
							</tr>
						  </table></td>
						</tr>
					  </table></td>';
			} elseif($i==1){
				$photo_list .= '<td width="228" align="center" valign="top"><table width="183" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><table width="183" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="17" height="13" align="left" valign="top"><img src="images/box2-top-left.jpg" width="17" height="14" alt=""  title=""/></td>
                            <td height="13" align="left" valign="top" class="box2-top-border"><img src="images/spacer.gif" width="1" height="13" alt="" title="" /></td>
                            <td width="17" height="13" align="left" valign="top"><img src="images/box2-top-right.jpg" width="17" height="14" alt=""  title=""/></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="box2-border">' . com_db_output($data_sql['title']) . '</td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><img src="images/box2-inner-top.jpg" width="183" height="11" alt="" title="" /></td>
                    </tr>
                    <tr>
                      <td align="center" valign="top" class="box2-inner-box"><table width="169" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                             <td align="center" valign="top" class="box2-inner-box-pic-border">' . com_setImage($photo,'167','','') . '</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">' . com_db_output($data_sql['short_desc']) . '</td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><img src="images/box2-inner-bottom.jpg" width="183" height="11" alt="" title="" /></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><table width="183" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="32" height="32" align="left" valign="top"><img src="images/box2-bottom-left.jpg" width="32" height="32" alt=""  title=""/></td>
                            <td height="13" align="center" valign="middle" class="box2-bottom-border"><img src="images/spacer.gif" width="1" height="13" alt="" title="" /><a href="foto.php?pid='. $data_sql['photo_id'] .'"><img src="images/box2-readmore-buttn.jpg"  alt="" width="99" height="22" border="0" title="" /></a></td>
                            <td width="32" height="32" align="left" valign="top"><img src="images/box2-bottom-right.jpg" width="32" height="32" alt=""  title=""/></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table></td>';
			
			
			} else {
			
				$photo_list .= '<td width="228" align="left" valign="top"><table width="183" border="0" align="right" cellpadding="0" cellspacing="0">
                    <tr>
                      <td align="left" valign="top"><table width="183" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="17" height="13" align="left" valign="top"><img src="images/box3-top-left.jpg" width="17" height="14" alt=""  title=""/></td>
                            <td height="13" align="left" valign="top" class="box3-top-border"><img src="images/spacer.gif" width="1" height="13" alt="" title="" /></td>
                            <td width="17" height="13" align="left" valign="top"><img src="images/box3-top-right.jpg" width="17" height="14" alt=""  title=""/></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top" class="box3-border">' . com_db_output($data_sql['title']) . '</td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><img src="images/box3-inner-top.jpg" width="183" height="11" alt="" title="" /></td>
                    </tr>
                    <tr>
                      <td align="center" valign="top" class="box3-inner-box"><table width="169" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                             <td align="center" valign="top" class="box3-inner-box-pic-border">' . com_setImage($photo,'167','','') . '</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr>
                            <td align="left" valign="top">' . com_db_output($data_sql['short_desc']) . '</td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><img src="images/box3-inner-bottom.jpg" width="183" height="11" alt="" title="" /></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><table width="183" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="32" height="32" align="left" valign="top"><img src="images/box3-bottom-left.jpg" width="32" height="32" alt=""  title=""/></td>
                            <td height="13" align="center" valign="middle" class="box3-bottom-border"><img src="images/spacer.gif" width="1" height="13" alt="" title="" /><a href="foto.php?pid='. $data_sql['photo_id'] .'"><img src="images/box3-readmore-buttn.jpg"  alt="" width="99" height="22" border="0" title="" /></a></td>
                            <td width="32" height="32" align="left" valign="top"><img src="images/box3-bottom-right.jpg" width="32" height="32" alt=""  title=""/></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table></td>';
			
			}
		$i++;
		}
	$photo_list .= '</tr>
              	</table>';
	return 	$photo_list;		
	
	}	
	
function ShowLokaties(){
	$sql_Lokaties=com_db_query("select * from " . TABLE_PRACTICE_CITY . " order by pc_id");
	$Lokaties .='';
	$Lokaties .='<table width="248" border="0" align="right" cellpadding="0" cellspacing="0">
            <tr>
              <td align="center" valign="top"><img src="images/spacer.gif" width="1" height="18" alt="" title="" /></td>
            </tr>
            <tr>
              <td align="left" valign="top"><h1>Lokaties</h1></td>
            </tr>
           ';
            
	while($sql_data=com_db_fetch_array($sql_Lokaties)){
	$link = 'lokaties.php?pcid=' . $sql_data['pc_id'];
	$Lokaties .=' <tr>
             <td align="center" valign="top"><img src="images/spacer.gif" width="1" height="27" alt="" title="" /></td>
            </tr><tr>
              <td align="left" valign="top" class="left-box-text"><strong><a href="'. $link .'">' . com_db_output($sql_data['title']) . '</a></strong><br />
                ' . com_db_output($sql_data['address']) . '
            </tr>';
	}		
   
   $Lokaties .='<tr>
              <td align="center" valign="top"><img src="images/spacer.gif" width="1" height="20" alt="" title="" /></td>
            </tr>
            <tr>
              <td align="left" valign="top"  class="left-box-text"><strong><a href="afspraak.php">Afspraak (Mailform)</a></strong></td>
            </tr>
            <tr>
              <td align="left" valign="top"  class="left-box-text"><strong><a href="appointment.php">Online Appointment Request</a></strong></td>
            </tr>
        </table>';
	
	return $Lokaties;

}

function ShowVideo(){
	$sql_video=com_db_query("select * from " . TABLE_VIDEO . " order by rand() limit 0, 1");
	$data_video=com_db_fetch_array($sql_video);
	$code=com_db_output($data_video['code']);
	return $code;
}

function ShowSearch(){
	
	/*$search = '<table width="230" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td  align="left" valign="middle" class="search-box"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="57%">Zoek op deze site</td>
                        <td width="43%">
                            <input name="textfield" type="text"  class="input-text"/>
                        
                        </td>
                      </tr>
                    </table></td>
                    <td width="36" align="left" valign="middle">
                        <input type="image" name="imageField" src="images/go-buttn.jpg" />                    </td>
                  </tr>
                </table>';
				
	$search = '<table width="204" border="0" align="left" cellpadding="0" cellspacing="0">
				<form name="search" method="get" action="http://www.google.com/search" target="_blank" onsubmit="return checkForm();">
                  <tr>
                    <td width="149" align="left" valign="middle" class="search-box"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="38%">Search</td>
                        <td width="62%">
                            <input name="q" id="searchKey" type="text"  class="input-text"/>
                        	<input type="hidden" name="domains" value="http://www.templateheart.com/demo/acupunctuurpraktijk/" />
                    		<input type="hidden" name="sitesearch" value="http://www.templateheart.com/demo/acupunctuurpraktijk/" />
                        </td>
                      </tr>
                    </table></td>
                    <td width="36" align="left" valign="middle">
                        <input type="image" src="images/go-buttn.jpg" /></td>
                  </tr>
				  </form>
                </table>';	*/		
	
	$search = '<div id="searchcontrol"></div>';
	
				
	return $search;		

}
?>