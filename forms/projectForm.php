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
$project_id = "Auto";
$project_name = "";
$project_description = "";
$dateCreated = "";

if (isset($_GET['id'])) {
    $project_id = $_GET['id'];
    $sql = "SELECT * FROM projects WHERE id = $project_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $project_name = $row['project_name'];
        $project_description = $row['project_description'];
        $dateCreated = $row['dateCreated'];
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
            <h3 class="text-center"><?php echo isset($_GET['id']) ? 'Edit Project' : 'Add Project'; ?></h3>
            <hr>
            <form id="project-form">
                <div class="form-group">
                    <label for="project_id">ID</label>
                    <input type="text" class="form-control" id="project_id" name="project_id" value="<?php echo $project_id; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="project_name">Project Name</label>
                    <input type="text" class="form-control" id="project_name" name="project_name" value="<?php echo $project_name; ?>">
                    <div class="error-message" id="project_name_error"></div>
                </div>
                <div class="form-group">
                    <label for="project_description">Project Description</label>
                    <textarea class="form-control" id="project_description" name="project_description"><?php echo $project_description; ?></textarea>
                    <div class="error-message" id="project_description_error"></div>
                </div>
                <div class="form-group">
                    <label for="projectImage">Project Image</label>
                    <input type="file" id="projectImage" name="projectImage" class="form-control">
                    <div class="error-message" id="projectImage_error"></div>
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
        $('#project-form').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
            var error = false;
            $('.error-message').html('');
            form.find('input, textarea').removeClass('error-border');

            // Check for empty fields
            form.find('input, textarea').each(function(){
                if ($(this).val() == '' && $(this).attr('id') !== 'project_id') {
                    var fieldName = $(this).attr('name');
                    $('#' + fieldName + '_error').html('This field is required.');
                    $(this).addClass('error-border');
                    error = true;
                }
            });

            // Validate image file format
            var fileInput = $('#projectImage');
            var file = fileInput[0].files[0];
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            if (file && !allowedExtensions.exec(file.name)) {
                $('#projectImage_error').html('Please select a valid image file.');
                fileInput.addClass('error-border');
                error = true;
            }

            if (!error) {
                start_loader();
                $.ajax({
                    url: "phpAction/submitProject.php?id=" + (form.find('#project_id').val() !== 'Auto' ? form.find('#project_id').val() : ''),
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
