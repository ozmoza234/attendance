<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Attendance_m');
    }

    public function index()
    {
        $this->load->view('template/header');
        $this->load->view('attendance/log');
        $this->load->view('template/footer');
    }

    public function indexE()
    {
        $this->load->view('template/header');
        $this->load->view('attendance/employeelog');
        $this->load->view('template/footer');
    }

    public function get_log()
    {
        $result['data'] = $this->Attendance_m->load_log();
        echo json_encode($result);
    }

    public function detailss()
    {
        $EmployeeID = $this->input->get('EmployeeID');
        $date_begin = $this->input->get('date_begin');
        $date_end = $this->input->get('date_end');

        $result['data'] = $this->Attendance_m->load_d_v2($EmployeeID, $date_begin, $date_end);
        echo json_encode($result);
    }
}
