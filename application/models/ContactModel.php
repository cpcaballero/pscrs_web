<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ContactModel extends CI_Model
{

    public function GetContact()
    {
        $q = $this->db->get('contact_us');
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function UpdateContact($data)
    {
        $this->db->set($data);
        $this->db->update('contact_us');
    }

    public function CreateContact($data)
    {
        $this->db->insert('contact_us', $data);
    }
}
