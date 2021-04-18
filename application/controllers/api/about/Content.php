<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';

class Content extends Rest_lib
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        $this->objOfJwt = new CreatorJwt();
    }

    public function index_get($id = null)
    {
        if ($id) {
            if ($this->AboutModel->GetAbout($id)) {
                $message = array(
                    'success' => array(
                        'message' => 'Record/s fetched successfully!',
                        'data' => $this->AboutModel->GetAbout($id)
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
            if ($this->AboutModel->GetAbout()) {
                $message = array(
                    'success' => array(
                        'message' => 'Record/s fetched successfully!',
                        'data' => $this->AboutModel->GetAbout()
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

            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('active_user', 'active account', 'required|strip_tags|trim');
            $this->form_validation->set_rules('mission', 'Mission', 'required|trim');
            $this->form_validation->set_rules('vision', 'Vision', 'required|trim');
            $this->form_validation->set_rules('pres_message', 'President\'s Message', 'required|trim');

            if ($this->form_validation->run() == FALSE) {
                $this->response(array(
                    'error' => array(
                        'message' => validation_errors()
                    )
                ), Rest_lib::HTTP_OK);
            } else {

                if (($token_data->role == "superadmin" || $token_data->role == "admin") && $token_data->status) {

                    $about_data = array(
                        'mission' => $this->input->post('mission'),
                        'vision' => $this->input->post('vision'),
                        'pres_message' => $this->input->post('pres_message'),
                        'datetime_created' => NOW,
                        'created_by' => $this->input->post('active_user'),
                    );

                    $this->AboutModel->PublishAbout($about_data);

                    //////////////////////////// AUDIT TRAIL ////////////////////////////

                    $agent = $this->get_agent();

                    $audit_data = (object) array(
                        'datetime' => NOW,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                        'module' => "about",
                        'action' => "published content",
                    );

                    $this->audit($audit_data);

                    //////////////////////////// AUDIT TRAIL ////////////////////////////


                    $this->response(array(
                        'success' => array(
                            'status' => true,
                            'message' => 'Content published successfully!',
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

            if ($token_data->status) {

                if ($id) {

                    if ($this->AboutModel->GetAbout($id)) {

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $agent = $this->get_agent();

                        $audit_data = (object) array(
                            'datetime' => NOW,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                            'module' => "about",
                            'action' => "delete content - ID: " . $id,
                        );

                        $this->audit($audit_data);

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $this->AboutModel->DeleteAbout($id);

                        $message = array(
                            'success' => array(
                                'message' => 'Content deleted successfully!'
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
