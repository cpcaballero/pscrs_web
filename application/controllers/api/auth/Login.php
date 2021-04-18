<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class Login extends Rest_lib
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
                'status' => false,
                'message' => 'Method Not Allowed',
            ),
        );
        $this->response($message, Rest_lib::HTTP_METHOD_NOT_ALLOWED);
    }

    public function index_post()
    {
        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('username', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');

        if ($this->form_validation->run() == FALSE) {
            $message = array(
                'error' => array(
                    'status' => false,
                    'message' => validation_errors()
                )
            );
            $this->response($message, Rest_lib::HTTP_OK);
        } else {

            $account = $this->AuthModel->login($this->input->post());

            if ($account) {
                if ($account->status) {
                    $token_data = array(
                        'email' => $account->email_address,
                        'fullname' => $account->fullname,
                        'role' => $account->role,
                        'status' => $account->status,
                    );

                    $user = array(
                        'token' => $this->objOfJwt->GenerateToken($token_data),
                        'details' => array(
                            'id' => $account->id,
                            'firstname' => $account->fname,
                            'middlename' => $account->mname,
                            'lastname' => $account->lname,
                            'fullname' => $account->fullname,
                            'contact_number' => $account->contact_number,
                            'email' => $account->email_address,
                            'role' => $account->role,
                            'created_at' => $account->datetime_created,
                            'status' => $account->status,
                            'is_expert' => $account->is_expert,
                        )
                    );

                    $this->session->set_userdata('account', $user);

                    //////////////////////////// AUDIT TRAIL ////////////////////////////

                    $agent = $this->get_agent();

                    $audit_data = (object) array(
                        'datetime' => NOW,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                        'module' => "auth",
                        'action' => $account->role . " logged in - ID: " . $account->id,
                    );

                    $this->audit($audit_data);

                    //////////////////////////// AUDIT TRAIL ////////////////////////////

                    $message = array(
                        'success' => array(
                            'message' => 'Login successful!',
                            'status' => true,
                            'data' => $user
                        )
                    );

                    $this->response($message, Rest_lib::HTTP_OK);
                } else {
                    $message = array(
                        'error' => array(
                            'message' => 'Account is blocked!',
                            'status' => false
                        )
                    );
                    $this->response($message, Rest_lib::HTTP_OK);
                }
            } else {

                $message = array(
                    'error' => array(
                        'status' => false,
                        'message' => 'Username/Password is incorrect!',
                    )
                );
                $this->response($message, Rest_lib::HTTP_OK);
            }
        }
    }

    public function index_put()
    {
        $message = array(
            'error' => array(
                'status' => false,
                'message' => 'Method Not Allowed',
            ),
        );
        $this->response($message, Rest_lib::HTTP_METHOD_NOT_ALLOWED);
    }

    public function index_delete()
    {
        $message = array(
            'error' => array(
                'status' => false,
                'message' => 'Method Not Allowed',
            ),
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
