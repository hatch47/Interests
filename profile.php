<?php
require "session.php";
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
<script src="script.js"></script>
<link rel="icon" href="Logo.png" type="image/png">
<title>My Profile</title>
</head>
<body>
<div class="container">

<br>

<?php
include "navbar.php";
?> 
<br><br><br>
<div class="button-container">
  <button class="click-button" onclick="toggleEdit()">Edit Profile</button>
</div>
</div>
<!-- <div class="designer-element" style="margin-left: 500px;"> -->
<div class="container">

<?php
include "DBConnection.php"; // include the database connection file

// Get the user ID from the current session
$user_id = $_SESSION['user_id'];

echo "<br><div style='width: 800px; border: 1px solid lightgrey; padding: 10px;'>";
include "profilepic.php";

$sql = "SELECT USERNAME, DISPLAYNAME
        FROM USERACCOUNT
        WHERE ID = $user_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>";
        echo "<h1 class='username'><b>" . $row['DISPLAYNAME'] . "</b></h1>";
        echo "<h5 class='username'><b>" . $row['USERNAME'] . "</b></h5>";
        echo "</div>";
    }
}

$sql = "SELECT BIO
        FROM USERACCOUNT
        WHERE ID = $user_id";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div>";
        echo "<p>Bio: ";
        echo "<b class='username'>" . $row['BIO'] . "</b></p>";
        echo "</div>";
    }
}
echo "</div><br>";

mysqli_close($conn); // close the database connection
?>

<div class ="edit-profile-container" id="edit" style="display: none;">

<?php
include "editProfile.php";
?> 
<br>
</div></div>



<script>
  function toggleEdit() {
    var followersDiv = document.getElementById('edit');
    if (followersDiv.style.display === 'none') {
      followersDiv.style.display = 'block';
    } else {
      followersDiv.style.display = 'none';
    }
  }
</script>

<script>
function redirectToProfile(username) {
    // Redirect to viewProfile.php with the username as a query parameter
    window.location.href = "viewProfile.php?username=" + encodeURIComponent(username);
}
</script>
</body>
</html>





