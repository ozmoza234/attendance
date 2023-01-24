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

    public function get_log()
    {
        $result['data'] = $this->Attendance_m->load_log();
        echo json_encode($result);
    }
}
