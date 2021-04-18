<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class Change extends Rest_lib
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
        $token = null;
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', trim($headers['Authorization']));
        }

        try {
            $token_data = (object) $this->objOfJwt->DecodeToken($token);

            $existing_account = $this->UserModel->GetUser($this->input->post('id'));

            if ($existing_account) {

                $this->form_validation->set_error_delimiters('', '');
                $this->form_validation->set_rules('active_user', 'Active Account', 'required|strip_tags|trim');
                $this->form_validation->set_rules('id', 'Account', 'required|strip_tags|trim');
                $this->form_validation->set_rules('pass', 'Password', 'required|strip_tags|min_length[8]|max_length[40]|trim');
                $this->form_validation->set_rules('repass', 'Retype Password', 'required|strip_tags|min_length[8]|max_length[40]|trim|matches[pass]');

                if ($this->form_validation->run() == FALSE) {
                    $this->response(array(
                        'error' => array(
                            'message' => validation_errors()
                        )
                    ), Rest_lib::HTTP_OK);
                } else {

                    if ($token_data->status) {

                        $user_data = array(
                            'password' => $this->input->post('pass'),
                            'datetime_modified' => NOW,
                            'modified_by' => $this->input->post('active_user'),
                        );

                        $this->UserModel->ChangePass($this->input->post('id'), $user_data);

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $agent = $this->get_agent();

                        $audit_data = (object) array(
                            'datetime' => NOW,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                            'module' => "user",
                            'action' => "Change password - email " . $existing_account->email_address,
                        );

                        $this->audit($audit_data);

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $this->response(array(
                            'success' => array(
                                'status' => true,
                                'message' => 'Password changed successfully!',
                            )
                        ), Rest_lib::HTTP_OK);
                    } else {

                        $this->response(array(
                            'success' => array(
                                'status' => true,
                                'message' => 'Unauthorized access',
                            )
                        ), Rest_lib::HTTP_UNAUTHORIZED);
                    }
                }
            } else {
                $message = array(
                    'error' => array(
                        'message' => 'No records found!',
                        'data' => ''
                    )
                );
                $this->response($message, Rest_lib::HTTP_OK);
            }
        } catch (Exception $e) { // Token is invalid or tampered
            $this->response(array(
                'error' => array(
                    'message' => 'Invalid Token',
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

    public function index_delete()
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
