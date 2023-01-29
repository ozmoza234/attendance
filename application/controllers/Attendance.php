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
        $month = $this->input->get('month');
        $year = $this->input->get('year');

        $result['data'] = $this->Attendance_m->load_d($EmployeeID, $month, $year);
        echo json_encode($result);
    }
}
