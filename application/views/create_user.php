<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'create_user/check_details'); ?>
				<h2 class="text-center">Create new User</h2>       
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Username" required="required" name="username">
					</div>
					<div class="form-group">
						<input type="email" class="form-control" placeholder="Email Address" required="required" name="email">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Password" required="required" name="password">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Re-enter Password" required="required" name="password_2">
					</div>
					<div class="form-group"> 
						<label for="secret-question">Please choose a secret question.</label>
						<select class="form-control" id="secret_question" required="required" name="secret_question">
							<option>What is your mother's maiden name?</option>
							<option>What is the name of your first pet?</option>
							<option>What was the model of your first car?</option>
							<option>What is the name of your childhood best friend?</option>
							<option>What is your city of birth?</option>
						</select>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Answer" required="required" name="secret_answer">
					</div>
					<div class="form-group">
						<?php echo $error; ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Create User</button>
					</div>
			<?php echo form_close(); ?>
	</div>
</div>