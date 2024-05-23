<?php
error_reporting(0);
// Fetch data from the lectures table
include_once("../connection/connection.php");

$sql = "SELECT * FROM categories";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['category']}</td>
                <td>{$row['description']}</td>
                <td>{$row['status']}</td>
                <td>{$row['date_created']}</td>
                
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No categories found</td></tr>";
}
?>
