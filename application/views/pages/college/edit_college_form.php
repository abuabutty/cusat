<div class="container" style="padding: 10px">
  
  <div class="card" style="padding: 9px">
    
    <h3>College Edit</h3>

  </div>
  <div style="padding: 9px"></div>



<body>

<div class="card">
<div class="container" style="padding: 20px">
    <form name="form" method="post" class="container" action="<?php echo base_url('admin/update_college'); ?>" >

      <input type="hidden" name="id" value="">

      <div class="form-group">
        <label for="name">Code</label>
        <input type="text" name="collegecode" value="<?php echo $college[0]->college_code;?>" id="collegecode" class="form-control required" placeholder="Enter Student ID" >
        <input type="hidden" name="college_id" id="college_id" value="<?php if(isset($college[0]->id)){ echo $college[0]->id; }?>">
        <span id="iderror" class="text-danger"></span>
      </div>
      <div class="form-group">
        <label for="name">College Name</label>
        <input type="text" name="collegename" value="<?php echo $college[0]->college_name;?>" id="collegename" class="form-control required" placeholder="Enter Student Name" >
        <span id="nameerror"></span>
      </div>    
      <div class="input-group">

          <button type="submit" class="btn btn-info" name="save">Save</button>&nbsp&nbsp
          <a href="college_table" type="submit" class="btn btn-primary" name="back">Back</a>
          
      </div>
        
    </form>

    </div>
</div>
</div>
</body>