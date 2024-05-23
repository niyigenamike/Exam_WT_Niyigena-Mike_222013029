<?php
error_reporting(0);
include_once("../connection/connection.php");

$sql = "SELECT * FROM auditor ORDER BY id DESC";
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
        echo "<td><img src='phpAction/".$row["image"]."' class='rounded-image' alt='Auditor Image'></td>";
        echo "<td>
                <a onclick='viewImage(\"" . $row["image"] . "\")' data-id='".$row["id"]."' class='btn btn-primary btn-sm'>View</a> |
                <a class='updateAuditor' data-id='".$row["id"]."' class='btn btn-primary btn-sm'>Edit</a> |
                <a class='deleteAuditor' data-id='".$row["id"]."' href='#' class='btn btn-primary btn-sm'>Delete</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='10'>No records found</td></tr>";
}
?>

<script>
    $(document).ready(function(){
        // Open modal with auditor form on Edit link click
        $('.updateAuditor').click(function(){
            var id = $(this).data('id');
            uni_modal("", "forms/auditorForm.php?id=" + id);
        });

        // Delete action for auditors
        $('.deleteAuditor').click(function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var table = "auditor";
            if(confirm("Are you sure you want to delete this auditor?")){
                $.ajax({
                    url: "delete/deleteData.php?table="+table+"&id=" + id,
                    method: "GET",
                    success: function(resp){
                        if(resp.status == 'success'){
                            alert("Auditor deleted successfully");
                            location.reload();
                        } else {
                            alert("An error occurred while deleting the auditor");
                        }
                    },
                    error: function(xhr, status, error){
                        alert("An error occurred while deleting the auditor");
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
