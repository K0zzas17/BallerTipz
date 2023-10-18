<html>
  <head>
          <title>BallerTipz</title>
          <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
          <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/header.css">
          <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
          <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
  </head>
  <body>
    <script>
          // Show select image using file input.
          /*function readURL(input) {
              $('#default_img').show();
              if (input.files && input.files[0]) {
                  var reader = new FileReader();

                  reader.onload = function(e) {
                      $('#select')
                          .attr('src', e.target.result)
                          .width(300)
                          .height(200);

                  };

                  reader.readAsDataURL(input. files[0]);
              }
          } */
    </script>

    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #FF4900;">
      <a class="navbar-brand" href="<?php echo base_url(); ?>login"><img src="<?php echo base_url(); ?>assets/img/ballerTipz_logo-modified.png"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span></button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item mr-3">
                <a href="<?php echo base_url(); ?>login"><i class="bi-house"></i> Home </a>
            </li>
        </ul>

        <ul class="navbar-nav my-lg-2">
          <?php if(!$this->session->userdata('logged_in')) : ?>
              <li class="nav-item">
                <a class="mr-4" href="<?php echo base_url(); ?>login"><i class="bi-box-arrow-in-right"></i> Login </a>
                <a id="create-user" class="btn btn-dark mr-2" href="<?php echo base_url(); ?>create_user" role="button"> Create an account </a>
              </li>
          <?php endif; ?>
          <?php if($this->session->userdata('logged_in')) : ?>
          <li class="nav-item">
            <a class="mr-4" href="<?php echo base_url(); ?>dashboard"><i class="bi bi-bar-chart"></i>Dashboard </a>
            <a class="mr-4" href="<?php echo base_url(); ?>discussion"><i class="bi-chat-left"></i> Discussion Hub </a>
            <a class="mr-4" href="<?php echo base_url(); ?>my_account"><i class="bi-person-circle"></i> My Account</a>
            <a class="mr-4" href="<?php echo base_url(); ?>login/logout"><i class="bi-box-arrow-in-left"></i> Logout</a>
          </li>
          <?php endif; ?>
        </ul>

      </div>

      <?php if($this->session->userdata('logged_in')) : ?>
        <form class="form-inline my-2 my-lg-0 ml-2">
          <?php echo form_open('ajax'); ?>
            <input class="form-control mr-sm-2" id="search_val" type="search" placeholder="Search" name = "search" aria-label="Search">
            <button class="btn btn-outline-dark my-2 my-sm-0" id="search_btn" type="button" data-toggle="collapse" data-target="#collapsed" 
            aria-expanded="false" aria-controls="collapsed">Search</button>
          <?php echo form_close(); ?>        
      <?php endif; ?>
  
    </nav>


  <div class="container">
    <div class="collapse" id="collapsed">
      <div class="card-header">
        Results
      </div>
      <div class="card card-body" id="result">

      </div>
    </div>

    <script>
    $(document).ready(function(){
      load_data();
          //Search funciton
          function load_data(query){
              $.ajax({
              url:"<?php echo base_url(); ?>ajax/search_questions", //gets method search_questions result based off query (search value)
              method:"GET",
              data:{query:query},
              success:function(response){
                  $('#result').html("");
                  if (response == "" ) {
                      $('#result').html(response);
                  }else{
                      //saves JSON string (search query) as a variable obj in array form
                      var obj = JSON.parse(response);
                      if(obj.length>0){ 
                          var items=[];
                          $.each(obj, function(i,val){
                            items.push($("<a class='h5' href='<?php echo base_url().'discussion?active='; ?>" + val.question_id + "'>").text(val.question_title + ' -' + val.question_author));
                      });
                      $('#result').append.apply($('#result'), items);         
                      }else{
                      $('#result').html("Not Found!");
                      }; 
                  };
              }
          });
          }
          $('#search_val').keyup(function(){ //Search function ativats on keyup
              var search = $(this).val(); //probides query search value for load data
              if(search != ''){
                  load_data(search);
              }else{
                  load_data();
              }
          });
      });


    </script>

