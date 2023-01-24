<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_m');
        $this->load->library('form_validation');
        // if (!$this->session->userdata('username')) {
        //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Please do Login First!</div>');
        //     redirect('Auth');
        // }
    }

    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim', ['required' => "Username can't be empty!"]);

        $this->form_validation->set_rules('password', 'Password', 'required|trim', ['required' => "Password can't be empty!"]);

        if ($this->form_validation->run() == false) {
            $this->load->view('index');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->db->get_where('sys0001', ['UserName' => $username])->row_array();

            if ($user) {
                // var_dump($user['Password']);
                if (password_verify($password, $user['Password'])) {
                    $data = array(
                        'username' => $user['UserName']
                    );
                    $this->session->set_userdata($data);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Login Success!</div>');
                    $data['data'] = $this->Auth_m->sum_kry()->row_array();
                    $this->load->view('template/header');
                    $this->load->view('dashboard', $data);
                    $this->load->view('template/footer');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password Error!</div>');
                    redirect('Auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Username Error!</div>');
                redirect('Auth');
            }
        }
    }

    public function dashboard()
    {
        $data['data'] = $this->Auth_m->sum_kry()->row_array();
        $this->load->view('template/header');
        $this->load->view('dashboard', $data);
        $this->load->view('template/footer');
    }

    public function get_data_graph()
    {
        $result = $this->Auth_m->sum_fm();
        echo json_encode($result);
    }

    public function destroy()
    {
        $this->session->unset_userdata('username');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
        redirect('Auth');
    }
}
