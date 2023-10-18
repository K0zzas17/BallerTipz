<div class="main mt-5"> 
    <?php echo form_open_multipart('upload_profile_picture/do_upload');?>
<div class="row justify-content-center">
    <div class="col-md-8 col-md-offset-6 centered">
    <h1>Please upload a profile photo. </h1>
        <?php echo $error;?>
    <div class="from-group form-control-lg custom-file">
        <input type="file" class="custom-file-input" id="userfile" name="userfile" data-height="500">
        <label class="custom-file-label" for="userfile">Drag file or click here to browse...</label>
    </div>
    
  <p id="finish_upload"></p>
        <div class="form-group">
            <input id="submit" type="submit" value="upload" />
        </div>
    </div>
</div>

<script>

//Allows selected file text to be visisble  
//Code adapted from stackoverflow
$('.custom-file-input').on('change', function() { 
    
   let new_file = $(this).val().split('\\').pop(); 
   
   $(this).next('.custom-file-label').addClass("selected").html(new_file); 
     $("#finish_upload").append("Click upload below to make this your new profile picture.");
});


</script>

<?php echo form_close(); ?></div>

