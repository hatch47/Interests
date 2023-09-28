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

<br><br><br>
<!-- Toggle new post button  -->
<div class="button-container">
  <button class="click-button" onclick="toggleNewPost()">New Interest Post</button>
</div>

<!-- post.php appears when button is clicked -->
<div class ="edit-profile-container" id="newPost" style="display: none;">
    <?php
    include "post.php";
    ?> 
    <br>
</div></div>
<div class="container">
    
<?php
include "DBConnection.php"; // include the database connection file

// Get the user ID from the current session
$user_id = $_SESSION['user_id'];

echo "<br><p>User: $user_id</p>";
include "explore.php";

mysqli_close($conn); // close the database connection
?>

</div>

<script>
function toggleNewPost() {
    var followersDiv = document.getElementById('newPost');
    if (followersDiv.style.display === 'none') {
      followersDiv.style.display = 'block';
    } else {
      followersDiv.style.display = 'none';
    }
  }
</script>

</body>
</html>