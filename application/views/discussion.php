<style type="text/css">
    textarea {
        resize:none;
    }

</style>

<div class="container">
    <div class="row justify-content-start">
    <div class="col-6 col-md-4">
    <h1>Discussion forum</h1>
        <div class="list-group" id="list-tab" role="tablist">
        <?php 
        $active = '';

                //Questions are shown in a list by iterating through an array containing all question tuples as arrays
                foreach ($db_questions as $questions) {
                    if ($active_question == $questions[0]) {
                        $active = 'active';
                    } else {
                        $active = 'not-on';
                    }
                   
                    echo '<a class="list-group-item list-group-item-action '.$active.'" id="list-'.$questions[0].'-list" data-toggle="list" href="#list-'.$questions[0].
                    '" role="tab" aria-controls="home">'.'#'.$questions[0].' '.$questions[1]."<br></a> ";
                }
                ?>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-8 mt-5">
        <div class="tab-content" id="nav-tabContent">
        <?php 
        
            //Similar process as described above
            foreach ($db_questions as $questions) {
                /* Set variables which will be used to build the answer and question forms */
                $answer_form = ''; //Answer form text
                $show = ''; //Defines whether or not tab is show when page is first opened
                if ($active_question == $questions[0]) {
                    $active = 'active';
                    $show = 'show active';
                } else {
                    $active = 'not-on';
                    $show = '';
                }


                $favourite_button_text = 'Remove favourite'; //If user has already favourited an 
                $question_favourite_button = ' Favourites: '.'<div class="d-inline-block"><p id="ratings">'.$questions[5].'<p></div>'.'<br>';
                $question_date = date_create_from_format('Y-m-j', $questions[4]); //Modify data format
                $question_display = '<h1><b>#'.$questions[0].' '.$questions[1].'</b><br><h4>Posted by '.$questions[2].' On '.date_format($question_date, 'M d Y').
                '</h4><br><p class="h3 font-weight-normal">'.$questions[3].'</p>'; //Text related to question from questions database
             
                $answers_display = '<h3>Replies</h3>';
                foreach ($db_answers as $answers) {
                   
                    if ($answers[1] == $questions[0]) {
                    $answer_date = date_create_from_format('Y-m-j', $answers[4]); //Modify data format
                    $answers_display .= '<br><p class="h4 font-weight-normal">'.$answers[3].'</p><p class="font-weight-normal"> - '.$answers[2].' On '.date_format($answer_date, 'M d Y').'</p>';
                
                    }
                }                  
                
                //Check favourite status to determine button type
                if (!($favourite_status[0] && $questions[0] == $favourite_status[1])) {
                    $favourite_button_text = 'Add favourite';                    
                }
                
                $question_favourite_button =  
                    form_open(base_url()."discussion/add_question_favourite")
                    .'<div class="form-group"><input class="btn btn-primary" type="submit" value="'.$favourite_button_text.'"> 
                    Favourites: <p class="d-inline-block" id="ratings">'.$questions[5].'<p></div>'.
                    '<div class="form-group">
                    <input class="d-none" name="question_id" type="text" value="'.$questions[0].'">
                    </div>'
                    .form_close();
               
                $answer_form = 
                
                    form_open(base_url()."discussion/post_answer").'
                    <div class="form-group">
                        <br><label class="h5" for="answer">Your Answer</label><br>
                        <textarea class="form-control resize-none" name="answer" id="answer" required="required" 
                            rows="10" columns="40" maxlength="200" placeholder="Write your answer here..."></textarea>
                    </div>
                    <div class="form-group">
						<?php echo $error; ?>
					</div>
                    <div class="form-group">
                        <input class="d-none" name="question_id" type="text" value="'.$questions[0].'">
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-block">
                    </div>
                    '.form_close();
 

                if ($answers_display == '<h3>Replies</h3>') {
                    $answers_display = '<h3>Be the first to write a reply below!</h3>';
                }


                echo '<div class="tab-pane fade'.$show.'" id="list-'.$questions[0].'" role="tabpanel" aria-labelledby="list-'.
                $questions[0].'-list">'.$question_display.$question_favourite_button.'<hr>'.$answers_display.$answer_form.'</div>';

            }
        ?>

        </div>
    </div>
    </div>
        </div>