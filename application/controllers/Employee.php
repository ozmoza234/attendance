<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Employee_m');
    }

    public function index()
    {
        $this->load->view('template/header');
        $this->load->view('employee/employeelist');
        $this->load->view('template/footer');
    }

    public function getData()
    {
        $result['data'] = $this->Employee_m->load_edata();
        echo json_encode($result);
    }

    public function salary()
    {
        $this->load->view('template/header');
        $this->load->view('employee/salarylist');
        $this->load->view('template/footer');
    }

    public function getDatas()
    {
        $result['data'] = $this->Employee_m->load_sedata();
        echo json_encode($result);
    }
}
