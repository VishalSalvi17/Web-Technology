<?php include_once 'db.php'; 
date_default_timezone_set("Europe/London");
$phpQuery = mysqli_query($db, "SELECT * FROM voters WHERE voters_choice='PHP'");
$javaQuery = mysqli_query($db, "SELECT * FROM voters WHERE voters_choice='JAVA'");
$numVotersPHP = mysqli_num_rows($phpQuery);
$numVotersJAVA = mysqli_num_rows($javaQuery);
$sum = $numVotersPHP + $numVotersJAVA;
if ($numVotersPHP === 0) {
	$phpPercent = 0;
}else {
$phpPercent = round(floatval(($numVotersPHP / $sum) * 100));
}
if ($numVotersJAVA === 0) {
	$javaPercent = 0;
}else {
$javaPercent = round(floatval(($numVotersJAVA / $sum) * 100));
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Polling Application</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<style>
		.row{
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<h2>Polling Application - using PHP and MYSQL</h2>
				<form action="process.php" method="POST" role='form'>
					<div class="form-group">
						<input type="email" name="email" placeholder="Email Address" class="form-control">
					</div>
					<div class="radio" style="display: flex;">
						<label class="radio"><input type="radio" name="choice" value="PHP"><img src="image/php.jpg" width="70"><h3 style="display: inline-block;">&nbsp;&nbsp;PHP</h3></label>
						<label class="radio"><input type="radio" name="choice" value="JAVA"><img src="image/java.png" width="70"><h3 style="display: inline-block;">&nbsp;&nbsp;JAVA</h3></label>
					</div>
					<div class="form-group">
						<input type="submit" name="vote" value="VOTE" class="btn btn-primary">
					</div>
				</form>
				<div class="progress">
				  <div class="progress-bar progress-bar-info" role="progressbar" style="width:<?php echo $phpPercent; ?>%">
				    PHP <?php echo $phpPercent; ?>%
				  </div>
				  <div class="progress-bar progress-bar-danger" role="progressbar" style="width:<?php echo $javaPercent;?>%">
				    JAVA <?php echo $javaPercent;?>%
				  </div>
				</div>
				<div class="table-responsive">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th>Voter's Email</th>
								<th>Voter's Choice</th>
								<th>Voting Date and Time</th>
								<th>Time Interval</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$query = mysqli_query($db,"SELECT * FROM voters ORDER BY voters_id DESC LIMIT 4");
								while ($row = mysqli_fetch_array($query)):
									$email = $row['voters_email'];
									$choice = $row['voters_choice'];
									$date_added = $row['time'];
									$msg = "Just now";

									$date_time_now = date("Y-m-d H:i:s");
									$startdate = new DateTime($date_added);
									$endDate = new DateTime($date_time_now);
									$interval = $startdate->diff($endDate);

					if ($interval->y >= 1) {
						if ($interval->y === 1) {
							$msg = $interval->y . " year ago";
						}else{
							$msg = $interval->y . " years ago";
						}
					}elseif ($interval->m >= 1) {
						if ($interval->m === 1) {
							$msg = $interval->m . " month ago";
						}else{
							$msg = $interval->m . " months ago";
						}
					}elseif ($interval->d >= 1) {
						if ($interval->d === 1) {
							$msg = $interval->d . " day ago";
						}else{
							$msg = $interval->d . " days ago";
						}
					}
					if ($interval->h >= 1) {
						if ($interval->h === 1) {
							$msg = $interval->h . " hour ago";
						}else{
							$msg = $interval->h . " hours ago";
						}
					}elseif ($interval->i >= 1) {
						if ($interval->i === 1) {
							$msg = $interval->i . " minute ago";
						}else{
							$msg = $interval->i . " minutes ago";
						}
					}elseif ($interval->s >= 1) {
						if ($interval->s >= 30) {
							$msg = $interval->s . " seconds ago";
						}else{
						$msg = "Just now";
					}
					}
?>
			<tr>
				<td><?php echo $email; ?></td>
				<td><?php echo $choice; ?></td>
				<td><?php echo $date_added; ?></td>
				<td><?php echo $msg; ?></td>
			</tr>
								<?php endwhile;
							?>
						</tbody>
					</table>
				</div>
			</div>	
		</div>
	</div>
</body>
</html>