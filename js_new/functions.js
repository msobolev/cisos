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

    $('#top-content .pic-slider ul').jcarousel({
    	auto:3,
    	duration:1,
    	wrap:"circular",
    	vertical:true,
    	scroll:1,
    	visible:1,
    	buttonNextHTML: null,
        buttonPrevHTML: null
    })

	$('.ch-field').click(function(){
		$(this).toggleClass('checked');
		var state = $(this).hasClass('checked') ? true : false;
		$('input', this).attr('checked', state);
		IndexPageResult();
	})
	$('.ch-label').click(function(){
		$(this).parent().find('.ch-field').trigger('click');
	});

	$('#filters .check-section').jScrollPane()

	$('.revenue-slider').slider({
		range: true,
		min: 0,
		max: 8,
		step: 1,
		values: [0,8],
		slide: function( event, ui ) {
				var val1, val2;
				switch (ui.values[0])
					{
					case 0:
					  val1 = "0";
					  break;
					case 1:
					  val1 = '$1 mil';
					  break;
					case 2:
					  val1 = '$10 mil';
					  break;
					case 3:
					  val1 = '$50 mil';
					  break;
					case 4:
					  val1 = '$100 mil';
					  break;
				    case 5:
					  val1 = '$250 mil';
					  break;
					case 6:
					  val1 = '$500 mil';
					  break;
					case 7:
					  val1 = '$1 bil';
					  break;
					case 8:
					  val1 = ' >$1 bil';
					  break;
					};
				switch (ui.values[1])
					{
					case 0:
					  val2 = "0";
					  break;
					case 1:
					  val2 = '$1 mil';
					  break;
					case 2:
					  val2 = '$10 mil';
					  break;
					case 3:
					  val2 = '$50 mil';
					  break;
					case 4:
					  val2 = '$100 mil';
					  break;
				    case 5:
					  val2 = '$250 mil';
					  break;
					case 6:
					  val2 = '$500 mil';
					  break;
					case 7:
					  val2 = '$1 bil';
					  break;
					case 8:
					  val2 = ' >$1 bil';
					  break;
					};
				$('.revenue-slider').parents('.section').find('h4 .val1').text(val1);
				$('.revenue-slider').parents('.section').find('h4 .val2').text(val2);
				document.getElementById('revenue').value= val1+"||"+val2;
				
				IndexPageResult();
			}
			
	});

	$('.employee-slider').slider({
		range: true,
		min: 0,
		max: 8,
		step: 1,
		values: [0,8],
		slide: function( event, ui ) {
				var val1, val2;
				switch (ui.values[0])
					{
					case 0:
					  val1 = "0";
					  break;
					case 1:
					  val1 = '25';
					  break;
					case 2:
					  val1 = '100';
					  break;
					case 3:
					  val1 = '250';
					  break;
					case 4:
					  val1 = '1K';
					  break;
				    case 5:
					  val1 = '10K';
					  break;
					case 6:
					  val1 = '50K';
					  break;
					case 7:
					  val1 = '100K';
					  break;
					case 8:
					  val1 = ' >100K';
					  break;
					};
				switch (ui.values[1])
					{
					case 0:
					  val2 = "0";
					  break;
					case 1:
					  val2 = '25';
					  break;
					case 2:
					  val2 = '100';
					  break;
					case 3:
					  val2 = '250';
					  break;
					case 4:
					  val2 = '1K';
					  break;
				    case 5:
					  val2 = '10K';
					  break;
					case 6:
					  val2 = '50K';
					  break;
					case 7:
					  val2 = '100K';
					  break;
					case 8:
					  val2 = ' >100K';
					  break;
					};
				$('.employee-slider').parents('.section').find('h4 .val1').text(val1);
				$('.employee-slider').parents('.section').find('h4 .val2').text(val2);
				document.getElementById('employee').value= val1+"||"+val2;
				
				IndexPageResult();
			}
			
	});


	var listing_item = $('.listing tr:last') // taking last item for instance

	function listing_restyle() {
		$('.listing tr').removeClass();
		$('.listing tr:first').addClass('first')
		$('.listing tr:even').addClass('even')
	}
	listing_restyle()
	setInterval( function(){
		listing_item.clone().prependTo('.listing table').hide().fadeIn(300)
		listing_restyle()
	},3000)


	$('.listing .banner').on("click", function(){
		window.location = $(this).find('a.banner-btn').attr('href')
	})
});