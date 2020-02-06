      <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>

        <!-- Icon Cards-->
        <div class="row">

<?php if($this->session->userdata('user')=='admin') { ?>

          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-university"></i>
                </div>
                <div class="mr-5"><?php echo $college_count;?> Colleges!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="college_table">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>

<?php } ?>

<?php if($this->session->userdata('user')=='admin' || $this->session->userdata('user')=='coadmin') { ?> 
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-book"></i>
                </div>
                <div class="mr-5"><?php echo $course_count;?> Courses!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="course_table">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
<?php } ?>

<?php if($this->session->userdata('user')=='admin') { ?>

          <div class="col-xl-3 col-sm-6 mb-3">
             <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-life-ring"></i>
                </div>
                <div class="mr-5"><?php print_r($coadmin_count);?> College Admins!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="coadmin_table">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
<?php } ?>

<?php if($this->session->userdata('user') == 'admin' || $this->session->userdata('user') == 'coadmin') { ?>         
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-info o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-list"></i>
                </div>
                <div class="mr-5"><?php echo $teacher_count;?> Teachers!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="teacher_table">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
<?php } ?>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-user"></i>
                </div>
                <div class="mr-5"><?php echo $student_count;?> Students!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="student_table">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>

<?php if($this->session->userdata('user') == 'teacher') { ?>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-list"></i>
                </div>
                <div class="mr-5">Attendance!</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="get_attendance/<?php echo $this->session->userdata('course_id');?>">
                <span class="float-left">View Details</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
<?php } ?>

        </div>

        <!-- Area Chart Example-->
<!--         <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            Area Chart Example</div>
          <div class="card-body">
            <canvas id="myAreaChart" width="100%" height="30"></canvas>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div> -->

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Data Table Example</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTabledash" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>SI</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Gender</th>
                    
                    <?php if($this->session->userdata('user')== 'admin' || $this->session->userdata('user')== 'coadmin') { ?>
                    <th>Course</th>
                    <?php } ?>

                    <?php if($this->session->userdata('user')=='admin') { ?>
                      <th>College</th>
                    <?php } ?>

                    <th>Action</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th>SI</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Gender</th>

                    <?php if($this->session->userdata('user')== 'admin' || $this->session->userdata('user')== 'coadmin') { ?>
                    <th>Course</th>
                    <?php } ?>

                    <?php if($this->session->userdata('user')=='admin') { ?>
                      <th>College</th>
                    <?php } ?>
                    
                    <th>Action</th>
                  </tr>
                </tfoot>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>



        <script type="text/javascript">
  $(document).ready(function()
  {
    var dataTable = $('#dataTabledash').DataTable({  
             "processing":true,  
             "serverSide":true,  
             "order":[],  
             "ajax":{  
                  url:"<?php echo base_url() . 'admin/fetch_student'; ?>",  
                  type:"POST"  
             },  
        });

    $('#message').fadeOut(5000);

  });
</script>