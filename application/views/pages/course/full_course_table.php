<div class="containcer" style="margin-top: 30px">
	<div class="card">
		<span id="message"></span>
		<div class="card-header">
			<div class="row">
				<div class="col-md-2"><h3>Course List </h3></div>
				<div class="col-md-8" align="center">
					<?php   if($this->session->flashdata('save'))
					        { ?>
					        	<div class="col-md-6" >
					          		<span class="alert alert-success message hideit" id="message">
					          			<strong><?php echo $this->session->flashdata('save'); ?></strong>
					          	</div>
					<?php   } ?>
			        <?php   if($this->session->flashdata('update'))
					        { ?>
					        	<div class="col-md-6" >
						          	<span class="alert alert-success message hideit" id="message">
						          		<strong><?php echo $this->session->flashdata('update'); ?></strong>
						          	</span>
						        </div>
					<?php   } ?>
					<?php   if($this->session->flashdata('delete'))
					        { ?>
					        	<div class="col-md-6" >
						          	<span class="alert alert-danger message hideit" id="message">
						          		<strong><?php echo $this->session->flashdata('delete'); ?></strong>
						          	</span>
					          	</div>
					<?php   } ?>
				</div>
				<div class="col-md-2" align="right">	
					<span><input type="submit" name="add" id="add" value="Add" class="btn btn-primary"></span>
				</div>
			</span></div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="course_table">
					<thead>
						<tr>
							<th>SI</th>
							<th>Course</th>
							<?php if($this->session->userdata('user')=='admin') { ?>
								<th>College</th>
							<?php } ?>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>




<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Course Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="save_course" method="POST" id="myform">
      <div class="modal-body">
          <?php if($this->session->userdata('user')=='admin') { ?>
	      <div class="form-group">
	        <label for="college" style="width: 200px">College</label><br>
	        <select name="id" id="id" style="width: 465px" class="form-control">
	          <option value="">Select College</option>
	          <?php foreach($college as $row){ ?>
	          <option value="<?php echo $row->id;?>"><?php echo $row->college_name;?></option>
	        <?php } ?>
	        </select>
	      </div>
	  	<?php } ?>

          <div class="form-group">
            <label>Course Name</label><span class="text-danger">*</span>
            <input type="text" class="form-control" name="coursename" id="coursename" placeholder="Enter Course Name">
            <span id="errorcollege" class="text-danger"></span>
          </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="save" class="btn btn-primary" id="save">Save</button>
      </div>

      </form>
    </div>
  </div>
</div>


<script type="text/javascript">
	$(document).ready(function()
	{
		var dataTable = $('#course_table').DataTable({  
	           "processing":true,  
	           "serverSide":true,  
	           "order":[],  
	           "ajax":{  
	                url:"<?php echo base_url() . 'admin/fetch_course1'; ?>",  
	                type:"POST"
	           },  
	      });



		$('#add').click(function()
			{
				$('#mymodal').modal('show');
			});

		$('.hideit').fadeOut(10000);


		$("#myform").validate(
	    {
	     rules:{
	      id: {
	        required:true
	      },
	      coursename:{
	        required:true
	      }

	     },
	     messages:{
	      id:{
	        required: "Please select College"
	      },
	      coursename:{
	        required: "Please enter Course Name"
	      }
	     }
	    });


	});
</script>