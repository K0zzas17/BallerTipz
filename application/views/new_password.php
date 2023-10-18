<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'reset_password/change_password'); ?>
				<h2 class="text-center">Update password for <?php echo $email; ?></h2>       
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Password" required="required" name="password">
                        <input name= "email" value="<?php echo $email; ?>" class="d-none"></input>
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Confirm Password" required="required" name="password_2">
					</div>
					<div class="form-group">
						<?php echo $error; ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Change password</button>
					</div>
			<?php echo form_close(); ?>
	</div>
</div>