<?php
include_once("./connection/connection.php");

// Fetch categories from the database
 
// Get the total number of items in the cart for the current user

?> 

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid px-4 px-lg-5">
        <button class="navbar-toggler btn btn-sm" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>            <?php //if (isset($_SESSION['valid'])){ ?>

      <!--  <a class="navbar-brand" href="./">
             <img src="myImages/avatar.png" width="30" height="30" class="d-inline-block align-top" alt="" loading="lazy">
            <?php// echo "<b>".$_SESSION['role']."</b> ".$_SESSION['first_name']." ".$_SESSION['last_name']; ?>
        </a>-->
<?php //} else{ ?>

    <a class="navbar-brand" href="./">
            <!-- Your logo and short name here -->
            <b><i>Remote Work Collaboration Tool</i></b>
        </a>
    <?php //} ?>
    <?php if(!isset($_SESSION['valid']) && 1==1){ ?>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link" aria-current="page" href="./">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownCourses" role="button" data-toggle="dropdown" aria-expanded="false">Projects</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownCourses">
                    <li><a class="dropdown-item" href="#">Data</a></li>
                    <li><a class="dropdown-item" href="#">Data</a></li>
                    <li><a class="dropdown-item" href="#">Data</a></li>
                    <li><a class="dropdown-item" href="#">Data</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="./?p=manageProject">Projects</a></li>
                <li class="nav-item"><a class="nav-link" href="./?p=manageOrder">Order</a></li>
                <li class="nav-item"><a class="nav-link" href="./?p=manageOrder">Order</a></li>

                 <?php }else{} ?>
            </ul>
            <?php if(isset($_SESSION['valid'])){ ?>
                <div class="d-flex align-items-center">
                <a class="btn btn-outline-dark ml-2" id="login-btn" href="logout.php">LogOut</a>
            </div>

         <?php   }else{ ?>
            <div class="d-flex align-items-center">
                <a class="btn btn-outline-dark ml-2" id="login-btn" href="#">Login</a>
            </div>
            <?php } ?>
        </div>
    </div>
</nav>



<script>
  $(function(){
    $('#login-btn').click(function(){
      uni_modal("","forms/login.php")
    })
    $('#navbarResponsive').on('show.bs.collapse', function () {
        $('#mainNav').addClass('navbar-shrink')
    })
    $('#navbarResponsive').on('hidden.bs.collapse', function () {
        if($('body').offset.top == 0)
          $('#mainNav').removeClass('navbar-shrink')
    })
  })

 
</script>