<style>
    #uni_modal .modal-content>.modal-footer, #uni_modal .modal-content>.modal-header {
        display: flex;
        justify-content: space-between;
    }
    .error-message {
        color: red;
    }
    .error-border {
        border: 1px solid red !important;
    }
</style>

<?php
include_once("../connection/connection.php");
$task_id = "Auto";
$task_name = "";
$taskDescription = "";
$tool_name = "";

if (isset($_GET['id'])) {
    $task_id = $_GET['id'];
    $sql = "SELECT * FROM task WHERE id = $task_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $task_name = $row['task_name'];
        $taskDescription = $row['taskDescription'];
        $tool_name = $row['tool_name'];
    }
}

// Fetch tool names from the database
$tool_sql = "SELECT tool_name FROM tools";
$tool_result = $conn->query($tool_sql);
?>

<div class="container-fluid">
    <form id="task-form">
        <div class="form-group">
            <label for="task_id">ID</label>
            <input type="text" class="form-control" id="task_id" name="task_id" value="<?php echo $task_id; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="task_name">Task Name</label>
            <input type="text" class="form-control" id="task_name" name="task_name" value="<?php echo $task_name; ?>" required>
        </div>
        <div class="form-group">
            <label for="taskDescription">Task Description</label>
            <textarea class="form-control" id="taskDescription" name="taskDescription" required><?php echo $taskDescription; ?></textarea>
        </div>
        <div class="form-group">
            <label for="tool_name">Tool Name</label>
            <select class="form-control" id="tool_name" name="tool_name" required>
                <option value="">Select Tool</option>
                <?php while($tool_row = $tool_result->fetch_assoc()): ?>
                    <option value="<?php echo $tool_row['tool_name']; ?>" <?php if($tool_name == $tool_row['tool_name']) echo 'selected'; ?>>
                        <?php echo $tool_row['tool_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
         
    </form>
</div>

<script>
    $(document).ready(function(){
        $('#task-form').submit(function(e){
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: "phpAction/saveTask.php",
                type: "POST",
                data: formData,
                success: function(resp){
                    if(resp.status == 'success'){
                        alert("Task saved successfully");
                        $('#uni_modal').modal('hide');
                        location.reload();
                    } else {
                        alert("Task saved successfully");
                        $('#uni_modal').modal('hide');
                    }
                },
                error: function(xhr, status, error){
                    alert("An error occurred while saving the task");
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
