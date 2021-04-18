<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class Register extends Rest_lib
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        $this->objOfJwt = new CreatorJwt();
    }

    public function index_get()
    {
        $message = array(
            'error' => array(
                'message' => 'Method Not Allowed',
            )
        );
        $this->response($message, Rest_lib::HTTP_METHOD_NOT_ALLOWED);
    }

    public function index_post()
    {

        $this->form_validation->set_rules('fname', 'First Name', 'required|strip_tags|max_length[255]|trim');
        $this->form_validation->set_rules('mname', 'Middle Name', 'required|strip_tags|max_length[255]|trim');
        $this->form_validation->set_rules('lname', 'Last Name', 'required|strip_tags|max_length[255]|trim');
        $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|is_unique[users.contact_number]|strip_tags|strip_tags|min_length[10]|max_length[40]|trim');
        $this->form_validation->set_rules('email_address', 'Email Address', 'required|is_unique[users.email_address]|strip_tags|max_length[150]|valid_email|trim');
        $this->form_validation->set_rules('pass', 'Password', 'required|strip_tags|min_length[8]|max_length[40]|trim');
        $this->form_validation->set_rules('repass', 'Retype-Password', 'required|matches[pass]|strip_tags|min_length[8]|max_length[40]|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->response(array(
                'error' => array(
                    'message' => validation_errors()
                )
            ), Rest_lib::HTTP_OK);
        } else {

            $user_data = array(
                'fname' => $this->input->post('fname'),
                'mname' => $this->input->post('mname'),
                'lname' => $this->input->post('lname'),
                'fullname' => $this->input->post('fname') . ' ' . $this->input->post('mname') . ' ' . $this->input->post('lname'),
                'contact_number' => $this->input->post('contact_number'),
                'email_address' => $this->input->post('email_address'),
                'username' => $this->input->post('email_address'),
                'password' => $this->input->post('pass'),
                'role' => "member",
                'datetime_created' => NOW,
                'status' => true,
            );

            $this->UserModel->CreateUser($user_data);

            //////////////////////////// AUDIT TRAIL ////////////////////////////

            $agent = $this->get_agent();

            $audit_data = (object) array(
                'datetime' => NOW,
                'ip' => $_SERVER['REMOTE_ADDR'],
                'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                'module' => "user",
                'action' => "create account - " . $this->input->post('email_address'),
            );

            $this->audit($audit_data);

            //////////////////////////// AUDIT TRAIL ////////////////////////////


            $this->response(array(
                'success' => array(
                    'status' => true,
                    'message' => 'Registration Successful!',
                )
            ), Rest_lib::HTTP_OK);
        }
    }

    public function index_put()
    {
        $message = array(
            'error' => array(
                'message' => 'Method Not Allowed',
            )
        );
        $this->response($message, Rest_lib::HTTP_METHOD_NOT_ALLOWED);
    }

    public function index_delete($id)
    {
        $message = array(
            'error' => array(
                'message' => 'Method Not Allowed',
            )
        );
        $this->response($message, Rest_lib::HTTP_METHOD_NOT_ALLOWED);
    }

    public function audit($data)
    {
        $audit_data = (object) array(
            'datetime' => NOW,
            'ip' => $data->ip,
            'device' => $data->device,
            'module' => $data->module,
            'action' => $data->action,
        );

        $this->AuditModel->SaveAudit($audit_data);
    }

    public function get_agent()
    {
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }

        return $agent;
    }
}
