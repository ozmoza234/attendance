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
}
