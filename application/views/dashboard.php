<div class="container">
    <h1 class="text-center">Welcome to the Dashboard!</h1><br>
    <h4 class="text-center">Here, you can access questions, user stats, ratings and more!</h4> 
    <?php echo form_open('dashboard', array('method'=>'get'))?>

    <div class="container d-flex justify-content-center">
        <div class="col-2 form-inline">
            <label for="user">User:&nbsp;</label>
            <input size="5" id="user" type="text" class="form-control" name="user" value="<?php echo $user;  ?>">
        </div>

        <div class="col-3 form">
            <div class="form-group">
                <label for="ratings">Number of ratings:&nbsp;</label>
                <select name="ratings" id="ratings" class="form-control" >
                    <option <?php if ($ratings == 'asc')  echo 'selected';  ?> value="asc">Ascending</option>
                    <option <?php if ($ratings == 'desc') echo 'selected'; ?>  value="desc">Descending</option>
                </select>
            </div>
        </div>

        <div class="col-3 form">
            <div class="form-group">
                <label for="questions_asked">Number of ratings asked:&nbsp;</label>
                <select name="questions_asked" id="questions_asked" class="form-control" >
                    <option <?php if ($questions_asked == 'asc')  echo 'selected'; ?> value="asc">Ascending</option>
                    <option <?php if ($questions_asked == 'desc') echo 'selected'; ?>  value="desc">Descending</option>
                </select>
            </div>
        </div>

        <div class="col-3 form">
            <div class="form-group">
                <label for="questions_answered">Number of answers asked:&nbsp;</label>
                <select name="questions_answered" id="questions_asked" class="form-control" >
                    <option <?php if ($questions_answered == 'asc')  echo 'selected'; ?> value="asc">Ascending</option>
                    <option <?php if ($questions_answered == 'desc') echo 'selected'; ?>  value="desc">Descending</option>
                </select>
            </div>
        </div>

        <div class="col-2 form-inline">
            <button type="submit"  class="btn btn-primary" >Go!</button>
        </div>

    </div>
    </form>

    <hr>

    <table class="table table-striped text-center">
        <thead>
        <tr>
            <th>User</th>
            <th>Order of ratings</th>
            <th>Number of ratings</th>
            <th>Number of answers</th>
        </tr>
        </thead>
        <tbody>
        <?php if(isset($users))
            foreach($users as $tuple){
                echo "
				<tr>
					<td>$tuple->username</td>
					<td>$tuple->question_title</td>
					<td>$tuple->ratings</td>
					<td>$tuple->answers</td>
				</tr>
			";
            }?>
        </tbody>
    </table>    
</div>