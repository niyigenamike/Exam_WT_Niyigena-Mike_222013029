<?php
error_reporting(0);
include_once("../connection/connection.php");

$sql = "SELECT * FROM supervisor ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["fullnames"]."</td>";
        echo "<td>".$row["phone"]."</td>";
        echo "<td>".$row["email"]."</td>";
        echo "<td>".$row["address"]."</td>";
        echo "<td>".$row["gender"]."</td>";
        echo "<td>".$row["status"]."</td>";
        echo "<td>".$row["age"]."</td>";
        echo "<td><img src='phpAction/" . $row["image"] . "' class='rounded-image' onclick='viewImage(\"" . $row["image"] . "\")'></td>";
        echo "<td>".$row["date_"]."</td>";
        echo "<td>
                <a onclick='viewImage(\"" . $row["image"] . "\")' data-id='".$row["id"]."' class='btn btn-primary btn-sm'>View</a> |
                <a class='updateSupervisor' data-id='".$row["id"]."' class='btn btn-primary btn-sm'>Edit</a> |
                <a class='deleteSupervisor' data-id='".$row["id"]."' href='#' class='btn btn-primary btn-sm'>Delete</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='11'>No records found</td></tr>";
}
?>

<script>
    $(document).ready(function(){
        // Open modal with supervisor form on Edit link click
        $('.updateSupervisor').click(function(){
            var id = $(this).data('id');
            uni_modal("", "forms/supervisorForm.php?id=" + id);
        });

        // Delete action for supervisors
        $('.deleteSupervisor').click(function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var table = "supervisor";
            if(confirm("Are you sure you want to delete this supervisor?")){
                $.ajax({
                    url: "delete/deleteData.php?table="+table+"&id=" + id,
                    method: "GET",
                    success: function(resp){
                        if(resp.status == 'success'){
                            alert("Supervisor deleted successfully");
                            location.reload();
                        } else {
                            alert("Supervisor deleted successfully");
                        }
                    },
                    error: function(xhr, status, error){
                        alert("An error occurred while deleting the supervisor");
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
