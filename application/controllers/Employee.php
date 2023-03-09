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
        // $data['lustopkandang'] = $this->Ump_m->list_op_kandang();
        $sum = $this->Employee_m->sum_recap();
        $no = $sum[0]->c;
        $p = $no + 1;
        $c = sprintf("%03s", $p);
        $no_voc = $c;
        $data['no'] = 'RECAP/' . $no_voc;
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
    public function lembur()
    {
        $data['employ'] = $this->Employee_m->list_emp();
        $this->load->view('template/header');
        $this->load->view('spl/form', $data);
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

    public function get_nup()
    {
        $result['data'] = $this->Employee_m->load_nup_list();
        echo json_encode($result);
    }

    public function save_nup()
    {
        date_default_timezone_set('Asia/Jakarta');
        $data = array(
            'is_active' => 1,
            'date_created' => date('Y-m-d H:i:s'),
            'nup_number' => $this->input->post('no_nup')
        );
        $this->Employee_m->save_nup($data);
        echo json_encode($data);
    }

    public function update_nup()
    {
        $data = array(
            'is_active' => $this->input->get('is_active')
        );
        $id = $this->input->get('id');

        if ($this->input->get('is_active') == "0") {
            $this->Employee_m->delete_all_emp($id);
            $this->Employee_m->update_status_nup($data, $id);
        } else if ($this->input->get('is_active') == "1") {
            $this->Employee_m->update_status_nup($data, $id);
        }
        echo json_encode($data);
    }

    public function load_op_by_id()
    {
        $id = $this->input->get('EmployeeID');
        $result = $this->Ump_m->get_nik_n_grup($id);
        echo json_encode($result);
    }
    public function save_emp_for_nup()
    {
        $data = array(
            'id_nup' => $this->input->get('id'),
            'id_employee' => $this->input->get('EmployeeID')
        );

        $result = $this->Employee_m->input_emp_in_nup($data);
        echo json_encode($result);
    }

    public function load_emp_to_nup()
    {
        $id = $this->input->get('id');
        $result['data'] = $this->Employee_m->get_emp_to_nup($id);
        echo json_encode($result);
    }

    public function load_opt_kdg()
    {
        $result = $this->Ump_m->list_op_kandang_ajax();
        echo json_encode($result);
    }

    public function del_from_nup()
    {
        $id_nup = $this->input->post('id_nup');
        $id_employee = $this->input->post('id_employee');
        $this->Employee_m->remove_from_nup($id_nup, $id_employee);
    }

    public function insert_new_recap()
    {
        $data = array(
            'number' => $this->input->post('number'),
            'date_start' => $this->input->post('date_start'),
            'date_end' => $this->input->post('date_end'),
            'date_created' => $this->input->post('date_created'),
            'date_modified' => $this->input->post('date_modified'),
        );

        $result = $this->Employee_m->new_data_recap($data);
        echo json_encode($result);
    }

    public function get_data_recap()
    {
        $result['data'] = $this->Employee_m->load_recap_list();
        echo json_encode($result);
    }

    public function del_recap()
    {
        $id = $this->input->post('id');
        $this->Employee_m->del_m_recap($id);
    }

    public function load_rekap_op_kdg()
    {
        $date_start = $this->input->post('date_start');
        $date_end = $this->input->post('date_end');

        $result['data'] = $this->Employee_m->rekap_op_kdg($date_start, $date_end);
        echo json_encode($result);
    }
}
