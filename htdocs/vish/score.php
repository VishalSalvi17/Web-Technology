<?php
// (1) INIT
set_time_limit(60); // Set the appropriate time limit
ignore_user_abort(false); // Stop when polling breaks
// ! CHANGE THESE TO YOUR OWN !
define('DB_HOST', 'localhost');
define('DB_NAME', 'test');
define('DB_CHARSET', 'utf8');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

// (2) DATABASE
class DB {
  protected $pdo = null;
  protected $stmt = null;
  function __construct() {
    try {
      $this->pdo = new PDO(
        "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET . ";dbname=" . DB_NAME, 
        DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]
      );
      return true;
    } catch (Exception $ex) {
      print_r($ex);
      die();
    }
  }
  function __destruct() {
    if ($this->stmt !== null) { $this->stmt = null; }
    if ($this->pdo !== null) { $this->pdo = null; }
  }
  function getScore() {
    $this->stmt = $this->pdo->prepare("SELECT * FROM `score` ORDER BY `score_time` DESC LIMIT 1");
    $this->stmt->execute();
    $result = $this->stmt->fetchAll();
    return count($result)==0 ? ["t"=>0, "h"=>0, "a"=>0] : ["t"=>strtotime($result[0]['score_time']), "h"=>$result[0]['score_home'], "a"=>$result[0]['score_away']];
  }
}
$pdoDB = new DB();

// (3) LOOP - CHECK FOR UPDATES
// Will keep looping until a score update or AJAX timeout
while (true) {
  $score = $pdoDB->getScore();
  if ($score['t']>$_POST['last']) {
    echo json_encode($score);
    break;
  }
  sleep(1);
}
?>