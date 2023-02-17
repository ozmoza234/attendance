<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Employee_m');
        $this->load->model('Ump_m');
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

    public function op_kandang()
    {
        $data['listump'] = $this->Ump_m->load_eedata();
        $data['listptkp'] = $this->Ump_m->load_ptdata();
        $this->load->view('template/header');
        $this->load->view('employee/opkandanglist', $data);
        $this->load->view('template/footer');
    }

    public function addon()
    {
        $this->load->view('template/header');
        $this->load->view('employee/salaryaddon');
        $this->load->view('template/footer');
    }

    public function getDatas()
    {
        $result['data'] = $this->Employee_m->load_sedata();
        echo json_encode($result);
    }

    public function get_op_kandang()
    {
        $id = 29;
        $result['data'] = $this->Employee_m->get_op_list($id);
        echo json_encode($result);
    }
}
