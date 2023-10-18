<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'login/create_user'); ?>
				<h2 class="text-center">Create new User</h2>       
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Username" required="required" name="username">
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Email Address" required="required" name="emai">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Password" required="required" name="password">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Re-enter Password" required="required" name="password2">
					</div>
					<div class="form-group">
						<label for="basketballPositionForm">What's your main position?</label>
						<select class="form-control" id="basketballPositionForm">
							<option>Point Guard (1)</option>
							<option>Shooting Guard (2)</option>
							<option>Small Forward (3)</option>
							<option>Power Forward (4)</option>
							<option>Center (5)</option>
						</select>
					</div>
					<div class="form-group">
					<?php echo $error; ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Create User</button>
					</div>
					<div class="clearfix">
						<label class="float-left form-check-label"><input type="checkbox"> Remember me</label>
						<a href="#" class="float-right">Forgot Password?</a>
					</div>    
			<?php echo form_close(); ?>
	</div>
</div>