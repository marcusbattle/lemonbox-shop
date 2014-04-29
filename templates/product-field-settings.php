<div id="product-settings" class="custom-setting" data-title="Product Settings">
	<ul>
		<li>
			<label>Prdouct</label>
			<select id="product_id" multiple style="width: 100%;">
				<?php foreach( lbox_get_products() as $product ): ?>
					<option value="<?php echo $product->ID ?>" data-price="40"><?php echo $product->post_title ?></option>
				<?php endforeach; ?>
			</select>
			<small>Select multiple categories by holding control (command on Mac) and click</small>
		</li>
		<!-- <li>
			<label>Price</label>
		</li> -->
	</ul>
	<script>
		(function($){
			
			// Update product settings
			$(document).on( 'click', '#lbox-fields > div', function() {
				
				// if ( ($(this).data('field-type') != 'product') || ($(this).data('field-type') == undefined) ) $('#product-settings').hide();
				// else if ( ($(this).data('field-type') == 'product') && $(this).hasClass('focus') ) $('#product-settings').show();

				if ( ($(this).data('field-type') == 'product') ) {
					
					var options = [];

					$(this).find('select option').each(function(i) {
						options[i] = $(this).val();
					});

					$('.custom-setting #product_id').val( options );

				}

			});

			// Update the product field dropdown
			$('.custom-setting #product_id').on('click', function(){

				var products = $(this).find(':selected');

				if ( $('#lbox-fields > div.focus').data('field-type') == 'product'  ) {
					
					var select = $('#lbox-fields > div.focus select');

					$(select).html('<option>--</option>');
					
					$(products).each(function() {
						
						$(select).append( $(this).clone() );

					});

					update_form_html();

				}

			});
			
		})(jQuery);
	</script>
</div>