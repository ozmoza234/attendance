<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ump_m extends ci_model
{
    public function load_edata()
    {
        $data = "SELECT
        emp0006.PeriodeUMP,
        emp0006.`YEAR`,
        emp0006.UMP,
        emp0006.UmpID
        FROM
        emp0006";

        $q = $this->db->query($data);
        return $q->result();
    }

    public function load_eedata()
    {
        $data = "SELECT
        emp0006.PeriodeUMP,
        emp0006.`YEAR`,
        emp0006.UMP,
        emp0006.UmpID
        FROM
        emp0006";

        return $this->db->query($data);
    }

    public function load_ptdata()
    {
        $data = "SELECT
        emp0007.PTKPID,
        emp0007.Description
        FROM
        emp0007
        WHERE
        emp0007.IsActive = 'T'
        ";

        return $this->db->query($data);
    }

    public function list_op_kandang()
    {
        $data = "SELECT
        emp0003.`Name`,
        emp0003.NIK,
        emp0003.EmployeeID,
        CASE
            
            WHEN nuprhb.nup_number IS NULL THEN
            'empty' ELSE nuprhb.nup_number 
        END nup_number 
        FROM
        emp0003
        LEFT JOIN nupemployee ON nupemployee.id_employee = emp0003.EmployeeID
        LEFT JOIN nuprhb ON nupemployee.id_nup = nuprhb.id 
        WHERE
        emp0003.TitleID = 29
        AND nuprhb.nup_number IS NULL
        AND emp0003.IsActive = 'T'
        ";

        return $this->db->query($data);
    }

    public function list_op_kandang_ajax()
    {
        $data = "SELECT
        emp0003.`Name`,
        emp0003.NIK,
        emp0003.EmployeeID,
        CASE
            
            WHEN nuprhb.nup_number IS NULL THEN
            'empty' ELSE nuprhb.nup_number 
        END nup_number 
        FROM
        emp0003
        LEFT JOIN nupemployee ON nupemployee.id_employee = emp0003.EmployeeID
        LEFT JOIN nuprhb ON nupemployee.id_nup = nuprhb.id 
        WHERE
        emp0003.TitleID = 29
        AND nuprhb.nup_number IS NULL
        AND emp0003.IsActive = 'T'
        ";
        $query = $this->db->query($data);
        return $query->result();
    }

    public function get_nik_n_grup($id)
    {
        $data = "SELECT
        emp0003.EmployeeID,
        emp0003.NIK,
        emp0003.`Name` ename,
        emp0004.GroupDesc
        FROM
        emp0003
        LEFT JOIN emp0005 ON emp0005.EmployeeID = emp0003.EmployeeID
        LEFT JOIN emp0004 ON emp0004.GroupID = emp0005.GroupID
        WHERE
        emp0003.EmployeeID = $id";
        $query = $this->db->query($data);
        return $query->result();
    }
    // public function get_nik_n_grup($id)
    // {
    //     $data = "SELECT
    //     t2.GroupDesc,
    //     t1.EmployeeID,
    //     t3.NIK,
    //     t3.`Name` AS ename
    //     FROM
    //     emp0005 AS t1
    //     LEFT JOIN emp0004 AS t2 ON t1.GroupID = t2.GroupID
    //     LEFT JOIN emp0003 AS t3 ON t1.EmployeeID = t3.EmployeeID
    //     WHERE
    //     t1.EmployeeID = $id";
    //     $query = $this->db->query($data);
    //     return $query->result();
    // }

    public function load_edata_by_id()
    {
        $data = "SELECT
        emp0006.PeriodeUMP,
        emp0006.`YEAR`,
        emp0006.UMP,
        emp0006.UmpID
        FROM
        emp0006";

        $query = $this->db->query($data);
        return $query->result();
    }

    public function load_ump_by_id($UmpID)
    {
        $data = "SELECT
        emp0006.UMP
        FROM
        emp0006
        WHERE
        emp0006.UmpID = $UmpID";
        $query = $this->db->query($data);
        return $query->result();
    }
}
