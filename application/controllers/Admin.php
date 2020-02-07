<?php
class Admin extends CI_Controller 
{
	public function __construct()
	{
	
		parent::__construct();

		$this->load->database();

		$this->load->helper(array('form', 'url','html'));

		$this->load->model('Admin_Model');

		$this->load->library('session');

		$this->load->library('form_validation');

		$this->load->library(array('encryption','Layouts'));

		$this->load->library('pagination');

		if($this->session->userdata('loggedin') != TRUE)
		{
			redirect('login');
		}
	
	}

//******************************************************** REGISTER ****************************************************************


	// public function register()
	// {
	// 	$this->load->view('pages/register');

	// }

	// public function register_validation()
	// {
	// 	$this->form_validation->set_rules('inputName','Name','required');
	// 	$this->form_validation->set_rules('inputPassword','Password','required');
	// 	$this->form_validation->set_rules('confirmPassword','Password','required');

	// 	if($this->form_validation->run())
	// 	{
	// 		if($this->input->post('register'))
	// 		{
	// 			$name=$this->input->post('inputName');
	// 			$password=$this->input->post('inputPassword');
	// 			$cpassword=$this->input->post('confirmPassword');

	// 			if($password==$cpassword)
	// 			{
	// 				$epassword=$this->encryption->encrypt($password);
	// 				$data=array('name'=>$name,'password'=>$epassword);
	// 				$this->Admin_Model->savedata($data);
	// 				redirect('admin/login');
	// 			}
	// 			else
	// 			{
	// 				$this->session->set_flashdata('password','Password should be same');
	// 				redirect('admin/register');
	// 			}			

	// 		}
	// 	}
	// 	else
	// 	{
	// 		$this->register();
	// 	}
	// }



//******************************************************** FRONT PAGE ****************************************************************
	public function dashboard()
	{
		if($this->session->userdata('user')=='admin')
		{
			$college = $this->Admin_Model->get_college(NULL,NULL);
			$college_count = count($college);

			$course = $this->Admin_Model->get_course(NULL,NULL);
			$students = $this->Admin_Model->get_students(NULL,NULL);
			$coadmin = $this->Admin_Model->get_coadmin();
			$coadmin_count = count($coadmin);
			$teacher = $this->Admin_Model->get_teacher(NULL,NULL);
		}

		if($this->session->userdata('user')=='coadmin')
		{
			$course = $this->Admin_Model->get_course($this->session->userdata('college_id'),"college");
			$students = $this->Admin_Model->get_students($this->session->userdata('college_id'),"college");
			$teacher = $this->Admin_Model->get_teacher($this->session->userdata('college_id'),"college");

			$c = $this->Admin_Model->get_college($this->session->userdata('college_id'),"college");
			$d = array('college_name' => $c[0]->college_name);
			$this->session->set_userdata($d);

		}

		if($this->session->userdata('user') == 'teacher')
		{
			$students = $this->Admin_Model->get_students($this->session->userdata('course_id'),"course");
		}
		else
		{
			$course_count = count($course);	
			$teacher_count = count($teacher);
		}

		$student_count = count($students);
			
		
		if($this->session->userdata('user')=='admin')
		{
			$count = array('college_count'=>$college_count,'course_count'=>$course_count,'student_count'=>$student_count,'coadmin_count' => $coadmin_count,'teacher_count' =>$teacher_count);
		}

		if($this->session->userdata('user')=='coadmin')
		{
			$count = array('course_count'=>$course_count,'student_count'=>$student_count,'teacher_count' =>$teacher_count);
		}

		if($this->session->userdata('user')=='teacher')
		{
			$count = array('student_count'=>$student_count);
		}

		$this->layouts->set_title("Dashboard");
		$this->layouts->view('pages/dashborad',$count);
		
	}
//************************************************ COLLEGE START *******************************************************

	public function college_table()
	{

		$this->layouts->set_title("College Table");
		$this->layouts->view('pages/college/full_college_table');

	}

//************************************************ DATA TABLE COLLEGE *******************************************************


      function fetch_college(){    
           $fetch_data = $this->Admin_Model->make_datatables_college();  
           $data = array();  
           $i=1;
           foreach($fetch_data as $row)  
           {  
                $sub_array = array(); 
                $sub_array[] = $i;   
                $sub_array[] = $row->college_code;  
                $sub_array[] = $row->college_name;  
                $sub_array[] = '<div align="center"><a href ="edit_college_form?college_id='.$row->id.'" type="submit" name="update" id="'.$row->id.'" class="update" value=""><i class="fas fa-edit"></i></a>&nbsp&nbsp
                				<a href ="delete_college?id='.$row->id.'" type="submit" name="delete" id="'.$row->id.'" class="update" ><i class="fa fa-trash"></a></div>';   
                $data[] = $sub_array;  
                $i++;
           }  
           $output = array(  
                "draw"                  =>     intval($_POST["draw"]),  
                "recordsTotal"          =>     $this->Admin_Model->get_all_data_college(),  
                "recordsFiltered"     	=>     $this->Admin_Model->get_filtered_data_college(),  
                "data"                  =>     $data  
           );  
           echo json_encode($output);  
      }



//************************************************ SAVE COLLEGE *******************************************************

