<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'verify_email/verify'); ?>
				<h2 class="text-center">Verify your email account.</h2>       
					<div class="form-group">
                        <label for="verify">Enter your account's verification key below:</label>
						<input type="text" class="form-control" placeholder="Verification Key" required="required" name="verify">
					</div>
					<div class="form-group">
					<?php echo $error; ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Submit</button>
					</div>
			<?php echo form_close(); ?>
	</div>
</div>
