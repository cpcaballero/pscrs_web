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
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('token', 'Token', 'required|strip_tags');
        $this->form_validation->set_rules('old_pass', 'Old Password', 'required|strip_tags|min_length[6]|max_length[30]');
        $this->form_validation->set_rules('new_pass', 'New Password', 'required|strip_tags|min_length[6]|max_length[30]');
        $this->form_validation->set_rules('retype_pass', 'Retype Password', 'required|strip_tags|min_length[6]|max_length[30]|matches[new_pass]');

        if ($this->form_validation->run() == FALSE) {
            $message = array(
                'error' => array(
                    'message' => validation_errors()
                )
            );
            $this->response($message, Rest_lib::HTTP_OK);
        } else {

            try {
                $old_token = $this->input->post('token');
                $decoded_token = (object) $this->objOfJwt->DecodeToken($old_token);

                $user = array(
                    'username' => $decoded_token->email,
                    'password' => $this->input->post('old_pass'),
                );

                $account = $this->AuthModel->login($user);  // check if account exists

                if ($account) { // if account exists

                    if ($account->status) { // check if account is blocked/allowed
                        $token_data = array(
                            'email' => $account->email_address,
                            'fullname' => $account->fullname,
                            'role' => $account->role,
                            'status' => $account->status,
                        );

                        $new_token = $this->objOfJwt->GenerateToken($token_data);

                        $account_details = array(
                            'token' => $new_token,
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

                        $this->session->set_userdata('account', $account_details);  // set updated session data

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $agent = $this->get_agent();

                        $audit_data = (object) array(
                            'datetime' => NOW,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                            'module' => "auth",
                            'action' => $account->role . " change password - ID: " . $account->id,
                        );

                        $this->audit($audit_data);

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $this->AuthModel->ChangePassword($decoded_token->email, $this->input->post('new_pass')); // Change Password

                        $this->response(array(
                            'success' => array(
                                'message' => 'Password changed successfully',
                                'token' => $this->objOfJwt->GenerateToken($token_data) // set the new token data for mobile auth
                            )
                        ), Rest_lib::HTTP_OK);
                    } else { // Account is blocked

                        $this->session->sess_destroy();

                        $this->response(array(
                            'error' => array(
                                'message' => 'You\'re account is blocked. Please contact your administrator for more details.',
                                'action' => 'reset'
                            )
                        ), Rest_lib::HTTP_UNAUTHORIZED);
                    }
                } else { // Account doesn't exist

                    $this->response(array(
                        'error' => array(
                            'message' => 'Incorrect Old Password',
                        )
                    ), Rest_lib::HTTP_OK);
                }
            } catch (Exception $e) { // Token is invalid or tampered
                $this->response(array(
                    'error' => array(
                        'message' => 'Invalid Token',
                    )
                ), Rest_lib::HTTP_OK);
            }
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
