<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class Feedback extends Rest_lib
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

            if (($token_data->role == "superadmin" || $token_data->role == "admin") && $token_data->status) {

                if ($id) {
                    if ($this->FeedbackModel->GetFeedback($id)) {
                        $message = array(
                            'success' => array(
                                'message' => 'Record/s fetched successfully!',
                                'data' => $this->FeedbackModel->GetFeedback($id)
                            )
                        );

                        $this->response($message, Rest_lib::HTTP_OK);
                    } else {
                        $message = array(
                            'error' => array(
                                'message' => 'No record/s found!',
                                'data' => ''
                            )
                        );

                        $this->response($message, Rest_lib::HTTP_OK);
                    }
                } else {
                    if ($this->FeedbackModel->GetFeedbacks()) {
                        $message = array(
                            'success' => array(
                                'message' => 'Record/s fetched successfully!',
                                'data' => $this->FeedbackModel->GetFeedbacks()
                            )
                        );

                        $this->response($message, Rest_lib::HTTP_OK);
                    } else {
                        $message = array(
                            'error' => array(
                                'message' => 'No record/s found!',
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

            $this->form_validation->set_rules('name', 'Name', 'required|strip_tags|trim');
            $this->form_validation->set_rules('email', 'Email Address', 'required|strip_tags|trim|valid_email');
            $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|strip_tags|trim');
            $this->form_validation->set_rules('subject', 'Subject', 'required|strip_tags|trim');
            $this->form_validation->set_rules('message', 'Message', 'required|trim');

            if ($this->form_validation->run() == FALSE) {
                $this->response(array(
                    'error' => array(
                        'message' => validation_errors()
                    )
                ), Rest_lib::HTTP_OK);
            } else {

                if ($token_data->status) {

                    $feedback_data = array(
                        'name' => $this->input->post('name'),
                        'email' => $this->input->post('email'),
                        'contact_number' => $this->input->post('contact_number'),
                        'subject' => $this->input->post('subject'),
                        'message' => $this->input->post('message'),
                        'sent_datetime' => NOW
                    );

                    $this->FeedbackModel->CreateFeedback($feedback_data);


                    //////////////////////////// AUDIT TRAIL ////////////////////////////

                    $agent = $this->get_agent();

                    $audit_data = (object) array(
                        'datetime' => NOW,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                        'module' => "feedback_suggestion",
                        'action' => "submit feedback - " . $this->input->post('subject'),
                    );

                    $this->audit($audit_data);

                    //////////////////////////// AUDIT TRAIL ////////////////////////////


                    $this->response(array(
                        'success' => array(
                            'status' => true,
                            'message' => 'Feedback submitted successfully!',
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
        // <input type="hidden" name="_method" value="delete" />

        $token = null;
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', trim($headers['Authorization']));
        }

        try {
            $token_data = (object) $this->objOfJwt->DecodeToken($token);

            if (($token_data->role == "superadmin" || $token_data->role == "admin") && $token_data->status) {

                if ($id) {

                    if ($this->FeedbackModel->GetFeedback($id)) {

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $agent = $this->get_agent();

                        $audit_data = (object) array(
                            'datetime' => NOW,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                            'module' => "feedback_suggestion",
                            'action' => "delete feedback - ID: " . $id,
                        );

                        $this->audit($audit_data);

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $this->FeedbackModel->DeleteFeedback($id);

                        $message = array(
                            'success' => array(
                                'message' => 'Feedback/s deleted successfully!'
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