	public function save_college()
	{

		$college['college_code'] = $this->input->post('collegecode');
		$college['college_name'] = $this->input->post('collegename');

		if($college != "")
		{
			$this->Admin_Model->add_college($college);
			$this->session->set_flashdata('save','College Added Successfully');

			redirect('admin/college_table');
		}
		else
		{
			redirect('admin/college_table');
		}


	}
	//ok

//************************************************ EDIT COLLEGE FORM *******************************************************

      public function edit_college_form()
      {
      	$college_id = $this->input->get('college_id');
      	
      	$college['college'] = $this->Admin_Model->get_college($college_id,"college");
      	$this->layouts->set_title("College Edit");
      	$this->layouts->view('pages/college/edit_college_form',$college);
      }


//************************************************ UPDATE COLLEGE *******************************************************


	public function update_college()
	{

		$college['id'] = $this->input->post('college_id');
		$college['college_code'] = $this->input->post('collegecode');
		$college['college_name'] = $this->input->post('collegename');

		$this->Admin_Model->update_college($college);

		$this->session->set_flashdata('update','College Updated Successfully');
		redirect('admin/college_table');
	}


//************************************************ DELETE COLLEGE *******************************************************


	public function delete_college()
	{

		$id = $this->input->get('id');
		$this->Admin_Model->delete_by_college($id);

		$this->session->set_flashdata('delete','College Deleted Successfully');
		redirect('admin/college_table');

	}
//************************************************ END COLLEGE *******************************************************

//************************************************ COURSE START *******************************************************

	public function course_table()
	{
		$college = $this->Admin_Model->get_college(NULL,NULL);

		$course['college'] = $college;
		$this->layouts->set_title("Course Table");
		$this->layouts->view('pages/course/full_course_table',$course);

	}

//************************************************ DATA TABLE COURSE *******************************************************

      function fetch_course1(){

      	if($this->session->userdata('user')=='admin')
      	{
      		$fetch_data = $this->Admin_Model->make_datatables_course(NULL,NULL);
      	}

      	if($this->session->userdata('user')=='coadmin')
      	{
      		$fetch_data = $this->Admin_Model->make_datatables_course($this->session->userdata('college_id'),"college");
      	}
             
           $data = array();  
           $i=1;
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();    
                $sub_array[] = $i;  
                $sub_array[] = $row->course_name;
                if($this->session->userdata('user')=='admin')
                {
                	$sub_array[] = $row->college_name;
                }
                  
                $sub_array[] = '<div align="middle">
                				<a href="get_attendance/'.$row->id.'" type="submit" name="attendance" id="attendance"><i class="fa fa-address-card" aria-hidden="true"></i>
</a>&nbsp&nbsp
								<a href ="edit_course_form?course_id='.$row->id.'&college_id='.$row->college_id.'" type="submit" name="update" id="'.$row->id.'" class="fas fa-edit"></a>&nbsp&nbsp
                				<a href ="delete_course?id='.$row->id.'" type="submit" name="delete" id="'.$row->id.'" class="fa fa-trash"></a></div>';  
                $data[] = $sub_array;  
                $i++;
           }

           if($this->session->userdata('user')=='admin')
	      	{
	      		$output = array(  
                "draw"                  =>     intval($_POST["draw"]),  
                "recordsTotal"          =>      $this->Admin_Model->get_all_data_course(NULL,NULL),  
                "recordsFiltered"     	=>     $this->Admin_Model->get_filtered_data_course(NULL,NULL),  
                "data"                  =>     $data  
           		);
	      	}

	      	if($this->session->userdata('user')=='coadmin')
	      	{
	      		$output = array(  
                "draw"                  =>     intval($_POST["draw"]),  
                "recordsTotal"          =>      $this->Admin_Model->get_all_data_course($this->session->userdata('college_id'),"college"),  
                "recordsFiltered"     	=>     $this->Admin_Model->get_filtered_data_course($this->session->userdata('college_id'),"college"),  
                "data"                  =>     $data  
           		);
	      	}
  
           echo json_encode($output);  
      }


//************************************************ SAVE COURSE *******************************************************

	public function save_course()
	{
		if($this->session->userdata('user')=='admin')
		{
			$id = $this->input->post('id');
		}

		if($this->session->userdata('user')=='coadmin')
		{
			$id = $this->session->userdata('college_id');
		}
		
		$course = $this->input->post('coursename');

		if($course !="")
		{
			$data = array('course_name'=>$course,'college_id'=>$id);
			$this->Admin_Model->save_course($data);
			
			$this->session->set_flashdata('save', 'Saved Successfully');
			redirect('admin/course_table');
		}

	}

//*******************************************************************************************************

	public function fetch_course()
	{
		$college_id = $this->input->post('college_id');
		$course = $this->Admin_Model->get_course($college_id,"college");

		if($course)
		{
			echo '<option value="">Select Course</option>';
			foreach($course as $row)
			{
				echo '<option value="'.$row->id.'">'.$row->course_name.'</option>';
			}
		}
	}

