<?php
class Poll {
  protected $pdo = null;
  protected $stmt = null;

  function __construct () {
  // __construct() : connect to the database
  // PARAM : DB_HOST, DB_CHARSET, DB_NAME, DB_USER, DB_PASSWORD

    try {
      $this->pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET, DB_USER, DB_PASSWORD, [
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::ATTR_EMULATE_PREPARES => false
        ]
      );
      return true;
    } catch (Exception $ex) {
      $this->CB->verbose(0, "DB", $ex->getMessage(), "", 1);
    }
  }

  function __destruct () {
  // __destruct() : close connection when done

    if ($this->stmt !== null) { $this->stmt = null; }
    if ($this->pdo !== null) { $this->pdo = null; }
  }

  function save ($pollID, $optionID, $userID){
  // save() : save the vote
  // PARAM $pollID - poll ID
  //       $optionID - option ID
  //       $userID - user ID

    // REMOVE OLD ENTRY, JUST IN CASE.
    $sql = "DELETE FROM `poll_votes` WHERE `poll_id`=? AND `user_id`=?";
    $cond = [$pollID, $userID];
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
    } catch (Exception $ex) {
      // die($ex->getMessage());
      return false;
    }

    // ADD ENTRY
    $sql = "INSERT INTO `poll_votes` (`poll_id`, `option_id`, `user_id`) VALUES (?, ?, ?)";
    $cond = [$pollID, $optionID, $userID];
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
    } catch (Exception $ex) {
      // die($ex->getMessage());
      return false;
    }

    return true;
  }

  function add ($question, $options) {
  // add() : add a new poll
  // PARAM $question - poll question
  //       $options - poll options (array)

    // ADD MAIN ENTRY
    $sql = "INSERT INTO `poll_main` (`poll_question`) VALUES (?)";
    $cond = [$question];
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
    } catch (Exception $ex) {
      return false;
    }

    // ADD OPTIONS
    $pollID = $this->pdo->lastInsertId();
    $sql = "INSERT INTO `poll_options` (`poll_id`, `option_id`, `option_text`) VALUES ";
    $cond = [];
    $i = 1;
    foreach ($options as $o) {
      $sql .= "(?, ?, ?),";
      array_push($cond, $pollID, $i, $o);
      $i++;
    }
    $sql = substr($sql, 0, -1) . ";";
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
    } catch (Exception $ex) {
      return false;
    }

    return true;
  }

  function edit ($question, $options, $pollID) {
  // edit() : edit a poll
  // PARAM $question - poll question
  //       $options - poll options (array)
  //       $pollID - poll ID

    // UPDATE MAIN ENTRY
    $sql = "UPDATE `poll_main` SET `poll_question`=? WHERE `poll_id`=?";
    $cond = [$question, $pollID];
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
    } catch (Exception $ex) {
      return false;
    }

    // REMOVE OLD OPTIONS
    $sql = "DELETE FROM `poll_options` WHERE `poll_id`=?";
    $cond = [$pollID];
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
    } catch (Exception $ex) {
      return false;
    }

    // ADD OPTIONS
    $sql = "INSERT INTO `poll_options` (`poll_id`, `option_id`, `option_text`) VALUES ";
    $cond = [];
    $i = 1;
    foreach ($options as $o) {
      $sql .= "(?, ?, ?),";
      array_push($cond, $pollID, $i, $o);
      $i++;
    }
    $sql = substr($sql, 0, -1) . ";";
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
    } catch (Exception $ex) {
      return false;
    }

    return true;
  }

  function del ($pollID) {
  // del() : delete poll
  // PARAM $pollID - poll ID

    // DELETE ALL VOTES
    $sql = "DELETE FROM `poll_votes` WHERE `poll_id`=?";
    $cond = [$pollID];
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
    } catch (Exception $ex) {
      return false;
    }

    // DELETE ALL OPTIONS
    $sql = "DELETE FROM `poll_options` WHERE `poll_id`=?";
    $cond = [$pollID];
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
    } catch (Exception $ex) {
      return false;
    }

    // DELETE MAIN POLL
    $sql = "DELETE FROM `poll_main` WHERE `poll_id`=?";
    $cond = [$pollID];
    try {
      $this->stmt = $this->pdo->prepare($sql);
      $this->stmt->execute($cond);
    } catch (Exception $ex) {
      return false;
    }

    return true;
  }
  
  function getAll () {
  // getAll() : get all polls
  // You might want to paginate this properly

    $sql = "SELECT * FROM `poll_main` WHERE 1";
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute();
    $polls = $this->stmt->fetchAll();
    return count($polls)==0 ? false : $polls ;
  }

  function get ($id) {
  // get() : get the poll question and options
  // PARAM $id - poll id

    // THE MAIN QUESTION
    $sql = "SELECT * FROM `poll_main` WHERE `poll_id`=?";
    $cond = [$id];
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute($cond);
    $question = $this->stmt->fetchAll();
    if (count($question)==0) { return false; }

    // THE OPTIONS
    $sql = "SELECT * FROM `poll_options` WHERE `poll_id`=?";
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute($cond);
    $options = array();
    while ($row = $this->stmt->fetch(PDO::FETCH_NAMED)) {
      $options[$row['option_id']] = $row['option_text'];
    }

    // FORMAT + RETURN RESULT
    return [
      "question" => $question[0]['poll_question'],
      "options" => count($options)==0 ? false : $options
    ];
  }
  
  function getVotes ($id) {
  // avg() : get the votes count for selected poll
  // PARAM $id - poll id

    $sql = "SELECT COUNT(`option_id`) `votes`, `option_id` FROM `poll_votes` WHERE `poll_id`=? GROUP BY `option_id`";
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute([$id]);
    $result = ["total" => 0];
    $total = 0;
    while ($row = $this->stmt->fetch(PDO::FETCH_NAMED)) {
      $result[$row['option_id']] = $row['votes'];
      $result['total'] += $row['votes'];
    }
    return count($result)==0 ? false : $result ;
  }

  function hasVoted ($pollID, $userID) {
  // hasVoted() : check if the given user has voted for the specified poll
  // PARAM $pollID - poll id
  //       $userID - user id

    $sql = "SELECT * FROM `poll_votes` WHERE `poll_id`=? AND `user_id`=?";
    $this->stmt = $this->pdo->prepare($sql);
    $this->stmt->execute([$pollID, $userID]);
    $voted = $this->stmt->fetchAll();
    return count($voted)==0 ? false : true ;
  }
}
?>