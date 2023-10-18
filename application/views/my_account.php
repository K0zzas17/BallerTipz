<div class="container">
	<div class="text-center">
	<?php 

	if ($profile_picture) {
		foreach ($profile_picture as $img) {
			echo '<img class="rounded-circle mx-auto d-block mt-3" src="'.base_url().'uploads/profile_pictures/'.$img.'" alt="profile-picture" width="150" height="150">';
		} 
	}

	?>
	</div>
	
	<h1 class='text-center'><b><?php echo $this->session->userdata('username'); ?></b></h1><hr>
	<?php 
		if (!$valid) {	
			echo '<h3 class="text-danger">Your account is incomplete. 
						Please complete the needed items to complete your account setup. <a class="text-dark" href="complete_profile"><u>Complete profile.</u></a></h3><hr>';
		}

		if (!is_null($token)) {
			echo '<h3 class="text-danger d-inline"> Email not verified. 
			<a class="text-danger" href="verify_email/send_verification"><u>Re-send email verification</u></a>
			or click<a class="text-danger" href="verify_email"> <u>here</u></a> to verify your account.</h3><hr>';
		}
	?>
	
	<div id="body" class='text-left'>
	<a href="<?php echo base_url(); ?>account_information" ><h5>Account Information</h5></a><br>
		<a href="upload_profile_picture" ><h5>Change profile picture</h5></a><br>
        <a href="<?php echo base_url(); ?>update_details" ><h5>Update profile details</h5></a><br>
        <a href="my_account/get_questions" ><h5>My Questions</h5></a><br>
        <a href="my_account/get_answers" ><h5>My Answers</h5></a><br>		
	</div>

</div>

