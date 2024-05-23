<?php
error_reporting(0);
include_once("../connection/connection.php");

$sql = "SELECT * FROM team ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["id"]."</td>";
        echo "<td>".$row["team_name"]."</td>";
        echo "<td>".$row["team_description"]."</td>";
        echo "<td>".$row["dateAdded"]."</td>";
        echo "<td><img src='phpAction/" . $row["teamImage"] . "' class='rounded-image' onclick='viewImage(\"" . $row["teamImage"] . "\")'></td>";
        echo "<td>
                <a onclick='viewImage(\"" . $row["teamImage"] . "\")' data-id='".$row["id"]."' class='btn btn-primary btn-sm'>View</a> |
                <a class='updateTeam' data-id='".$row["id"]."' class='btn btn-primary btn-sm'>Edit</a> |
                <a class='deleteTeam' data-id='".$row["id"]."' href='#' class='btn btn-primary btn-sm'>Delete</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='6'>No records found</td></tr>";
}
?>

<script>
    $(document).ready(function(){
        // Open modal with team form on Edit link click
        $('.updateTeam').click(function(){
            var id = $(this).data('id');
            uni_modal("", "forms/teamForm.php?id=" + id);
        });

        // Delete action for teams
        $('.deleteTeam').click(function(e){
            e.preventDefault();
            var id = $(this).data('id');
            var table = "team";
            if(confirm("Are you sure you want to delete this team?")){
                $.ajax({
                    url: "delete/deleteData.php?table="+table+"&id=" + id,
                    method: "GET",
                    success: function(resp){
                        if(resp.status == 'success'){
                            alert("Team deleted successfully");
                            location.reload();
                        } else {
                            alert("Team deleted successfully");
                        }
                    },
                    error: function(xhr, status, error){
                        alert("An error occurred while deleting the team");
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
