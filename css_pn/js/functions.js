;(function($, window, document, undefined) {
	var $win = $(window);
	var $doc = $(document);

	$doc.ready(function() {
	    $('.pricing-table td, .pricing-table th').hover(function(){
	        var idx = $(this).index()
	        if ((idx >= 1) && (idx <= 3)) {
	            $('.pricing-table td, .pricing-table th').removeClass('blue')
	            $('.pricing-table tr').each(function(){
	                $(this).find('td').eq(idx).addClass('blue')
	                $(this).find('th').eq(idx).addClass('blue')
	            })
	        }
	    });

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

	    // Offer items
	    $('.offer-standard').addClass('offer-hover');

	    $('.offer').not(':eq(0)').on('mouseover', function() {
	    	$('.offer').removeClass('offer-hover');
	    	$(this).addClass('offer-hover');
	    });

		$('.offer').on('mouseleave', function() {
			$('.offer-standard').addClass('offer-hover');
	    	$(this).removeClass('offer-hover');
	    });
	});
})(jQuery, window, document);
