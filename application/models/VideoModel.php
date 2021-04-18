<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VideoModel extends CI_Model
{

    public function GetVideos()
    {
        $this->db->order_by('video_id', 'DESC');
        $q = $this->db->get('view_surgical_videos');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetActiveVideo($id)
    {
        $q = $this->db->get_where('view_surgical_videos', array(
            'video_status' => 1,
            'video_id' => $id
        ));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function GetActiveVideos()
    {
        $this->db->order_by('video_id', 'DESC');
        $q = $this->db->get_where('view_surgical_videos', array('video_status' => 1));

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetVideo($id)
    {
        $q = $this->db->get_where('view_surgical_videos', array('video_id' => $id));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function DeleteVideo($id)
    {
        $q = $this->db->delete('surgical_videos', array('id' => $id));
    }

    public function UpdateVideo($id, $data)
    {
        $this->db->set($data);
        $this->db->where(array('id' => $id));
        $this->db->update('surgical_videos');
    }

    public function CreateVideo($data)
    {
        $this->db->insert('surgical_videos', $data);
    }

    public function SearchVideo($term)
    {
        $this->db->like(array('title' => $term));
        $q = $this->db->get('surgical_videos');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function RateVideo($data)
    {
        $this->db->insert('surgical_user_ratings', $data);
    }

    public function CheckIfRated($id, $video_id)
    {
        $q = $this->db->get_where('surgical_user_ratings', array(
            'user_id' => $id,
            'surgical_id' => $video_id,
        ));

        if ($q->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function GetVideoRatings()
    {
        $q = $this->db->get('view_surgical_ratings');

        if ($q->num_rows() > 0) {
            return $q->result();
        }

        return array();
    }
}
