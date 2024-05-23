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
$tool_id = "Auto";
$tool_name = "";
$toolDescription = "";
$tool_image = "";

if (isset($_GET['id'])) {
    $tool_id = $_GET['id'];
    $sql = "SELECT * FROM tools WHERE id = $tool_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tool_name = $row['tool_name'];
        $toolDescription = $row['toolDescription'];
        $tool_image = $row['tool_image'];
    }
}
?>

<div class="container-fluid">
    <form id="tool-form">
        <div class="form-group">
            <label for="tool_id">ID</label>
            <input type="text" class="form-control" id="tool_id" name="tool_id" value="<?php echo $tool_id; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="tool_name">Tool Name</label>
            <input type="text" class="form-control" id="tool_name" name="tool_name" value="<?php echo $tool_name; ?>">
            <div class="error-message" id="tool_name_error"></div>
        </div>
        <div class="form-group">
            <label for="toolDescription">Description</label>
            <input type="text" class="form-control" id="toolDescription" name="toolDescription" value="<?php echo $toolDescription; ?>">
            <div class="error-message" id="toolDescription_error"></div>
        </div>
        
      
    </form>
</div>

<script>
    $(function(){
        $('#tool-form').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var formData = form.serialize();
            var error = false;
            $('.error-message').html('');
            form.find('input').removeClass('error-border');

            // Check for empty fields
            form.find('input').each(function(){
                if ($(this).val() == '' && $(this).attr('id') !== 'tool_id') {
                    var fieldName = $(this).attr('name');
                    $('#' + fieldName + '_error').html('This field is required.');
                    $(this).addClass('error-border');
                    error = true;
                }
            });

            if (!error) {
                start_loader();
                $.ajax({
                    url: "phpAction/submitTool.php?id=" + (form.find('#tool_id').val() !== 'Auto' ? form.find('#tool_id').val() : ''),
                    method: "POST",
                    data: formData,
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
