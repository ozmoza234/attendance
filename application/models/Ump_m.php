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
}
