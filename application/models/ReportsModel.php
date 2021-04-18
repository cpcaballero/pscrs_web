<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ReportsModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        $this->load->dbutil();
    }

    public function GetLastLogin($filter, $extract = false)
    {
        $this->db->select("fullname,email_address,contact_number,role, is_expert,last_login");
        if ($filter == 'today') {
            $this->db->where(array(
                'DATE(last_login)' => date('Y-m-d', time())
            ));
        } else if ($filter == 'month') {
            $this->db->where(array(
                'MONTH(last_login)' => date('m', time()),
                'YEAR(last_login)' => date('Y', time()),
            ));
        } else if ($filter == 'year') {
            $this->db->where(array(
                'YEAR(last_login)' => date('Y', time()),
            ));
        } else {
            $this->db->where(array(
                'DATE(last_login)' => date('Y-m-d', time())
            ));
        }
        $q = $this->db->get("users");

        if ($q->num_rows() > 0) {
            if ($extract) {
                return $this->dbutil->csv_from_result($q);
            }
            else{
                return array(
                    "fields" => $q->list_fields(),
                    "result" => $q
                );
            }
        }
        return false;
    }

    public function GetFeedback($filter, $extract = false)
    {
        $this->db->order_by('id', 'DESC');
        if ($filter == 'today') {
            $this->db->where(array(
                'DATE(sent_datetime)' => date('Y-m-d', time())
            ));
        } else if ($filter == 'month') {
            $this->db->where(array(
                'MONTH(sent_datetime)' => date('m', time()),
                'YEAR(sent_datetime)' => date('Y', time()),
            ));
        } else if ($filter == 'year') {
            $this->db->where(array(
                'YEAR(sent_datetime)' => date('Y', time()),
            ));
        } else {
            $this->db->where(array(
                'DATE(sent_datetime)' => date('Y-m-d', time())
            ));
        }

        $q = $this->db->get('feedback_suggestions');
        
        if ($q->num_rows() > 0) {
            if ($extract == "csv") {
                return $this->dbutil->csv_from_result($q);
            } else {
                return array(
                    "fields" => $q->list_fields(),
                    "result" => $q
                );
            }
        }
    }

    public function GetVideos($filter, $extract = false)
    {
        $this->db->order_by('video_id', 'DESC');
        if ($filter == 'today') {
            $this->db->where(array(
                'DATE(video_date_created)' => date('Y-m-d', time())
            ));
        } else if ($filter == 'month') {
            $this->db->where(array(
                'MONTH(video_date_created)' => date('m', time()),
                'YEAR(video_date_created)' => date('Y', time()),
            ));
        } else if ($filter == 'year') {
            $this->db->where(array(
                'YEAR(video_date_created)' => date('Y', time()),
            ));
        } else {
            $this->db->where(array(
                'DATE(video_date_created)' => date('Y-m-d', time())
            ));
        }

        $q = $this->db->get('view_surgical_videos');

        if ($q->num_rows() > 0) {
            if ($extract) {
                return $this->dbutil->csv_from_result($q);
            }
            else{
                return array(
                    "fields" => $q->list_fields(),
                    "result" => $q
                );
            }
        }
        return false;
    }

    public function GetLectures($filter, $extract = false)
    {
        $this->db->order_by('id', 'DESC');
        if ($filter == 'today') {
            $this->db->where(array(
                'DATE(datetime_created)' => date('Y-m-d', time())
            ));
        } else if ($filter == 'month') {
            $this->db->where(array(
                'MONTH(datetime_created)' => date('m', time()),
                'YEAR(datetime_created)' => date('Y', time()),
            ));
        } else if ($filter == 'year') {
            $this->db->where(array(
                'YEAR(datetime_created)' => date('Y', time()),
            ));
        } else {
            $this->db->where(array(
                'DATE(datetime_created)' => date('Y-m-d', time())
            ));
        }

        $q = $this->db->get('lectures');

        if ($q->num_rows() > 0) {
            if ($extract) {
                return $this->dbutil->csv_from_result($q);
            }
            else{
                return array(
                    "fields" => $q->list_fields(),
                    "result" => $q
                );
            }
        }
        return false;
    }

    public function GetNews($filter, $extract = false)
    {
        if ($filter == 'today') {
            $this->db->where(array(
                'DATE(datetime_created)' => date('Y-m-d', time())
            ));
        } else if ($filter == 'month') {
            $this->db->where(array(
                'MONTH(datetime_created)' => date('m', time()),
                'YEAR(datetime_created)' => date('Y', time()),
            ));
        } else if ($filter == 'year') {
            $this->db->where(array(
                'YEAR(datetime_created)' => date('Y', time()),
            ));
        } else {
            $this->db->where(array(
                'DATE(datetime_created)' => date('Y-m-d', time())
            ));
        }

        $q = $this->db->get('view_news');

        if ($q->num_rows() > 0) {
            if ($extract) {
                return $this->dbutil->csv_from_result($q);
            }
            else{
                return array(
                    "fields" => $q->list_fields(),
                    "result" => $q
                );
            }
        }
        return false;
    }

    public function GetProducts($filter, $extract = false)
    {
        $this->db->order_by('product_id', 'DESC');
        if ($filter == 'today') {
            $this->db->where(array(
                'DATE(product_datetime_created)' => date('Y-m-d', time())
            ));
        } else if ($filter == 'month') {
            $this->db->where(array(
                'MONTH(product_datetime_created)' => date('m', time()),
                'YEAR(product_datetime_created)' => date('Y', time()),
            ));
        } else if ($filter == 'year') {
            $this->db->where(array(
                'YEAR(product_datetime_created)' => date('Y', time()),
            ));
        } else {
            $this->db->where(array(
                'DATE(product_datetime_created)' => date('Y-m-d', time())
            ));
        }

        $q = $this->db->get('view_products');
        if ($q->num_rows() > 0) {
            if ($extract) {
                return $this->dbutil->csv_from_result($q);
            }
            else{
                return array(
                    "fields" => $q->list_fields(),
                    "result" => $q
                );
            }
        }
        return false;
    }

    public function GetBilling($filter, $extract = false)
    {
        $this->db->order_by('datetime_ordered', 'DESC');
        if ($filter == 'today') {
            $this->db->where(array(
                'DATE(datetime_ordered)' => date('Y-m-d', time())
            ));
        } else if ($filter == 'month') {
            $this->db->where(array(
                'MONTH(datetime_ordered)' => date('m', time()),
                'YEAR(datetime_ordered)' => date('Y', time()),
            ));
        } else if ($filter == 'year') {
            $this->db->where(array(
                'YEAR(datetime_ordered)' => date('Y', time()),
            ));
        } else {
            $this->db->where(array(
                'DATE(datetime_ordered)' => date('Y-m-d', time())
            ));
        }

        $q = $this->db->get('view_billing');

        if ($q->num_rows() > 0) {
            if ($extract) {
                return $this->dbutil->csv_from_result($q);
            }
            else{
                return array(
                    "fields" => $q->list_fields(),
                    "result" => $q
                );
            }
        }
        return false;
    }

    public function GetExpertConvos($filter, $extract = false)
    {
        $where_string = '';
        if ($filter == 'today') {
            $where_string .= "DATE(msg_date) = '" .  date('Y-m-d', time()) . "'";
        } else if ($filter == 'month') {
            $where_string .= "MONTH(msg_date) = '" . date('m', time()) . "' AND YEAR(msg_date) = '" . date('Y', time()) . "'";
        } else if ($filter == 'year') {
            $where_string .= "YEAR(msg_date) = '" . date('Y',  time()) . "'";
        } else {
            $where_string .= "DATE(msg_date) = '" . date('Y-m-d', time()) . "'";
        }
        $q = $this->db->query("SELECT * FROM view_expert_messaging vem WHERE " . $where_string . "AND msg_date in (SELECT MAX(msg_date) from view_expert_messaging where vem.convo_id = view_expert_messaging.convo_id) GROUP BY convo_id HAVING MAX(msg_date) ORDER BY msg_date DESC");
        // SELECT * FROM view_expert_messaging vem WHERE YEAR(msg_date) = '2021' AND msg_date in (SELECT MAX(msg_date) from view_expert_messaging where vem.convo_id = view_expert_messaging.convo_id) GROUP BY convo_id HAVING MAX(msg_date) ORDER BY msg_date DESC
 
        if ($q->num_rows() > 0) {
            if ($extract) {
                return $this->dbutil->csv_from_result($q);
            }
            else{
                return array(
                    "fields" => $q->list_fields(),
                    "result" => $q
                );
            }
        }
        return false;
    }
}
