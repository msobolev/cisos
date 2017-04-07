<?php

$cto = mysql_connect("10.132.233.131","ctou2","ToC@!mvCo23") or die("Database CTO ONE ERROR ");
mysql_select_db("ctou2",$cto) or die ("ERROR: Database not found ");

$get_title_q = "SELECT mm.title,pm.personal_id from cto_movement_master as mm,cto_personal_master as pm,cto_company_master as cm where cm.company_id = mm.company_id and mm.personal_id = pm.personal_id";
//echo "<br>Comp Q: select company_id,email_domain from cto_company_master where email_pattern_id is null and email_domain != '' order by company_id desc LIMIT 0,500";
$title_res = mysql_query($get_title_q,$cto);

$num_rows = mysql_num_rows($title_res);

while($title_row = mysql_fetch_array($title_res))
{
    $ciso_user = 0;
    $title = $title_row['title'];
    $personal_id = $title_row['personal_id'];
    
    $ciso_filters = array('CISO','ciso','Chief Information Security Officer','information security','cyber security','technology security','IT security','Information Security','chief information security officer','Cyber Security','Technology Security','IT Security');
    foreach($ciso_filters as $kw)
    {
        //echo "<br>kw: ".$kw;
        if(strpos($title,$kw) > -1)
        {
            $ciso_user = 1;
        }        
    }
    //echo "<br>ciso_user: ".$ciso_user;
    //echo "<br><br><br>Title: ".$title;
    if($ciso_user == 1)
    {
        //echo "<br>within if";
        //$ciso_user_col = ",ciso_user";
        //$ciso_user_clause = ",".$ciso_user;

        //$ciso_update = 'ciso_user = 1';
        
        $update_p = "UPDATE cto_personal_master set ciso_user = 1 where personal_id = ".$personal_id;
        //echo "<br>update_p: ".$update_p;
        $update_p = mysql_query($update_p,$cto);
    }
    else
    {
        $ciso_update = 'ciso_user = 0';
    }  
}    




?>