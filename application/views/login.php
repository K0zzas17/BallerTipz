<style>
   .g-recaptcha {
        display: inline-block;
    }
</style>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'login/check_login'); ?>
				<h2 class="text-center">Login</h2>       
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Username" required="required" name="username">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Password" required="required" name="password">
					</div>
					<div class="g-recaptcha" data-sitekey="6LcRth4gAAAAAKonyedRTNi59s6SH1Zqy_uB6dbs"></div>
					<div class="form-group">
					<?php echo $error; ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Log in</button>
					</div>
					<div class="clearfix">
						<label class="float-left form-check-label"><input type="checkbox" name="remember"> Remember me</label>
						<a href="reset_password" class="float-right">Forgot Password?</a>
					</div>    
			<?php echo form_close(); ?>
	</div>
</div>
