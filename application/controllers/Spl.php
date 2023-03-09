<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Spl extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Employee_m');
        $this->load->model('Spl_m');
    }

    public function insert_new_overtime()
    {
        $data = array(
            'number' => $this->input->post('number'),
            'date' => $this->input->post('date'),
            'remarks' => $this->input->post('remarks'),
            'hour' => $this->input->post('hour'),
            'date_created' => $this->input->post('date_created'),
            'date_modified' => $this->input->post('date_modified'),
            'status' => $this->input->post('status'),
            'approval_1' => 0,
            'remarks_app1' => ""
        );
        $this->Spl_m->save_nup($data);
        echo json_encode($data);
    }

    public function list()
    {
        $result['data'] = $this->Spl_m->tampil_list_spl();
        echo json_encode($result);
    }

    public function save_detail()
    {
        $id = $this->input->get('id');
        $date = $this->input->get('date');
        $data = array(
            'id_spl' => $id,
            'id_emp' => $this->input->get('EmployeeID'),
            'date_created' => $date
        );

        $result = $this->Spl_m->input_data($data);

        $data = array(
            'approval_1' => 0,
            'status' => 0,
            'date_modified' => $date
        );

        $this->Spl_m->reset($id, $data);
        echo json_encode($result);
    }

    public function load_spl_to_emp()
    {
        $id = $this->input->get('id');
        $result['data'] = $this->Spl_m->get_spl_to_emp($id);
        echo json_encode($result);
    }

    public function del()
    {
        $id = $this->input->post('id');
        $this->Spl_m->del_data($id);
    }
}
