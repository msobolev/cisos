
function setSeacrhMenu(id_menu,value)
{
 var d = document;
 d.getElementById('search_type').value = value;
 var lis = document.getElementById("top_label").getElementsByTagName("LI");
 for (var i=0; i<lis.length; i++) { lis[i].className = ""; } 
 d.getElementById('label_top_menu_'+id_menu).className = 'cur';
 if (value=='name')
 {
  d.getElementById('box_date_search').style.display = 'none'; 
  d.getElementById('box_input_search').style.display = 'block';
  d.getElementById('box_input_company').style.display = 'none';
 }
 
 if (value=='company')
 {
  d.getElementById('box_input_search').style.display = 'none';
  d.getElementById('box_date_search').style.display = 'none';
  d.getElementById('box_input_company').style.display = 'block';  
 }

 if (value=='date')
 {
  d.getElementById('box_input_search').style.display = 'none';
  d.getElementById('box_input_company').style.display = 'none';
  d.getElementById('box_date_search').style.display = 'block';
 }
 
}

	function getElementPosition(elemId)
	{
	
		var elem = elemId;
		
		var w = elem.offsetWidth;
		var h = elem.offsetHeight;
		
		var l = 0;
		var t = 0;
		
		while (elem)
		{
			l += elem.offsetLeft;
			t += elem.offsetTop;
			elem = elem.offsetParent;
		}
	
		return {"left":l, "top":t, "width": w, "height":h};
	}

    function mousePageXY(e)
    {
      var x = 0, y = 0;

      if (!e) e = window.event;

      if (e.pageX || e.pageY)
      {
        x = e.pageX;
        y = e.pageY;
      }
      else if (e.clientX || e.clientY)
      {
        x = e.clientX + (document.documentElement.scrollLeft || document.body.scrollLeft) - document.documentElement.clientLeft;
        y = e.clientY + (document.documentElement.scrollTop || document.body.scrollTop) - document.documentElement.clientTop;
      }

      return {"x":x, "y":y};
    }
 
 function showRealease(id_block,id_link,e)
 {
  var l_pos = getElementPosition(id_link);
  var m_pos = mousePageXY(e);
  var map_info = document.getElementById('press_realease_'+id_block);  
  map_info.style.top = (m_pos.y+10)+'px';
  map_info.style.left = (m_pos.x+10)+'px';  
  map_info.style.display = 'block';
 }
 
 function hideRealease(id_block)
 {
  var map_info = document.getElementById('press_realease_'+id_block);
  map_info.style.display = 'none';
 }
 
 function selAllResult()
 {
    var state = document.getElementById('check_all').checked;
    var checkboxes = document.getElementById('data_tbl').getElementsByTagName('input');
    for ( var i = 0; i < checkboxes.length; i++ ) {
        if ( checkboxes[i].type == 'checkbox' ) {
            checkboxes[i].checked = state;
        }
    }
    return true;  
 }

 function setExcelDownload()
 {
    var sel_str = '';
    var checkboxes = document.getElementById('data_tbl').getElementsByTagName('input');
    for ( var i = 0; i < checkboxes.length; i++ ) {
        if ( checkboxes[i].type == 'checkbox' && checkboxes[i].checked == true && checkboxes[i].value != 'cl') {
            sel_str = sel_str + checkboxes[i].value + ':';
        }
    }
    if (sel_str!='')
    {
     if (document.getElementById('check_all').checked == true) 
     {
        document.getElementById('check_all_form').value = document.getElementById('check_all').value;
     }
     document.getElementById('downloads_id').value = sel_str;
     document.getElementById('search_excel_download').submit();
    }
 }
 
 function regOpen()
 {
  Effect.BlindUp('reg1'); 
  Effect.BlindDown('reg2');  
 }
 
 function searchPage(page_id)
 {
   document.getElementById('search_form_mini3').action = '/search/page/'+page_id+'/';
   document.getElementById('search_form_mini3').submit();
 }
 