//************************************************ EDIT COURSE *******************************************************

      public function edit_course_form()
      {
      	$course_id = $this->input->get('course_id');
      	$college_id = $this->input->get('college_id');
      	
      	$course['course'] = $this->Admin_Model->search_course($course_id);
      	$course['college_id'] = $college_id;
      	$course['college'] = $this->Admin_Model->get_college(NULL,NULL);

      	$this->layouts->set_title("Course Edit");
      	$this->layouts->view('pages/course/edit_course_form',$course);
      }


//************************************************ UPDATE COURSE *******************************************************

	public function update_course()
	{
		if($this->session->userdata('user')=='admin')
		{
			$college_id = $this->input->post('college');
		}

		if($this->session->userdata('user')=='coadmin')
		{
			$college_id = $this->session->userdata('college_id');
		}

		
		$course_name = $this->input->post('course_name');
		$course_id = $this->input->post('course_id');

		$this->Admin_Model->update_course($college_id,$course_name,$course_id);

		$this->session->set_flashdata('update','Updated Successfully');
		redirect('admin/course_table');
		
	}

//************************************************ DELETE COURSE *******************************************************

	public function delete_course()
	{
		$id = $this->input->get('id');
		$cid = $this->input->get('cid');
		$this->Admin_Model->delete_course($id);
		$this->session->set_flashdata('delete','Course Deleted Successfully');
		redirect('admin/course_table');
	}

//************************************************ COURSE ENDS *******************************************************

//************************************************ STUDENT STARTS *******************************************************


	public function student_table()
	{
		$student['student'] = $this->Admin_Model->get_students(NULL,NULL);

		$this->layouts->set_title("Students");
		$this->layouts->view('pages/student/full_student_table',$student);
	}

//************************************************ DATA TABLE STUDENT *******************************************************


	function fetch_student()
	{    
		if($this->session->userdata('user')=='admin')
		{
			$fetch_data = $this->Admin_Model->make_datatables_student(NULL,NULL);
		}

		if($this->session->userdata('user')=='coadmin')
		{
			$fetch_data = $this->Admin_Model->make_datatables_student($this->session->userdata('college_id'),"college");
		}

		if($this->session->userdata('user')=='teacher')
		{
			$fetch_data = $this->Admin_Model->make_datatables_student($this->session->userdata('course_id'),"course");
		}

             
           $data = array();  
           $i=1;
           foreach($fetch_data as $row)  
           {  
                $sub_array = array();    
                $sub_array[] = $i;  
                $sub_array[] = $row->student_id;
                $sub_array[] = $row->student_name;
                $sub_array[] = $row->student_gender;

                if($this->session->userdata('user')=='admin' || $this->session->userdata('user') == 'coadmin')
                {
                	$sub_array[] = $row->course_name;
                }

                if($this->session->userdata('user')=='admin')
                {
                	$sub_array[] = $row->college_name;
                }
                
                $sub_array[] = '<div align="center"><a href ="edit_student_form?course_id='.$row->student_course.'&college_id='.$row->college_id.'&student_id='.$row->id.'" type="submit" name="update" id="'.$row->id.'" class="fas fa-edit"></a>&nbsp&nbsp
                				<a href ="delete_student_list?id='.$row->id.'" type="submit" name="delete" id="'.$row->id.'" class="fa fa-trash"></a></div>';  
                $data[] = $sub_array;  
                $i++;
           } 

           if($this->session->userdata('user')=='admin')
			{
				$output = array(  
                "draw"                  =>     intval($_POST["draw"]),  
                "recordsTotal"          =>      $this->Admin_Model->get_all_data_student(NULL,NULL),  
                "recordsFiltered"     	=>     $this->Admin_Model->get_filtered_data_student(NULL,NULL),  
                "data"                  =>     $data  
           		);
			}

			if($this->session->userdata('user')=='coadmin')
			{
				$output = array(  
                "draw"                  =>     intval($_POST["draw"]),  
                "recordsTotal"          =>      $this->Admin_Model->get_all_data_student($this->session->userdata('college_id'),"college"),  
                "recordsFiltered"     	=>     $this->Admin_Model->get_filtered_data_student($this->session->userdata('college_id'),"college"),  
                "data"                  =>     $data  
           		);
			}

			if($this->session->userdata('user')=='teacher')
			{
				$output = array(  
                "draw"                  =>     intval($_POST["draw"]),  
                "recordsTotal"          =>      $this->Admin_Model->get_all_data_student($this->session->userdata('course_id'),"course"),  
                "recordsFiltered"     	=>     $this->Admin_Model->get_filtered_data_student($this->session->userdata('course_id'),"course"),  
                "data"                  =>     $data  
           		);
			}
 
           echo json_encode($output);  
      }


