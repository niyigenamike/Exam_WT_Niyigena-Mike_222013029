<?php
error_reporting(0);
include_once("../connection/connection.php");

$sql = "SELECT * FROM task ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["task_name"]."</td>";
        echo "<td>".$row["taskDescription"]."</td>";
        echo "<td>".$row["tool_name"]."</td>";
        echo "<td>
                <a class='updateTask' data-id='".$row["id"]."' class='btn btn-primary btn-sm'>Edit</a> |
                <a class='deleteTask' data-id='".$row["id"]."' href='#' class='btn btn-primary btn-sm'>Delete</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No records found</td></tr>";
}
?>

<script>
    $(document).ready(function(){
        // Open modal with task form on Edit link click
        $('.updateTask').click(function(){
            var id = $(this).data('id');
            uni_modal("", "forms/taskForm.php?id=" + id);
        });

        // Delete action for tasks
        $('.deleteTask').click(function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var table = "task";
            if(confirm("Are you sure you want to delete this task?")){
                $.ajax({
                    url: "delete/deleteData.php?table="+table+"&id=" + id,
                    method: "GET",
                    success: function(resp){
                        if(resp.status == 'success'){
                            alert("Task deleted successfully");
                            location.reload();
                        } else {
                            alert("Task deleted successfully");
                        }
                    },
                    error: function(xhr, status, error){
                        alert("An error occurred while deleting the task");
                        console.log(xhr.responseText);
                    }
                });
            }
        });
    });
</script>
