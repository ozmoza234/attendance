<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employee_m extends ci_model
{
    public function load_edata()
    {
        $data = "SELECT
        emp0003.EmployeeID,
        emp0003.NIK,
        emp0003.`Name` ename,
        emp0001.DepartmentDesc d,
        emp0002.PositionDesc p, 
        emp0025.TitleDesc t,
        emp0003.Gender,
        emp0003.Grade,
        emp0003.TempatLahir,
        emp0003.DateBirth,
        emp0003.EmployeeDate,
        emp0003.EndEmpDate,
        emp0003.Address,
        emp0003.IsActive,
        emp0003.Staff,
        emp0003.BankName,
        emp0003.AccountBank,
        emp0003.NOBPJSTK,
        emp0003.NOBPJSKS,
        emp0003.NOBPJSPEN,
        emp0003.Married,
        emp0003.StatusEmp,
        emp0003.ActiveDT,
        emp0003.CrtDate,
        emp0003.CrtUsr,
        emp0003.ModDate,
        emp0003.ModUsr,
        emp0003.KTP,
        emp0003.DTAWLKON,
        emp0003.DTAKHKON,
        emp0003.Pendidikan,
        emp0003.Email,
        emp0003.MobilePhone
        FROM
        emp0003
        LEFT JOIN emp0001 ON emp0003.DepartmentID = emp0001.DepartmentID
        LEFT JOIN emp0002 ON emp0003.PositionID = emp0002.PositionID
        LEFT JOIN emp0025 ON emp0003.TitleID = emp0025.TitleID
        WHERE emp0003.IsActive = 'T'
        ";
        $query = $this->db->query($data);
        return $query->result();
    }

    public function load_sedata()
    {
        $data = "SELECT
        emp0003.EmployeeID,
        emp0003.NIK,
        emp0003.`Name` AS ename,
        emp0001.DepartmentDesc AS d,
        emp0002.PositionDesc AS p,
        emp0025.TitleDesc AS t,
        emp0003.IsActive,
        emp0008.UMP,
        emp0008.Salary,
        emp0008.PTKPID,
        emp0008.Allw_Keterampilan,
        emp0008.Allw_Jabatan,
        emp0008.Allw_MasaKerja,
        emp0008.Allw_Dll,
        emp0008.Pot_Koperasi,
        emp0008.Pot_Dll,
        emp0008.Pot_Bpjs,
        emp0008.Pot_Bpjs_TK
        FROM
        emp0003
        LEFT JOIN emp0001 ON emp0003.DepartmentID = emp0001.DepartmentID
        LEFT JOIN emp0002 ON emp0003.PositionID = emp0002.PositionID
        LEFT JOIN emp0025 ON emp0003.TitleID = emp0025.TitleID
        LEFT JOIN emp0008 ON emp0008.EmployeeID = emp0003.EmployeeID
        WHERE
        emp0003.IsActive = 'T'
        ";
        $query = $this->db->query($data);
        return $query->result();
    }

    public function get_op_list($id)
    {
        $data = "SELECT
        t1.NIK,
        t1.`Name` AS ename,
        emp0004.Head,
        emp0003.`Name` AS Head_name,
        emp0004.GroupDesc,
        emp0005.GroupID,
        emp0005.EmployeeID,
        emp0025.TitleID,
        emp0025.TitleDesc,
        emp0001.DepartmentDesc,
        t8.UMP,
        t8.Salary,
        t8.PTKPID,
        t8.Allw_Keterampilan,
        t8.Allw_Jabatan,
        t8.Allw_MasaKerja,
        t8.Allw_Dll,
        t8.Pot_Koperasi,
        t8.Pot_Dll,
        t8.Pot_Bpjs,
        t8.Pot_Bpjs_TK,
        emp0007.PTKP,
        emp0002.PositionDesc
        FROM
        emp0003 AS t1
        LEFT JOIN emp0005 ON emp0005.EmployeeID = t1.EmployeeID
        LEFT JOIN emp0004 ON emp0005.GroupID = emp0004.GroupID
        LEFT JOIN emp0003 ON emp0003.EmployeeID = emp0004.Head
        LEFT JOIN emp0025 ON t1.TitleID = emp0025.TitleID
        LEFT JOIN emp0001 ON t1.DepartmentID = emp0001.DepartmentID
        LEFT JOIN emp0008 AS t8 ON t8.EmployeeID = t1.EmployeeID
        LEFT JOIN emp0007 ON t8.PTKPID = emp0007.PTKPID
        LEFT JOIN emp0002 ON t1.PositionID = emp0002.PositionID
        WHERE
        t1.IsActive = 'T' AND
        t1.TitleID = $id
        GROUP BY
        t1.EmployeeID";
        $query = $this->db->query($data);
        return $query->result();
    }
    // public function get_op_list($id)
    // {
    //     $data = "SELECT
    //     t1.GroupID,
    //     t2.GroupDesc,
    //     t2.Head,
    //     t1.EmployeeID,
    //     t3.NIK,
    //     t3.`Name` AS ename,
    //     t4.`Name` AS Head_name,
    //     t5.TitleDesc,
    //     t7.PositionDesc,
    //     t6.DepartmentDesc,
    //     t5.TitleID,
    //     t8.UMP,
    //     t8.Salary,
    //     t8.PTKPID,
    //     pajak.PTKP,
    //     t8.Allw_Keterampilan,
    //     t8.Allw_Jabatan,
    //     t8.Allw_MasaKerja,
    //     t8.Allw_Dll,
    //     t8.Pot_Koperasi,
    //     t8.Pot_Dll,
    //     t8.Pot_Bpjs,
    //     t8.Pot_Bpjs_TK 
    //     FROM
    //     emp0005 AS t1
    //     LEFT JOIN emp0004 AS t2 ON t1.GroupID = t2.GroupID
    //     LEFT JOIN emp0003 AS t3 ON t1.EmployeeID = t3.EmployeeID
    //     LEFT JOIN emp0003 AS t4 ON t2.Head = t4.EmployeeID
    //     LEFT JOIN emp0025 AS t5 ON t3.TitleID = t5.TitleID
    //     LEFT JOIN emp0001 AS t6 ON t3.DepartmentID = t6.DepartmentID
    //     LEFT JOIN emp0002 AS t7 ON t3.PositionID = t7.PositionID
    //     LEFT JOIN emp0008 AS t8 ON t8.EmployeeID = t3.EmployeeID
    //     LEFT JOIN emp0007 AS pajak	ON pajak.PTKPID = t8.PTKPID
    //     WHERE
    //     T3.IsActive = 'T' 
    //     AND t3.TitleID = $id 
    //     ORDER BY
    //     t8.Salary ASC";
    //     $query = $this->db->query($data);
    //     return $query->result();
    // }

    public function load_nup_list()
    {
        $data = "SELECT
        nuprhb.id,
        nuprhb.nup_number,
        nuprhb.is_active,
        nuprhb.date_created
        FROM
        nuprhb
        ";
        $query = $this->db->query($data);
        return $query->result();
    }

    public function load_recap_list()
    {
        $data = "SELECT
        recapitulation.number,
        recapitulation.date_start,
        recapitulation.date_end,
        recapitulation.date_created,
        recapitulation.date_modified,
        recapitulation.id
        FROM
        recapitulation
        ";
        $query = $this->db->query($data);
        return $query->result();
    }

    public function save_nup($data)
    {
        $this->db->insert('nuprhb', $data);
    }

    public function update_status_nup($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('nuprhb', $data);
    }

    public function input_emp_in_nup($data)
    {
        $this->db->insert('nupemployee', $data);
    }

    public function get_emp_to_nup($id)
    {
        $data = "SELECT
        nupemployee.id_nup,
        nupemployee.id_employee,
        nuprhb.nup_number,
        emp0003.`Name`,
        emp0003.NIK,
        emp0004.GroupDesc
        FROM
        nupemployee
        left JOIN nuprhb ON nupemployee.id_nup = nuprhb.id
        left JOIN emp0003 ON nupemployee.id_employee = emp0003.EmployeeID
        left JOIN emp0005 ON emp0005.EmployeeID = emp0003.EmployeeID
        left JOIN emp0004 ON emp0004.GroupID = emp0005.GroupID
        WHERE nupemployee.id_nup = $id";
        $query = $this->db->query($data);
        return $query->result();
    }

    public function remove_from_nup($id_nup, $id_employee)
    {
        // $this->db->where('id_nup', $id_nup);
        // $this->db->where('id_employee', $id_employee);
        // $this->db->delete('mform');

        $data = "DELETE FROM nupemployee 
        WHERE nupemployee.id_nup = $id_nup 
        AND nupemployee.id_employee = $id_employee";

        $this->db->query($data);
    }

    public function delete_all_emp($id)
    {
        $data = "DELETE FROM nupemployee 
        WHERE nupemployee.id_nup = $id";
        $this->db->query($data);
    }

    public function new_data_recap($data)
    {
        $this->db->insert('recapitulation', $data);
    }

    public function sum_recap()
    {
        $data = "SELECT
        COUNT(recapitulation.id) c
        FROM
        recapitulation";
        $query = $this->db->query($data);
        return $query->result();
    }

    public function del_m_recap($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('recapitulation');
    }
}
