<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NewsModel extends CI_Model
{

    public function GetNews()
    {
        $q = $this->db->get('view_news');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetNewsArticle($id)
    {
        $q = $this->db->get_where('view_news', array('news_id' => $id));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function DeleteNews($id)
    {
        $q = $this->db->delete('news', array('id' => $id));
    }

    public function UpdateNews($id, $data)
    {
        $this->db->set($data);
        $this->db->where(array('id' => $id));
        $this->db->update('news');
    }

    public function CreateNews($data)
    {
        $this->db->insert('news', $data);
    }

    public function GetActiveNews()
    {
        $this->db->order_by('news_id', 'desc');
        $q = $this->db->get_where('view_news', array('status' => 1));

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetActiveNewsArticle($id)
    {
        $q = $this->db->get_where('view_news', array(
            'status' => 1,
            'news_id' => $id
        ));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }




    public function SearchNews($term)
    {
        $this->db->like(array('title' => $term));
        $q = $this->db->get('news');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function RateNews($data)
    {
        $this->db->insert('news_user_ratings', $data);
    }

    public function CheckIfRated($id, $news_id)
    {
        $q = $this->db->get_where('news_user_ratings', array(
            'user_id' => $id,
            'news_id' => $news_id,
        ));

        if ($q->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function GetNewsRatings()
    {
        $q = $this->db->get('view_news_ratings');

        if ($q->num_rows() > 0) {
            return $q->result();
        }

        return array();
    }
}
