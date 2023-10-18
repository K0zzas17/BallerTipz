<div class="container">
      <div class="col-4 offset-4">	
	  <?php if ($valid) : echo $error; else : ?>
        <?php echo form_open(base_url().'complete_profile/submit_profile_details'); ?>
				<h2 class="text-center">Complete Profile</h2>       
				<h6 class="text-center">Enter your details below.</h6>
					<div class="form-group">
					<label for="given_name">Given name/s:</label>
						<input type="text" class="form-control" placeholder="Given Name/s" required="required" name="given_name">
					</div>
					<div class="form-group">
					<label for="surname">Surname:</label>
                        <input type="text" class="form-control" placeholder="Surname" required="required" name="surname">
					</div>
					<div class="form-group">
						<label for="dob">Date of Birth:</label>
						<input type="date" class="form-control" placeholder="DOB" required="required" name="dob" min="01/01/1900" max="26/06/2022">
					</div>
					<div class="form-group">
					<label for="contact_number">Contact number:</label>
                    <input type="tel" class="form-control" placeholder="contact number" required="required" name="contact_number">
					</div>
					
					<div class="form-group">
						<?php echo $error; ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Update my profile</button>
					</div>
		<?php echo form_close(); ?>		 
		<?php endif; ?>
	</div>
</div>