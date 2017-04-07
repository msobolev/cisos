$(function() {
	$('.field, textarea').focus(function() {
        if(this.title==this.value) {
            this.value = '';
        }
    }).blur(function(){
        if(this.value=='') {
            this.value = this.title;
        }
    });

    $('.radio').click(function(){
    	
    	var indexView = $(this).parents('td').index();
    	var container = '#table';

    	$(this).parents('.last-row').find('.radio span').removeClass('active');
    	$(this).find('span').addClass('active');

    	$(this).parents('.last-row').find('.radio input').removeAttr('checked');
    	$(this).find('input').attr('checked', 'checked');

    	$('td, th', container).removeClass('active-bg');
		$('table tr', container).each(function() {
			$($(this).find('td, th')[indexView]).addClass('active-bg');
		});

 		return false; 	
    });

    $('.question').hover(function() { 
        $(this).find('span:first').fadeIn(100);
    }, function() { 
        $(this).find('span:first').fadeOut(100);
    });

	if ($.browser.msie && $.browser.version == 6) {
      DD_belatedPNG.fix('h1#logo a, img, #table .radio span, #table .radio span.active');
    }
});