<?php
$sql = "SELECT ua.USERNAME, p.TITLECONTENT, ua.DISPLAYNAME, p.POSTDATE, ua.PROFILEPIC, p.ID, p.IMAGEURL, p.RANK1, p.RANK2, p.RANK3, p.RANK4, p.RANK5, p.RANK6, p.RANK7, p.RANK8, p.RANK9, p.RANK10
        FROM USERACCOUNT ua
        LEFT JOIN POST p ON p.OWNERID = ua.ID
        WHERE (ua.ID = $user_id OR ua.ID IN (SELECT OWNERID FROM FOLLOWER WHERE FOLLOWERID = $user_id))
        AND p.ID IS NOT NULL
        ORDER BY p.ID DESC";
$result = mysqli_query($conn, $sql);

// Fetch the imageurl
if ($row = mysqli_fetch_assoc($result)) {
    $imageurl = $row['IMAGEURL'];
}

echo '<table style="background-image: url(' . $imageurl . ');">';
echo '<tr>';
echo '<th>Rank 1</th>';
echo '<th>Rank 6</th>';
echo '</tr>';
echo '<tr>';
echo '<th>Rank 2</th>';
echo '<th>Rank 7</th>';
echo '</tr>';
echo '<tr>';
echo '<th>Rank 3</th>';
echo '<th>Rank 8</th>';
echo '</tr>';
echo '<tr>';
echo '<th>Rank 4</th>';
echo '<th>Rank 9</th>';
echo '</tr>';
echo '<tr>';
echo '<th>Rank 5</th>';
echo '<th>Rank 10</th>';
echo '</tr>';

while ($row = mysqli_fetch_assoc($result)) {
    echo '<tr>';
    echo '<td>' . $row['RANK1'] . '</td>';
    echo '<td>' . $row['RANK2'] . '</td>';
    echo '<td>' . $row['RANK3'] . '</td>';
    echo '<td>' . $row['RANK4'] . '</td>';
    echo '<td>' . $row['RANK5'] . '</td>';
    echo '<td>' . $row['RANK6'] . '</td>';
    echo '<td>' . $row['RANK7'] . '</td>';
    echo '<td>' . $row['RANK8'] . '</td>';
    echo '<td>' . $row['RANK9'] . '</td>';
    echo '<td>' . $row['RANK10'] . '</td>';
    echo '</tr>';
}

echo '</table>';
?>




