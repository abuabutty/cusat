<div class="containcer" style="margin-top: 30px">
	<div class="card">
		<span id="message"></span>
		<div class="card-header">
			<div class="row">
				<div class="col-md-9"><h3>Attendance List</h3></div>
				<div class="col-md-3" align="right">
					<span><input type="submit" name="add" id="add" value="Add" class="btn btn-primary"></span>
					<?php if($action!="false"){?>
						<span><input type="submit" name="edit" id="edit" value="Edit" class="btn btn-info"></span>
						<a href="export_csv?course_id=<?php echo $students[0]->student_course;?>" type="submit" name="csv" id="csv" class="btn btn-success"><i class="fa fa-file"></i> Excel</a>
				<?php }?>
				</div>
			</div>
		</div>
		<div class="row">
				<div class="col-md-12" align="center">
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
		</div>
		<div class="card-body">

					<?php   if($this->session->flashdata('update_attendance'))
					   { ?>
					          <div class="card message">
					          	<span class="alert alert-success message" id="message">
					          		<strong><?php echo $this->session->flashdata('update_attendance'); ?></strong>
					          	</span>
					          </div>
					<?php   } ?>
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="attendance_table">
					<thead>
						<tr>
							<th>SI</th>
							<th>Roll Number</th>
							<th>Name</th>
							<th>Course</th>
							<th>Attendance</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
 						<?php $i=1; foreach($students as $row) { ?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $row->student_id;?></td>
							<td><?php echo $row->student_name;?></td>
							<td><?php echo $row->course_name;?></td>
							<td><?php echo $row->attendance_morning;?></td>
							<td><?php echo $row->date;?></td>
						</tr>
					<?php $i++;} ?>
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
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="save_attendance" method="POST" id="myform">
      <div class="modal-body">
		<div class="card-body">
			<div class="form-group">
				<div class="row">
					<label class="col-md-4 text-right">Attendance Date</label>
					<div class="col-md-8">
						<input type="date" name="date" id="date" class="form-control">
						<span class="text-danger" id="date_error"></span>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="attendance">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Present</th>
							<th>Absent</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($student as $row) { ?>

							<tr>
								<td><?php echo $row->student_id;?></td>
								<td><?php echo $row->student_name;?>
									<input type="hidden" name="student_id[]" value="<?php echo $row->id;?>">
									<input type="hidden" name="student_name[]" value="<?php echo $row->student_name;?>">
								</td>
								<td id="present"><input type="radio" id="attendance<?php echo $row->id;?>" name="attendance<?php echo $row->id;?>" value="Present"></td>
								<td id="absent"><input type="radio" id="attendance<?php echo $row->id;?>" name="attendance<?php echo $row->id;?>" value="Absent" checked></td>
							</tr>

						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="save" class="btn btn-primary" id="save" value="Save">

        <input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id;?>">

      </div>

      </form>
    </div>
  </div>
</div>



<div class="modal fade" id="myeditmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Attendance Form</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="edit_attendance_new" method="POST" id="myform">
      <div class="modal-body">
		<div class="card-body">
			<div class="form-group">
				<div class="row">
					<label class="col-md-4 text-right">Date</label>
					<div class="col-md-8">
						<input type="date" name="edit_date" id="edit_date" class="form-control">
					</div>
				</div>
			</div>
		</div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" name="save" class="btn btn-primary" id="save" value="Get Attendance">

        <input type="hidden" name="course_id" id="course_id" value="<?php echo $course_id;?>">

      </div>

      </form>
    </div>
  </div>
</div>


<script type="text/javascript">
	$(document).ready(function()
	{
		var dataTable = $('#attendance_table').DataTable();

		$('.hideit').fadeOut(10000);

		$('#add').click(function()
		{
			$("#mymodal").modal('show');
			$("#exampleModalLabel").text("Attendance Form");
			$('#date-error').hide();
			clear();

		});

		$('#edit').click(function()
		{
			$("#myeditmodal").modal('show');

			$('#edit_date-error').hide();
			clear();

		});

		$('#date').change(function()
			{
				var date = $('#datee').val();
				
			});


		function clear()
		{
			$('#myform')[0].reset();
		}

		$('#date').focusout(function()
		{
			var date = $('#date').val();

			if(date=='')
			{
				$('#date_error').text("Please fill this field");
			}
			else
			{
				$('#date_error').text("");
			}
		});

		$("#myform").validate(
	    {
	     rules:{
	      date: {
	        required:true
	      }

	     },
	     messages:{
	      date:{
	        required: "Please enter the Date"
	      }
	     }
	    });

	    $('#date').change(function()
	    {
	    	var date = $('#date').val();
	    	var course_id = $('#course_id').val();
	    	
	    	$.ajax({
	    		url: "<?php echo base_url('admin/chechdate');?>",
	    		method: "POST",
	    		data:{date:date,course_id:course_id},
	    		success:function(data)
	    		{
	    			$('#date_error').text(data);
	    		}
	    	 });
	    });


	});
</script>