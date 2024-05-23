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
$supervisor_id = "Auto";
$fullnames = "";
$phone = "";
$email = "";
$address = "";
$gender = "";
$status = "";
$age = "";
$image = "";
$date_ = "";

if (isset($_GET['id'])) {
    $supervisor_id = $_GET['id'];
    $sql = "SELECT * FROM supervisor WHERE id = $supervisor_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fullnames = $row['fullnames'];
        $phone = $row['phone'];
        $email = $row['email'];
        $address = $row['address'];
        $gender = $row['gender'];
        $status = $row['status'];
        $age = $row['age'];
        $image = $row['image'];
        $date_ = $row['date_'];
    }
}
?>

<div class="container-fluid">
    <form id="supervisor-form" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="supervisor_id">ID</label>
            <input type="text" class="form-control" id="supervisor_id" name="supervisor_id" value="<?php echo $supervisor_id; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="fullnames">Full Names</label>
            <input type="text" class="form-control" id="fullnames" name="fullnames" value="<?php echo $fullnames; ?>">
            <div class="error-message" id="fullnames_error"></div>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $phone; ?>">
            <div class="error-message" id="phone_error"></div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
            <div class="error-message" id="email_error"></div>
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="<?php echo $address; ?>">
            <div class="error-message" id="address_error"></div>
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <input type="text" class="form-control" id="gender" name="gender" value="<?php echo $gender; ?>">
            <div class="error-message" id="gender_error"></div>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <input type="text" class="form-control" id="status" name="status" value="<?php echo $status; ?>">
            <div class="error-message" id="status_error"></div>
        </div>
        <div class="form-group">
            <label for="age">Age</label>
            <input type="text" class="form-control" id="age" name="age" value="<?php echo $age; ?>">
            <div class="error-message" id="age_error"></div>
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" id="image" name="image" class="form-control">
            <div class="error-message" id="image_error"></div>
        </div>
        <div class="form-group d-flex justify-content-between">
            <button type="submit" class="btn btn-primary btn-flat"><?php echo isset($_GET['id']) ? 'Update' : 'Add'; ?></button>
        </div>
    </form>
</div>

<script>
    $(function(){
        $('#supervisor-form').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var formData = new FormData(form[0]);
            var error = false;
            $('.error-message').html('');
            form.find('input').removeClass('error-border');

            // Check for empty fields
            form.find('input').each(function(){
                if ($(this).val() == '' && $(this).attr('id') !== 'supervisor_id') {
                    var fieldName = $(this).attr('name');
                    $('#' + fieldName + '_error').html('This field is required.');
                    $(this).addClass('error-border');
                    error = true;
                }
            });

            // Validate image file format
            var fileInput = $('#image');
            var file = fileInput[0].files[0];
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            if (file && !allowedExtensions.exec(file.name)) {
                $('#image_error').html('Please select a valid image file.');
                fileInput.addClass('error-border');
                error = true;
            }

            if (!error) {
                start_loader();
                $.ajax({
                    url: "phpAction/submitSupervisor.php?id=" + (form.find('#supervisor_id').val() !== 'Auto' ? form.find('#supervisor_id').val() : ''),
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
