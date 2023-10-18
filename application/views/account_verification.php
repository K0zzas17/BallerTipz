<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'reset_password/check_details'); ?>
				<h2 class="text-center">Answer the secret question:</h2>       
					<div class="text-center">
						<input name="secret_question" type="text" readonly class="form-control-plaintext" value="<?php echo $secret_question; ?>"></input>
						<input name= "email" value="<?php echo $email; ?>" class="d-none"></input>
					</div>
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Answer" required="required" name="secret_answer">
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
