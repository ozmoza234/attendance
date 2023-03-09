<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Spl_m extends ci_model
{
    public function save_nup($data)
    {
        $this->db->insert('spl', $data);
    }

    public function tampil_list_spl()
    {
        $data = "SELECT
        spl.id,
        spl.number,
        spl.remarks,
        spl.date,
        spl.date_created,
        spl.approval_1,
        spl.date_app_1,
        spl.remarks_app1,
        spl.date_modified,
        spl.`status`,
        spl.`hour`
        FROM
        spl
        ";
        $query = $this->db->query($data);
        return $query->result();
    }

    public function input_data($data)
    {
        $this->db->insert('splemp', $data);
    }

    public function get_spl_to_emp($id)
    {
        $data = "SELECT
        splemp.id_spl,
        splemp.id_emp,
        emp0003.`Name`,
        emp0003.NIK,
        spl.number,
        emp0004.GroupDesc
        FROM
        splemp
        LEFT JOIN emp0003 ON splemp.id_emp = emp0003.EmployeeID
        LEFT JOIN spl ON splemp.id_spl = spl.id
        LEFT JOIN emp0005 ON emp0005.EmployeeID = emp0003.EmployeeID
        LEFT JOIN emp0004 ON emp0005.GroupID = emp0004.GroupID
        WHERE
        splemp.id_spl = $id";
        $query = $this->db->query($data);
        return $query->result();
    }

    public function reset($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('spl', $data);
    }

    public function del_data($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('spl');
    }
}
