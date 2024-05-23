<?php
error_reporting(0);

include_once("../connection/connection.php");

$sql = "SELECT * FROM system_log_info";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['logInfo']}</td>
                <td>{$row['userName']}</td>
                <td>{$row['dateDone']}</td>
                 
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No logs found</td></tr>";
}
?>
