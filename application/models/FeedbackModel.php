<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FeedbackModel extends CI_Model
{

    public function GetFeedbacks()
    {
        $q = $this->db->get('feedback_suggestions');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetFeedback($id)
    {
        $q = $this->db->get_where('feedback_suggestions', array('id' => $id));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function DeleteFeedback($id)
    {
        $q = $this->db->delete('feedback_suggestions', array('id' => $id));
    }

    public function UpdateFeedback($id, $data)
    {
        $this->db->set($data);
        $this->db->where(array('id' => $id));
        $this->db->update('feedback_suggestions');
    }

    public function CreateFeedback($data)
    {
        $this->db->insert('feedback_suggestions', $data);
    }

    public function SearchFeedback($term)
    {
        $this->db->like(array('title' => $term));
        $q = $this->db->get('feedback_suggestions');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    
}
