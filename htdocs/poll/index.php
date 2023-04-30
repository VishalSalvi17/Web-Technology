<!doctype html>
<html>
	<head>
		<title>Poll</title>
	</head>
	<body>
		<?php

		$pollid = $_GET['pollid'];
		$connect = mysqli_connect('localhost', 'root','','poll');
		$query = "SELECT * FROM polls WHERE pollid='$pollid'";
		$q = mysqli_query($connect, $query);
		while($row = mysqli_fetch_array($q)) {
			$id = $row[0];
			$title = $row[1];
			$pollid = $row[2];
			$ipaddress = $row[3];
			echo "<h1>$title</h1>";
			?>
			<table>
				<form action="" method="POST">
			<?php
				$questions = "SELECT * FROM questions WHERE pollid='$pollid'";
				$q2 = mysqli_query($connect, $questions);
				while($r = mysqli_fetch_array($q2)) {
				$question = $r[1];
				$votes = $r[2];
				$newvotes = $votes + 1;
				$ip = $_SERVER['REMOTE_ADDR'];
				$newipaddress = $ipaddress."$ip,";

				if (isset($_POST['vote'])) {
					$polloption = $_POST['polloption'];
					if ($polloption == "") {
						die("You didn't select an option.");
					} else {

							$ipaddresse = explode(",", $ipaddress);
							if (in_array($ip, $ipaddresse)) {
								die("You've already voted");
							} else {
						mysqli_query($connect, "UPDATE questions SET votes='$newvotes' WHERE pollid='$pollid' AND question='$polloption'");
						mysqli_query($connect, "UPDATE polls SET ipaddress='$newipaddress' WHERE pollid='$pollid'");
						die("You voted Successfully");
						}
					}
				}

				echo '<tr><td>'.$question.'</td><td><input type="radio" name="polloption" value="'.$question.'" /> '.$votes.' votes</td></tr>';
				}
		}
		?>
		<tr><td><input type="submit" name="vote" value="Vote" /></td></tr>
				</form>
			</table>
	</body>
</html>