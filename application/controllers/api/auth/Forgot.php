<?php
require APPPATH . 'libraries/Rest_lib.php';
class Forgot extends Rest_lib
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
    }

    public function index_get()
    {
        $message = array(
            'error' => 'error',
            'message' => 'Method Not Allowed',
        );

        $this->response($message, Rest_lib::HTTP_METHOD_NOT_ALLOWED);
    }

    public function index_post()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('email', 'Email', 'required');

        if ($this->form_validation->run() == FALSE) {
            $message = array(
                'error' => array(
                    'message' => validation_errors()
                )
            );
            $this->response($message, Rest_lib::HTTP_OK);
        } else {
            $account = $this->AuthModel->CheckEmail($this->input->post('email'));

            if ($account) {
                try {

                    $numbers = substr(str_shuffle('0123456789'), 0, 4);
                    $small = substr(str_shuffle('abcdefghijklmnopqrstuvwxyz'), 0, 2);
                    $capital = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 2);

                    $code = str_shuffle($numbers . $small . $capital);

                    $recipient = $this->input->post('email');
                    $subject = "PSCRS Online - Password Recovery";
                    $message =
                        '
                        <p>Hi ' . $account->fname . '<p>
                        <br>
                        <p>You recently requested to reset your password for your PSCRS Online account.</p>
                        <br>
                        
                        <p>Enter this code <strong>' . $code . '</strong> to :' . base_url("Login_FE/entersecuritycode") . ' to proceed with your request.</p>
                        
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
                        'module' => "Email",
                        'action' => "Send email - " . $this->input->post('subject') . " to " . $this->input->post('recipient'),
                    );

                    $this->audit($audit_data);

                    $forgot_details = array(
                        'trans_email' => '',
                        'trans_date' => '',
                        'trans_token' => '',
                        'trans_expire' => '',
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
                $message = array(
                    'error' => array(
                        'message' => "Invalid Account"
                    )
                );
                $this->response($message, Rest_lib::HTTP_OK);
            }
        }
    }

    public function index_put()
    {
        $message = array(
            'error' => 'error',
            'message' => 'Method Not Allowed',
        );
        $this->response($message, Rest_lib::HTTP_METHOD_NOT_ALLOWED);
    }

    public function index_delete()
    {
        $message = array(
            'error' => 'error',
            'message' => 'Method Not Allowed',
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
