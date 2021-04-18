<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NotificationModel extends CI_Model
{

    public function GetNotifications()
    {
        $this->db->order_by('id', 'DESC');
        $q = $this->db->get('notifications');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetNotification($id)
    {
        $q = $this->db->get_where('notifications', array('id' => $id));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function DeleteNotification($id)
    {
        $q = $this->db->delete('notifications', array('id' => $id));
    }

    public function UpdateNotification($id, $data)
    {
        $this->db->set($data);
        $this->db->where(array('id' => $id));
        $this->db->update('notifications');
    }

    public function CreateNotification($data)
    {
        $this->db->insert('notifications', $data);
    }

    public function SearchNotification($term)
    {
        $this->db->like(array('title' => $term));
        $q = $this->db->get('notifications');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }
}
