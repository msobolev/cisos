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

    $('.pricing-table td, .pricing-table th').hover(function(){
        var idx = $(this).index()
        if ((idx >= 1) && (idx <= 3)) {
            $('.pricing-table td, .pricing-table th').removeClass('blue')
            $('.pricing-table tr').each(function(){
                $(this).find('td').eq(idx).addClass('blue')
                $(this).find('th').eq(idx).addClass('blue')
            })
        }
    })

    $('.pricing-table').mouseleave(function(){
         $('.pricing-table td, .pricing-table th').removeClass('blue')
         $('.pricing-table tr').each(function(){
            $(this).find('td').eq(2).addClass('blue')
            $(this).find('th').eq(2).addClass('blue')
        })
    })

    $('.tip').hover(function() { 
        $(this).find('.balloon').fadeIn(100);
    }, function() { 
        $(this).find('.balloon').fadeOut(100);
    });



});