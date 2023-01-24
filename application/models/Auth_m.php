<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_m extends ci_model
{
    public function sum_kry()
    {
        $data = "SELECT
        COUNT(CASE WHEN emp0003.IsActive = 'T' THEN emp0003.EmployeeID END) AS total_act
        FROM
        emp0003";
        return $this->db->query($data);
    }

    public function sum_fm()
    {
        $data = "SELECT
        COUNT(CASE WHEN emp0003.Gender = 'M' AND emp0003.IsActive = 'T' THEN emp0003.EmployeeID END) AS m,
        COUNT(CASE WHEN emp0003.Gender = 'F' AND emp0003.IsActive = 'T' THEN emp0003.EmployeeID END) AS f
        FROM
        emp0003";
        $query = $this->db->query($data);
        return $query->result();
    }
}
