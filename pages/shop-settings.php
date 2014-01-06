<div class="wrap nosubsub">
	<h2>Lemonbox Shop Settings</h2>
	<h3>Stripe Keys</h3>
	<form id="lemonbox-shop-settings">
		<input type="hidden" action="lemonbox_update_shop_settings" />
		<h4>Test Keys</h4>
		<ul>
			<li>Test Secret<input type="text" name="stripe_test_secret_key" value="<?php echo get_option( 'stripe_test_secret_key' ); ?>" /></li>
			<li>Test Publishable<input type="text" name="stripe_test_publishable_key" value="<?php echo get_option( 'stripe_test_publishable_key' ); ?>" /></li>
		</ul>
		<h4>Live Keys</h4>
		<ul>
			<li>Live Secret<input type="text" name="stripe_live_secret_key" value="<?php echo get_option( 'stripe_live_secret_key' ); ?>" /></li>
			<li>Live Publishable<input type="text" name="stripe_live_publishable_key" value="<?php echo get_option( 'stripe_live_publishable_key' ); ?>" /></li>
		</ul>
		<button type="submit">Update Settings</button>
	</form>
</div>