<?php 
	include_once 'db.php';
	date_default_timezone_set("Africa/Banjul");
	if (isset($_POST['vote'])) {
		$email = $_POST['email'];
		if (!isset($_POST['choice'])) {
			$choice = $_POST['choice'] = "Null";
			header("Location: index.php?choice_not_set");
		}else {
			$choice = $_POST['choice'];
		}
		if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			header("Location: index.php?email_invalid");
		}else {
			$sql = mysqli_query($db, "SELECT voters_email FROM voters WHERE voters_email = '$email'");
			if (mysqli_num_rows($sql) > 0) {
				header("Location: index.php?email_has_been_used");
			}else{
				$date_added = date("Y-m-d H:i:s");
				$query = mysqli_query($db, "INSERT INTO voters VALUES('','$email','$choice','$date_added');");
				if (!$query) {
					header("Location: index.php?could_not_vote");
				}else{
					header("Location: index.php?thanks_for_voting");
				}
			}
		}
	}