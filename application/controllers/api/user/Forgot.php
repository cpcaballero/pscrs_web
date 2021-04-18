<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class Forgot extends Rest_lib
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        $this->objOfJwt = new CreatorJwt();
    }

    public function index_get($token = null)
    {
        try {
            // check if token is not null
            if ($token != null) {

                // get request details
                $request = $this->UserModel->CheckLink($token);

                if ($request) {
                    // get accout details 
                    $account = $this->UserModel->GetUserbyEmail($request->trans_email);

                    // check if token is expired or used
                    if (!$request->trans_status || strtotime($request->trans_expire) <= time()) {

                        // use link
                        $this->UserModel->UseLink($request);

                        // // generate temp password
                        $temp_pass = $this->generate_token();


                        // // save new password
                        $this->UserModel->ChangePass($account->id, array(
                            'password' => $temp_pass
                        ));

                        $recipient = $request->trans_email;
                        $subject = "PSCRS Online - Password Recovery";
                        $message =
                            '
                            <p>Hi ' . $account->fname . '<p>
                            <br>
                            <p>PSCRS Online password reset successful.</p>
                            <br>
                            
                            <p>Here is your new TEMPORARY PASSWORD: ' . $temp_pass . '.</p>
                            
                            <br>
                            <p>Please change your password immediately after this.</p>
                            <p>If you did not request a password reset please ignore this email or reply to let us know.</p>
                        ';

                        $message = $this->email_template($message);
                        $config['protocol'] = 'smtp';
                        $config['smtp_crypto'] = 'tls';
                        $config['smtp_host'] = 'smtp.gmail.com';
                        $config['smtp_port'] = '587';
                        $config['smtp_user'] = 'pscrsonline@gmail.com';
                        $config['smtp_pass'] = 'pscrsonline1234';
                        $config['mailtype'] = 'html';
                        $config['newline'] = "\r\n";

                        $this->email->initialize($config);
                        $this->email->from('pscrsonline@gmail.com', 'PSCRS Online');
                        $this->email->to($recipient);

                        $this->email->subject($subject);
                        $this->email->message($message);
                        $this->email->send();

                        $message = array(
                            'success' => array(
                                'status' => true,
                                'message' => 'Check your email for your new temporary password',
                            )
                        );

                        $this->response($message, Rest_lib::HTTP_OK);
                    } else {
                        $message = array(
                            'error' => array(
                                'status' => false,
                                'message' => 'Link is either expired or used already.',
                            )
                        );
                        $this->response($message, Rest_lib::HTTP_OK);
                        unset($_SESSION);
                    }
                } else {
                    $message = array(
                        'error' => array(
                            'status' => false,
                            'message' => 'Link is either expired or used already.',
                        )
                    );
                    $this->response($message, Rest_lib::HTTP_OK);
                    unset($_SESSION);
                }
            } else {
                $message = array(
                    'error' => array(
                        'status' => false,
                        'message' => 'Invalid Request',
                    )
                );
                $this->response($message, Rest_lib::HTTP_OK);
                unset($_SESSION);
            }
        } catch (Exception $e) { // Token is invalid or tampered
            $this->response(array(
                'error' => array(
                    'status' => false,
                    'message' => 'Invalid Token',
                )
            ), Rest_lib::HTTP_OK);
            unset($_SESSION);
        }
    }

    public function index_post()
    {

        $this->form_validation->set_error_delimiters('<p>', '</p>');
        $this->form_validation->set_rules('email', 'Email Address', 'required|strip_tags|trim|valid_email');

        // Check if email is sent
        if ($this->form_validation->run() == FALSE) {
            $this->response(array(
                'error' => array(
                    'status' => false,
                    'message' => validation_errors()
                )
            ), Rest_lib::HTTP_OK);
        } else {


            $existing_account = $this->UserModel->GetUserByEmail($this->input->post('email'));

            // Check if account exists
            if ($existing_account) {

                $token = $this->generate_token();
                $expiry = strtotime(NOW) + 86400; // one day
                $user_data = array(
                    'trans_email' => $this->input->post('email'),
                    'trans_date' => NOW,
                    'trans_token' => $token,
                    'trans_expire' => date('Y-m-d H:i:s', $expiry),
                    'trans_status' => 0,
                );

                // save password reset request
                // NOTE: every time you send a request all the other requests sent by you will be voided. Only the latest link can be used to reset your password.

                $this->UserModel->RequestReset($user_data);

                // password reset link
                $link = base_url() . 'Forgot/' . $token;

                $this->session->set_userdata('temp_details', array('id' => $existing_account->id));

                $recipient = $existing_account->email_address;
                $subject = "PSCRS Online - Password Recovery";
                $message =
                    '
                <p>Hi ' . $existing_account->fname . '<p>
                <br>
                <p>You recently requested to reset your password for your PSCRS Online account.</p>
                <br>
                
                <p>Enter this code: <strong>' . $token . '</strong> to proceed with your request.</p>
                
                <br>
                <p>If you did not request a password reset please ignore this email or reply to let us know.</p>
            ';

                $message = $this->email_template($message);
                $config['protocol'] = 'smtp';
                $config['smtp_crypto'] = 'tls';
                $config['smtp_host'] = 'smtp.gmail.com';
                $config['smtp_port'] = '587';
                $config['smtp_user'] = 'pscrsonline@gmail.com';
                $config['smtp_pass'] = 'pscrsonline1234';
                $config['mailtype'] = 'html';
                $config['newline'] = "\r\n";

                $this->email->initialize($config);
                $this->email->from('pscrsonline@gmail.com', 'PSCRS Online');
                $this->email->to($recipient);

                $this->email->subject($subject);
                $this->email->message($message);
                $this->email->send();

                //////////////////////////// AUDIT TRAIL ////////////////////////////

                $agent = $this->get_agent();

                $audit_data = (object) array(
                    'datetime' => NOW,
                    'ip' => $_SERVER['REMOTE_ADDR'],
                    'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                    'module' => "user",
                    'action' => "Forgot password - email " . $existing_account->email_address,
                );

                $this->audit($audit_data);

                //////////////////////////// AUDIT TRAIL ////////////////////////////

                $this->response(array(
                    'success' => array(
                        'status' => true,
                        'message' => 'Link verified.',
                        'link' => $link
                    )
                ), Rest_lib::HTTP_OK);
            } else {
                $message = array(
                    'error' => array(
                        'status' => false,
                        'message' => 'Invalid Email Address!',
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

    public function generate_token()
    {
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $request_token = substr(str_shuffle($permitted_chars), 0, 6);
        if ($this->UserModel->check_if_token_unique($request_token)) {
            $this->generate_token();
        }

        return $request_token;
    }

    public function email_template($message)
    {
        $template = '
        <!DOCTYPE html>

        <html lang="en">

        <body style="background-color:white;">
        ' . $message . '
        </body>

        </html>
        ';

        return $template;
    }

    public function dd($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
    }
}
