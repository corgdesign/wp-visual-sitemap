jQuery(document).ready(function($){
    

	// Update icon
	$( '.iconpicker-item' ).on('click', function(){
		
		var chosen_icon =  $( this ).children( 'i' ).attr( 'class' );

		$( '#wpvs_fa_chosen_icon' ).attr( 'class', '');
		$( '#wpvs_fa_chosen_icon' ).attr( 'class', chosen_icon );
		$( '#wpvs_fa_chosen_icon' ).hide().fadeIn();

		console.log(chosen_icon);

	});


	// Initiate the colorpicker
    $('.my-color-field').wpColorPicker();



});