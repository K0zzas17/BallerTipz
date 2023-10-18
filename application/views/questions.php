<div id="container">
	<h1><b>Got a Question? Ask it below:</b></h1>

	<div id="body">
        <?php echo form_open(base_url().'questions/post_question'); ?>
            <div class="form-group">
            <label for="question_title">Question Title:</label>
            <input type="text" class="form-control" id="question_title" placeholder="Title" name="question_title" required="required">
            </div>
            <div class="form-group">
                <label for="question_text">What is your question?</label>
                <textarea id="question_text" class="form-control" rows="3" required="required" name="question_text"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post Question</button>
			<a type="button" href='login' class="btn btn-primary ml-2">Back to homepage</a>
            <div class="form-group">
						<?php echo $error; ?>
					</div>
        <?php echo form_close(); ?>
	</div>
</div>
