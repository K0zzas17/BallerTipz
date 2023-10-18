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
	<h1 class='text-center'><b><?php echo $this->session->userdata('username'); ?></b><hr>
	<h1 class='text-left'>Your Account information</h1>
	<div id="body" class='text-left'>
        <ul class="list-group list-group-flush">
        <?php
        foreach ($user_info as $info) {
            $verified_email = ' <a href="update_details/update_email">Change</a></li>';
            if ($info[1] == $this->session->userdata('username')) {
                if ($info[8] == 0) {
                echo '<h3 class="text-danger">Your account is incomplete. 
                Please complete the needed items to complete your account setup. <a class="text-dark" href="complete_profile"><u>Complete profile.</u></a></h3><hr>';
                }
                
                if (!is_null($info[7])) {
                    $verified_email = '<p class="text-danger d-inline"> Email not verified. 
                    <a class="text-danger" href="verify_email/send_verification"><u>Re-send email verification.</u></a>
                    or click<a class="text-danger" href="verify_email"> <u>here</u></a> to verify your account.</p>';
                }

                echo '<li class="list-group-item">Username: '.$info[1].'</li>';
                echo '<li class="list-group-item">Name: '.$info[3].' '.$info[4]. ' <a href="update_details/update_name">Change</a></li>';
                echo '<li class="list-group-item">Email: '.$info[2].$verified_email;
                echo '<li class="list-group-item">Contact Number: '. $info[6].' <a href="update_details/update_contact_number">Change</a></li>';
                echo '<li class="list-group-item">Date of birth: '.$info[5].' <a href="update_details/update_dob">Change</a></li>';
            }
        }
            ?>
        </ul>	
	</div>

</div>

