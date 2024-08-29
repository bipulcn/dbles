<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Adpro extends CI_Controller
{
	function __construct()
	{
		parent::__construct(); // needed when adding a constructor to a controller
		$this->load->model('basicdb');
		$this->load->model('practicedb');
		// $this->data can be accessed from anywhere in the controller.
	}
	public function load_dril()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['pdb'] = $this->practicedb;
		$this->load->view('admins/problems/php/load_dril', $data);
	}
	public function load_exam()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['pdb'] = $this->practicedb;
		$this->load->view('admins/problems/php/load_exam', $data);
	}
	public function enbl_exam()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['pdb'] = $this->practicedb;
		$this->load->view('admins/problems/php/enbl_exam', $data);
	}
	public function load_pans()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['pdb'] = $this->practicedb;
		$this->load->view('admins/problems/php/load_answers', $data);
	}
	public function lod_res()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['pdb'] = $this->practicedb;
		$this->load->view('admins/problems/php/load_results', $data);
	}
	public function load_eans()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['pdb'] = $this->practicedb;
		$this->load->view('admins/problems/php/exam_answers', $data);
	}
	public function lod_eres()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['pdb'] = $this->practicedb;
		$this->load->view('admins/problems/php/exam_results', $data);
	}
	public function ld_lesson()
	{
		$data = array();
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['pdb'] = $this->practicedb;
		$this->load->view('admins/lessons/php/load_lesson', $data);
	}
	public function db_survey()
	{
		$data = array();
		$this->load->model('survey');
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['fbk'] = $this->survey;
		$this->load->view('admins/profiles/php/db_survey', $data);
	}
	public function db_surres()
	{
		$data = array();
		$this->load->model('survey');
		$data['db'] = $this->basicdb;
		$data['s_on'] = $this->session;
		$data['fbk'] = $this->survey;
		$this->load->view('admins/profiles/php/db_surres', $data);
	}
}
