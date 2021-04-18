<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthModel extends CI_Model
{

    public function Login($credentials)
    {
        $q = $this->db->get_where('users', $credentials);

        if ($q->num_rows() > 0) {
            $this->db->set(array(
                'last_login' => NOW
            ));
            $this->db->where($credentials);
            $this->db->update('users');
            return $q->row();
        }
        return false;
    }

    public function ChangePassword($email, $new_pass)
    {
        $this->db->set(array(
            'password' => $new_pass,
            'datetime_modified' => date('Y-m-d H:i:s')
        ));
        $this->db->where(array('email_address' => $email));
        $this->db->update('users');
    }

    public function CheckEmail($email)
    {
        $q = $this->db->get_where('users', array('email_address' => $email));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
}
