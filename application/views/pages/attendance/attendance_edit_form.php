<div class="containcer" style="margin-top: 30px">
	<div class="card">
		<span id="message"></span>
		<form name="myform" id="myform" action="edit_attendance">
		<div class="card-header">
			<div class="row">
				<div class="col-md-9"><h3>Course List</h3></div>
				<div class="col-md-9"><h8>Attendance on <?php if(isset($attendance[0]->date)){ echo $attendance[0]->date;}?></h8></div>
				<div class="col-md-9"><h8>Course: <?php if(isset($course[0]->course_name)){ echo $course[0]->course_name;}?></h8></div>
				<div class="col-md-3" align="right">
					<input type="hidden" name="course_id" id="course_id" value="<?php if(isset($course[0]->id)){ echo $course[0]->id; }?>">
					<input type="hidden" name="date" id="date" value="<?php if(isset($attendance[0]->date)){ echo $attendance[0]->date; }?>">
					<span><input type="submit" name="save" id="save" value="Save" class="btn btn-primary"></span>
				</div>
			</div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="course_table">
					<thead>
						<tr>
							<th>SI</th>
							<th>ID</th>
							<th>Student Name</th>
							<th>Present</th>
							<th>Absent</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1;
							foreach($attendance as $row){
							?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $row->student_id;?></td>
								<td><?php echo $row->student_name;?>
									<input type="hidden" name="student_id[]" id="student_id[]" value="<?php echo $row->id;?>">
								</td>
								<td><input type="radio" id="attendance<?php echo $row->id;?>" name="attendance<?php echo $row->id;?>" value="Present" <?php if($row->attendance_morning == "Present"){ echo "checked"; }?>></td>
								<td><input type="radio" id="attendance<?php echo $row->id;?>" name="attendance<?php echo $row->id;?>" value="Absent" <?php if($row->attendance_morning == "Absent"){ echo "checked"; }?>></td>
							</tr>
						<?php $i++; }?>
					</tbody>
				</table>
			</div>
		</div>
		</form>
	</div>
</div>



<script type="text/javascript">
	$(document).ready(function()
	{


		$('#add').click(function()
			{
				$('#mymodal').modal('show');
			});




	});
</script>