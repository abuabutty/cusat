<div class="container" style="padding: 10px">
  
  <div class="card" style="padding: 9px">
    
    <h3>Course Edit</h3>

  </div>
  <div style="padding: 9px"></div>



<body>

<div class="card">
<div class="container" style="padding: 20px">
    <form name="form" method="post" class="container" action="<?php echo base_url('admin/update_course'); ?>" >

      <input type="hidden" name="id" value="">

<?php if($this->session->userdata('user')=='admin') { ?>
      <div class="form-group">
        <label for="name">College</label>
          <select name="college" id="college" style="width: 465px" class="form-control">
            <option value="select">Select College</option>
            <?php foreach($college as $row){ ?>
            <option value="<?php echo $row->id;?>" <?php if($college_id == $row->id){echo "selected";}?>><?php echo $row->college_name;?></option>
          <?php }   ?>
          
          </select>
      </div>
<?php } ?>
      <div class="form-group">
        <label for="name">Course Name</label>
        <input type="text" name="course_name" value="<?php echo $course[0]->course_name;?>" id="course_name" class="form-control required" placeholder="Enter Student Name">
        <input type="hidden" name="course_id" id="course_id" value="<?php echo $course[0]->id;?>">
        <span id="nameerror"></span>
      </div>    
      <div class="input-group">

          <button type="submit" class="btn btn-info" name="save">Save</button>&nbsp&nbsp
          <a href="course_table" type="submit" class="btn btn-primary" name="back">Back</a>
          
      </div>
        
    </form>

    </div>
</div>
</div>
</body>