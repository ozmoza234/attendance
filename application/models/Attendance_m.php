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

    public function load_d_v2($EmployeeID, $date_begin, $date_end)
    {
        $data = "SELECT
        DATE( t1.Enroll ) AS date,
        DAYNAME( t1.Enroll ) AS DAY,
        MONTH( t1.Enroll ) AS MONTH,
        YEAR( t1.Enroll ) AS YEAR,
        t2.`Name`,
        t3.BTIn AS Begin_in,
        t3.ETIn AS End_in,
        t3.BTOut AS Begin_out,
        t3.ETOut AS End_out,
        t6.GroupDesc,
        TIMEDIFF(MAX(TIME(t1.Enroll)), MIN(TIME(t1.Enroll))) total,
        SUBTIME(TIMEDIFF(MAX(TIME(t1.Enroll)), MIN(TIME(t1.Enroll))), '08:00:00') difference,
        CASE
            WHEN TIMEDIFF(MAX(TIME( t1.Enroll)), MIN(TIME(t1.Enroll))) < '08:00:00' AND TIMEDIFF( MAX( TIME( t1.Enroll ) ), MIN( TIME( t1.Enroll ) ) ) != '00:00:00' THEN
            'Minus' 
            WHEN MAX(TIME(t1.Enroll)) = MIN(TIME(t1.Enroll)) THEN
            'Forgot Scan' ELSE 'OK' 
        END WorkHourDesc,
        CASE
            
            WHEN MIN( TIME( t1.Enroll ) ) BETWEEN t3.BTIn 
            AND t3.ETIn THEN
                MIN( TIME( t1.Enroll ) ) ELSE 'null' 
                END AS time_in,
        CASE
                
                WHEN MAX( TIME( t1.Enroll ) ) BETWEEN t3.BTOut 
                AND t3.ETOut THEN
                    MAX( TIME( t1.Enroll ) ) ELSE 'null' 
                    END AS time_out 
            FROM
                dvc0004 AS t1
                LEFT JOIN emp0003 AS t2 ON t1.EmpID = t2.EmployeeID,
                shd0001 AS t3,
                emp0005 AS t5
                LEFT JOIN dvc0004 AS t4 ON t4.EmpID = t5.EmployeeID
                LEFT JOIN emp0004 AS t6 ON t5.GroupID = t6.GroupID
            WHERE
                t2.EmployeeID = $EmployeeID 
                AND t5.EmployeeID = $EmployeeID
                AND DATE ( t1.Enroll ) BETWEEN '$date_begin' AND '$date_end'
            GROUP BY
                DATE( t1.Enroll ) 
        ORDER BY
        t1.Enroll DESC";
        $query = $this->db->query($data);
        return $query->result();
    }

    public function get_head()
    {
        $data = "SELECT
        t1.GroupID,
        t2.GroupDesc,
        t2.Head,
        t1.EmployeeID,
        t3.`Name` AS Nama_operator,
        t4.`Name`
        FROM
        emp0005 AS t1
        LEFT JOIN emp0004 AS t2 ON t1.GroupID = t2.GroupID
        LEFT JOIN emp0003 AS t3 ON t1.EmployeeID = t3.EmployeeID
        LEFT JOIN emp0003 AS t4 ON t2.Head = t4.EmployeeID";
    }
}
