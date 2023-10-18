<div class="container">
<div class="text-center">
	<?php 
	if ($profile_picture) {
		foreach ($profile_picture as $img) {
			echo '<img class="rounded-circle mx-auto d-block mt-3" src="'.base_url().'uploads/profile_pictures/'.$img.'" alt="profile-picture" width="100" height="100">';
		}
	} 
	?>
	</div>
	<h1 class='text-center'><b><?php echo $this->session->userdata('username'); ?></b></h1><hr>
	<div class="text-center h4">
		<?php if ($error) : echo $error; endif; ?>
		<?php 
		//After the email is sent, resents the email_sent property.
		echo $this->session->flashdata('email_sent');
			 $this->session->flashdata('email_sent', ''); ?>
	</div>
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
	<p class="h3 font-weight-normal">Hey <b><?php echo $this->session->userdata('username'); ?></b>, please check out the links below or what you need. Click here to check your profile status.</p>

	<div class="body text-center">
		<a class="btn btn-dark m-2" href="<?php echo base_url(); ?>questions" role="button"> Ask a Question </a>
		<a class="btn btn-dark m-2" href="<?php echo base_url(); ?>discussion" role="button"> Discussion Hub </a>
		<a class="btn btn-dark m-2" href="<?php echo base_url(); ?>#" role="button"> My nearest court </a>
	</div>


</div>