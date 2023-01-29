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

    public function load_d($EmployeeID, $month, $year)
    {
        $data = "SELECT
        emp0003.`Name`,
        DAYNAME(dvc0004.Enroll) DAY,
        DATE(dvc0004.Enroll) date,
        MONTH (dvc0004.Enroll) MONTH,
        YEAR (dvc0004.Enroll) YEAR,
        MIN(TIME(dvc0004.Enroll)) inTime,
        MAX(TIME(dvc0004.Enroll)) outTime,
        TIMEDIFF(MAX(TIME(dvc0004.Enroll)), MIN(TIME(dvc0004.Enroll))) total,
        CASE
            WHEN DAYNAME(dvc0004.Enroll) = 'Sunday' 
            OR DAYNAME(dvc0004.Enroll) = 'Saturday' THEN
                'Off' ELSE 'Work' 
            END DayDesc,
        CASE
            WHEN TIMEDIFF(MAX(TIME( dvc0004.Enroll)), MIN(TIME(dvc0004.Enroll))) < '08:00:00' AND TIMEDIFF( MAX( TIME( dvc0004.Enroll ) ), MIN( TIME( dvc0004.Enroll ) ) ) != '00:00:00' THEN
            'Minus' 
            WHEN MAX(TIME(dvc0004.Enroll)) = MIN(TIME(dvc0004.Enroll)) THEN
            'Forgot Scan' ELSE 'OK' 
        END WorkHourDesc,
        SUBTIME(TIMEDIFF(MAX(TIME(dvc0004.Enroll)), MIN(TIME(dvc0004.Enroll))), '08:00:00') difference 
        FROM
        dvc0004
        LEFT JOIN emp0003 ON emp0003.EmployeeID = dvc0004.EmpID 
        WHERE
        MONTH ( dvc0004.Enroll ) = $month
        AND YEAR ( dvc0004.Enroll ) = $year
        AND EmpID = $EmployeeID 
        GROUP BY
        DATE( dvc0004.Enroll ) 
        ORDER BY
        dvc0004.Enroll ASC";
        $query = $this->db->query($data);
        return $query->result();
    }
}
