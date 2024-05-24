 
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Add Work Done on Project</h1>
                <div class="card">
                    <div class="card-header">
                        <h4>Add Work</h4>
                    </div>
                    <div class="card-body">
                        <form id="workForm" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="project_name">Project Name</label>
                                <input type="text" id="project_name" name="project_name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="project_id">Project ID</label>
                                <input type="text" id="project_id" name="project_id" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="sharedImage">Shared Image</label>
                                <input type="file" id="sharedImage" name="sharedImage[]" class="form-control" multiple accept="image/*" required>
                                <div id="imagePreview" class="mt-2"></div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .preview-image {
            width: 100px;
            height: 100px;
            margin: 5px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
    </style>

     <script>
        $(document).ready(function() {
            var selectedImages = [];

            $('#sharedImage').on('change', function() {
                var files = $(this)[0].files;
                $('#imagePreview').html('');
                selectedImages = [];

                if (files.length > 10) {
                    alert('You can only upload a maximum of 10 images');
                    $('#sharedImage').val('');
                    return;
                }

                for (var i = 0; i < files.length; i++) {
                    selectedImages.push(files[i].name);

                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').append('<img src="' + e.target.result + '" class="preview-image">');
                    }
                    reader.readAsDataURL(files[i]);
                }
            });

            $('#workForm').submit(function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                formData.append('userId', '<?php echo $_SESSION['id']; ?>');
                formData.append('selectedImages', selectedImages.join(','));

                $.ajax({
                    url: 'phpAction/save_project.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert('Work Sent to the admin successfully');
                        $('#workForm')[0].reset();
                        $('#imagePreview').html('');
                        selectedImages = [];
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred while saving the work:", error);
                    }
                });
            });
        });
    </script>
 