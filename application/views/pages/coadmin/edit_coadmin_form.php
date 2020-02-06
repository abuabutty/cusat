<div class="container" style="padding: 10px">
  
  <div class="card" style="padding: 9px">

    <div class="row">
    <div class="col-md-4">
      <h3>College Admin Form</h3>
    </div>
    <div class="col-md-6">
      <?php if($this->session->flashdata('formnull')) { ?>
        <div class="col-md-6" >
              <span class="alert alert-danger message hideit" id="message">
              <strong><?php echo $this->session->flashdata('formnull'); ?></strong>
        </div>
      <?php } ?>
      <?php if($this->session->flashdata('password')) { ?>
        <div class="col-md-6" >
              <span class="alert alert-primary message hideit" id="message">
              <strong><?php echo $this->session->flashdata('password'); ?></strong>
        </div>
      <?php } ?>
    </div>
    <div class="col-md-2" align="right">
      <span><a href="coadmin_table"><input type="submit" class="btn btn-success" name="back" value="Back"></input></a></span>
    </div>
    </div>

  </div>

  <div style="padding: 9px"></div>



<body>

<div class="card">
<div class="container" style="padding: 20px">
    <form name="form" method="post" class="container" action="<?php echo base_url('admin/update_coadmin'); ?>" >

      <input type="hidden" name="coadmin_id" id="coadmin_id" value="<?php echo $coadmin[0]->coadmin_id;?>">

      <div class="form-group">
        <label for="name">Username</label>
        <input type="text" name="username" value="<?php echo $coadmin[0]->coadmin_username;?>" id="username" class="form-control required" placeholder="Enter Username" >
      </div>
      <div class="form-group">
        <label for="name">Password</label>
        <input type="text" name="password" value="<?php echo $password;?>" id="password" class="form-control required" placeholder="Enter Password" >
      </div>
      <div class="form-group">
        <label for="name">Confirm Password</label>
        <input type="password" name="cpassword" value="" id="cpassword" class="form-control required" placeholder="Re-enter Password" >
      </div>

      <div class="form-group">
        <label for="college_id" style="width: 100px">College</label>
        <select name="college_id" id="college_id" style="width: 300px">
          <option value="">Select College</option>
          <?php foreach($college as $row){ ?>
          <option value="<?php echo $row->id;?>" <?php if($coadmin[0]->coadmin_college_id == $row->id){ echo "selected";}?>><?php echo $row->college_name;?></option>
        <?php } ?>
        </select>
        <span style="color: red"><?php echo form_error('college_id'); ?></span>
      </div>
      
      <div class="input-group">
          
          <button type="submit" class="btn btn-primary" name="save">Save</button>
          
      </div>
        
    </form>

    </div>
</div>
</div>
</body>


<script type="text/javascript">
  
  $(document).ready(function()
  {
    $('.hideit').fadeOut(10000);

    $('#college').change(function()
    {
      var college_id = $('#college').val();
      
      if(college_id!='')
      {
        $.ajax({

          url: "<?php echo base_url('admin/fetch_course');?>",
          method: "POST",
          data: {college_id:college_id},
          success:function(data)
          {
            $('#course').html(data);
          }
        });
      }
    });


    $("#id").keyup(function()
    {
      var id = $('#id').val();
      
      if(id!='')
      {
        $.ajax({

          url: "<?php echo base_url('admin/check_student_id');?>",
          method: "POST",
          data: {id:id},
          success:function(data)
          {
            $('#iderror').html(data);
          }
        });
      }

    });
  });

</script>