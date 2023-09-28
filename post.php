<br><br>
<?php
include "DBConnection.php";

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["titleContent"])) {
  // Getting user id
  $user_id = $_SESSION['user_id'];

  // Prepare and bind parameters
  $titleContent = mysqli_real_escape_string($conn, $_POST['titleContent']);
  $imageURL = mysqli_real_escape_string($conn, $_POST['imageURL']);
  $rank1 = mysqli_real_escape_string($conn, $_POST['rank1']);
  $rank2 = mysqli_real_escape_string($conn, $_POST['rank2']);
  $rank3 = mysqli_real_escape_string($conn, $_POST['rank3']);
  $rank4 = mysqli_real_escape_string($conn, $_POST['rank4']);
  $rank5 = mysqli_real_escape_string($conn, $_POST['rank5']);
  $rank6 = mysqli_real_escape_string($conn, $_POST['rank6']);
  $rank7 = mysqli_real_escape_string($conn, $_POST['rank7']);
  $rank8 = mysqli_real_escape_string($conn, $_POST['rank8']);
  $rank9 = mysqli_real_escape_string($conn, $_POST['rank9']);
  $rank10 = mysqli_real_escape_string($conn, $_POST['rank10']);
  // Insert data into posts table
  $sql = "INSERT INTO post (OWNERID, TITLECONTENT, IMAGEURL, RANK1, RANK2, RANK3, RANK4, RANK5, RANK6, RANK7, RANK8, RANK9, RANK10) VALUES ('$user_id', '$titleContent', '$imageURL', '$rank1', '$rank2', '$rank3', '$rank4', '$rank5', '$rank6', '$rank7', '$rank8', '$rank9', '$rank10')";
  $result = mysqli_query($conn, $sql);

  if ($result) {
    echo "<br><br><br><br><br><br><span id='success-message'>Post Sent.</span>";
  } else {
    // Error handling if the query fails
    echo "Error: " . mysqli_error($conn);
}
}
?>

<div style='width: 800px; border: 0px solid lightgrey; padding: 10px; align-items: center; justify-content: center;  display: flex;'>
<form method='post'>
  <label><b>Title</label><br>
  <input type="text" name="titleContent" required style="width: 300px;"></input><br><br>
  
  <label for="imageURL">Image URL:</label><br>
  <input type="text" id="imageURL" name="imageURL">
  <p style="color: black; font-size: 12px;">
  <a href="https://imgur.com/" target="_blank" style="color: black; text-decoration: none;"><u>Search URLs</u></a>
  </p>
<br>

  <table>
  <tr>
    <td><label for="rank1">Rank 1:</label></td>
    <td><input type="text" id="rank1" name="rank1" required></td>

    <td><label for="rank6">Rank 6:</label></td>
    <td><input type="text" id="rank6" name="rank6"></td>
    
  </tr>
  <tr>
    <td><label for="rank2">Rank 2:</label></td>
    <td><input type="text" id="rank2" name="rank2" required></td>

    <td><label for="rank7">Rank 7:</label></td>
    <td><input type="text" id="rank7" name="rank7"></td>
  </tr>
  <tr>
  <td><label for="rank3">Rank 3:</label></td>
    <td><input type="text" id="rank3" name="rank3" required></td>

    <td><label for="rank8">Rank 8:</label></td>
    <td><input type="text" id="rank8" name="rank8"></td>
  </tr>
  <tr>
    <td><label for="rank4">Rank 4:</label></td>
    <td><input type="text" id="rank4" name="rank4"></td>

    <td><label for="rank9">Rank 9:</label></td>
    <td><input type="text" id="rank9" name="rank9"></td>
  </tr>
  <tr>
    <td><label for="rank5">Rank 5:</label></td>
    <td><input type="text" id="rank5" name="rank5"></td>
        
    <td><label for="rank10">Rank 10:</label></td>
    <td><input type="text" id="rank10" name="rank10"></td>
  </tr>
</table>
<br>

  <input type="submit" value="Post" onclick="showSavedMessage()">
</form>
</div>

<script src="script.js"></script>
<script>
  // Automatically hide the success message after 5 seconds
  setTimeout(function() {
    var successMessage = document.getElementById('success-message');
    if (successMessage) {
      successMessage.style.display = 'none';
    }
  }, 5000); // 5000 milliseconds = 5 seconds

  function showSavedMessage() {
  alert("Interest Posted!");
  location.href = location.href;
}
</script>

