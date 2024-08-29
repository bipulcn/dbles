<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct(); // needed when adding a constructor to a controller
		$this->load->model('basicdb');
		$this->load->model('practicedb');
		$s_on = $this->session;
		if ($s_on->userid != "") {
			if (!($s_on->userrole == "A" || $s_on->userrole == "T")) {
				// echo "Its not admin ".$this->session->userrole;
				header('Location: ' . base_url());
			}
		} else header('Location: ' . base_url());
		// $this->data can be accessed from anywhere in the controller.
	}
	public function index()
	{
		$data['page'] = "admins/welcomeadmin";
		$data['angular'] = "problems_edtPbellesson";
		$this->load->view('layouts/admins/master', $data);
	}
	public function edles()
	{
		$data['page'] = "admins/problems/edtPbellesson";
		$data['angular'] = "problems_edtPbellesson";
		$this->load->view('layouts/admins/master', $data);
	}
	public function edexm()
	{
		$data['page'] = "admins/problems/edtPbelExams";
		$data['angular'] = "problems_edtPbelExams";
		$this->load->view('layouts/admins/master', $data);
	}
	public function enbexm()
	{
		$data['page'] = "admins/problems/enblPbelExams";
		$data['angular'] = "problems_enblPbelExams";
		$this->load->view('layouts/admins/master', $data);
	}
	public function pans()
	{
		$data['page'] = "admins/problems/prob_answers";
		$data['angular'] = "prob_answers";
		$this->load->view('layouts/admins/master', $data);
	}
	public function result()
	{
		$data['page'] = "admins/problems/prob_results";
		$data['angular'] = "prob_results";
		$this->load->view('layouts/admins/master', $data);
	}
	public function eans()
	{
		$data['page'] = "admins/problems/exam_answers";
		$data['angular'] = "exam_answers";
		$this->load->view('layouts/admins/master', $data);
	}
	public function eresult()
	{
		$data['page'] = "admins/problems/exam_results";
		$data['angular'] = "exam_results";
		$this->load->view('layouts/admins/master', $data);
	}
	public function xslexp($id = '', $lab = '')
	{
		$data['id'] = $id;
		$data['lab'] = $lab;
		$this->load->view("admins/problems/exportxsl", $data);
	}
	public function xslexam($id = '', $lab = '')
	{
		$data['exm'] = $id;
		$data['grp'] = $lab;
		$this->load->view("admins/problems/exportxslexam", $data);
	}
	public function lesson()
	{
		if ($this->session->aduid == "") header('Location: ' . base_url() . 'admin');
		$data['page'] = "admins/lessons/addPbellesson";
		$data['angular'] = "lessons_addPbellesson";
		$this->load->view('layouts/admins/master', $data);
	}
	public function schema()
	{
		if ($this->session->aduid == "") header('Location: ' . base_url() . 'admin');
		$data['page'] = "admins/lessons/schemamanage";
		$data['angular'] = "lessons_manschema";
		$this->load->view('layouts/admins/master', $data);
	}
	public function survey()
	{
		if ($this->session->aduid == "") header('Location: ' . base_url() . 'admin');
		$data['page'] = "admins/profiles/survey_man";
		$data['angular'] = "survey_man";
		$this->load->view('layouts/admins/master', $data);
	}
	public function surres()
	{
		if ($this->session->aduid == "") header('Location: ' . base_url() . 'admin');
		$data['page'] = "admins/profiles/survey_result";
		$data['angular'] = "survey_result";
		$this->load->view('layouts/admins/master', $data);
	}
	public function password()
	{
		if ($this->session->aduid == "") header('Location: ' . base_url() . 'admin');
		$data['page'] = "admins/users/reset_password";
		$data['angular'] = "reset_password";
		$this->load->view('layouts/admins/master', $data);
	}
	public function xslsurv($id = '')
	{
		$this->load->model('survey');
		$data['fbk'] = $this->survey;
		$data['fbkid'] = $id;
		$this->load->view("admins/profiles/exportxslsurv", $data);
	}
}