//************************************************ STUDENT REGISTRETION FORM *******************************************************

	public function student_registration()
	{
		$data['college'] = $this->Admin_Model->get_college(NULL,NULL);

		if($this->session->userdata('user') == 'coadmin')
		{
			$data['course'] = $this->Admin_Model->get_course($this->session->userdata('college_id'),"college");
		}
		
		$data['academic'] = $this->Admin_Model->get_academic();
		$this->layouts->set_title("Student Registration");
		$this->layouts->view('pages/student/student_register_form',$data);
	}

//************************************************ SAVE STUDENT *******************************************************


	public function save_student()
	{
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$gender = $this->input->post('gender');
		$academic = $this->input->post('academic');

		if($this->session->userdata('user') == 'admin')
		{
			$college = $this->input->post('college');
		}

		if($this->session->userdata('user') == 'coadmin')
		{
			$college = $this->session->userdata('college_id');
		}
		
		if($this->session->userdata('user') == 'teacher')
		{
			$college = $this->session->userdata('college_id');
			$course = $this->session->userdata('course_id');
		}
		else
		{
			$course = $this->input->post('course');
		}
		

		if($this->Admin_Model->check_id($id,"student"))
		{
			$data = array('student_id'=>$id,'student_name'=>$name,'student_gender'=>$gender,'student_year'=>$academic,'student_course'=>$course,'student_college'=>$college);
			$this->Admin_Model->save_student($data);
			$this->session->set_flashdata('save','Saved Successfully');
		}
		
		redirect('admin/student_table');
	}

//*******************************************************************************************************

	public function check_id()
	{
		$id = $this->input->post('id');
		$action = $this->input->post('action');
		if($this->Admin_Model->check_id($id,$action))
		{
			echo "";
		}
		else
		{
			echo "Alerady taken";
		}

	}


//************************************************ EDIT STUDENT *******************************************************

     public function edit_student_form()
     {
      	$course_id = $this->input->get('course_id');
      	$college_id = $this->input->get('college_id');
	    $student_id = $this->input->get('student_id');
	      	
	    $course['student'] = $this->Admin_Model->get_students($student_id,"student");
	    $course['college_id'] = $college_id;
	    $course['student_id'] = $student_id;
	    $course['course_id'] = $course_id;
	    $course['academic'] = $this->Admin_Model->get_academic();
	    $course['college'] = $this->Admin_Model->get_college(NULL,NULL);
	    $course['course'] = $this->Admin_Model->get_course($college_id,"college");

	    $this->layouts->set_title("Student Edits");
	    $this->layouts->view('pages/student/edit_student_form',$course);
      }


//************************************************ UPDATE STUDENT *******************************************************


	public function update_student()
	{
		$data['student_id'] = $this->input->post('id');
		$data['student_name'] = $this->input->post('name');
		$data['student_gender'] = $this->input->post('gender');
		$data['student_year'] = $this->input->post('academic');

		if($this->session->userdata('user') == 'admin')
		{
			$data['student_course'] = $this->input->post('course');
			$data['student_college'] = $this->input->post('college');
		}
		elseif($this->session->userdata('user') == 'coadmin')
		{
			$data['student_college'] = $this->session->userdata('college_id');
			$data['student_course'] = $this->input->post('course');
		}
		else
		{
			$data['student_college'] = $this->session->userdata('college_id');
			$data['student_course'] = $this->session->userdata('course_id');
		}
		
		
		$data['id'] = $this->input->post('student_id');

		$this->Admin_Model->update_student($data);
		$this->session->set_flashdata('update','Updated Successfully');
		redirect('admin/student_table');
	}


//************************************************ DELETE STUDENT *******************************************************

    public function delete_student_list()
	{
		$student_id = $this->input->get('id');
		$course_id = $this->input->get('course');
		$college_id = $this->input->get('college');
		$this->Admin_Model->delete_student($student_id);

		$this->session->set_flashdata('delete','Deleted Successfully');
		redirect('admin/student_table');

	}

//************************************************ STUDENT ENDS *******************************************************

//************************************************ ATTENDANCE START *******************************************************


	public function get_attendance($course)
	{
		$course_id = $this->uri->segment(3);
		$students['students'] = $this->Admin_Model->get_attendance("full",$course_id);
		$students['student'] = $this->Admin_Model->get_students($course_id,"course");
		$students['course_id'] = $course_id;

		
		if($students['students']==true)
		{
			$students['action']="true";
		}
		else
		{
			$students['action']="false";
		}
		
		$this->layouts->set_title("Attendance");
		$this->layouts->view('pages/attendance/attendance_table',$students);


		
	}


//************************************************ SAVE ATTENDANCE *******************************************************

	function save_attendance()
		{
			$course_id = $this->input->post('course_id');

			$students = $this->input->post('student_id');
			$student_name = $this->input->post('student_name');

			$date = $this->input->post('date');

			$check = $this->Admin_Model->check_attendance($date,$course_id);

		if($check ==true)
		{
			for($i=0;$i<count($students);$i++)
			{
				$atten = $this->input->post('attendance'.$students[$i]);
				$data = array('student_id'=>$students[$i],'student_name'=>$student_name[$i],'student_course'=>$course_id,'date'=>$date,'attendance_morning'=>$atten);
				
				$this->Admin_Model->save_attendance($data);
			}

			//$this->session->flashdata('course_id');
			$this->session->set_flashdata('save','Saved Successfully');
			redirect('admin/get_attendance/'.$course_id);
			
		}
		else
		{

			redirect('admin/get_attendance/'.$course_id);
		}
		
	}

