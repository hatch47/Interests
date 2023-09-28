<?php
include "DBConnection.php"; // include the database connection file

// Get the user ID from the current session
$user_id = $_SESSION['user_id'];

// Select the names from the table
$sql = "SELECT ua.USERNAME, t.TITLECONTENT, t.IMAGEURL, ua.DISPLAYNAME, t.POSTDATE, ua.PROFILEPIC, t.ID
        FROM USERACCOUNT ua
        LEFT JOIN POST t ON t.OWNERID = ua.ID
        WHERE t.ID IS NOT NULL
        ORDER BY t.ID DESC";
$result = mysqli_query($conn, $sql);

    echo "<h2><b>Explore Interests</b></h2>";
    

// Check if the button is clicked
if (isset($_POST['like_button'])) {
    $post_id = $_POST['post_id']; // Get the post ID from the form

    // Insert a like into the postmetrics table
    $insert_query = "INSERT INTO POSTMETRICS (POSTID, Likes) VALUES (?, 1) ON DUPLICATE KEY UPDATE Likes = Likes + 1";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, "i", $post_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<br><span id='success-message'>&#128151;</span>";
    } else {
        echo "Error adding like: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

// Check if the button is clicked
if (isset($_POST['repost_button'])) {
    $post_id = $_POST['post_id']; // Get the post ID from the form

    // Insert a repost into the postmetrics table
    $insert_query = "INSERT INTO POSTMETRICS (POSTID, Reposts) VALUES (?, 1) ON DUPLICATE KEY UPDATE Reposts = Reposts + 1";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, "i", $post_id);

    if (mysqli_stmt_execute($stmt)) {
        echo "<br><span id='success-message'>&#128257;</span>";
    } else {
        echo "Error adding repost: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

// New comments and comment count
if (isset($_POST['comment_button'])) {
    $post_id = $_POST['post_id']; // Get the post ID from the form
    $comment_text = $_POST['comment_text']; // Get the comment text from the form

    // Insert the comment into the POSTMETRICS table
    $insert_query = "INSERT INTO POSTMETRICS (POSTID, newComments, Comments) VALUES (?, ?, 1) ON DUPLICATE KEY UPDATE Reposts = Reposts + 1";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, "is", $post_id, $comment_text);

    if (mysqli_stmt_execute($stmt)) {
        echo "<br><span id='success-message'>&#128172;</span>";
    } else {
        echo "Error adding comment: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}


// Comment content
if (isset($_POST['newComment_button'])) {
    $post_id = $_POST['post_id']; // Get the post ID from the form

    // Retrieve post information
    $post_query = "SELECT ua.USERNAME, t.TITLECONTENT, t.IMAGEURL, ua.DISPLAYNAME, t.POSTDATE, ua.PROFILEPIC, t.ID
        FROM USERACCOUNT ua
        LEFT JOIN POST t ON t.OWNERID = ua.ID
        WHERE t.ID = ?
        AND t.ID IS NOT NULL
        ORDER BY t.ID DESC";
    $post_stmt = mysqli_prepare($conn, $post_query);
    mysqli_stmt_bind_param($post_stmt, "i", $post_id);

    if (mysqli_stmt_execute($post_stmt)) {
        $post_result = mysqli_stmt_get_result($post_stmt);

        if (mysqli_num_rows($post_result) > 0) {
            while ($row = mysqli_fetch_assoc($post_result)) {
                echo "<div style='width: 800px; border: 1px solid lightgrey; padding: 10px;'>";
                echo "<table style='border-collapse: collapse; width: 100%;'>";
                echo "<tr>";
                echo "<td style='border: none; padding: 5px; background-color: white; display: flex; align-items: center;'>";
                echo "<img src='" . $row['PROFILEPIC'] . "' alt='Profile Picture' style='max-width: 60px; max-height: 60px;'>";
                echo "<div style='margin-left: 10px;'>";
                echo "<h3 class='username' style='margin: 0;'>" . $row['DISPLAYNAME'] . "</h3>";
                echo "<h5 class='username' style='margin-top: 5px;'><b><a href='viewProfile.php?username=" . urlencode($row['USERNAME']) . "' style='color: black; text-decoration: none;'>" . $row['USERNAME'] . "</a></b></h5>";
                echo "</div>";
                echo "</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td colspan='2' style='border: none; padding: 5px; background-color: white;'>";
                echo "<h4 style='margin: 0 0 5px 0;'>". $row['TITLECONTENT'] . "</h4>";
                echo "<h4 style='margin: 0 0 5px 0;'>". $row['IMAGEURL'] . "</h4>";
                // echo "<h6 style='color: dimgrey; margin: 0 0 5px;'>&#128151; 0 &nbsp; &#128257; 0 &nbsp; &#128172; 0</h6>";
                // Check if there are any likes for the post with POSTID equal to $row['ID']
$query_check_likes = "SELECT COUNT(*) AS like_count FROM POSTMETRICS WHERE POSTID = " . $row['ID'] . " AND Likes = 1";
$result_check_likes = mysqli_query($conn, $query_check_likes);

if ($result_check_likes) {
    $like_data = mysqli_fetch_assoc($result_check_likes);
    $like_count = $like_data['like_count'];
} else {
    // Handle the database query error
    $like_count = 0;
}

// Check if there are any reposts for the post with POSTID equal to $row['ID']
$query_check_reposts = "SELECT COUNT(*) AS repost_count FROM POSTMETRICS WHERE POSTID = " . $row['ID'] . " AND Reposts = 1";
$result_check_reposts = mysqli_query($conn, $query_check_reposts);

if ($result_check_reposts) {
    $repost_data = mysqli_fetch_assoc($result_check_reposts);
    $repost_count = $repost_data['repost_count'];
} else {
    // Handle the database query error
    $repost_count = 0;
}

// Check if there are any comments for the post with POSTID equal to $row['ID']. eventually the comments query will check and count to see if the comments row is not null and POSTID = " . $row['ID'] . - an onclick will then select all and display all of the comments
$query_check_comments = "SELECT COUNT(*) AS comment_count FROM POSTMETRICS WHERE POSTID = " . $row['ID'] . " AND comments = 1";
$result_check_comments = mysqli_query($conn, $query_check_comments);

if ($result_check_comments) {
    $comment_data = mysqli_fetch_assoc($result_check_comments);
    $comment_count = $comment_data['comment_count'];
} else {
    // Handle the database query error
    $comment_count = 0;
}

echo '<div style="display: flex;">';
// like button
echo '<form method="post">';
echo '<input type="hidden" name="post_id" value="' . $row['ID'] . '">'; 
echo '<div style="display: inline-block;">';
echo '<span style="color: dimgrey; margin-right: -2px;">' . $like_count . '</span>';
echo '<button type="submit" name="like_button" style="border: none; background: none; cursor: pointer;" title="Like POST">&#128151;&nbsp;</button>';
echo '</div>';
echo '</form>';

// repost button
echo '<form method="post">';
echo '<input type="hidden" name="post_id" value="' . $row['ID'] . '">'; 
echo '<div style="display: inline-block;">';
echo '<span style="color: dimgrey; margin-right: -2px;">' . $repost_count . '</span>';
echo '<button type="submit" name="repost_button" style="border: none; background: none; cursor: pointer;" title="Repost POST">&#128257;&nbsp;</button>';
echo '</div>';
echo '</form>';


// Comment button
echo '<form method="post">';
echo '<input type="hidden" name="post_id" value="' . $row['ID'] . '">';
echo '<div style="display: inline-block;">';
echo '<span style="color: dimgrey; margin-right: -2px;">' . $comment_count . '</span>';
echo '<button type="button" name="comment_button" style="border: none; background: none; cursor: pointer;" title="Comment on POST" onclick="showCommentForm()">&#128172;</button>';
// Create js to make the newComment button disappear when clicked twice
echo '<button type="submit" name="newComment_button" style="border: none; background: none; cursor: pointer;" title="View Comments" onclick="showComments()">&#128173;</button>';
echo '</div></div>';
echo '</form>';
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan='2' style='border: none; padding: 5px; background-color: white;'>";
echo "<h6 style='color: dimgrey; margin: 0 0 5px;'>". $row['POSTDATE'] . "</h6>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td colspan='2' style='border: none; padding: 5px; background-color: white;'>";
                // Comment form
echo '<div id="commentForm" style="display: none;"><form method="POST">';
echo '<input type="hidden" name="post_id" value="' . $row['ID'] . '">';
echo '<textarea name="comment_text" rows="2" cols="50" placeholder="Add a comment"></textarea><br>';
echo '<input type="submit" style="background-color: rgb(145, 0, 0); color: white;" name="comment_button" value="Comment">';
echo '</form></div>';
echo "</td>";
echo "</tr>";
echo "</table>";
echo "</div>";
            }
        } else {
            echo "No posts found.";
        }
    } else {
        echo "Error retrieving post information: " . mysqli_error($conn);
    }

    mysqli_stmt_close($post_stmt);

      // Retrieve new comments and reactorID for the specified post_id
      $comment_query = "SELECT newComments, reactorID FROM POSTMETRICS WHERE POSTID = ?";
      $comment_stmt = mysqli_prepare($conn, $comment_query);
      mysqli_stmt_bind_param($comment_stmt, "i", $post_id);
  
      if (mysqli_stmt_execute($comment_stmt)) {
          $comment_result = mysqli_stmt_get_result($comment_stmt);
  
          // Check if there are any new comments
          if (mysqli_num_rows($comment_result) > 0) {
              echo "<table>";
              echo "<tr><th></th><th>Comments</th></tr>";
  
              // Loop through the new comments and display them in a table
              while ($comment_row = mysqli_fetch_assoc($comment_result)) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($comment_row['reactorID']) . "</td>";
                  echo "<td>" . htmlspecialchars($comment_row['newComments']) . "</td>";
                  echo "</tr>";
              }
  
              echo "</table>";
          } else {
              echo "No new comments found for this post.";
          }
      } else {
          echo "Error retrieving comments: " . mysqli_error($conn);
      }
  
      mysqli_stmt_close($comment_stmt);
  }

// Print the data in a table format
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div style='width: 800px; border: 1px solid lightgrey; padding: 10px;'>";
        echo "<table style='border-collapse: collapse; width: 100%;'>";
        echo "<tr>";
        echo "<td style='border: none; padding: 5px; background-color: white; display: flex; align-items: center;'>";
        echo "<img src='" . $row['PROFILEPIC'] . "' alt='Profile Picture' style='max-width: 60px; max-height: 60px;'>";
        echo "<div style='margin-left: 10px;'>";
        echo "<h3 class='username' style='margin: 0;'>" . $row['DISPLAYNAME'] . "</h3>";
        echo "<h5 class='username' style='margin-top: 5px;'><b><a href='viewProfile.php?username=" . urlencode($row['USERNAME']) . "' style='color: black; text-decoration: none;'>" . $row['USERNAME'] . "</a></b></h5>";
        echo "</div>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='2' style='border: none; padding: 5px; background-color: white;'>";
        echo "<h4 style='margin: 0 0 5px 0;'>". $row['TITLECONTENT'] . "</h4>";
        echo "<h4 style='margin: 0 0 5px 0;'>". $row['IMAGEURL'] . "</h4>";
        // echo "<h6 style='color: dimgrey; margin: 0 0 5px;'>&#128151; 0 &nbsp; &#128257; 0 &nbsp; &#128172; 0</h6>";
        // Check if there are any likes for the post with POSTID equal to $row['ID']
$query_check_likes = "SELECT COUNT(*) AS like_count FROM POSTMETRICS WHERE POSTID = " . $row['ID'] . " AND Likes = 1";
$result_check_likes = mysqli_query($conn, $query_check_likes);

if ($result_check_likes) {
    $like_data = mysqli_fetch_assoc($result_check_likes);
    $like_count = $like_data['like_count'];
} else {
    // Handle the database query error
    $like_count = 0;
}

// Check if there are any reposts for the post with POSTID equal to $row['ID']
$query_check_reposts = "SELECT COUNT(*) AS repost_count FROM POSTMETRICS WHERE POSTID = " . $row['ID'] . " AND Reposts = 1";
$result_check_reposts = mysqli_query($conn, $query_check_reposts);

if ($result_check_reposts) {
    $repost_data = mysqli_fetch_assoc($result_check_reposts);
    $repost_count = $repost_data['repost_count'];
} else {
    // Handle the database query error
    $repost_count = 0;
}

// Check if there are any comments for the post with POSTID equal to $row['ID']. eventually the comments query will check and count to see if the comments row is not null and POSTID = " . $row['ID'] . - an onclick will then select all and display all of the comments
$query_check_comments = "SELECT COUNT(*) AS comment_count FROM POSTMETRICS WHERE POSTID = " . $row['ID'] . " AND comments = 1";
$result_check_comments = mysqli_query($conn, $query_check_comments);

if ($result_check_comments) {
    $comment_data = mysqli_fetch_assoc($result_check_comments);
    $comment_count = $comment_data['comment_count'];
} else {
    // Handle the database query error
    $comment_count = 0;
}

echo '<div style="display: flex;">';
// like button
echo '<form method="post">';
echo '<input type="hidden" name="post_id" value="' . $row['ID'] . '">'; 
echo '<div style="display: inline-block;">';
echo '<span style="color: dimgrey; margin-right: -2px;">' . $like_count . '</span>';
echo '<button type="submit" name="like_button" style="border: none; background: none; cursor: pointer;" title="Like POST">&#128151;&nbsp;</button>';
echo '</div>';
echo '</form>';

// repost button
echo '<form method="post">';
echo '<input type="hidden" name="post_id" value="' . $row['ID'] . '">'; 
echo '<div style="display: inline-block;">';
echo '<span style="color: dimgrey; margin-right: -2px;">' . $repost_count . '</span>';
echo '<button type="submit" name="repost_button" style="border: none; background: none; cursor: pointer;" title="Repost POST">&#128257;&nbsp;</button>';
echo '</div>';
echo '</form>';


// Comment button
echo '<form method="post">';
echo '<input type="hidden" name="post_id" value="' . $row['ID'] . '">';
echo '<div style="display: inline-block;">';
echo '<span style="color: dimgrey; margin-right: -2px;">' . $comment_count . '</span>';
echo '<button type="button" name="comment_button" style="border: none; background: none; cursor: pointer;" title="Comment on POST" onclick="showCommentForm()">&#128172;</button>';
// Create js to make the newComment button disappear when clicked twice
echo '<button type="submit" name="newComment_button" style="border: none; background: none; cursor: pointer;" title="View Comments" onclick="showComments()">&#128173;</button>';
echo '</div></div>';
echo '</form>';
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='2' style='border: none; padding: 5px; background-color: white;'>";
        echo "<h6 style='color: dimgrey; margin: 0 0 5px;'>". $row['POSTDATE'] . "</h6>";
        echo "</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td colspan='2' style='border: none; padding: 5px; background-color: white;'>";
        // Comment form
echo '<div id="commentForm" style="display: none;"><form method="POST">';
echo '<input type="hidden" name="post_id" value="' . $row['ID'] . '">';
echo '<textarea name="comment_text" rows="2" cols="50" placeholder="Add a comment"></textarea><br>';
echo '<input type="submit" style="background-color: rgb(145, 0, 0); color: white;" name="comment_button" value="Comment">';
echo '</form></div>';
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        echo "</div>";
    }
} else {
    echo "No posts found.";
}



?>

</div>
<script>
function redirectToProfile(username) {
    // Redirect to viewProfile.php with the username as a query parameter
    window.location.href = "viewProfile.php?username=" + encodeURIComponent(username);
}
</script>
<script>
  // Automatically hide the success message after 2 seconds
  setTimeout(function() {
    var successMessage = document.getElementById('success-message');
    if (successMessage) {
      successMessage.style.display = 'none';
    }
  }, 2000); // 2000 milliseconds = 2 seconds
</script>

<script>
let formVisible = false;

function showCommentForm() {
    const commentForm = document.getElementById('commentForm');
    
    if (formVisible) {
        commentForm.style.display = 'none';
    } else {
        commentForm.style.display = 'block';
    }

    formVisible = !formVisible;
}
</script>

<script>
let formVisible = false;

function showComments() {
    const commentForm = document.getElementById('showComments');
    
    if (formVisible) {
        commentForm.style.display = 'none';
    } else {
        commentForm.style.display = 'block';
    }

    formVisible = !formVisible;
}
</script>