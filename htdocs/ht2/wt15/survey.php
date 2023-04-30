<!DOCTYPE html>
<html>
<head>
<title>Result</title>

<link rel="stylesheet"href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js">
</script>
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Vishalsalvi"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if (isset($_POST['fruit'])) {
 mysqli_query($conn,'UPDATE `survey` SET Votes = Votes + 1 WHERE ID ='.$_POST['fruit'] );
}

$sql = "SELECT * FROM survey";
$result = $conn->query($sql);
?>

<h1 align="center">Thank you!!</h1><br>
<h2 align="center">Favourite Fruits Poll </h2><br>
<?php
    if ($result->num_rows > 0) {
 ?>
 <div align="center">
 <table class="table table-dark" style="width: 80%;">
 <tr>
 <th scope="col">ID</th>
 <th scope="col">Name</th>
 <th scope="col">Votes</th>
 </tr>
 <?php
 while($row = $result->fetch_assoc()) { ?>
 <tr>
 <th scope="row"><?php echo $row["ID"];?></th>
 <td><?php echo $row["Name"];?></td>
 <td><?php echo $row["Votes"];?></td>
 </tr> 
 <?php }
 ?> </table>
 </div><?php
} else {
 echo "0 results";
}
?>

</body>
</html>