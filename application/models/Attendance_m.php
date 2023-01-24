<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_m extends ci_model
{
    public function load_log()
    {
        $data = "SELECT
        dvc0004.Idx,
        emp0003.NIK,
        emp0003.`Name`,
        dvc0001.DeviceDesc,
        dvc0004.Enroll
        FROM
        dvc0004
        LEFT JOIN dvc0001 ON dvc0001.DeviceID = dvc0004.DeviceID
        LEFT JOIN emp0003 ON dvc0004.EmpID = emp0003.EmployeeID
        ORDER BY
        dvc0004.Enroll DESC LIMIT 100000";
        $query = $this->db->query($data);
        return $query->result();
    }
}
