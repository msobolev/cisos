<?
chdir(dirname( __FILE__ ));
	include("includes/include-top.php");
	
	$tot_smp_file = com_db_GetValue("select count(sitemap_name) from ".TABLE_SITEMAP." where sitemap_name like 'sitemapfile%.xml'");
	
	$first_open_file = $tot_smp_file;
	$file_name = 'sitemapfile'.$tot_smp_file.".xml";
	$sitemap_name = 'sitemapfile'.$tot_smp_file.'.xml';
	$added = date('Y-m-d');
	$count_url = 1;
	$fp = fopen($file_name,"r+");
	if ($fp) {
		while (!feof($fp)) {
			$buffer = fgets($fp, 4096);
			$string = substr($buffer,0,9);
			if($string =='</urlset>'){
				 $ch_fp=ftell($fp); 
			}else{
				$buffer = substr($buffer,0,strlen('<url><loc>http://www.ctosonthemove.com/'));
				if($buffer =='<url><loc>http://www.ctosonthemove.com/'){
					$count_url++;
				}
			}
		}
		
		fseek($fp, $ch_fp-9);
		
		$url_query = "select mm.move_id,mm.movement_url from " .TABLE_MOVEMENT_MASTER ." mm,".TABLE_PERSONAL_MASTER." pm where mm.personal_id=pm.personal_id and mm.status='0' and mm.movement_url<>'' and mm.sitemap_status='0' order by pm.first_name";
		$url_result = com_db_query($url_query);

		$num_of_file = $tot_smp_file;
		$tot_url ='';			

		$num_of_file++;
		while($url_row = com_db_fetch_array($url_result)){
			if($count_url == '1000'){
				$count_url = 1;	
				$file_name = 'sitemapfile'.$num_of_file.'.xml';
				$sitemap_name = 'sitemapfile'.$num_of_file.'.xml';
				$fp=fopen($file_name,"w");
				$num_of_file++;
				
			}
			$tot_url .= '<url><loc>'.HTTP_SITE_URL.$url_row['movement_url']."</loc><changefreq>monthly</changefreq></url>\n";
			$count_url++;
			if($count_url >= 1000){
				$tot_url .= '</urlset>';
				fwrite($fp, $tot_url);
				fclose($fp);
				$isFilePresent = com_db_GetValue("select sitemap_name from " .TABLE_SITEMAP." where sitemap_name='".$sitemap_name."'");
				if($isFilePresent==''){
					$query = "insert into " . TABLE_SITEMAP . " (sitemap_name, add_date) values ('$sitemap_name', '$added')";
					com_db_query($query);
				}
				$tot_url = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
					'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
			}
			com_db_query("update " .TABLE_MOVEMENT_MASTER." set sitemap_status='1' where move_id='".$url_row['move_id']."'");
		}
		if($count_url < 1000){
			$tot_url .= '</urlset>';
			fwrite($fp, $tot_url);
			fclose($fp);
			$isFilePresent1 = com_db_GetValue("select sitemap_name from " .TABLE_SITEMAP." where sitemap_name='".$sitemap_name."'");
			if($isFilePresent1==''){
				$query = "insert into " . TABLE_SITEMAP . " (sitemap_name, add_date) values ('$sitemap_name', '$added')";
				com_db_query($query);
			}
		}
	}
	
	if($first_open_file != $num_of_file-1){
		$s_no = $first_open_file+1;
		$fp = fopen('sitemap.xml',"r+");
		if ($fp) {
			while (!feof($fp)) {
				$buffer = fgets($fp, 4096);
				$string = substr($buffer,0,15);
				if($string =='</sitemapindex>'){
					 $ch_fp=ftell($fp); 
				}
			}
		}
		fseek($fp, $ch_fp-15);
		$tot_url='';
		for($ss=$s_no;$ss<=$num_of_file;$ss++){	
			if(file_exists("sitemapfile".$ss.".xml")){
				$tot_url .= '<sitemap><loc>'.HTTP_SITE_URL.'sitemapfile'.$ss.".xml</loc><lastmod>".date('Y-m-d')."</lastmod></sitemap>"."\n";
			}
		}			
		$tot_url .= '</sitemapindex>';
		fwrite($fp, $tot_url);
		fclose($fp);
	}
	
