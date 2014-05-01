<button>Product
	<div class="field form-group" data-field-type="product" data-disable-name="true" data-disable-placeholder="true">
		<label>Product</label>
		<div class="row">
			<div class="col-xs-8 col-sm-8 col-md-8">
				<select name="fields[product_id][]" class="form-control">
					<option value="">--</option>
				</select>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4">
				<div class="input-group">
					<span class="input-group-addon">$</span>
					<input type="text" name="fields[amount][]" class="form-control" placeholder="00.00" />
				</div>
			</div>
		</div>
	</div>
	<div class="field form-group" data-field-type="creditcard" data-disable-name="true" data-disable-placeholder="true">
		<div class="row row-1">
			<div class="col-xs-8 col-sm-8 col-md-8">
				<label>Credit Card</label>
				<input type="text" name="fields[card_number]" class="form-control" placeholder="**** **** **** 0000" />
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4">
				<label>Secuirty Code</label>
				<input type="text" name="fields[cvc_code]" class="form-control" placeholder="•••" maxlength="3" />
			</div>
		</div>
		<div class="row row-2">
			<div class="col-xs-6 col-sm-6 col-md-6">
				<label>Name on Card</label>
				<input type="text" name="fields[name_on_card]" class="form-control" placeholder="John Doe" />
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6">
				<label>Expiration</label>
				<div class="row">
					<div class="col-xs-6 col-md-6">
						<select name="fields[exp_month]" class="form-control">
							<option value="">MM</option>
							<option value="">01</option>
							<option value="">02</option>
							<option value="">03</option>
							<option value="">04</option>
							<option value="">05</option>
							<option value="">06</option>
							<option value="">07</option>
							<option value="">08</option>
							<option value="">09</option>
							<option value="">10</option>
							<option value="">11</option>
							<option value="">12</option>
						</select>
					</div>
					<div class="col-xs-6 col-md-6">
						<select name="fields[exp_year]" class="form-control">
							<option value="">YY</option>
							<?php for( $y = 0; $y < 11; $y++ ): $year = date('y', strtotime('+' . $y . ' years' )); ?>
							<option value="<?php echo $year ?>"><?php echo $year ?></option>
							<?php endfor; ?>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
</button>