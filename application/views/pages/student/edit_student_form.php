<div class="container" style="padding: 10px">
  
  <div class="card" style="padding: 9px">
    
    <h3>Student Form</h3>

  </div>
  <div style="padding: 9px"></div>



<body>
<!-- <?php echo '<pre>'; print_r($course); echo '</pre>';?> -->
<div class="card">
<div class="container" style="padding: 20px">
    <form name="form" method="post" class="container" action="<?php echo base_url('admin/update_student'); ?>" >

      <input type="hidden" name="id" value="">

      <div class="form-group">
        <label for="name">ID</label>
        <input type="text" name="id" id="id" class="form-control required" placeholder="Enter Student ID" value="<?php echo $student[0]->student_id;?>" >
        <input type="hidden" name="student_id" id="student_id" value="<?php if(isset($student[0]->id)){ echo $student[0]->id; }?>">
        <span id="iderror" class="text-danger"></span>
      </div>
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control required" placeholder="Enter Student Name" value="<?php echo $student[0]->student_name;?>" >
        <span id="nameerror"></span>
      </div>

      <div class="form-group">
        <label for="gender">Gender</label><br>
        <input type="radio" name="gender" value="male" <?php if($student[0]->student_gender == "male"){ echo "checked"; }?>>Male
        <input type="radio" name="gender" value="female" <?php if($student[0]->student_gender == "female"){ echo "checked"; }?>>Female
        <span id="countryerror"></span>
      </div>

      <div class="form-group">
        <label for="college" style="width: 200px">Academic Year</label>
        <select name="academic" id="academic" style="width: 50%" class="form-control">
          <option value="">Select Year</option>
          <?php foreach($academic as $row){ ?>
          <option value="<?php echo $row->academic_id;?>" <?php if($student[0]->student_year == $row->academic_id) { echo "selected";}?>><?php echo $row->academic_name;?></option>
        <?php } ?>
        </select>
      </div>

<?php if($this->session->userdata('user') == 'admin') { ?>
      <div class="form-group">
        <label for="college" style="width: 100px">College</label>
        <select name="college" id="college" style="width: 50%" class="form-control">
          <option value="">Select College</option>
          <?php foreach($college as $row){ ?>
          <option value="<?php echo $row->id;?>" <?php if($college_id == $row->id){echo "selected";}?>><?php echo $row->college_name;?></option>
        <?php } ?>
        </select>
      </div>
<?php } ?>

<?php if($this->session->userdata('user') == 'admin' || $this->session->userdata('user') == 'coadmin') { ?>
      <div class="form-group">
        <label for="course" style="width: 99px">Course</label>
        <select name="course" id="course" style="width: 50%" class="form-control">
          <option value="">Select Course</option>
          <?php foreach($course as $row){ ?>
          <option value="<?php echo $row->id;?>" <?php if($course_id == $row->id){echo "selected";}?>><?php echo $row->course_name;?></option>
        <?php } ?>
        </select>
      </div>
<?php } ?>
    
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