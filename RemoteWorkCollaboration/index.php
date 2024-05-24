<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('inc/header.php') ?>
<style> 
           .page {
             margin-top: 70px;
        }

        .left {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .container2 {
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn-submit {
            background-color: #007bff;
            margin-right: 10px;
        }

        .btn-reset {
            background-color: #dc3545;
        }

        .btn-submit,
        .btn-reset {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: black;
        }

        .btn-reset:hover {
            background-color: #c82333;
        }



.page {
    display: flex;
    flex-direction: column;
    background-color: green;
    padding: 20px;
}

.left {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.left h1 {
    font-size: 24px;
    margin: 0;
}

.breadcrumb {
    list-style: none;
    padding: 0;
    margin: 0;
}

.breadcrumb li {
    display: inline;
    font-size: 14px;
    color: #666;
}

.breadcrumb li i {
    margin: 0 5px;
}

.btn-download {
    display: flex;
    align-items: center;
    background-color: blue;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
}

.btn-download:hover {
    background-color: #0056b3;
}

.DataTable {
    background-color: #00FF00;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.cardHeader {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.cardHeader h2 {
    font-size: 20px;
    margin: 0;
}

.btn {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
}

.btn:hover {
    background-color: #0056b3;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background-color: #f8f9fa;
}

thead tr {
    border-bottom: 2px solid #dee2e6;
}

thead td {
    font-weight: bold;
    padding: 10px 0;
    text-align: left;
}

tbody tr {
    border-bottom: 1px solid #dee2e6;
}

tbody td {
    padding: 10px 0;
    text-align: left;
}

.status {
    padding: 5px 10px;
    border-radius: 5px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
}

.delivered {
    background-color: #28a745;
    color: #fff;
}

.pending {
    background-color: #ffc107;
    color: #000;
}

.return {
    background-color: #dc3545;
    color: #fff;
}

.inProgress {
    background-color: #17a2b8;
    color: #fff;
}


</style>
<body>
<?php require_once('inc/topBarNav.php') ?>
<?php $page = isset($_GET['p']) ? 'pages/'.$_GET['p'] : 'pages/home';  ?>
<?php 
    if(!file_exists($page.".php") && !is_dir($page)){
        include '404.html';
    }else{
    if(is_dir($page))
        include $page.'/index.php';
    else
        include $page.'.php';

    }
?>
<?php require_once('inc/footer.php') ?>
<div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog   rounded-0 modal-md modal-dialog-centered" role="document">
      <div class="modal-content  rounded-0">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog  rounded-0 modal-full-height  modal-md" role="document">
      <div class="modal-content rounded-0">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-right"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="viewer_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
              <button type="button" class="btn-close" data-dismiss="modal"><span class="fa fa-times"></span></button>
              <img src="" alt="">
      </div>
    </div>
  </div>
<script>
        $(function(){
 
        $('#empty_cart').click(function(){
            var confirmEmpty = confirm("Are you sure you want to empty your cart?");
            if (confirmEmpty) {
                $.ajax({
                    url: 'cartAction.php?f=empty_cart',
                    method: 'GET',
                    dataType: 'json',
                    success: function(resp){
                        if(resp.status == 'success'){
                            alert('Cart emptied successfully.');
                            location.reload();
                        }else{
                            alert('Failed to empty cart. Please try again.');
                        }
                    },
                    error: function(xhr, status, error){
                        console.error(xhr.responseText);
                        alert('An error occurred while emptying cart.');
                    }
                });
            }
        })


        
        $('#continueCheckout').click(function(){
            var confirmCheckout = confirm("Are you sure you want to add the cart to the database?");
            if (confirmCheckout) {
                $.ajax({
                    url: 'cartAction.php?f=add_enrollment',
                    method: 'POST',
                    data: {
                        course_id: '<?php echo $course_Id; ?>',
                        course_name: '<?php echo $course_name; ?>'
                    },
                    dataType: 'json',
                    success: function(resp){
                        if(resp.status == 'success'){
                            alert('Cart added successfully.');
                            location.reload();
                        }else{
                            alert('Failed to add cart. Please try again.');
                        }
                    },
                    error: function(xhr, status, error){
                        console.error(xhr.responseText);
                        alert('An error occurred while adding cart.');
                    }
                });
            }
        });
    });
</script>
</body>
</html>