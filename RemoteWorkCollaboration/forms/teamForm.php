<style>
    #uni_modal .modal-content>.modal-footer, #uni_modal .modal-content>.modal-header {
        display: none;
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
$team_id = "Auto";
$team_name = "";
$team_description = "";
$dateAdded = "";

if (isset($_GET['id'])) {
    $team_id = $_GET['id'];
    $sql = "SELECT * FROM team WHERE id = $team_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $team_name = $row['team_name'];
        $team_description = $row['team_description'];
        $dateAdded = $row['dateAdded'];
    }
}
?>

<div class="container-fluid">
    <div class="row">
        <h3 class="float-right">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </h3>
        <div class="col-lg-12">
            <h3 class="text-center"><?php echo isset($_GET['id']) ? 'Edit Team' : 'Add Team'; ?></h3>
            <hr>
            <form id="team-form">
                <div class="form-group">
                    <label for="team_id">ID</label>
                    <input type="text" class="form-control" id="team_id" name="team_id" value="<?php echo $team_id; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="team_name">Team Name</label>
                    <input type="text" class="form-control" id="team_name" name="team_name" value="<?php echo $team_name; ?>">
                    <div class="error-message" id="team_name_error"></div>
                </div>
                <div class="form-group">
                    <label for="team_description">Team Description</label>
                    <textarea class="form-control" id="team_description" name="team_description"><?php echo $team_description; ?></textarea>
                    <div class="error-message" id="team_description_error"></div>
                </div>
                <div class="form-group">
                    <label for="teamImage">Team Image</label>
                    <input type="file" id="teamImage" name="teamImage" class="form-control">
                    <div class="error-message" id="teamImage_error"></div>
                </div>
                <div class="form-group d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary btn-flat"><?php echo isset($_GET['id']) ? 'Update' : 'Add'; ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#team-form').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
            var error = false;
            $('.error-message').html('');
            form.find('input, textarea').removeClass('error-border');

            // Check for empty fields
            form.find('input, textarea').each(function(){
                if ($(this).val() == '' && $(this).attr('id') !== 'team_id') {
                    var fieldName = $(this).attr('name');
                    $('#' + fieldName + '_error').html('This field is required.');
                    $(this).addClass('error-border');
                    error = true;
                }
            });

            // Validate image file format
            var fileInput = $('#teamImage');
            var file = fileInput[0].files[0];
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            if (file && !allowedExtensions.exec(file.name)) {
                $('#teamImage_error').html('Please select a valid image file.');
                fileInput.addClass('error-border');
                error = true;
            }

            if (!error) {
                start_loader();
                $.ajax({
                    url: "phpAction/submitTeam.php?id=" + (form.find('#team_id').val() !== 'Auto' ? form.find('#team_id').val() : ''),
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(resp){
                        if (resp.status == 'success') {
                            alert_toast("Successfully Done", 'success');
                            setTimeout(function(){
                                location.reload();
                            }, 2000);
                        } else {
                            alert_toast("Successfully Done", 'success');
                            console.log(resp);
                        }
                        form[0].reset();
                        end_loader();
                    },
                    error: function(xhr, status, error){
                        alert_toast("An error occurred", 'error');
                        console.log(xhr.responseText);
                        end_loader();
                    }
                });
            }
        });
    });
</script>
