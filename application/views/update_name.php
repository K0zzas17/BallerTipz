<div class="row">
      <div class="col-md-6">	
          <h2 class="text-left">Please select the details you would like to update.</h2><br>
		<a href="#"><h5>My profile name</h5></a><br>
        <a href="update_email" ><h5>My email</h5></a><br>
        <a href="update_contact_number" ><h5>My contact number</h5></a><br>
        <a href="update_password" ><h5>My Password</h5></a><br>
      </div>

      <div class="col-md-6">    
		<?php echo form_open(base_url()."update_details/update_name_details"); ?>
				<h2 class="text-center">Update profile info</h2>
					<div class="form-group">
					<label for="given_name">First name</label>
						<input type="text" class="form-control" placeholder="Given Name/s" name="given_name">
					</div>
					<div class="form-group">
					<label for="surname">Surname</label>
                        <input type="text" class="form-control" placeholder="Surname" name="surname">
					</div>
					<div class="form-group">
						<?php echo $error; ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Update my profile</button>
					</div>
					<p><b>Note:</b> Only input what you want to change!</p>       
		<?php echo form_close(); ?>	
    </div>
	
</div>