<?Php
$dbhost_name = "localhost";
$database = "plus2net";
$username = "root";
$password = "test";

//////// Do not Edit below /////////
try {
$dbo = new PDO('mysql:host=localhost;dbname='.$database, $username, $password);
} catch (PDOException $e) {
print "Error!: " . $e->getMessage() . "<br/>";
die();
}
?> 

