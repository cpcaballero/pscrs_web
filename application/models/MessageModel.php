<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MessageModel extends CI_Model
{
    public function GetUserMessages($sender, $recipient)
    {
        $this->db->where(array(
            'user_id' => $sender,
            'recipient_id' => $recipient
        ));

        $this->db->or_where(array(
            'user_id' => $recipient,
            'recipient_id' => $sender
        ));
        $q = $this->db->get('messaging');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function SendMessage($data)
    {
        $this->db->insert('messaging', $data);
    }

    public function GetMessages($convo_id)
    {
        $this->db->order_by('msg_id','ASC');
        $q = $this->db->get_where('view_expert_messaging', array(
            'convo_id' => $convo_id
        ));

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetConversations($receiver)
    {
        $this->db->distinct();
        $this->db->select('convo_id,sender_id,sender_name,sender_email,sender_contact,receiver_id');
        $q = $this->db->get_where('view_expert_messaging', array(
            'receiver_id' => $receiver
        ));

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    /** MARKETPLACE */

    public function MP_GetUserMessages($sender, $recipient)
    {
        $this->db->where(array(
            'user_id' => $sender,
            'recipient_id' => $recipient
        ));

        $this->db->or_where(array(
            'user_id' => $recipient,
            'recipient_id' => $sender
        ));
        $q = $this->db->get('marketplace_messaging');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function MP_SendMessage($data)
    {
        $this->db->insert('marketplace_messaging', $data);
    }

    public function MP_GetMessages($id, $id2)
    {
        $or_array = array($id."_".$id2, $id2."_".$id);
        $this->db->order_by('msg_id','ASC');
        $this->db->or_where_in('convo_id', $or_array);
        $q = $this->db->get('view_marketplace_messaging');
        // var_dump($this->db->last_query());

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function MP_GetConversations($receiver)
    {
        $this->db->distinct();
        $this->db->select('convo_id,sender_id,sender_name,sender_email,sender_contact,receiver_id');
        $q = $this->db->get_where('view_marketplace_messaging', array(
            'receiver_id' => $receiver
        ));

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }
}