//Personal sitemap
$tot_smp_file_pm = com_db_GetValue("select count(sitemap_name) from ".TABLE_SITEMAP_PERSONAL." where sitemap_name like 'sitemappersonal%.xml'");
	
	$first_open_file_pm = $tot_smp_file_pm;
	$file_name = 'sitemappersonal'.$tot_smp_file_pm.".xml";
	$sitemap_name = 'sitemappersonal'.$tot_smp_file_pm.'.xml';
	$added = date('Y-m-d');
	$count_url = 1;
	$fppm = fopen($file_name,"r+");
	if ($fppm) {
		while (!feof($fppm)) {
			$buffer = fgets($fppm, 4096);
			$string = substr($buffer,0,9);
			if($string =='</urlset>'){
				 $ch_fp=ftell($fppm); 
			}else{
				$buffer = substr($buffer,0,strlen('<url><loc>'));
				if($buffer =='<url><loc>'){
					$count_url++;
				}
			}
		}
		
		fseek($fppm, $ch_fp-9);
		
		$url_query = "select first_name,last_name,personal_id from " .TABLE_PERSONAL_MASTER." where status='0' and sitemap_status='0' order by first_name";
		$url_result = com_db_query($url_query);

		$num_of_file = $tot_smp_file_pm;
		$tot_url ='';			

		$num_of_file++;
		while($url_row = com_db_fetch_array($url_result)){
			if($count_url == '1000'){
				$count_url = 1;	
				$file_name = 'sitemappersonal'.$num_of_file.'.xml';
				$sitemap_name = 'sitemappersonal'.$num_of_file.'.xml';
				$fppm=fopen($file_name,"w");
				$num_of_file++;
				
			}
			$tot_url .= '<url><loc>'.HTTP_SITE_URL.$url_row['first_name']."_".$url_row['last_name'].'_Exec_'.$url_row['personal_id']."</loc><changefreq>monthly</changefreq></url>\n";
			$count_url++;
			if($count_url >= 1000){
				$tot_url .= '</urlset>';
				fwrite($fppm, $tot_url);
				fclose($fppm);
				$isFilePresent = com_db_GetValue("select sitemap_name from " .TABLE_SITEMAP_PERSONAL." where sitemap_name='".$sitemap_name."'");
				if($isFilePresent==''){
					$query = "insert into " . TABLE_SITEMAP_PERSONAL . " (sitemap_name, add_date) values ('$sitemap_name', '$added')";
					com_db_query($query);
				}
				$tot_url = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
					'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
			}
			com_db_query("update " .TABLE_PERSONAL_MASTER." set sitemap_status='1' where personal_id='".$url_row['personal_id']."'");
		}
		if($count_url < 1000){
			$tot_url .= '</urlset>';
			fwrite($fppm, $tot_url);
			fclose($fppm);
			$isFilePresent1 = com_db_GetValue("select sitemap_name from " .TABLE_SITEMAP_PERSONAL." where sitemap_name='".$sitemap_name."'");
			if($isFilePresent1==''){
				$query = "insert into " . TABLE_SITEMAP_PERSONAL . " (sitemap_name, add_date) values ('$sitemap_name', '$added')";
				com_db_query($query);
			}
		}
	}
	
	if($first_open_file_pm != $num_of_file-1){
		$s_no = $first_open_file_pm+1;
		$fp = fopen('sitemap.xml',"r+");
		if ($fp) {
			while (!feof($fp)) {
				$buffer = fgets($fp, 4096);
				$string = substr($buffer,0,15);
				if($string =='</sitemapindex>'){
					 $ch_fp=ftell($fp); 
				}
			}
		}
		fseek($fp, $ch_fp-15);
		$tot_url='';
		for($ss=$s_no;$ss<=$num_of_file;$ss++){	
			if(file_exists("sitemappersonal".$ss.".xml")){
				$tot_url .= '<sitemap><loc>'.HTTP_SITE_URL.'sitemappersonal'.$ss.".xml</loc><lastmod>".date('Y-m-d')."</lastmod></sitemap>"."\n";
			}
		}			
		$tot_url .= '</sitemapindex>';
		fwrite($fp, $tot_url);
		fclose($fp);
	}

