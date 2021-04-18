<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class Send extends Rest_lib
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

            $this->form_validation->set_rules('subject', 'Subject', 'required|strip_tags|trim');
            $this->form_validation->set_rules('recipient', 'Recipient', 'required|strip_tags|trim|valid_email');
            $this->form_validation->set_rules('message', 'Message', 'required|trim');

            if ($this->form_validation->run() == FALSE) {
                $this->response(array(
                    'error' => array(
                        'status' => false,
                        'message' => validation_errors()
                    )
                ), Rest_lib::HTTP_OK);
            } else {

                if ($token_data->status) {

                    try {

                        $recipient = $this->input->post('recipient');
                        $subject = $this->input->post('subject');
                        $message = $this->input->post('message');

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
                            'module' => "Email",
                            'action' => "Send email - " . $this->input->post('subject') . " to " . $this->input->post('recipient'),
                        );

                        $this->audit($audit_data);

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $this->response(array(
                            'success' => array(
                                'status' => true,
                                'message' => 'Email sent successfully!',
                                'email' => $message
                            )
                        ), Rest_lib::HTTP_OK);
                    } catch (Exception $e) { // Token is invalid or tampered
                        $this->response(array(
                            'error' => array(
                                'status' => false,
                                'message' => 'Email sending failed!',
                            )
                        ), Rest_lib::HTTP_OK);
                    }
                } else {

                    $this->response(array(
                        'error' => array(
                            'status' => false,
                            'message' => 'Unauthorized access',
                        )
                    ), Rest_lib::HTTP_UNAUTHORIZED);
                }
            }
        } catch (Exception $e) { // Token is invalid or tampered
            $this->response(array(
                'error' => array(
                    'status' => false,
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

    // public function send_mail($recipient = null, $subject = null, $refcode = null)
    // {

    // }

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
}
