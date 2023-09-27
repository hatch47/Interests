<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">

<div class="navbar"><b>
    <a href="home.php">Home</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a></b>
  </div>
  
  <?php
  $user = $_SESSION['user_id'];
  if(isset($_SESSION['user_id'])){
    // echo "<h3>Logged in with user ID $user</h3>";
  }

  if (isset($_GET['logout'])) {
    // If logout button was pressed, end the session
    session_unset();
    session_destroy();
  }

?>


</div>
</body>
</html>
