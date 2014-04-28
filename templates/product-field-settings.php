<div class="custom-setting" data-title="Product Settings" data-field-type="product">
	<ul>
		<li>
		   	<label>Products</label>
		   	<select id="product_id" multiple style="width: 100%;">
		   		<?php foreach( lbox_get_products() as $product ): ?>
		  			<option value="<?php echo $product->ID ?>"><?php echo $product->post_title ?></option>
				<?php endforeach; ?>	  
			</select>
			<small>To select more than one product hold down control (command on Mac) and click</small>
		</li>
	</ul>
	<script>
		(function($){
			$('.custom-setting #product_id').on('click', function(){
				if ( $('#lbox-form-fields > div.focus').data('field-type') == 'product' ) {
					alert('editing a product');
				}
			});
		})(jQuery);
	</script>
</div>