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
$auditor_id = "Auto";
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
    $auditor_id = $_GET['id'];
    $sql = "SELECT * FROM auditor WHERE id = $auditor_id";
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
    <form id="auditor-form">
        <div class="form-group">
            <label for="auditor_id">ID</label>
            <input type="text" class="form-control" id="auditor_id" name="auditor_id" value="<?php echo $auditor_id; ?>" readonly>
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
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
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
        
        
    </form>
</div>

<script>
    $(function(){
        $('#auditor-form').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            var error = false;
            $('.error-message').html('');
            form.find('input').removeClass('error-border');

            // Check for empty fields
            form.find('input').each(function(){
                if ($(this).val() == '' && $(this).attr('id') !== 'auditor_id') {
                    var fieldName = $(this).attr('name');
                    $('#' + fieldName + '_error').html('This field is required.');
                    $(this).addClass('error-border');
                    error = true;
                }
            });

            if (!error) {
                start_loader();
                $.ajax({
                    url: "phpAction/submitAuditor.php?id=" + (form.find('#auditor_id').val() !== 'Auto' ? form.find('#auditor_id').val() : ''),
                    method: "POST",
                    data: formData,
                    success: function(resp){
                        if (resp.status == 'success') {
                            alert_toast("Successfully Done", 'success');
                            setTimeout(function(){
                                location.reload();
                            }, 2000);
                        } else {
                            alert_toast("An error occurred", 'error');
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
