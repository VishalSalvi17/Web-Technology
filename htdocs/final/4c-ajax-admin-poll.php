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

  /* [SHOW POLLS LIST] */
  // YOU MIGHT WANT TO PROPERLY PAGINATE THIS
  case "list":
    $polls = $pollDB->getAll(); ?>
    <h1>MANAGE POLLS</h1>
    <input type="button" value="Add Poll" onclick="polljs.addEdit()"/>
    <?php if (is_array($polls)) {
      foreach ($polls as $p) {
        printf("<div>%s <input type='button' value='Delete' onclick='polljs.del(%u)'/> <input type='button' value='Edit' onclick='polljs.addEdit(%u)'/></div>", $p['poll_question'], $p['poll_id'], $p['poll_id']);
      }
    } else {
      echo "No polls found";
    }
    break;

  /* [DELETE POLL] */
  case "del":
    echo $pollDB->del($_POST['poll_id']) ? "OK" : "ERR";
    break;

  /* [ADD/EDIT DOCKET] */
  case "addEdit":
    $edit = is_numeric($_POST['poll_id']);
    if ($edit) {
      $poll = $pollDB->get($_POST['poll_id']);
    } ?>
    <h1><?=$edit?"EDIT":"ADD"?> POLL</h1>
    <h3>QUESTION</h3>
    <input type="hidden" id="ae-poll-id" value="<?=$_POST['poll_id']?>"/>
    <input type="text" id="ae-poll-text" value="<?=$poll['question']?>"/>
    <h3>OPTIONS</h3>
    <div id="ae-poll-opt"><?php
    if (is_array($poll['options'])) {
      foreach ($poll['options'] as $o) {
        printf("<div><input type='text' class='ae-poll-opt' value='%s'> <input type='button' value='Remove' onclick='polljs.remove(this)'/></div>", $o);
      }
    }
    ?></div>
    <input type="button" value="Add option" onclick="polljs.create()"/>
    <hr>
    <input type="button" value="Back" onclick="polljs.list()"/>
    <input type="button" value="Save" onclick="polljs.save()"/>
    <?php break;

  /* [ADD POLL] */
  case "add":
    echo $pollDB->add($_POST['poll_question'], $_POST['poll_options']) ? "OK" : "ERR";
    break;

  /* [EDIT POLL] */
  case "edit":
    echo $pollDB->edit($_POST['poll_question'], $_POST['poll_options'], $_POST['poll_id']) ? "OK" : "ERR";
    break;
}
?>