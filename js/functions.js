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

    $('a.question-ico').hover(function() { 
        $(this).find('.balloon').fadeIn(100);
    }, function() { 
        $(this).find('.balloon').fadeOut(100);
    });

    // add last class
    $('.featured-holder:last').addClass('last');

    $(window).resize( function(){
        resizer( $( '.intro-section img.wide-img' ) );
    }).resize();

    function resizer( $img ) {
        var ww = $( '.intro-section' ).width(),
            wh = $( '.intro-section' ).height(),
            iw = $img.width(),
            ih = $img.height(),
            rw = wh / ww,
            ri = ih / iw,
            newWidth, newHeight,
            newLeft, newTop,
            properties;

        if ( rw > ri ) {
            newWidth = wh / ri;
            newHeight = wh;
        } else {
            newWidth = ww;
            newHeight = ww * ri;
        }

        properties = {
            'width': newWidth + 'px',
            'height': newHeight + 'px',
            'top': 'auto',
            'bottom': 'auto',
            'left': 'auto',
            'right': 'auto'
        }

        properties[ 'top' ] = ( wh - newHeight ) / 2;
        properties[ 'left' ] = ( ww - newWidth ) / 2;

        $img.css( properties );
    }

    $(window).load(function() {
        $('select').chosen({disable_search_threshold: 10});
        $('select').data("placeholder","Select Frameworks...").chosen();
        $('.checkbox').checkbox();
        $('.datepicker-from, .datepicker-to').datepicker();
        $('.ico-datepicker').click(function () {
            return false;
        })
    });
});