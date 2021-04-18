
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AboutModel extends CI_Model
{
    public function GetAbout($id = null)
    {
        if ($id) {
            $this->db->order_by('id', 'DESC');
            $this->db->where(array('id' => $id));
            $q = $this->db->get('about');
            if ($q->num_rows() > 0) {
                return $q->row();
            }
            return false;
        } else {
            $this->db->order_by('id', 'DESC');
            $q = $this->db->get('about');
            if ($q->num_rows() > 0) {
                return $q->result();
            }
            return false;
        }
    }

    public function UpdateAbout($id, $data)
    {
        $this->db->set($data);
        $this->db->where(array('id' => $id));
        $this->db->update('about');
    }

    public function DeleteAbout($id)
    {
        $q = $this->db->delete('about', array('id' => $id));
    }

    public function PublishAbout($data)
    {
        $this->db->insert('about', $data);
    }
}
