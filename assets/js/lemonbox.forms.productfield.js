(function($){
	
	$('select[name="fields[product_id]"]').on( 'change', function(){

		var selected = $(this).find('option:selected');
		var payment_type = selected.data('payment-type');

		if( payment_type && ( payment_type != 'free' ) ) {

			$('div[data-field-type="amount"]').removeClass('hide');

		} else {
			
			$('div[data-field-type="amount"]').addClass('hide');

		}

	});

})(jQuery);