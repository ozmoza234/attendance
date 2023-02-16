<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ump extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ump_m');
    }

    public function index()
    {
        $this->load->view('template/header');
        $this->load->view('ump/umplist');
        $this->load->view('template/footer');
    }

    public function getData()
    {
        $result['data'] = $this->Ump_m->load_edata();
        echo json_encode($result);
    }

    public function get_ump_by_id()
    {
        $UmpID = $this->input->get('umpid');
        $result['data'] = $this->Ump_m->load_ump_by_id($UmpID);
        echo json_encode($result);
    }
}
