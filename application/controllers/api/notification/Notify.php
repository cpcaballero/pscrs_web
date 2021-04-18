<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class Notify extends Rest_lib
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        $this->objOfJwt = new CreatorJwt();
    }

    public function index_get($id = null)
    {
        $token = null;
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', trim($headers['Authorization']));
        }

        try {
            $token_data = (object) $this->objOfJwt->DecodeToken($token);

            if ($token_data->status) {

                if ($id) {
                    if ($this->NotificationModel->GetNotification($id)) {
                        $message = array(
                            'success' => array(
                                'message' => 'Record/s fetched successfully!',
                                'data' => $this->NotificationModel->GetNotification($id)
                            )
                        );

                        $this->response($message, Rest_lib::HTTP_OK);
                    } else {
                        $message = array(
                            'error' => array(
                                'message' => 'No records found!',
                                'data' => ''
                            )
                        );

                        $this->response($message, Rest_lib::HTTP_OK);
                    }
                } else {
                    if ($this->NotificationModel->GetNotifications()) {
                        $message = array(
                            'success' => array(
                                'message' => 'Record/s fetched successfully!',
                                'data' => $this->NotificationModel->GetNotifications()
                            )
                        );

                        $this->response($message, Rest_lib::HTTP_OK);
                    } else {
                        $message = array(
                            'error' => array(
                                'message' => 'No records found!',
                                'data' => ''
                            )
                        );

                        $this->response($message, Rest_lib::HTTP_OK);
                    }
                }
            } else { // invalid or blocked user

                $this->response(array(
                    'success' => array(
                        'status' => true,
                        'message' => 'Unauthorized access',
                    )
                ), Rest_lib::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) { // Token is invalid or tampered
            $this->response(array(
                'error' => array(
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
            $this->form_validation->set_rules('title', 'Notification Title', 'required|strip_tags|max_length[255]|trim');
            $this->form_validation->set_rules('description', 'Notification Content', 'required|trim');
            $this->form_validation->set_rules('recipient', 'Recipient', 'required|trim');

            if ($this->form_validation->run() == FALSE) {
                $this->response(array(
                    'error' => array(
                        'message' => validation_errors()
                    )
                ), Rest_lib::HTTP_OK);
            } else {
                if ($token_data->status) {

                    $notification_data = array(
                        'title' => $this->input->post('title'),
                        'description' => $this->input->post('description'),
                        'recipient' => $this->input->post('recipient'),
                        'datetime_created' => NOW,
                        'created_by' => $_SESSION['account']['details']['id'],
                        'status' => false,
                    );
                    $this->NotificationModel->CreateNotification($notification_data);

                    //////////////////////////// AUDIT TRAIL ////////////////////////////

                    $agent = $this->get_agent();
                    $audit_data = (object) array(
                        'datetime' => NOW,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                        'module' => "notification",
                        'action' => "create notification - " . $this->input->post('title'),
                    );
                    $this->audit($audit_data);

                    //////////////////////////// AUDIT TRAIL ////////////////////////////
                    $this->response(array(
                        'success' => array(
                            'status' => true,
                            'message' => 'Notification created successfully!',
                        )
                    ), Rest_lib::HTTP_OK);
                    // }
                } else {
                    $this->response(array(
                        'success' => array(
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
        $token = null;
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', trim($headers['Authorization']));
        }

        try {
            $token_data = (object) $this->objOfJwt->DecodeToken($token);

            if ($token_data->status) {

                if ($id) {
                    if ($this->NotificationModel->GetNotification($id)) {

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $agent = $this->get_agent();

                        $audit_data = (object) array(
                            'datetime' => NOW,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                            'module' => "notification",
                            'action' => "delete Notification - ID: " . $id,
                        );
                        $this->audit($audit_data);

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $this->NotificationModel->DeleteNotification($id);

                        $message = array(
                            'success' => array(
                                'message' => 'Record/s deleted successfully!'
                            )
                        );

                        $this->response($message, Rest_lib::HTTP_OK);
                    } else {
                        $message = array(
                            'error' => array(
                                'message' => 'No records found!',
                                'data' => ''
                            )
                        );

                        $this->response($message, Rest_lib::HTTP_OK);
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
            } else {
                $this->response(array(
                    'success' => array(
                        'status' => true,
                        'message' => 'Unauthorized access',
                    )
                ), Rest_lib::HTTP_UNAUTHORIZED);
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
