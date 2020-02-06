<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?php echo $title;?></title>

  <!-- Custom fonts for this template-->
  <link href="<?php echo base_url(); ?>assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">

  <script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
  
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>

<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<script type="text/javascript" src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>


</head>

<body id="page-top">

    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/datatables/jquery.dataTables.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url(); ?>assets/js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="<?php echo base_url(); ?>assets/js/demo/datatables-demo.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/demo/chart-area-demo.js"></script>

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
    <?php if($this->session->userdata('user') == 'admin')
    {
        echo '<a class="navbar-brand mr-1" href="">Admin</a>';
    }?>
    

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>

    <?php if($this->session->userdata('user') == 'coadmin')
    {
        echo '<a class="navbar-brand mr-1" href="">'.$this->session->userdata('college_name').'</a>';
    }?>

    <?php if($this->session->userdata('user') == 'teacher')
    {
        echo '<a class="navbar-brand mr-1" href="">'.$this->session->userdata('college_name')."  /  ".$this->session->userdata('course_name').'</a>';
    }?>
    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
      <div class="input-group">
<!--         <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
          <button class="btn btn-primary" type="button">
            <i class="fas fa-search"></i>
          </button>
        </div> -->
      </div>
    </form>
    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">
    <ul class="navbar-nav ml-auto ml-md-0">
          <a type="button" class="nav-link fas fa-sign-out-alt" href="#" data-toggle="modal" data-target="#logoutModal" style="color: white"><span> Logout</span></a>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url('admin/dashboard'); ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <?php if($this->session->userdata('user') === 'admin') { ?>
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url('admin/college_table'); ?>">
          <i class="fas fa-school"></i>
          <span>Colleges</span>
        </a>
      </li>
      <?php } ?>

      <?php if($this->session->userdata('user') === 'admin' || $this->session->userdata('user') === 'coadmin') { ?>
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url('admin/course_table'); ?>">
          <i class="fas fa-book-open"></i>
          <span>Course</span>
        </a>
      </li>
      <?php } ?>

      <?php if($this->session->userdata('user') === 'admin') { ?>
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url('admin/coadmin_table'); ?>">
          <i class="fas fa-users"></i>
          <span>College Admin</span>
        </a>
      </li>
      <?php } ?>

      <?php if($this->session->userdata('user') === 'admin' || $this->session->userdata('user') === 'coadmin') { ?>
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url('admin/teacher_table'); ?>">
          <i class="fas fa-users"></i>
          <span>Teachers</span>
        </a>
      </li>
      <?php } ?>

      <li class="nav-item active">
        <a class="nav-link" href="<?php echo base_url('admin/student_table'); ?>">
          <i class="fas fa-users"></i>
          <span>Students</span>
        </a>
      </li>

      <?php if($this->session->userdata('user') === 'admin') { ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('admin/coadmin_register_form'); ?>">
          <i class="fas fa-chalkboard-teacher"></i>
          <span>Add College Admin</span></a>
      </li>
      <?php } ?>

      <?php if($this->session->userdata('user') === 'admin' || $this->session->userdata('user') === 'coadmin') { ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('admin/teacher_register_form'); ?>">
          <i class="fas fa-chalkboard-teacher"></i>
          <span>Add Teacher</span></a>
      </li>
      <?php } ?>

      <?php if($this->session->userdata('user') === 'teacher') { ?>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('admin/get_attendance/'.$this->session->userdata('course_id')); ?>">
          <i class="fas fa fa-table"></i>
          <span>Attendance</span></a>
      </li>
      <?php } ?>
      
      <li class="nav-item">
        <a class="nav-link" href="<?php echo base_url('admin/student_registration'); ?>">
          <i class="fas fa-user-plus"></i>
          <span>Add Student</span></a>
      </li>
      
    </ul>

    <div id="content-wrapper">
      <div class="container-fluid">





<?php echo $content; ?>



    
        <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>
    </div>
  </div>
  
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <?php if($this->session->userdata('user')==='admin'){?>
          <a class="btn btn-primary" href="<?php echo base_url('login/logout'); ?>">Logout</a>
          <?php }?>

          <?php if($this->session->userdata('user')==='coadmin'){?>
          <a class="btn btn-primary" href="<?php echo base_url('login/logout_coadmin'); ?>">Logout</a>
          <?php }?>

          <?php if($this->session->userdata('user')==='teacher'){?>
          <a class="btn btn-primary" href="<?php echo base_url('login/logout_teacher'); ?>">Logout</a>
          <?php }?>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="<?php echo base_url(); ?>assets/vendor/chart.js/Chart.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/datatables/jquery.dataTables.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url(); ?>assets/js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="<?php echo base_url(); ?>assets/js/demo/datatables-demo.js"></script>
  <script src="<?php echo base_url(); ?>assets/js/demo/chart-area-demo.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" integrity="sha256-sPB0F50YUDK0otDnsfNHawYmA5M0pjjUf4TvRJkGFrI=" crossorigin="anonymous"></script>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script> 




</body>

</html>