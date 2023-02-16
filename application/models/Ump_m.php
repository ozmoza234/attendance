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
