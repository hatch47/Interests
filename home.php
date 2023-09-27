<?php
require "session.php";
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<link rel="icon" href="Logo.png" type="image/png">
<title>Home</title>
</head>
<body>
<div class="container">

<br>
<?php
include "navbar.php";
?> 

<!-- <h3>Your Feed</h3> -->
<br>
<?php
include "DBConnection.php"; // include the database connection file

// Get the user ID from the current session
$user_id = $_SESSION['user_id'];

include "post.php";
echo "<br><p>User: $user_id</p>";
include "explore.php";

mysqli_close($conn); // close the database connection
?>

</div>


</body>
</html>