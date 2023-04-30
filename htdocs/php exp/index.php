<?php
    //include and initialize Poll class 
    include 'Poll.class.php';
    $poll = new Poll;

    //get poll and options data
    $pollData = $poll->getPolls();
?>
<div class="pollContent">
    <?php echo !empty($statusMsg)?'<p class="stmsg">'.$statusMsg.'</p>':''; ?>
    <form action="" method="post" name="pollFrm">
    <h3><?php echo $pollData['poll']['subject']; ?></h3>
    <ul>
        <?php foreach($pollData['options'] as $opt){
            echo '<li><input type="radio" name="voteOpt" value="'.$opt['id'].'" >'.$opt['name'].'</li>';
        } ?>
    </ul>
    <input type="hidden" name="pollID" value="<?php echo $pollData['poll']['id']; ?>">
    <input type="submit" name="voteSubmit" class="button" value="Vote">
    <a href="results.php?pollID=<?php echo $pollData['poll']['id']; ?>">Results</a>
    </form>
</div>