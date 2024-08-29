<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auser extends CI_Controller
{
	function __construct()
	{
		parent::__construct(); // needed when adding a constructor to a controller
		$this->load->model('basicdb');
		$this->load->model('tracker');
		// $this->data can be accessed from anywhere in the controller.
	}
	public function index()
	{
		echo "User Details information";
		// $data['page'] = "admins/problems/pbellesson";
		// $data['angular'] = "base_page";
		// $this->load->view('layouts/admins/master', $data);
	}
	public function logdb()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['tk'] = $this->tracker;
		$this->load->view('admins/users/php/login_db', $data);
	}
	public function regdb()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$this->load->view('admins/users/php/regis_db', $data);
	}
	// public function register()
	// {
	// 	$data['page'] = 'admins/users/new_users';
	// 	$data['angular'] = 'register_cont';
	// 	$this->load->view('layouts/admins/master', $data);
	// }
	public function umanage()
	{
		if (!isset($this->session->userid) or $this->session->userid == '') header("Location: " . base_url());
		$data['page'] = 'admins/users/user_request';
		$data['angular'] = 'register_cont';
		$this->load->view('layouts/admins/master', $data);
	}
	public function mangrup()
	{
		if (!isset($this->session->userid) or $this->session->userid == '') header("Location: " . base_url());
		$data['page'] = 'admins/users/group_manage';
		$data['angular'] = 'group_cont';
		$this->load->view('layouts/admins/master', $data);
	}
	public function grpdb()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$this->load->view('admins/users/php/group_db', $data);
	}
	public function db_password()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$this->load->view('admins/users/php/db_password', $data);
	}
}
