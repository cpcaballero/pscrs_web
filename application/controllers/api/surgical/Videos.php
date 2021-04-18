<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class Videos extends Rest_lib
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
                    if ($this->VideoModel->GetVideo($id)) {
                        $message = array(
                            'success' => array(
                                'message' => 'Record/s fetched successfully!',
                                'data' => $this->VideoModel->GetVideo($id)
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
                    if ($this->VideoModel->GetVideos()) {
                        $message = array(
                            'success' => array(
                                'message' => 'Record/s fetched successfully!',
                                'data' => $this->VideoModel->GetVideos()
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

            $this->form_validation->set_rules('active_user', 'Active user', 'required|strip_tags|trim');
            $this->form_validation->set_rules('title', 'Title', 'required|strip_tags|max_length[255]|is_unique[surgical_videos.title]|trim');
            $this->form_validation->set_rules('owner_user_id', 'Owner', 'required|strip_tags|trim');
            $this->form_validation->set_rules('description', 'Description', 'required|trim');
            $this->form_validation->set_rules('video_link', 'Video Link', 'required|is_unique[surgical_videos.video_link]|strip_tags|trim');

            if ($this->form_validation->run() == FALSE) {
                $this->response(array(
                    'error' => array(
                        'message' => validation_errors()
                    )
                ), Rest_lib::HTTP_OK);
            } else {

                if (($token_data->role == "superadmin" || $token_data->role == "admin") && $token_data->status) {

                    $user_data = array(
                        'title' => $this->input->post('title'),
                        'owner_user_id' => $this->input->post('owner_user_id'),
                        'description' => $this->input->post('description'),
                        'video_link' => $this->input->post('video_link'),
                        'datetime_created' => NOW,
                        'created_by' => $this->input->post('active_user'),
                        'status' => true,
                    );

                    $this->VideoModel->CreateVideo($user_data);

                    //////////////////////////// AUDIT TRAIL ////////////////////////////

                    $agent = $this->get_agent();

                    $audit_data = (object) array(
                        'datetime' => NOW,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                        'module' => "surgical videos",
                        'action' => "create video - " . $this->input->post('title'),
                    );

                    $this->audit($audit_data);

                    //////////////////////////// AUDIT TRAIL ////////////////////////////


                    $this->response(array(
                        'success' => array(
                            'status' => true,
                            'message' => 'video created successfully!',
                        )
                    ), Rest_lib::HTTP_OK);
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

                    if ($this->VideoModel->GetVideo($id)) {

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $agent = $this->get_agent();

                        $audit_data = (object) array(
                            'datetime' => NOW,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                            'module' => "surgical videos",
                            'action' => "delete video - ID: " . $id,
                        );

                        $this->audit($audit_data);

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $this->VideoModel->DeleteVideo($id);

                        $message = array(
                            'success' => array(
                                'message' => 'Video/s deleted successfully!'
                            )
                        );

                        $this->response($message, Rest_lib::HTTP_OK);
                    } else {
                        $message = array(
                            'error' => array(
                                'message' => 'No records found!',
                            )
                        );

                        $this->response($message, Rest_lib::HTTP_OK);
                    }
                } else {
                    $message = array(
                        'error' => array(
                            'message' => 'No records found!',
                        )
                    );

                    $this->response($message, Rest_lib::HTTP_OK);
                }
            } else {

                $this->response(array(
                    'error' => array(
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
