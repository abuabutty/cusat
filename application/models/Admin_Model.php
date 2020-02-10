<?php
class Admin_Model extends CI_Model 
{


  function save_user()
  {
      $data = array('username' => $this->input->post('username'), 'password' => $this->input->post('password'),'active_status' => 0, 'delete_status' =>0);
      if($data != "")
      {
          $this->db->insert('user',$data);
      }
  }

//************************************************ COLLEGE DATA TABLE *******************************************************

      var $table = "college";  
      var $select_column = array("id", "college_code", "college_name");  
      var $order_column = array("college_code", "college_name");  
      function make_query_college()  
      {  
           $this->db->select($this->select_column);  
           $this->db->from($this->table);  
           if(isset($_POST["search"]["value"]))  
           {  
                $this->db->like("college_code", $_POST["search"]["value"]);  
                $this->db->or_like("college_name", $_POST["search"]["value"]);  
           }  
           if(isset($_POST["order"]))  
           {  
                $this->db->order_by($this->order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('college_name', 'ASC');  
           }  
      }

      function make_datatables_college()
      {  
           $this->make_query_college();  
           if($_POST["length"] != -1)  
           {  
                $this->db->limit($_POST['length'], $_POST['start']);  
           }  
           $query = $this->db->get();  
           return $query->result();  
      }  

      function get_filtered_data_college()
      {  
           $this->make_query_college();  
           $query = $this->db->get();  
           return $query->num_rows();  
      }       

      function get_all_data_college()  
      {  
           $this->db->select("*");  
           $this->db->from($this->table);  
           return $this->db->count_all_results();  
      } 


//************************************************ COURSE DATA TABLE *******************************************************


      var $course_table = "course";   
      var $course_order_column = array("college_code","course_name","college_name");  
      function make_query_course($id,$action)  
      {   
           $this->db->from('college');
           $this->db->join('course','college.id=course.college_id');

           if($action == "college")
           {
              $this->db->where('college.id',$id);
           }

           if(isset($_POST["search"]["value"]))  
           {  
                $this->db->group_start();
                $this->db->like("college.college_code", $_POST["search"]["value"]);  
                $this->db->or_like("course.course_name", $_POST["search"]["value"]);  
                $this->db->or_like("college.college_name", $_POST["search"]["value"]); 
                $this->db->group_end();  
           }  
           if(isset($_POST["order"]))  
           {  
                $this->db->order_by($this->course_order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('course.course_name', 'ASC');  
           }  
      }  
      function make_datatables_course($id,$action){  
           $this->make_query_course($id,$action);  
           if($_POST["length"] != -1)  
           {  
                $this->db->limit($_POST['length'], $_POST['start']);  
           }  
           $query = $this->db->get();  
           return $query->result();  
      }  
      function get_filtered_data_course($id,$action){  
           $this->make_query_course($id,$action);  
           $query = $this->db->get();  
           return $query->num_rows();  
      }       
      function get_all_data_course($id,$action)  
      {   
           $this->db->from($this->course_table);
           $this->db->join('college','college.id=course.college_id');
           if($action == "college")
           {
              $this->db->where('college.id',$id);
           }
           return $this->db->count_all_results();  
      } 


//************************************************ STUDENT DATA TABLE *******************************************************

  
      var $student_order_column = array("student_id","student_name","student_gender","course_name","college_name");  
      function make_query_student($id,$action)  
      {  
			$this->db->from('college');
			$this->db->join('course','college.id=course.college_id');
			$this->db->join('students','students.student_course=course.id');

      if($action=='college')
      {
        $this->db->where('students.student_college',$id);
      }

      if($action=='course')
      {
        $this->db->where('course.id',$id);
      }

           if(isset($_POST["search"]["value"]))  
           {  
                $this->db->group_start();

                $this->db->like("college.college_code", $_POST["search"]["value"]);  
                $this->db->or_like("students.student_name", $_POST["search"]["value"]);  
                $this->db->or_like("students.student_id", $_POST["search"]["value"]);  
                $this->db->or_like("students.student_gender", $_POST["search"]["value"]);  
                $this->db->or_like("course.course_name", $_POST["search"]["value"]);  
                $this->db->or_like("college.college_name", $_POST["search"]["value"]);

                $this->db->group_end();
           }  
           if(isset($_POST["order"]))  
           {  
                $this->db->order_by($this->student_order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('students.student_name', 'ASC');  
           }  
      }  
      function make_datatables_student($id,$action){  
           $this->make_query_student($id,$action);  
           if($_POST["length"] != -1)  
           {  
                $this->db->limit($_POST['length'], $_POST['start']);  
           }  
           $query = $this->db->get();  
           return $query->result();  
      }  
      function get_filtered_data_student($id,$action){  
           $this->make_query_student($id,$action);  
           $query = $this->db->get();  
           return $query->num_rows();  
      }       
      function get_all_data_student($id,$action)  
      {   
         $this->db->from('college');
         $this->db->join('course','college.id=course.college_id');
         $this->db->join('students','students.student_course=course.id');

          if($action=='college')
          {
            $this->db->where('students.student_college',$id);
          }

          if($action=='course')
          {
            $this->db->where('course.id',$id);
          }

           return $this->db->count_all_results();  
      } 


//************************************************ TEACHER DATA TABLE *******************************************************

  
      var $teacher_order_column = array("teacher_id","teacher_name","teacher_username","course_name","college_name");  
      function make_query_teacher($id,$action)  
      {  
    			$this->db->from('college');
    			$this->db->join('course','college.id=course.college_id');
    			$this->db->join('teacher','teacher.teacher_course=course.id');

      if($action == 'college')
      {
          $this->db->where('college.id',$id);
      }

           if(isset($_POST["search"]["value"]))  
           {  
                $this->db->group_start();
                $this->db->like("teacher.teacher_id", $_POST["search"]["value"]);  
                $this->db->or_like("teacher.teacher_name", $_POST["search"]["value"]);  
                $this->db->or_like("teacher.teacher_username", $_POST["search"]["value"]);  
                $this->db->or_like("course.course_name", $_POST["search"]["value"]);  
                $this->db->or_like("college.college_name", $_POST["search"]["value"]);
                $this->db->group_end();
           }  
           if(isset($_POST["order"]))  
           {  
                $this->db->order_by($this->teacher_order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('teacher.teacher_name', 'ASC');  
           }  
      }  
      function make_datatables_teacher($id,$action){  
           $this->make_query_teacher($id,$action);  
           if($_POST["length"] != -1)  
           {  
                $this->db->limit($_POST['length'], $_POST['start']);  
           }  
           $query = $this->db->get();  
           return $query->result();  
      }  
      function get_filtered_data_teacher($id,$action){  
           $this->make_query_teacher($id,$action);  
           $query = $this->db->get();  
           return $query->num_rows();  
      }       
      function get_all_data_teacher($id,$action)  
      {   
           $this->db->from('college');
           $this->db->join('course','college.id=course.college_id');
			     $this->db->join('teacher','teacher.teacher_course=course.id');

           if($action == 'college')
            {
                $this->db->where('college.id',$id);
            }
           return $this->db->count_all_results();  
      } 

//************************************************ COADMIN DATA TABLE *******************************************************
  
      var $coadmin_order_column = array("coadmin_username","college_code","college_name");  
      function make_query_coadmin()  
      {  
			$this->db->from('coadmin');
			$this->db->join('college','college.id=coadmin.coadmin_college_id');
           if(isset($_POST["search"]["value"]))  
           {  
                $this->db->like("coadmin.coadmin_username", $_POST["search"]["value"]);  
                $this->db->or_like("college.college_code", $_POST["search"]["value"]);   
                $this->db->or_like("college.college_name", $_POST["search"]["value"]);  
           }  
           if(isset($_POST["order"]))  
           {  
                $this->db->order_by($this->coadmin_order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);  
           }  
           else  
           {  
                $this->db->order_by('coadmin.coadmin_username', 'ASC');  
           }  
      }  
      function make_datatables_coadmin(){  
           $this->make_query_coadmin();  
           if($_POST["length"] != -1)  
           {  
                $this->db->limit($_POST['length'], $_POST['start']);  
           }  
           $query = $this->db->get();  
           return $query->result();  
      }  
      function get_filtered_data_coadmin(){  
           $this->make_query_coadmin();  
           $query = $this->db->get();  
           return $query->num_rows();  
      }       
      function get_all_data_coadmin()  
      {   
           $this->db->from('coadmin');
           $this->db->join('college','college.id=coadmin.coadmin_college_id');
           return $this->db->count_all_results();  
      } 


//************************************************ GET FULL COLLEGE *******************************************************

	function get_college($id,$action)
	{
    if($action == "college")
    {
        $this->db->where('id',$id);
    }

		$this->db->order_by('college_name','ASC');
		$query = $this->db->get('college');
		return $query->result();
	}

//************************************************ ADD COLLEGE *******************************************************

    function add_college($college)
	{
		$this->db->insert('college',$college);
	}


//************************************************ UPDATE COLLEGE *******************************************************

	function update_college($college)
	{
		$this->db->where('id',$college['id']);
		$this->db->set('college_code',$college['college_code']);
		$this->db->set('college_name',$college['college_name']);
		$this->db->update('college');
	}

//************************************************ DELETE COLLEGE *******************************************************

	function delete_by_college($id)
	{
		$this->db->from('college');
		$this->db->join('course','course.college_id=college.id');
		$this->db->join('students','students.student_college=college.id');
		$this->db->where('college.id',$id);
		$this->db->delete('college');
		$this->db->where('course.college_id',$id);
		$this->db->delete('course');
		$this->db->where('students.student_college',$id);
		$this->db->delete('students');
	}

//************************************************ GET FULL COURSE *******************************************************

	function get_course($id,$action)
	{
		$this->db->from('college');
		$this->db->join('course','college.id=course.college_id');

    if($action=="college")
    {
      $this->db->where('college.id',$id);
      $this->db->order_by('course.course_name');
    }

    if($action=="course")
    {
      $this->db->where('course.id',$id);
      $this->db->where('college.id',$this->session->userdata('college_id'));
    }

		return $this->db->get()->result();
	}

//************************************************ SAVE COURSE *******************************************************

	function save_course($data)
	{
		$this->db->insert('course',$data);
	}

//************************************************ SEARCH COURSE *******************************************************

	function search_course($course_id)
	{
		$this->db->where('id',$course_id);
		$query = $this->db->get('course');
		return $query->result();
	}


//************************************************ UPDATE COURSE *******************************************************

	function update_course($college_id,$course_name,$course_id)
	{
		$this->db->where('id',$course_id);
		$this->db->set('course_name',$course_name);
		$this->db->set('college_id',$college_id);
		$this->db->update('course');
	}


//************************************************ DELETE COURSE *******************************************************

	function delete_course($id)
	{
		$this->db->from('course');
		$this->db->join('students','students.student_course = course.id');
		$this->db->where('course.id',$id);
		$this->db->delete('course');
		$this->db->where('students.student_course',$id);
		$this->db->delete('students');
	}

//************************************************ TEACHER *******************************************************

	function save_teacher($data)
	{
		$this->db->insert('teacher',$data);
	}


	function get_teacher($id,$action)
	{
		$this->db->from('college');
		$this->db->join('course','college.id=course.college_id');
		$this->db->join('teacher','teacher.teacher_course=course.id');

    if($action=="college")
    {
      $this->db->where('college.id',$id);
    }

    if($action=="course")
    {
      $this->db->where('course.id',$id);
    }

    if($action=="id")
    {
      $this->db->where('teacher.id',$id);
    }
		return $this->db->get()->result();
	}


  function update_teacher($data,$id)
  {
      $this->db->where('id',$id);
      $this->db->update('teacher',$data);
  }

  function delete_teacher($id)
  {
    $this->db->where('id',$id);
    $this->db->delete('teacher');
  }

//************************************************ SAVE STUDENTS *******************************************************

	function save_student($data)
	{
		$this->db->insert('students',$data);
	}


//************************************************ STUDENT ID CHECK  *******************************************************

	function check_id($id,$action)
	{
    if($action == 'student')
    {
        $this->db->where('student_id',$id);
        $query = $this->db->get('students');
    }

    if($action == 'teacher')
    {
        $this->db->where('teacher_id',$id);
        $query = $this->db->get('teacher');
    }
		
		if($query->num_rows() > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}



//************************************************ GET STUDENT BY COURSE  *******************************************************

	function get_students($id,$action)
	{
    $this->db->from('college');
    $this->db->join('course','college.id=course.college_id');
    $this->db->join('students','students.student_course=course.id');

    if($action=="student")
    {
      $this->db->where('students.id',$id);
    }

    if($action=="course")
    {
      $this->db->where('course.id',$id);
    }

    if($action=="college")
    {
      $this->db->where('college.id',$id);
    }
		
		$this->db->order_by('student_name','ASC');
		return $this->db->get()->result();
	}


//************************************************ UPDATE STUDENT *******************************************************


	function update_student($data)
	{
		$this->db->set('student_id',$data['student_id']);
		$this->db->set('student_name',$data['student_name']);
		$this->db->set('student_gender',$data['student_gender']);
		$this->db->set('student_year',$data['student_year']);
		$this->db->set('student_course',$data['student_course']);
		$this->db->set('student_college',$data['student_college']);
		$this->db->where('id',$data['id']);
		$this->db->update('students');
	}


//************************************************ DELETE STUDENT  *******************************************************

	function delete_student($student_id)
	{
    $this->db->from('students');
    $this->db->join('attendance','students.student_course = attendance.student_course');
		$this->db->where('students.id',$student_id);
		$this->db->delete('students');
    $this->db->where('attendance.student_id',$student_id);
    $this->db->delete('attendance');
	}


//************************************************ ATTENDANCE  *******************************************************

	function save_attendance($data)
	{
		$this->db->insert('attendance',$data);
	}


//************************************************  *******************************************************

	function get_attendance($action,$course_id)
	{
		$this->db->from('course');
    $this->db->join('attendance','attendance.student_course=course.id');
		$this->db->join('students','attendance.student_id=students.id');
		$this->db->where('attendance.student_course',$course_id);

		if($action == "full")
		{
      $this->db->group_by(array('attendance.date','students.student_name'));
			$this->db->order_by('attendance.date','DESC');
      return $this->db->get()->result();
		}

		if($action == "name")
		{
			$this->db->group_by('students.student_name','DESC');
		}

		if($action == "date")
		{
			$this->db->group_by('attendance.date','DESC');
		}

    
	}


//************************************************  *******************************************************

	function check_attendance($date,$course_id)
	{
    $this->db->from('attendance');
		$this->db->where('date',$date);
		$this->db->where('student_course',$course_id);
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

//***************************************************** NEW ATTENDANCE EDITS **********************************


	function get_attendance_new($course_id,$date)
	{
		$this->db->from('attendance');
		$this->db->join('students','students.id = attendance.student_id');
		$this->db->where('students.student_course',$course_id);
		$this->db->where('attendance.date',$date);
		$query = $this->db->get();
		return $query->result();
	}



//************************************************ CO ADMIN STARTS  *******************************************************

	function save_coadmin($data)
	{
		$this->db->insert('coadmin',$data);
	}

//*******************************************************************************************************
	function get_coadmin()
	{
		return $this->db->get('coadmin')->result();
	}

//*******************************************************************************************************

	function update_coadmin($data)
	{
		$this->db->where('coadmin_id',$data['coadmin_id']);
		$this->db->update('coadmin',$data);
	}

//*******************************************************************************************************

    function search_coadmin($coadmin_id)
    {
      	$this->db->from('coadmin');
    		$this->db->where('coadmin_id',$coadmin_id);
    		return $this->db->get()->result();
    }

//*******************************************************************************************************

	function validate_coadmin($username)
	{
		$this->db->where('coadmin_username',$username);
		return $this->db->get('coadmin')->result();
	}

//*******************************************************************************************************

	function delete_coadmin($coadmin_id)
	{
		$this->db->where('coadmin_id',$coadmin_id);
		$this->db->delete('coadmin');
	}

//*************************************************** TEACHER ****************************************************


  function validate_teacher($username)
  {
    $this->db->from('college');
    $this->db->join('course','course.college_id = college.id');
    $this->db->join('teacher','teacher.teacher_course = course.id');
    $this->db->where('teacher_username',$username);
    return $this->db->get()->result();
  }

//*******************************************************************************************************





//*******************************************************************************************************





//*******************************************************************************************************





//*******************************************************************************************************





//*******************************************************************************************************





//*******************************************************************************************************





//*******************************************************************************************************






//*******************************************************************************************************






//*******************************************************************************************************





//*******************************************************************************************************




//*******************************************************************************************************







	function get_academic()
	{
		$this->db->order_by('academic_from','ASC');
		$query = $this->db->get('academic_year');
		return $query->result();
	}



	

	function get_excel($id,$from,$to,$action)
  {
      $this->db->from('students');
      $this->db->join('attendance','attendance.student_id = students.id');
      if($action != "student")
      {
        $this->db->where('students.student_course',$id);
      }
      
      $this->db->where('attendance.date >=', $from);
      $this->db->where('attendance.date <=', $to);

      if($action == "name")
      {         
          $this->db->group_by('attendance.student_name');
          $this->db->order_by('attendance.student_name','ASC');
      }

      if($action == "attendance")
      {
          $this->db->where('students.id',$id);
          $this->db->group_by(array('attendance.date','attendance.student_name'));
          $this->db->order_by('attendance.student_name','ASC');

      }

      if($action == "date")
      {
          $this->db->group_by('attendance.date');
          $this->db->order_by('attendance.date','ASC');
          
      }
      
      return $this->db->get()->result();
  }


  function get_attendance_student($id,$from,$to,$action)
  {
      $this->db->from('students');
      $this->db->join('attendance','attendance.student_id = students.id');
      $this->db->where('students.id',$id);
      $this->db->where('attendance.date >=', $from);
      $this->db->where('attendance.date <=', $to);
      $this->db->order_by('attendance.date','ASC');
      return $this->db->get()->result();
  }



	

	

	

	

	

	

	


	

	function get_attendance_excel($student_id)
	{
		$this->db->select('*');
		$this->db->where('student_id',$student_id);
		$this->db->order_by('date','ASC');
		return $this->db->get('attendance')->result();

	}

	

	

	function edit_attendance($data)
	{
		$this->db->where('student_id',$data['student_id']);
		$this->db->where('date',$data['date']);
		$this->db->set('attendance_morning',$data['attendance_morning']);
		$this->db->update('attendance');

	}





//************************************* Admin Validation ********************************
	function searchdata($name)
	{
		$this->db->select('*');
		$this->db->from('admin');
		$this->db->where('name',$name);
		$query=$this->db->get();

		if($query->num_rows() > 0)
		{
			return $query->row();
		}
		else
		{
			return false;
		}
		
	}



}