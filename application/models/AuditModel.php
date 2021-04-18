<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuditModel extends CI_Model
{

    public function GetAudits()
    {
        $q = $this->db->get('audit_trail');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetAudit($id)
    {
        $q = $this->db->get_where('audit_trail', array('id' => $id));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function SaveAudit($data)
    {
        $this->db->insert('audit_trail', $data);
    }
}