//Company sitemap
	
	$tot_smp_file_cm = com_db_GetValue("select count(sitemap_name) from ".TABLE_SITEMAP_COMPANY." where sitemap_name like 'sitemapcompany%.xml'");
	$first_open_file_cm = $tot_smp_file_cm;
	$file_name = 'sitemapcompany'.$tot_smp_file_cm.".xml";
	$sitemap_name = 'sitemapcompany'.$tot_smp_file_cm.'.xml';
	$added = date('Y-m-d');
	$count_url = 1;
	$fpcm = fopen($file_name,"r+");
	if ($fpcm) {
		while (!feof($fpcm)) {
			$buffer = fgets($fpcm, 4096);
			$string = substr($buffer,0,9);
			if($string =='</urlset>'){
				 $ch_fp=ftell($fpcm); 
			}else{
				$buffer = substr($buffer,0,strlen('<url><loc>'));
				if($buffer =='<url><loc>'){
					$count_url++;
				}
			}
		}
		
		fseek($fpcm, $ch_fp-9);
		
		$url_query = "select company_name,company_id from " .TABLE_COMPANY_MASTER ." where status='0' and sitemap_status='0' order by company_name";
		$url_result = com_db_query($url_query);

		$num_of_file = $tot_smp_file_cm;
		$tot_url ='';			

		$num_of_file++;
		while($url_row = com_db_fetch_array($url_result)){
			if($count_url == '1000'){
				$count_url = 1;	
				$file_name = 'sitemapcompany'.$num_of_file.'.xml';
				$sitemap_name = 'sitemapcompany'.$num_of_file.'.xml';
				$fpcm=fopen($file_name,"w");
				$num_of_file++;
			}
			$company_name = com_db_output($url_row['company_name']);
			$comURL = preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '_', ''),$company_name).'_Company_'.$url_row['company_id'];
			$tot_url .= '<url><loc>'.HTTP_SITE_URL.$comURL."</loc><changefreq>monthly</changefreq></url>\n";
			$count_url++;
			if($count_url >= 1000){
				$tot_url .= '</urlset>';
				fwrite($fpcm, $tot_url);
				fclose($fpcm);
				$isFilePresent = com_db_GetValue("select sitemap_name from " .TABLE_SITEMAP_COMPANY." where sitemap_name='".$sitemap_name."'");
				if($isFilePresent==''){
					$query = "insert into " . TABLE_SITEMAP_COMPANY . " (sitemap_name, add_date) values ('$sitemap_name', '$added')";
					com_db_query($query);
				}
				$tot_url = '<?xml version="1.0" encoding="UTF-8"?>'."\n".
					'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";
			}
			com_db_query("update " .TABLE_COMPANY_MASTER." set sitemap_status='1' where company_id='".$url_row['company_id']."'");
		}
		if($count_url < 1000){
			$tot_url .= '</urlset>';
			fwrite($fpcm, $tot_url);
			fclose($fpcm);
			$isFilePresent1 = com_db_GetValue("select sitemap_name from " .TABLE_SITEMAP_COMPANY." where sitemap_name='".$sitemap_name."'");
			if($isFilePresent1==''){
				$query = "insert into " . TABLE_SITEMAP_COMPANY . " (sitemap_name, add_date) values ('$sitemap_name', '$added')";
				com_db_query($query);
			}
		}
	}
	
	if($first_open_file_cm != $num_of_file-1){
		$s_no = $first_open_file_cm+1;
		$fp = fopen('sitemap.xml',"r+");
		if ($fp) {
			while (!feof($fp)) {
				$buffer = fgets($fp, 4096);
				$string = substr($buffer,0,15);
				if($string =='</sitemapindex>'){
					 $ch_fp=ftell($fp); 
				}
			}
		}
		fseek($fp, $ch_fp-15);
		$tot_url='';
		for($ss=$s_no;$ss<=$num_of_file;$ss++){	
			if(file_exists("sitemapcompany".$ss.".xml")){
				$tot_url .= '<sitemap><loc>'.HTTP_SITE_URL.'sitemapcompany'.$ss.".xml</loc><lastmod>".date('Y-m-d')."</lastmod></sitemap>"."\n";
			}
		}			
		$tot_url .= '</sitemapindex>';
		fwrite($fp, $tot_url);
		fclose($fp);
	}	
	
echo 'End of Work';
?>
