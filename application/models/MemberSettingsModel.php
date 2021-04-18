<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MemberSettingsModel extends CI_Model
{

    public function GetSettings()
    {
        $q = $this->db->get('member_settings');

        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return false;
    }

    public function GetSetting($id)
    {
        $q = $this->db->get_where('member_settings', array('id' => $id));

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    ///////////////////// FAQS /////////////////////

    public function CreateFaqs($faqs)
    {

        $action = '';
        if (!$this->GetSetting(1)) {
            $data = array(
                'faq' => $faqs,
                'faq_datetime_created' => NOW,
            );

            $action = 'create';

            $this->db->insert('member_settings', $data);
        } else {

            if ($this->GetSetting(1)->faq_datetime_created != "0000-00-00 00:00:00") {
                $data = array(
                    'faq' => $faqs,
                    'faq_datetime_modified' => NOW,
                );
                $action = 'update';
            } else {
                $data = array(
                    'faq' => $faqs,
                    'faq_datetime_created' => NOW,
                );
                $action = 'create';
            }

            $this->db->set($data);
            $this->db->where(array('id' => 1));
            $this->db->update('member_settings');
        }
        return $action;
    }

    public function DeleteFaqs($id, $data)
    {
        if ($this->GetSetting(1)) {
            $this->db->set($data);
            $this->db->where(array('id' => $id));
            $this->db->update('member_settings');
        }
    }

    ///////////////////// FAQS /////////////////////

    ///////////////////// TERMS ////////////////////

    public function CreateTerms($faqs)
    {
        $action = '';
        if (!$this->GetSetting(1)) {
            $data = array(
                'terms_condition' => $faqs,
                'terms_datetime_created' => NOW,
            );

            $action = 'create';
            $this->db->insert('member_settings', $data);
        } else {

            if ($this->GetSetting(1)->terms_datetime_created != "0000-00-00 00:00:00") {
                $data = array(
                    'terms_conditions' => $faqs,
                    'terms_datetime_modified' => NOW,
                );
                $action = 'update';
            } else {
                $data = array(
                    'terms_conditions' => $faqs,
                    'terms_datetime_created' => NOW,
                );
                $action = 'create';
            }

            $this->db->set($data);
            $this->db->where(array('id' => 1));
            $this->db->update('member_settings');
        }
        return $action;
    }

    public function DeleteTerms($id, $data)
    {
        if ($this->GetSetting(1)) {
            $this->db->set($data);
            $this->db->where(array('id' => $id));
            $this->db->update('member_settings');
        }
    }

    ///////////////////// TERMS ////////////////////

    ///////////////////// POLICIES ///////////////////

    public function CreatePrivacy($faqs)
    {
        $action = '';
        if (!$this->GetSetting(1)) {
            $data = array(
                'data_privacy' => $faqs,
                'dp_datetime_created' => NOW,
            );

            $action = 'create';
            $this->db->insert('member_settings', $data);
        } else {

            if ($this->GetSetting(1)->dp_datetime_created != "0000-00-00 00:00:00") {
                $data = array(
                    'data_privacy' => $faqs,
                    'dp_datetime_modified' => NOW,
                );
                $action = 'update';
            } else {
                $data = array(
                    'data_privacy' => $faqs,
                    'dp_datetime_created' => NOW,
                );
                $action = 'create';
            }

            $this->db->set($data);
            $this->db->where(array('id' => 1));
            $this->db->update('member_settings');
        }
        return $action;
    }

    public function DeletePrivacy($id, $data)
    {
        if ($this->GetSetting(1)) {
            $this->db->set($data);
            $this->db->where(array('id' => $id));
            $this->db->update('member_settings');
        }
    }

    ///////////////////// PRIVACY ///////////////////
}
