<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pdrill extends CI_Controller
{
	function __construct()
	{
		parent::__construct(); // needed when adding a constructor to a controller
		$this->load->model('basicdb');
		$this->load->model('practicedb');
		if ($this->session->userid == "") header('Location: ' . base_url());
		// $this->data can be accessed from anywhere in the controller.
	}
	public function index()
	{
		$data['page'] = "public/problems/pbellesson";
		$data['angular'] = "problems_pbellesson";
		$this->load->view('layouts/public/master', $data);
	}
	public function load_dril()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['pdb'] = $this->practicedb;
		$this->load->view('public/problems/php/load_dril', $data);
	}
	public function labs()
	{
		$data['page'] = "public/problems/pbellabworks";
		$data['angular'] = "problems_pbellabworks";
		$this->load->view('layouts/public/master', $data);
	}
	public function load_labs()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['pdb'] = $this->practicedb;
		$this->load->view('public/problems/php/load_labs', $data);
	}
	public function runqs()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['pdb'] = $this->practicedb;
		$this->load->view('/php/runquery', $data);
	}
	public function exam()
	{
		$data['page'] = "public/problems/pbellabexams";
		$data['angular'] = "problems_pbellabexams";
		$this->load->view('layouts/public/master', $data);
	}
	public function load_exam()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['pdb'] = $this->practicedb;
		$this->load->view('public/problems/php/load_exam', $data);
	}
	public function load_srvy()
	{
		$data = array();
		$this->load->model('survey');
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['fbk'] = $this->survey;
		$this->load->view('public/learning/php/db_survey', $data);
	}
}
