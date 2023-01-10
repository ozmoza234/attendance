<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('template/header');
        $this->load->view('user/userlist');
        $this->load->view('template/footer');
    }

    public function edit()
    {
        $this->load->view('template/header');
        $this->load->view('user/useredit');
        $this->load->view('template/footer');
    }
}
