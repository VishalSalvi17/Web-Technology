<?php
    session_start();
    require("dbcontroller.php");
	$dbController = new DBController();
	
	$answer_id  = $_POST['answer'];
	$question_id = $_POST['question'];
	
	$query = "INSERT INTO tbl_poll(question_id,answer_id,member_id) VALUES ('" . $question_id ."','" . $answer_id . "','" . $_SESSION["member_id"] . "')";
    $insert_id = $dbController->insertQuery($query);
    
    if(!empty($insert_id)) {
        $query = "SELECT * FROM tbl_answer WHERE question_id = " . $question_id;
        $answer = $dbController->runQuery($query);
    }
    
    if(!empty($answer)) {
?>        
        <div class="poll-heading"> Rating </div> 
<?php
        $query = "SELECT count(answer_id) as total_count FROM tbl_poll WHERE question_id = " . $question_id;
        $total_rating = $dbController->runQuery($query);

        foreach($answer as $k=>$v) {
            $query = "SELECT count(answer_id) as answer_count FROM tbl_poll WHERE question_id = " .$question_id . " AND answer_id = " . $answer[$k]["id"];
            $answer_rating = $dbController->runQuery($query);
            $answers_count = 0;
            if(!empty($answer_rating)) {
                $answers_count = $answer_rating[0]["answer_count"];
            }
            $percentage = 0;
            if(!empty($total_rating)) {
                $percentage = ( $answers_count / $total_rating[0]["total_count"] ) * 100;
                if(is_float($percentage)) {
                    $percentage = number_format($percentage,2);
                }
            }
            
?>
		<div class="answer-rating"> <span class="answer-text"><?php echo $answer[$k]["answer"]; ?></span><span class="answer-count"> <?php echo $percentage . "%"; ?></span></div>      
<?php 
        }
    }
?>
<div class="poll-bottom">
	<button class="next-link" onClick="show_poll();">Next</button>
</div>