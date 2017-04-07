<tr>
      <td align="left"  valign="top">&nbsp;</td>
      <td align="left" valign="top"><table width="960" border="0" align="center" cellpadding="0" cellspacing="0">
  	  <? if($current_page=='index.php'){ ?>
	   <tr>
        <td align="left" valign="top">
			<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width="43%" align="left" valign="middle" class="directry-heading-text">IT Executives Directory</td>
					<td width="57%" align="left" valign="middle" class="directry-heading-text">Company Directory</td>
				</tr>
				<tr>
					<td align="left" valign="top" class="pagination-link-text">
                    <?
					for($i=65; $i<=90; $i++){
						$char_cnt = com_db_GetValue("select count(pm.first_name) as cnt from " .TABLE_MOVEMENT_MASTER ." mm, ". TABLE_PERSONAL_MASTER . " pm where mm.personal_id=pm.personal_id and pm.first_name like '".chr($i)."%'");
						if($char_cnt > 0){
							echo '<a href="../executives-list.php?action=EName&amp;char='.chr($i).'">'.chr($i).'</a> ';
						}	
					}
					?>
					</td>
					<td align="left" valign="top" class="pagination-link-text">
                    <?
					for($c=65; $c<=90; $c++){
						$char_cnt = com_db_GetValue("select count(cm.company_name) as cnt from " . TABLE_MOVEMENT_MASTER . " mm, ".TABLE_COMPANY_MASTER." cm where mm.company_id=cm.company_id and cm.company_name like '".chr($c)."%'");
						if($char_cnt > 0){
							echo '<a href="../company-list.php?action=CName&amp;char='.chr($c).'">'.chr($c).'</a> ';
						}	
					}
					?>					
					</td>
				</tr>	
		  </table>
		</td>
      </tr>
	  <? } ?>
	   <tr>
        <td align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top" class="copyright-text">Copyright &copy; 2010 CTOsOnTheMove. All rights reserved.</td>
      </tr>
      <tr>
        <td align="center" valign="top">&nbsp;</td>
      </tr>
      </table></td>
      <td align="left"  valign="top">&nbsp;</td>
    </tr>
</table>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-6168564-1");
pageTracker._trackPageview();
} catch(err) {}</script>

</body>
</html>
