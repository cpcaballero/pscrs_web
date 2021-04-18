<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CalendarModel extends CI_Model
{

    public function GetCalendar()
    {
        $this->db->order_by('id', 'desc');
        $q = $this->db->get('calendar');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetCalendarEvent($id)
    {

        $q = $this->db->get_where('calendar', array('id' => $id));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function DeleteEvent($id)
    {
        $q = $this->db->delete('calendar', array('id' => $id));
    }

    public function UpdateEvent($id, $data)
    {
        $this->db->set($data);
        $this->db->where(array('id' => $id));
        $this->db->update('calendar');
    }

    public function CreateEvent($data)
    {
        $this->db->insert('calendar', $data);
    }
}
