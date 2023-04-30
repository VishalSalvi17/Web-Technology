<?php
/*************************************************
 * Micro Polling System
 *
 * Version: 1.0
 * Date: 2007-04-05
 *
 * Usage:
 * Add your votings settings to polldata.txt file
 * The first line is the question and the other
 * linas are the possible answers.
 *
 ****************************************************/

$pollQuestion = '';
$answers = '';

function readData(){
	global $pollQuestion,$answers;
	// Read configuration
	$rawdata = file('polldata.txt');
	// Get the question for polling
	$pollQuestion = $rawdata[0];
	
	// Get number of answers - The foirs row is the question
	$numberOfAnswers = sizeof($rawdata)-1;
	$count = 0;
	for ($i=1; $i <= $numberOfAnswers; $i++){
		$answerData = explode(':',$rawdata[$i]);
		// If tha actual row is not empty than add to the answers array
		if (strlen(trim($answerData[0]))>0){
			$answers[$count]['text']  = $answerData[0];
			$answers[$count]['count'] = $answerData[1];
			++$count;
		}
	}
}

function writeData(){
	global $pollQuestion,$answers;
	$file = fopen('polldata.txt','w');
	fwrite($file,$pollQuestion."\r\n",strlen($pollQuestion));
	foreach ($answers as $value) {
		$row = $value['text'].':'.$value['count']."\r\n";
		fwrite($file,$row,strlen($row));
	}
	fclose($file);
}

readData();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "DTD/xhtml1-transitional.dtd">
<html>
<head>
   <title>Micro Polling System</title>
   <link href="style/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id="main">
<?php if (!isset($_POST['submitBtn'])) { ?>      
      <div class="caption"><?php echo $pollQuestion; ?></div>
      <div id="icon">&nbsp;</div>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="poll">
        <table width="300">
        <?php
        	foreach ($answers as $value) {
				echo '<tr><td><input type="radio" name="polling" value="'.$value['text'].'"/> '.$value['text'].'</td></tr>';
        	}
        ?>
          <tr><td align="center"><br/><input class="text" type="submit" name="submitBtn" value="Vote" /></td></tr>
        </table>  
      </form>
<?php    
} else {
    	$count = 0;
       	foreach ($answers as $value) {
			if ($value['text']  == $_POST['polling']) {
				$answers[$count]['count'] = ((int)$value['count'])+1;
				(int)$totalCount++;
			}
			++$count;
       	}
       	
       	writeData();
?>
      <div class="caption">Thanks for your vote!</div>
      <div id="icon">&nbsp;</div>
      <div id="result">
        <table width="300">
<?php
       	foreach ($answers as $value) {
			echo '<tr><td> '.$value['text'].'</td><td>'.$value['count'].'</td></tr>';
       	}
?>
        </table>
     </div>
<?php } ?>
	<div id="source">Micro Polling System 1.0</div>
    </div>
</body>   