//************************************************ EDIT ATTENDANCE *******************************************************


	public function edit_attendance_new()
	{
		$course_id = $this->input->post('course_id');
		$date = $this->input->post('edit_date');

		$attendance['attendance'] = $this->Admin_Model->get_attendance_new($course_id,$date);
		$attendance['course'] = $this->Admin_Model->search_course($course_id);

		$this->layouts->set_title("Attendance Edit Form");
		$this->layouts->view('pages/attendance/attendance_edit_form',$attendance);

	}

//*******************************************************************************************************

	public function edit_attendance()
	{
		$course_id = $this->input->get('course_id');

		$students = $this->input->get('student_id');

		$date = $this->input->get('date');

		for($i=0;$i<count($students);$i++)
		{
			$atten = $this->input->get('attendance'.$students[$i]);
			$data['student_id'] = $students[$i];
			$data['attendance_morning'] = $atten;
			$data['date'] = $date;
			
			$this->Admin_Model->edit_attendance($data);
		}
		//$this->session->set_flashdata('course',$course_id);
		$this->session->set_flashdata('update','Update Attendance Successfully');

		redirect('admin/get_attendance/'.$course_id);

	}

//*******************************************************************************************************

	public function chechdate()
	{
		$date = $this->input->post('date');
		$course_id = $this->input->post('course_id');
		$check = $this->Admin_Model->check_attendance($date,$course_id);

		if($check == false)
		{
			echo "Attendance Already Taken";
		}
		else
		{
			echo "";
		}
	}


	public function edit_chechdate()
	{
		$date = $this->input->post('date');
		$course_id = $this->input->post('course_id');
		$check = $this->Admin_Model->check_attendance($date,$course_id);

		if($check == false)
		{
			echo "";
		}
		else
		{
			echo "Attendance Not Taken on this date";
		}
	}


//************************************************ COLLEGE ADMIN STARTS *******************************************************

	public function coadmin_table()
	{
		$this->layouts->set_title("College Admin Table");
		$this->layouts->view('pages/coadmin/full_coadmin_table');
	}

//************************************************ DATATABLE COLLEGE ADMIN *******************************************************

	public function fetch_coadmin()
	{

		$fetch_data = $this->Admin_Model->make_datatables_coadmin();  
		$data = array();  
		$i=1;
		foreach($fetch_data as $row)  
		{  
		    $sub_array = array(); 
		    $sub_array[] = $i;   
		    $sub_array[] = $row->coadmin_username;  
		    $sub_array[] = $row->college_code;
		    $sub_array[] = $row->college_name;
		    $sub_array[] = '<div align="center"><a href ="edit_coadmin_form?coadmin_id='.$row->coadmin_id.'" type="submit" name="update" id="'.$row->coadmin_id.'" class="update" value=""><i class="fas fa-edit"></i></a>&nbsp&nbsp
		    				<a href ="delete_coadmin?coadmin_id='.$row->coadmin_id.'" type="submit" name="delete" id="'.$row->coadmin_id.'" class="update" ><i class="fa fa-trash"></a></div>';   
		    $data[] = $sub_array;  
		    $i++;
		}  
		$output = array(  
		    "draw"                  =>     intval($_POST["draw"]),  
		    "recordsTotal"          =>      $this->Admin_Model->get_all_data_coadmin(),  
		    "recordsFiltered"     	=>     $this->Admin_Model->get_filtered_data_coadmin(),  
		    "data"                  =>     $data  
		);  
		echo json_encode($output);
           
	}


//************************************************ REGISTER COLLEGE ADMIN FORM *******************************************************


	public function coadmin_register_form()
	{

		$data['college'] = $this->Admin_Model->get_college(NULL,NULL);

		$this->layouts->set_title("College Admin Registration From");
		$this->layouts->view('pages/coadmin/coadmin_register_form',$data);

	}

//************************************************ SAVE COLLEGE ADMIN *******************************************************
	public function save_coadmin()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$cpassword = $this->input->post('cpassword');
		$college_id = $this->input->post('college_id');

		if($username != "" && $password !="" && $cpassword != "" && $college_id != "")
		{
			if($password == $cpassword)
			{
				$epassword = $this->encryption->encrypt($password);
				$data = array('coadmin_username' => $username, 'coadmin_college_id' => $college_id, 'coadmin_password' => $epassword);
				
				$this->Admin_Model->save_coadmin($data);
				redirect('admin/coadmin_table');
			}
			else
			{
				$this->session->set_flashdata('password','Password Missmatch');
				redirect('admin/coadmin_register_form');
			}
		}
		else
		{
			$this->session->set_flashdata('formnull','Please Enter the details');
			redirect('admin/coadmin_register_form');
		}

	}


