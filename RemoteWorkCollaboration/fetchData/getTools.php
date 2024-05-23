<?php
error_reporting(0);
include_once("../connection/connection.php");

$sql = "SELECT * FROM tools ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["tool_name"]."</td>";
        echo "<td>".$row["toolDescription"]."</td>";
        echo "<td>
                 <a class='updateTool' data-id='".$row["id"]."' class='btn btn-primary btn-sm'>Edit</a> |
                <a class='deleteTool' data-id='".$row["id"]."' href='#' class='btn btn-primary btn-sm'>Delete</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No records found</td></tr>";
}
?>

<script>
    $(document).ready(function(){
        // Open modal with tool form on Edit link click
        $('.updateTool').click(function(){
            var id = $(this).data('id');
            uni_modal("", "forms/toolForm.php?id=" + id);
        });

        // Delete action for tools
        $('.deleteTool').click(function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var table = "tools";
            if(confirm("Are you sure you want to delete this tool?")){
                $.ajax({
                    url: "delete/deleteData.php?table="+table+"&id=" + id,
                    method: "GET",
                    success: function(resp){
                        if(resp.status == 'success'){
                            alert("Tool deleted successfully");
                            location.reload();
                        } else {
                            alert("An error occurred while deleting the tool");
                        }
                    },
                    error: function(xhr, status, error){
                        alert("An error occurred while deleting the tool");
                        console.log(xhr.responseText);
                    }
                });
            }
        });

        // Function to view image in modal
        window.viewImage = function(src) {
            start_loader();
            var view;
            var t = src.split('.').pop().toLowerCase();
            if (t == 'mp4') {
                view = $("<video src='"+ src +"' controls autoplay></video>");
            } else {
                view = $("<img src='phpAction/"+ src +"' />");
            }
            $('#viewer_modal .modal-content video, #viewer_modal .modal-content img').remove();
            $('#viewer_modal .modal-content').append(view);
            $('#viewer_modal').modal({
                show: true,
                backdrop: 'static',
                keyboard: false,
                focus: true
            });
            end_loader();
        }
    });
</script>
