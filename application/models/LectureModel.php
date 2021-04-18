<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LectureModel extends CI_Model
{

    public function GetLectures()
    {
        $this->db->order_by('video_id', 'desc');
        $q = $this->db->get('view_lectures');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetLecture($id)
    {
        $q = $this->db->get_where('view_lectures', array('video_id' => $id));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function GetActiveLectures()
    {
        $this->db->order_by('video_id', 'desc');
        $q = $this->db->get_where('view_lectures', array('video_status' => 1));

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetActiveLecture($id)
    {
        $q = $this->db->get_where('view_lectures', array(
            'video_status' => 1,
            'video_id' => $id
        ));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }



    public function DeleteLecture($id)
    {
        $q = $this->db->delete('lectures', array('id' => $id));
    }

    public function UpdateLecture($id, $data)
    {
        $this->db->set($data);
        $this->db->where(array('id' => $id));
        $this->db->update('lectures');
    }

    public function CreateLecture($data)
    {
        $this->db->insert('lectures', $data);
    }

    public function SearchLecture($term)
    {
        $this->db->like(array('title' => $term));
        $q = $this->db->get('lectures');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function RateLecture($data)
    {
        $this->db->insert('lecture_user_ratings', $data);
    }

    public function CheckIfRated($id, $lecture_id)
    {
        $q = $this->db->get_where('lecture_user_ratings', array(
            'user_id' => $id,
            'lecture_id' => $lecture_id,
        ));

        if ($q->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function GetLectureRatings()
    {
        $q = $this->db->get('view_lecture_ratings');

        if ($q->num_rows() > 0) {
            return $q->result();
        }

        return array();
    }
}
