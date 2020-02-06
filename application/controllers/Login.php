<?php

class Login extends CI_Controller
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
	
	}

	public function index()
	{
		$this->load->view('pages/login');
	}


	public function login_validation()
	{
		$this->form_validation->set_rules('inputName','Name','required');
		$this->form_validation->set_rules('inputPassword','Password','required');

		if($this->form_validation->run())
		{
			$name=$this->input->post('inputName');
			$password=$this->input->post('inputPassword');

			$id=$this->Admin_Model->searchdata($name);

			$epassword=$this->encryption->decrypt($id->password);

			if($password==$epassword)
			{

				$userid=array('name'=>$name, 'loggedin'=> TRUE, 'user'=>'admin');
				$this->session->set_userdata($userid);
				redirect('admin/dashboard');
			}
			else
			{
				$this->session->set_flashdata('error','Invalid name or password');
				redirect('login/index');
			}
	
		}
		else
		{
			$this->login();
		}

	}

	public function login_coadmin()
	{
		$this->load->view('pages/coadmin/login');
	}

	public function coadmin_login_validation()
	{
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');

		if($this->form_validation->run())
		{
			$username=$this->input->post('username');
			$password=$this->input->post('password');

			$id=$this->Admin_Model->validate_coadmin($username);

			$epassword=$this->encryption->decrypt($id[0]->coadmin_password);

			if($password==$epassword)
			{
				$data = array('name' => $username, 'college_id' =>$id[0]->coadmin_college_id, 'loggedin'=> TRUE, 'user'=>'coadmin');

				$this->session->set_userdata($data);
				redirect('admin/dashboard');
			}
			else
			{
				$this->session->set_flashdata('error','Invalid name or password');
				redirect('login/login_coadmin');
			}
	
		}
		else
		{
			$this->login_coadmin();
		}
	}


	public function teacher_login()
	{
		$this->load->view('pages/teacher/login');
	}

	public function teacher_login_validation()
	{
		$this->form_validation->set_rules('username','Username','required');
		$this->form_validation->set_rules('password','Password','required');

		if($this->form_validation->run())
		{
			$username=$this->input->post('username');
			$password=$this->input->post('password');

			$id=$this->Admin_Model->validate_teacher($username);

			$epassword=$this->encryption->decrypt($id[0]->teacher_password);

			if($password==$epassword)
			{
				$data = array('name' => $username, 'college_id' => $id[0]->teacher_college,'college_name'=> $id[0]->college_name, 'course_id' => $id[0]->teacher_course,'course_name'=> $id[0]->course_name, 'loggedin'=> TRUE, 'user'=>'teacher');

				$this->session->set_userdata($data);
				redirect('admin/dashboard');
			}
			else
			{
				$this->session->set_flashdata('error','Invalid name or password');
				redirect('login/teacher_login');
			}
	
		}
		else
		{
			$this->teacher_login();
		}
	}

	public function logout()
	{
			$this->session->unset_userdata('name');
			$this->session->unset_userdata('loggedin');
			$this->session->unset_userdata('user');
			redirect('login');
	}

	public function logout_coadmin()
	{
			$this->session->unset_userdata('name');
			$this->session->unset_userdata('loggedin');
			$this->session->unset_userdata('user');
			$this->session->unset_userdata('college_id');
			$this->session->unset_userdata('college_name');
			redirect('login/login_coadmin');
	}

	public function logout_teacher()
	{
			$this->session->unset_userdata('name');
			$this->session->unset_userdata('loggedin');
			$this->session->unset_userdata('user');
			$this->session->unset_userdata('college_id');
			$this->session->unset_userdata('course_id');
			$this->session->unset_userdata('course_name');
			$this->session->unset_userdata('college_name');
			redirect('login/teacher_login');
	}

}


?>