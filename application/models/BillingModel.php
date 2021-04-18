<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BillingModel extends CI_Model
{

    public function GetBillings()
    {
        $this->db->order_by('id', 'DESC');
        $q = $this->db->get('view_billing');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetUserBilling($id)
    {
        $q = $this->db->get_where('view_billing', array('buyer_id' => $id));

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetSellerBilling($id)
    {
        $q = $this->db->get_where('view_billing', array('seller_id' => $id));

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetBilling($id)
    {
        $q = $this->db->get_where('view_billing', array('id' => $id));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function SellerUpdateBilling($data, $id){
        $q = $this->db->set($data)
            ->where(array('id' => $id))
            ->update('marketplace_transactions');
    }
}
