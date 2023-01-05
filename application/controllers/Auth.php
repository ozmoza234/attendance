<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    // function __construct()
    // {
    //     parent::__construct();
    // }

    public function index()
    {
        $this->load->view('template/header');
        $this->load->view('dashboard');
        $this->load->view('template/footer');
    }
}
