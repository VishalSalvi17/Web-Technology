<?php
// INIT
require __DIR__ . DIRECTORY_SEPARATOR . "lib" . DIRECTORY_SEPARATOR . "2a-config.php";
require PATH_LIB . "2b-lib-poll.php";
$pollDB = new Poll();

// DUMMY USER SESSION
// REMOVE THIS IN YOUR OWN PROJECT...
$_SESSION['user'] = [
    "id" => 999,
    "name" => "Jonh Doe"
];

// HANDLE AJAX REQUEST
switch ($_POST['req']) {
  /* [INVALID REQUEST] */
  default:
    echo "Invalid request";
    break;

  /* [SAVE VOTE] */
  case "save":
    echo $pollDB->save($_POST['poll_id'], $_POST['option_id'], $_SESSION['user']['id']) ? "OK" : "ERR";
    break;

  /* [SHOW POLL DOCKET] */
  // THERE ARE TWO "MODES" IN THIS DOCKET
  // O) SHOW VOTE OPTIONS (OPEN FOR REGISTERED USERS ONLY)
  // R) SHOW VOTE RESULTS
  case "show":
    // SHOW RESULTS BY DEFAULT
    $mode = "R";

    // CHECK IF USER HAS VOTED
    // SWITCH TO VOTE OPTIONS IF USER HAS NOT VOTED
    $voted = false;
    if (is_array($_SESSION['user'])) {
      $voted = $pollDB->hasVoted($_POST['poll_id'], $_SESSION['user']['id']);
      if (!$voted) { $mode = "O"; }
    }

    // USER CHOOSES TO SEE THE RESULTS
    if ($_POST['show']==1) { $mode = "R"; }

    // GET POLL QUESTION + OPTIONS
    $poll = $pollDB->get($_POST['poll_id']);

    // SHOW VOTE DOCKET
    if (is_array($poll)) {
      echo "<div class='poll-dock'>";
      echo "<div class='poll-question'>" . $poll['question'] . "</div>";

      // SHOW VOTING FORM - ONLY FOR REGISTERED USERS
      if (is_array($_SESSION['user']) && $mode=="O") {
        echo "<form class='poll-options' onsubmit='return polljs.save();'>";
        foreach ($poll['options'] as $oid=>$o) {
          printf("<div class='poll-option'><input type='radio' name='poll' id='poll-%u' value='%u'/> <label for='poll-%u'>%s</label></div>", $oid, $oid, $oid, $o);
        }
        echo "<input type='submit' value='Submit'/> <input type='button' value='Show Results' onclick='polljs.show(1)'/>";
        echo '</form>';
      }

      // SHOW VOTE RESULTS
      else {
        $votes = $pollDB->getVotes($_POST['poll_id']);
        echo "<div class='poll-votes'>";
        foreach ($poll['options'] as $oid=>$o) {
          $percent = ($votes[$oid]/$votes['total'])*100;
          printf("<div>%s</div><div class='poll-stats'>%0.2f%% (%u votes)</div>", $o, $percent, $votes[$oid]);
          printf("<div class='poll-bar-outside'><div class='poll-bar-inside' style='width:%0.2f%%'></div></div>", $percent);
        }
        echo "</div>";
      }

      echo '</div>';
    } else {
      echo "INVALID POLL!";
    }
    break;
}
?>