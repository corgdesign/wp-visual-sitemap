jQuery(document).ready(function($){
    

	// Update icon
	$( '#wpvs_fa_icon' ).change(function(){
		var chosen_icon = 'fa ' + $( this ).val();

		$( '#wpvs_fa_chosen_icon' ).attr( 'class', '');
		$( '#wpvs_fa_chosen_icon' ).attr( 'class', chosen_icon );

		console.log(chosen_icon);

	});


	// Initiate the colorpicker
    $('.my-color-field').wpColorPicker();



});