<div class="containcer" style="margin-top: 30px">
	<div class="card">
		<span id="message"></span>
		<div class="card-header">
			<div class="row">
				<div class="col-md-2"><h3>Student List</h3></div>
				<div class="col-md-6" align="center">
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
				<div class="col-md-4" align="right">
					<span><a href="student_registration"><input type="submit" name="add" id="add" value="Add" class="btn btn-primary"></a></span>
				</div>
		</div>
	</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered" id="student_table">
					<thead>
						<tr>
							<th>SI</th>
							<th>Student ID</th>
							<th>Name</th>
							<th>Gender</th>

							<?php if($this->session->userdata('user') == 'admin' || $this->session->userdata('user') == 'coadmin') { ?>
							<th>Course</th>
							<?php } ?>

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


<script type="text/javascript">
	$(document).ready(function()
	{
		var dataTable = $('#student_table').DataTable({  
	           "processing":true,  
	           "serverSide":true,  
	           "order":[],  
	           "ajax":{  
	                url:"<?php echo base_url() . 'admin/fetch_student'; ?>",  
	                type:"POST"  
	           },  
	      });

		$('.hideit').fadeOut(10000);

	});
</script>