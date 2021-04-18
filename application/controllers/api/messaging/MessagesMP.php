<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class MessagesMP extends Rest_lib
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        $this->objOfJwt = new CreatorJwt();
    }

    public function index_get($convo_id)
    {
        $token = null;
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', trim($headers['Authorization']));
        }

        try {
            $token_data = (object) $this->objOfJwt->DecodeToken($token);

            if ($token_data->status) {

                if ($this->MessageModel->MP_GetMessages($convo_id)) {
                    $message = array(
                        'success' => array(
                            'message' => 'Record/s fetched successfully!',
                            'data' => $this->MessageModel->MP_GetMessages($convo_id)
                        )
                    );
                    $this->response($message, Rest_lib::HTTP_OK);
                } else {
                    $message = array(
                        'success' => array(
                            'message' => 'No record/s found!',
                            'data' => ''
                        )
                    );
                    $this->response($message, Rest_lib::HTTP_OK);
                }
            } else { // invalid or blocked user

                $this->response(array(
                    'error' => array(
                        'status' => false,
                        'message' => 'Unauthorized access',
                    )
                ), Rest_lib::HTTP_UNAUTHORIZED);
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

    public function index_post()
    {
        $token = null;
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', trim($headers['Authorization']));
        }

        try {
            $token_data = (object) $this->objOfJwt->DecodeToken($token);

            $this->form_validation->set_rules('sender', 'Sender', 'required|strip_tags|trim');
            $this->form_validation->set_rules('receiver', 'Receiver', 'required|strip_tags|trim');
            $this->form_validation->set_rules('convo_id', 'Receiver', 'required|strip_tags|trim');
            $this->form_validation->set_rules('message', 'Message', 'required|strip_tags|trim');

            if ($this->form_validation->run() == FALSE) {
                $this->response(array(
                    'error' => array(
                        'message' => validation_errors()
                    )
                ), Rest_lib::HTTP_OK);
            } else {
                if ($token_data->status) {

                    $message_data = array(
                        'user_id' => $this->input->post('sender'),
                        'recipient_id' => $this->input->post('receiver'),
                        'convo_id' => $this->input->post('convo_id'),
                        'message' => $this->input->post('message'),
                        'datetime_created' => NOW
                    );

                    $this->MessageModel->MP_SendMessage($message_data);

                    $agent = $this->get_agent();

                    $audit_data = (object) array(
                        'datetime' => NOW,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                        'module' => "Messaging (EXPERT)",
                        'action' => "Message sent from UID: " . $this->input->post('sender') . ' to ' . 'UID: ' . $this->input->post('receiver'),
                    );

                    $this->audit($audit_data);

                    //////////////////////////// AUDIT TRAIL ///////////////////////////

                    $this->response(array(
                        'success' => array(
                            'status' => true,
                            'convo_id' => sha1($this->input->post('convo_id')),
                            'message' => 'Message sent successfully!',
                        )
                    ), Rest_lib::HTTP_OK);


                    //////////////////////////// AUDIT TRAIL ////////////////////////////


                } else {

                    $this->response(array(
                        'error' => array(
                            'status' => true,
                            'message' => 'Unauthorized access',
                        )
                    ), Rest_lib::HTTP_UNAUTHORIZED);
                }
            }
        } catch (Exception $e) { // Token is invalid or tampered
            $this->response(array(
                'error' => array(
                    'message' => 'Invalid Token',
                )
            ), Rest_lib::HTTP_OK);
        }
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
