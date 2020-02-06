<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin - Register</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Register an Account</div>
      <div class="card-body">
        <form method="POST" action="<?php echo base_url(); ?>admin/register_validation">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="inputName" class="form-control" placeholder="Name" name="inputName">
              <label for="inputName" >Name</label>
              <p id="emailav" style="color: red" class="text-center"></p>
              <p><?php echo form_error('inputName'); ?></p>
            </div>
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="inputPassword">
                  <label for="inputPassword">Password</label>
                  <p><?php echo form_error('inputPassword'); ?></p>
                  <p><?php echo $this->session->flashdata("password"); ?></p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-label-group">
                  <input type="password" id="confirmPassword" class="form-control" placeholder="Confirm password" name="confirmPassword">
                  <label for="confirmPassword">Confirm password</label>
                  <p><?php echo form_error('confirmPassword'); ?></p>
                </div>
              </div>
            </div>
          </div>
          <input class="btn btn-primary btn-block" type="submit" name="register" id="register" value="Register" ></input>
        </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="<?php echo base_url('admin/login'); ?>">Login Page</a>
          <a class="d-block small" href="<?php echo base_url('admin/forgotpassword'); ?>">Forgot Password?</a>
        </div>
      </div>
    </div>
  </div>


  <script type="text/javascript">
    
    $(document).ready(function()
    {

       $('#inputEmail').keyup(function()
       {
         var email=$(this).val();

          $.ajax({
            url: "<?php echo base_url('admin/checkemail'); ?>",
            method: "POST",
                data: {email:email},
                success: function(data)
                {
                    $("#emailav").html(data);
                },
                error: function() 
               {
          
                }
          });
       });
    });

  </script>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <script src="<?php echo base_url(); ?>assets/js/jquery-3.4.1.js"></script>

</body>

</html>