//************************************************ EDIT COLLEGE ADMIN *******************************************************


	public function edit_coadmin_form()
	{
		$coadmin_id = $this->input->get('coadmin_id');
		$coadmin['coadmin_id'] = $coadmin_id;
		$this->session->set_userdata('coadmin_id',$coadmin);


		$data['coadmin'] = $this->Admin_Model->search_coadmin($coadmin_id);

		$epassword = $data['coadmin'][0]->coadmin_password;

		$data['college'] = $this->Admin_Model->get_college(NULL,NULL);
		
		$data['password'] = $this->encryption->decrypt($epassword);

		$this->layouts->set_title("Edit Coadmin Form");
		$this->layouts->view('pages/coadmin/edit_coadmin_form',$data);
	}


//************************************************ UPDATE COLLEGE ADMIN *******************************************************

	public function update_coadmin()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$cpassword = $this->input->post('cpassword');
		$college_id = $this->input->post('college_id');
		$coadmin_id = $this->input->post('coadmin_id');

		if($username != "" && $password !="" && $cpassword != "" && $college_id != "")
		{
			if($password == $cpassword)
			{
				$epassword = $this->encryption->encrypt($password);
				$data = array('coadmin_username' => $username, 'coadmin_college_id' => $college_id, 'coadmin_password' => $epassword);
				$data['coadmin_id'] = $coadmin_id;

				$this->session->unset_userdata('coadmin_id');
				
				$this->Admin_Model->update_coadmin($data);
				redirect('admin/coadmin_table');
			}
			else
			{
				$this->session->set_flashdata('password','Password Missmatch');
				redirect('admin/edit_coadmin_form');
			}
		}
		else
		{
			$this->session->set_flashdata('formnull','Please Enter the details');
			redirect('admin/edit_coadmin_form');
		}


	}

//************************************************ DELETE COLLEGE ADMIN *******************************************************

	public function delete_coadmin()
	{
		$coadmin_id = $this->input->get('coadmin_id');

		$this->Admin_Model->delete_coadmin($coadmin_id);
		$this->session->set_flashdata('delete_coadmin','Delete Successfully');
		redirect('admin/coadmin_table');
	}


//************************************************ TEACHER STARTS *******************************************************

	public function teacher_table()
	{
		$this->layouts->set_title("Teacher Table");
		$this->layouts->view('pages/teacher/teacher_table');
	}

	public function fetch_teacher()
	{
		if($this->session->userdata('user') == 'admin')
		{
			$fetch_data = $this->Admin_Model->make_datatables_teacher(NULL,NULL);
		}

		if($this->session->userdata('user') == 'coadmin')
		{
			$fetch_data = $this->Admin_Model->make_datatables_teacher($this->session->userdata('college_id'),"college");
		}
			  
	       $data = array();  
	       $i=1;
	       foreach($fetch_data as $row)  
	       {  
	            $sub_array = array();    
	            $sub_array[] = $i;  
	            $sub_array[] = $row->teacher_id;
	            $sub_array[] = $row->teacher_name;
	            $sub_array[] = $row->teacher_username;
	            $sub_array[] = $row->course_name;

	            if($this->session->userdata('user') == 'admin')
	            {
	            	$sub_array[] = $row->college_name;
	            }
	            
	            $sub_array[] = '<div align="center"><a href ="edit_teacher_form?teacher_id='.$row->id.'&college_id='.$row->teacher_college.'" type="submit" name="update" id="'.$row->id.'" class="fas fa-edit"></a>&nbsp&nbsp
	            				<a href ="delete_teacher?id='.$row->id.'" type="submit" name="delete" id="'.$row->id.'" class="fa fa-trash"></a></div>';  
	            $data[] = $sub_array;  
	            $i++;
	       }

	       if($this->session->userdata('user') == 'admin')
	       {
	       		$output = array(  
	            "draw"                  =>     intval($_POST["draw"]),  
	            "recordsTotal"          =>     $this->Admin_Model->get_all_data_teacher(NULL,NULL),  
	            "recordsFiltered"     	=>     $this->Admin_Model->get_filtered_data_teacher(NULL,NULL),  
	            "data"                  =>     $data  
	       		); 
	       }
	       
	       if($this->session->userdata('user') == 'coadmin')
	       {
	       		$output = array(  
	            "draw"                  =>     intval($_POST["draw"]),  
	            "recordsTotal"          =>     $this->Admin_Model->get_all_data_teacher($this->session->userdata('college_id'),"college"),  
	            "recordsFiltered"     	=>     $this->Admin_Model->get_filtered_data_teacher($this->session->userdata('college_id'),"college"),  
	            "data"                  =>     $data  
	       		); 
	       } 
	       echo json_encode($output);
	}

