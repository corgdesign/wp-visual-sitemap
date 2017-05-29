jQuery(document).ready(function($){
    
	// Update icon
	$( '.iconpicker-item' ).on('click', function(){
		
		var chosen_icon =  $( this ).children( 'i' ).attr( 'class' );

		$( '#wpvs_fa_chosen_icon' ).attr( 'class', chosen_icon );
		$( '#wpvs_fa_chosen_icon' ).hide().fadeIn();

	});

	// Initiate the colorpicker
    $('.icon_background_colour, .text_colour, .hover_icon_background_colour, .hover_text_colour, .line_colour').wpColorPicker();


    // Update preview styles, when user moves mouse over the color picker

    // Hide icons if not selected
    if ( $('.use_icons:checked').length < 1 ) {
    	$('.menu_icon').hide();
    	$('.wpvs_preview_wrapper ul.wpvs_wrapper li > a span').addClass('no_icons');
    }

    // Background colour
    $('.icon_background_colour').parent('.wp-picker-input-wrap').siblings('.wp-picker-holder').mousemove(function(){
    	
    	var new_colour = $('.icon_background_colour').val();

    	$('ul.wpvs_wrapper li > a').css('background-color', new_colour);

    });

    // Text colour
    $('.text_colour').parent('.wp-picker-input-wrap').siblings('.wp-picker-holder').mousemove(function(){
    	
    	var new_colour = $('.text_colour').val();

    	$('ul.wpvs_wrapper li > a').css('color', new_colour);

    });

    // Hover background and text colours
    $('.hover_icon_background_colour, .hover_text_colour').parent('.wp-picker-input-wrap').siblings('.wp-picker-holder').mousemove(function(){
    	
    	$('ul.wpvs_wrapper li > a').hover(

    		// handlerIn
    		function(){		
	    		var background_colour = $('.hover_icon_background_colour').val();
	    		var text_colour = $('.hover_text_colour').val();
	    		$(this).css({
	    			'color' : text_colour,
	    			'background-color' : background_colour
	    		});
    		} ,

    		// handlerOut
    		function(){
    		
	    		var background_colour = $('.icon_background_colour').val();
	    		var text_colour = $('.text_colour').val();
	    		$(this).css({
	    			'color' : text_colour,
	    			'background-color' : background_colour
	    		});

    		}

		);

	});

	// Line colour
    $('.line_colour').parent('.wp-picker-input-wrap').siblings('.wp-picker-holder').mousemove(function(){
    	
    	var new_colour = $('.line_colour').val();

    	$('ul.wpvs_wrapper li > a, ul.wpvs_wrapper > li ul li').css('border-color', new_colour);

    });

    // Font size colour
    $('.font_size').change(function(){
    	
    	var new_text_size = $('.font_size').val();

    	$('ul.wpvs_wrapper li > a').css('font-size', new_text_size);

    });

    // Font size colour
    $('.use_icons').change(function(){
    	
    	$('.menu_icon').toggle();
    	$('.wpvs_preview_wrapper ul.wpvs_wrapper li > a span').toggleClass('no_icons');

    });

});