<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>College Admin Login</title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body class="bg-dark">
    <nav class="navbar navbar-dark bg-dark">
    <div class="row">

      <div class="col-md-3" align="middle">
  <h6><a class="navbar-brand" href="<?php echo base_url('login');?>">SAdmin</a></h6>
  </div>
      <div class="col-md-3">
  <h6><a class="navbar-brand" href="<?php echo base_url('login/login_coadmin');?>">Admin</a></h6>
  </div>

    <div class="col-md-6">
  <h6><a class="navbar-brand" href="<?php echo base_url('login/teacher_login');?>">Teacher</a></h6>
  </div>
  </div>
</nav>

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">College Admin Login</div>
      <div class="card-body">
        <form action="<?php echo base_url(); ?>login/coadmin_login_validation" method="POST">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="username" class="form-control" placeholder="Username" autofocus="autofocus" name="username">
              <label for="username">Username</label>
              <p><?php echo form_error('username'); ?></p>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="password" class="form-control" placeholder="password" name="password">
              <label for="password">Password</label>
              <p><?php echo form_error('password'); ?></p>
            </div>
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me">
                Remember Password
              </label>
            </div>
          </div>
          <input class="btn btn-primary btn-block" type="submit" name="login" value="Login"></input>
        </form>
        <div class="text-center">

        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    
    $(document).ready(function()
    {
      
    });
  </script>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
