<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'reset_password/check_email'); ?>
				<h2 class="text-center">Reset your password.</h2>       
					<div class="form-group">
                        <label for="email">Enter your account's email address below:</label>
						<input type="email" class="form-control" placeholder="Email" required="required" name="email">
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