//**********************************************************************************************************************


	public function teacher_register_form()
	{
		if($this->session->userdata('user') == 'admin')
		{
			$data['college'] = $this->Admin_Model->get_college(NULL,NULL);
		}

		if($this->session->userdata('user') == 'coadmin')
		{
			$data['course'] = $this->Admin_Model->get_course($this->session->userdata('college_id'),"college");
		}

		$data['academic'] = $this->Admin_Model->get_academic();
		

		$this->layouts->set_title("Teacher Register");
		$this->layouts->view('pages/teacher/teacher_register_form',$data);
	}


//**********************************************************************************************************************


	public function save_teacher()
	{
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$gender = $this->input->post('gender');
		$academic = $this->input->post('academic');

		if($this->session->userdata('user') == 'admin')
		{
			$college = $this->input->post('college');
		}

		if($this->session->userdata('user') == 'coadmin')
		{
			$college = $this->session->userdata('college_id');
		}
		
		$course = $this->input->post('course');

		if($this->Admin_Model->check_id($id,"teacher"))
		{
			$epassword = $this->encryption->encrypt($password);

			$data = array('teacher_id'=>$id,'teacher_name'=>$name,'teacher_gender'=>$gender,'teacher_academic'=>$academic,'teacher_college'=>$college,'teacher_course'=>$course, 'teacher_username'=>$username ,'teacher_password'=>$epassword);
			$this->Admin_Model->save_teacher($data);
			$this->session->set_flashdata('save','Saved Successfully');
		}
		
		redirect('admin/teacher_table');
	}


//**********************************************************************************************************************


	public function edit_teacher_form()
	{
		if($this->session->userdata('user') == 'admin')
		{
			$data['college'] = $this->Admin_Model->get_college(NULL,NULL);
			$data['course'] = $this->Admin_Model->get_course($this->input->get('college_id'),"college");
		}

		if($this->session->userdata('user') == 'coadmin')
		{
			$data['course'] = $this->Admin_Model->get_course($this->session->userdata('college_id'),"college");
		}

		$data['academic'] = $this->Admin_Model->get_academic();

		$id = $this->input->get('teacher_id');

		$data['teacher'] = $this->Admin_Model->get_teacher($id,"id");
		$epassword = $data['teacher'][0]->teacher_password;

		$data['password'] = $this->encryption->decrypt($epassword);

		$this->layouts->set_title("Edit Teacher");
		$this->layouts->view('pages/teacher/edit_teacher_form',$data);
	}

//**********************************************************************************************************************



	public function update_teacher()
	{
		$teacher_id = $this->input->post('teacher_id');
		$id = $this->input->post('id');
		$name = $this->input->post('name');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$gender = $this->input->post('gender');
		$academic = $this->input->post('academic');

		if($this->session->userdata('user') == 'admin')
		{
			$college = $this->input->post('college');
		}

		if($this->session->userdata('user') == 'coadmin')
		{
			$college = $this->session->userdata('college_id');
		}
		
		$course = $this->input->post('course');

		if($id !="" && $name !="" && $username !="" && $password !="" && $gender !="" && $academic !="")
		{
			$epassword = $this->encryption->encrypt($password);

			$data = array('teacher_id'=>$id,'teacher_name'=>$name,'teacher_gender'=>$gender,'teacher_academic'=>$academic,'teacher_college'=>$college,'teacher_course'=>$course, 'teacher_username'=>$username ,'teacher_password'=>$epassword);

			$this->Admin_Model->update_teacher($data,$teacher_id);
			$this->session->set_flashdata('update','Updated Successfully');

			redirect('admin/teacher_table');
		}
	}



	public function delete_teacher()
	{
		$id = $this->input->get('id');

		$this->Admin_Model->delete_teacher($id);

		$this->session->set_flashdata('delete', 'Deleted Successfully');
		redirect('admin/teacher_table');
	}


