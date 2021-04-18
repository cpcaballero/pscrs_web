<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class News extends Rest_lib
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
                    if ($this->NewsModel->GetNewsArticle($id)) {
                        $message = array(
                            'success' => array(
                                'message' => 'Record/s fetched successfully!',
                                'data' => $this->NewsModel->GetNewsArticle($id)
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
                    if ($this->NewsModel->GetNews()) {
                        $message = array(
                            'success' => array(
                                'message' => 'Record/s fetched successfully!',
                                'data' => $this->NewsModel->GetNews()
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
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('title', 'News Title', 'required|strip_tags|max_length[255]|trim');
            $this->form_validation->set_rules('owner_user_id', 'Owner', 'required|strip_tags|max_length[11]|trim');
            $this->form_validation->set_rules('description', 'Article Body', 'required|trim');
            // $this->form_validation->set_rules('image_upload', 'News Image', '');
            
            if ($this->form_validation->run() == FALSE) {
                $this->response(array(
                    'error' => array(
                        'message' => validation_errors()
                    )
                ), Rest_lib::HTTP_OK);
            } else {
                if ($token_data->status) {
                    // $config['upload_path'] = FCPATH . '/storage/images/news/original/';
                    // $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    // $config['file_ext_tolower'] = TRUE;
                    // $config['overwrite'] = TRUE; 
                    // $this->load->library("upload", $config);
                    // if(!$this->upload->do_upload('image_upload')){
                    //     $this->response(array(
                    //         'error' => array(
                    //             'message' => $this->upload->display_errors()
                    //         )
                    //     ), Rest_lib::HTTP_OK);
                    // } 
                    // else{  
                        
                    ///////////// IMAGE RESIZE /////////////

                        // $config['image_library'] = 'gd2';
                        // $config['source_image'] = $this->upload->data('full_path');
                        // $config['new_image'] = FCPATH . '/storage/images/news/thumb/';
                        // $config['create_thumb'] = TRUE;
                        // $config['maintain_ratio'] = TRUE;
                        // $config['width']         = 75;
                        // $config['height']       = 50;
                        // $this->load->library('image_lib', $config);
                        // $this->image_lib->resize();

                    ///////////// IMAGE RESIZE /////////////
                        
                        $news_data = array(
                            'title' => $this->input->post('title'),
                            'owner_user_id' => $this->input->post('owner_user_id'),
                            'description' => $this->input->post('description'),
                            'datetime_created' => NOW,
                            'created_by' => $_SESSION['account']['details']['id'],
                            'status' => true,
                            // 'thumbnail_path' => $this->upload->data('full_path')
                        );
                        $this->NewsModel->CreateNews($news_data);

                    //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $agent = $this->get_agent();
                        $audit_data = (object) array(
                            'datetime' => NOW,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                            'module' => "news",
                            'action' => "create news article - " . $this->input->post('title'),
                        );
                        $this->audit($audit_data);

                    //////////////////////////// AUDIT TRAIL ////////////////////////////
                        $this->response(array(
                            'success' => array(
                                'status' => true,
                                'message' => 'News created successfully!',
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
                    if ($this->NewsModel->GetNews($id)) {

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $agent = $this->get_agent();

                        $audit_data = (object) array(
                            'datetime' => NOW,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                            'module' => "news",
                            'action' => "delete news - ID: " . $id,
                        );
                        $this->audit($audit_data);

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $this->NewsModel->DeleteNews($id);

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
