<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    // function __construct()
    // {
    //     parent::__construct();
    // }

    public function index()
    {
        $this->load->view('template/header');
        $this->load->view('profile/profile_view');
        $this->load->view('template/footer');
    }
}
