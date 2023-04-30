<?php
    session_start();
    $_SESSION["member_id"] = 9;
    
	require("dbcontroller.php");
	$dbController = new DBController();
	
	$query = "SELECT DISTINCT question_id from tbl_poll WHERE member_id = " . $_SESSION["member_id"]; 
	$result = $dbController->getIds($query);
	
	$condition = "";
	if(!empty($result)) {
	    $condition = " WHERE id NOT IN (" . implode(",", $result) . ")";
    }
    
    $query = "SELECT * FROM `tbl_question` " . $condition . " limit 1";
    $questions = $dbController->runQuery($query);
    
    if(!empty($questions)) {
?>      
		<div class="question"><?php echo $questions[0]["question"]; ?><input type="hidden" name="question" id="question" value="<?php echo $questions[0]["id"]; ?>" ></div>      
<?php 
        $query = "SELECT * FROM tbl_answer WHERE question_id = " . $questions[0]["id"];
        $answers = $dbController->runQuery($query);
        if(!empty($answers)) {
            foreach($answers as $k=>$v) {
                ?>
			<div class="question"><input type="radio" name="answer" class="radio-input" value="<?php echo $answers[$k]["id"]; ?>" /><?php echo $answers[$k]["answer"]; ?></div>      
<?php 
            }
        }
?>
		<div class="poll-bottom">
			<button id="btnSubmit" onClick="addPoll()">Submit</button>
		</div>
<?php        
    } else {
?>
<div class='error'>No Questions Found</div>
<?php 
    }
?>