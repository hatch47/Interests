<br><br>
<?php
include "DBConnection.php";

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["content"])) {
  // Getting user id
  $user_id = $_SESSION['user_id'];

  // Prepare and bind parameters
  $content = mysqli_real_escape_string($conn, $_POST['content']);

  // Insert data into posts table
  $sql = "INSERT INTO TWEET (OwnerID, Content) VALUES ('$user_id','$content')";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    echo "<br><span id='success-message'>Post Sent.</span>";
  }
}
?>

<script src="script.js"></script>
<script>
  // Automatically hide the success message after 5 seconds
  setTimeout(function() {
    var successMessage = document.getElementById('success-message');
    if (successMessage) {
      successMessage.style.display = 'none';
    }
  }, 5000); // 5000 milliseconds = 5 seconds
</script>

<form method='post'>
  <label><b>New Post</b></label><br>
  <!-- <input type="text" name="content" style="width: 500px; height: 25px;" required> -->
  <textarea type="text" name="content" rows="2" cols="125" required></textarea>
  <br>
  <input type="submit" value="Post">
</form>