//************************************************ EXCEL EXPORT *******************************************************


	public function export_csvaa($course)
	{
		$course_id= $this->uri->segment(3);

		$from = $this->input->post('from');
		$to = $this->input->post('to');

		$date = array('from' => $from , 'to' => $to);
		print_r($date);

		$students['attendance'] = $this->Admin_Model->get_excel($course_id,$from,$to,"name");
		$students['date'] = $this->Admin_Model->get_excel($course_id,$from,$to,"date");

		echo '<pre>'; print_r($students['date']); echo '</pre>';

		// $students['dateorder'] = $this->Admin_Model->get_attendance("date",$course_id);
		// $students['nameorder'] = $this->Admin_Model->get_attendance("name",$course_id);

		//$students['students'] = $this->Admin_Model->get_excel($course_id,"name");

		//echo '<pre>'; print_r($students['students']); echo '</pre>';

		// require(APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php');
		// require(APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
		// require(APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel/Style/Alignment.php');

		// $alpha = array('C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');

		// $objPHPExcel = new PHPExcel();

		// $objPHPExcel->getProperties()->setCreated("");
		// $objPHPExcel->getProperties()->setLastModifiedBy("");
		// $objPHPExcel->getProperties()->setTitle("");
		// $objPHPExcel->getProperties()->setSubject("");
		// $objPHPExcel->getProperties()->setDescription("");

		// $objPHPExcel->setActiveSheetIndex(0);

		// $objPHPExcel->getActiveSheet()->SetCellValue('A1','ID');
		// $objPHPExcel->getActiveSheet()->SetCellValue('B1','Name');

		// $j=2;
		// $counting = 0;
		// foreach($students['students'] as $value)
		// {
		// 	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$j,$value->);
		// 	$j++;

		// }

		// $a=2;
		// foreach($students['nameorder'] as $value)
		// {
		// 	$objPHPExcel->getActiveSheet()->SetCellValue('A'.$a,$value->student_id);
		// 	$objPHPExcel->getActiveSheet()->SetCellValue('B'.$a,$value->student_name);
		// 	$objPHPExcel->getActiveSheet()->SetCellValue('C'.$a,$value->course_name);
			

		// 	$students['getname'] = $this->Admin_Model->get_attendance_excel($value->student_id);

		// 	$k=0;
		// 	foreach($students['getname'] as $value)
		// 	{
		// 		$date = $objPHPExcel->getActiveSheet()->getCell($alpha[$k].'1')->getValue();
		// 		$date_table = $value->date;
		// 		if($date == $date_table)
		// 		{
		// 			$objPHPExcel->getActiveSheet()->SetCellValue($alpha[$k].$a,$value->attendance_morning);

		// 		}
		// 		else
		// 		{
		// 			$objPHPExcel->getActiveSheet()->SetCellValue($alpha[$k].$a,$value->attendance_morning);

		// 		}
		// 		$k++;

		// 	}

		// 	$a++;
		// }


		// $filename="Attendance Sheet - ".$course_name.'.xlsx';
		// $objPHPExcel->getActiveSheet()->setTitle("Attendance");

		// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		// header('Content-Disposition: attachment;filename="'.$filename.'"');
		// header('Cache-Control: max-age=0');

		// $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		// $objWriter ->save('php://output');
		// exit;

	}


//************************************************ END *******************************************************


	public function export_csv($course)
	{
		$course_id= $this->uri->segment(3);

		$from = $this->input->post('from');
		$to = $this->input->post('to');

		$data['name'] = $this->Admin_Model->get_excel($course_id,$from,$to,"name");
		$data['date'] = $this->Admin_Model->get_excel($course_id,$from,$to,"date");
		$data['attendance'] = $this->Admin_Model->get_excel($course_id,$from,$to,"attendance");
		$data['data'] = $this->Admin_Model->get_attendance_student(107,$from,$to,"attendance");


		 //echo '<pre>'; print_r($data['data']); echo '</pre>';

		require(APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel.php');
		require(APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');
		require(APPPATH.'third_party/PHPExcel-1.8/Classes/PHPExcel/Style/Alignment.php');

		$alpha = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ','BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ','CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY','CZ','DA','DB','DC','DD','DE','DF','DG','DH','DI','DJ','DK','DL','DM','DN','DO','DP','DQ','DR','DS','DT','DU','DV','DW','DX','DY','DZ');

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->getProperties()->setCreated("");
		$objPHPExcel->getProperties()->setLastModifiedBy("");
		$objPHPExcel->getProperties()->setTitle("");
		$objPHPExcel->getProperties()->setSubject("");
		$objPHPExcel->getProperties()->setDescription("");

		$objPHPExcel->setActiveSheetIndex(0);

		$objPHPExcel->getActiveSheet()->SetCellValue('A1','ID');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1','Name');
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);

		for($k=2 ; $k<count($alpha) ; $k++)
		{
			$objPHPExcel->getActiveSheet()->getColumnDimension($alpha[$k])->setWidth(10);
		}

		$a=2;
		foreach($data['date'] as $row)
		{
			$objPHPExcel->getActiveSheet()->SetCellValue($alpha[$a].'1',$row->date);
			$a++;
		}

		$x=2;
		
		foreach($data['name'] as $row)
		{
			$a=0;
			$b=1;

			$data['data'] = $this->Admin_Model->get_attendance_student($row->student_id,$from,$to,"attendance");

			$objPHPExcel->getActiveSheet()->SetCellValue($alpha[$a].$x,$row->student_id);
			$objPHPExcel->getActiveSheet()->SetCellValue($alpha[$b].$x,$row->student_name);
			
			foreach($data['data'] as $value)
			{
				$pos =0;
				$proceed=false;
				for($i=2 ; $i< count($data['date'] )+2 ; $i++)
				{
					$date = $objPHPExcel->getActiveSheet()->getCell($alpha[$i].'1')->getValue();


					if($value->date == $date)
					{
						$proceed = true;
						$pos = $i;
					}

				}

				if($proceed ==true)
				{
					$objPHPExcel->getActiveSheet()->SetCellValue($alpha[$pos].$x,$row->attendance_morning);
				}
				

				
				
			}
			$x++;
			
		}


		$filename="Attendance Sheet - "."hai".'.xlsx';
		$objPHPExcel->getActiveSheet()->setTitle("Attendance");

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter ->save('php://output');
		exit;

	}















	






	



}
//*************************************************************** DATATABLE COURSE ***********************************************






      


