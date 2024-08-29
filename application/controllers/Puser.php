<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Puser extends CI_Controller
{
	function __construct()
	{
		parent::__construct(); // needed when adding a constructor to a controller
		$this->load->model('basicdb');
		$this->load->model('user');
		$this->load->model('tracker');
		// $this->data can be accessed from anywhere in the controller.
	}
	public function index()
	{
		echo "User Details information";
		// $data['page'] = "public/problems/pbellesson";
		// $data['angular'] = "base_page";
		// $this->load->view('layouts/public/master', $data);
	}
	public function logdb()
	{
		$data = array();
		$data['db'] = $this->user;
		$data['s_on'] = $this->session;
		$data['tk'] = $this->tracker;
		$this->load->view('public/users/php/login_db', $data);
	}
	public function regdb()
	{
		$data = array();
		$data['db'] = $this->user;
		$data['s_on'] = $this->session;
		$this->load->view('public/users/php/regis_db', $data);
	}
	public function login()
	{
		if ($this->session->userid != "") header('Location: ' . base_url());
		$data['page'] = 'public/users/loginpage';
		$data['angular'] = 'login_cont';
		// $data['base_url'] = base_url();
		$this->load->view('layouts/public/master', $data);
	}
	public function register()
	{
		if ($this->session->userid != "") header('Location: ' . base_url());
		$data['page'] = 'public/users/new_users';
		$data['angular'] = 'register_cont';
		// $data['base_url'] = base_url();
		$this->load->view('layouts/public/master', $data);
	}
	public function cnginfo()
	{
		if ($this->session->userid == "") header('Location: ' . base_url());
		$data['page'] = 'public/users/cng_users_info';
		$data['angular'] = 'user_info';
		$this->load->view('layouts/public/master', $data);
	}
	public function upimg()
	{
		$data['s_no'] = $this->session;
		$data['db'] = $this->user;
		$this->load->view('php/uploadimg', $data);
	}
	public function survey($sid = 0)
	{
		if ($this->session->userid == "") header('Location: ' . base_url());
		$data['page'] = 'public/learning/survey_quize';
		$data['angular'] = 'survey_quize';
		$data['sid'] = $sid;
		$this->load->view('layouts/public/master', $data);
	}
	public function reqpass()
	{
		$data['db'] = $this->basicdb;
		$data['s_no'] = $this->session;
		$data['page'] = 'public/users/requestpassword';
		$data['angular'] = 'requestpassword';
		$this->load->view('layouts/public/master', $data);
	}
	public function sendsms()
	{
		$data['db'] = $this->basicdb;
		$data['s_no'] = $this->session;
		$this->load->view('public/users/php/sendsms', $data);
	}
	public function logout() {
		$this->session->aduid = "";
		$this->session->userid = '';
		$this->session->userrole = '';
		$this->session->uname = "";
		$this->session->phone = "";
		$this->session->email = "";
		$this->session->session = "";
		header('Location: ' . base_url());
	}
}
