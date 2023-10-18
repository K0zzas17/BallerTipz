<div class="row">
      <div class="col-md-6">	
          <h2 class="text-left">Please select the details you would like to update.</h2><br>
		<a href="update_name"><h5>My profile name</h5></a><br>
        <a href="update_email" ><h5>My email</h5></a><br>
        <a href="update_contact_number" ><h5>My contact number</h5></a><br>
        <a href="#"><h5>My Password</h5></a><br>
      </div>

      <div class="col-md-6">    
		<?php echo form_open(base_url()."update_details/update_password_details"); ?>
				<h2 class="text-center">Update password</h2>
					<div class="form-group">
					<label for="old_password">Old password</label>
						<input type="password" class="form-control" placeholder="Old password" name="old_password" required="required">
					</div>
					<div class="form-group">
					<label for="new_password">New passowrd</label>
                        <input type="password" class="form-control" placeholder="New password" name="new_password" required="required">
					</div>
					<div class="form-group">
						<label for="new_password_verify">Re-enter password</label>
						<input type="password" class="form-control" placeholder="Re-enter password" name="new_password_verify" required="required">
					</div>
					<div class="form-group">
						<?php echo $error; ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Update my password</button>
					</div>
					<p><b>Note:</b> Only input what you want to change!</p>       
		<?php echo form_close(); ?>	
    </div>
	
</div>