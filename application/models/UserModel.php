<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends CI_Model
{

    public function GetUsers()
    {
        $q = $this->db->where('role!=', 'superadmin')->get('users');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetUser($id)
    {
        $q = $this->db->get_where('users', array('id' => $id));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function GetUserbyEmail($email)
    {
        $q = $this->db->get_where('users', array('email_address' => $email));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function DeleteUser($id)
    {
        $q = $this->db->delete('users', array('id' => $id));
    }

    public function UpdateUser($id, $data)
    {
        $this->db->set($data);
        $this->db->where(array('id' => $id));
        $this->db->update('users');
    }

    public function ChangePass($id, $data)
    {
        $this->db->set($data);
        $this->db->where(array('id' => $id));
        $this->db->update('users');
    }

    public function CreateUser($data)
    {
        $this->db->insert('users', $data);
    }

    public function BlockUser($id)
    {
        $this->db->set(array('status' => 0));
        $this->db->where(array('id' => $id));
        $this->db->update('users');
    }

    public function AllowUser($id)
    {
        $this->db->set(array('status' => 1));
        $this->db->where(array('id' => $id));
        $this->db->update('users');
    }

    // FORGOT PASSWORD ///////////////////////////////

    public function check_if_token_unique($token)
    {
        $this->db->select('trans_token');
        $this->db->where(array(
            'trans_token' => $token,
            'trans_expire >=' => NOW,
            'trans_status' => 0
        ));
        $q = $this->db->get('forgot_password');
        if ($q->num_rows() > 0) {
            return true;
        }
        return false;
    }

    public function RequestReset($data)
    {
        // set all previous links to USED
        $this->db->set(array(
            'trans_status' => 1,
        ));
        $this->db->where(array('trans_email' => $data['trans_email']));
        $this->db->update('forgot_password');

        // insert latest
        $this->db->insert('forgot_password', $data);
    }

    public function UseLink($data)
    {
        $this->db->set(array(
            'trans_status' => 1,
            'trans_use_date' => NOW,
        ));
        $this->db->where(array(
            'trans_email' => $data->trans_email,
            'trans_date' => $data->trans_date
        ));
        $this->db->update('forgot_password');
    }

    public function CheckLink($token)
    {
        $this->db->where(array(
            'trans_token' => $token,
            'trans_status' => 0
        ));
        $q = $this->db->get('forgot_password');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    // FORGOT PASSWORD ///////////////////////////////

    // EXPERT STATUS /////////////////////////////////

    public function ExpertStatus($id)
    {

        $user = $this->GetUser($id);
        $this->db->set(array('is_expert' => !$user->is_expert));
        $this->db->where(array('id' => $id));
        $this->db->update('users');
    }

    // EXPERT STATUS /////////////////////////////////
}
