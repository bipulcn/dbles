<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Sqlparc extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Sqlmodel');
    }
    public function index()
    {
        echo "Sqlparc";
    }
}