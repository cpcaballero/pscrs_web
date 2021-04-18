<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class Users extends Rest_lib
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
                    if ($this->UserModel->GetUser($id)) {
                        $message = array(
                            'success' => array(
                                'message' => 'Record/s fetched successfully!',
                                'data' => $this->UserModel->GetUser($id)
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
                    if ($this->UserModel->GetUsers()) {
                        $message = array(
                            'success' => array(
                                'message' => 'Record/s fetched successfully!',
                                'data' => $this->UserModel->GetUsers()
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

            $this->form_validation->set_rules('active_user', 'Active Account', 'required|strip_tags|trim');
            $this->form_validation->set_rules('fname', 'First Name', 'required|strip_tags|max_length[255]|trim');
            $this->form_validation->set_rules('mname', 'Middle Name', 'required|strip_tags|max_length[255]|trim');
            $this->form_validation->set_rules('lname', 'Last Name', 'required|strip_tags|max_length[255]|trim');
            $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|is_unique[users.contact_number]|strip_tags|strip_tags|min_length[10]|max_length[40]|trim');
            $this->form_validation->set_rules('email_address', 'Email Address', 'required|is_unique[users.email_address]|strip_tags|max_length[150]|valid_email|trim');
            $this->form_validation->set_rules('pass', 'Password', 'required|strip_tags|min_length[8]|max_length[40]|trim');
            // $this->form_validation->set_rules('repass', 'Retype-Password', 'required|matches[pass]|strip_tags|min_length[8]|max_length[40]|trim');
            $this->form_validation->set_rules('role', 'Role', 'required|strip_tags|min_length[5]|max_length[40]|trim');
            $this->form_validation->set_rules('is_expert', 'Expert Status', 'required|strip_tags|trim');
            if ($this->input->post('role') == 'admin') {
                $this->form_validation->set_rules('is_expert', 'Expert Status', 'strip_tags|trim');
            }

            // $this->form_validation->set_rules('profile_image', 'Profile Image', '');

            if ($this->form_validation->run() == FALSE) {
                $this->response(array(
                    'error' => array(
                        'message' => validation_errors()
                    )
                ), Rest_lib::HTTP_OK);
            } else {

                if (($token_data->role == "superadmin" || $token_data->role == "admin") && $token_data->status) {
                    // $ext = explode('.', $_FILES['profile_image']['name']);
                    // $original = $_POST['fname'] . $_POST['lname'] . time() . '.' . $ext[1];
                    // $thumb = $_POST['fname'] . $_POST['lname'] . time() . '_thumb.' . $ext[1];

                    // $config['upload_path'] = FCPATH . '/storage/images/profile/original/';
                    // $config['file_name']            = $original;
                    // $config['max_size']             = 50000;
                    // $config['max_width']            = 10000;
                    // $config['max_height']           = 10000;
                    // $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    // $config['file_ext_tolower'] = TRUE;
                    // $config['overwrite'] = TRUE;
                    // $this->load->library("upload", $config);
                    // if (!$this->upload->do_upload('profile_image')) {
                    //     $this->response(array(
                    //         'error' => array(
                    //             'message' => $this->upload->display_errors()
                    //         )
                    //     ), Rest_lib::HTTP_OK);
                    // } else {

                    ///////////// IMAGE RESIZE /////////////

                    // $config['image_library'] = 'gd2';
                    // $config['source_image'] = $this->upload->data('full_path');
                    // $config['new_image'] = FCPATH . '/storage/images/profile/thumb/';
                    // $config['create_thumb'] = TRUE;
                    // $config['maintain_ratio'] = TRUE;
                    // $config['width']         = 75;
                    // $config['height']       = 75;
                    // $this->load->library('image_lib', $config);
                    // $this->image_lib->resize();

                    ///////////// IMAGE RESIZE /////////////

                    $user_data = array(
                        'fname' => $this->input->post('fname'),
                        'mname' => $this->input->post('mname'),
                        'lname' => $this->input->post('lname'),
                        'fullname' => $this->input->post('fname') . ' ' . $this->input->post('mname') . ' ' . $this->input->post('lname'),
                        'contact_number' => $this->input->post('contact_number'),
                        'email_address' => $this->input->post('email_address'),
                        'username' => $this->input->post('email_address'),
                        'password' => $this->input->post('pass'),
                        'role' => $this->input->post('role'),
                        'datetime_created' => NOW,
                        'created_by' => $this->input->post('active_user'),
                        'status' => true,
                        'is_expert' => $this->input->post('is_expert'),
                        'field_study' => $this->input->post('field_study')
                        // 'profile_orig' => base_url('storage/images/profile/original/') . $original,
                        // 'profile_thumb' => base_url('storage/images/profile/thumb/') . $thumb,
                    );

                    $this->UserModel->CreateUser($user_data);

                    //////////////////////////// AUDIT TRAIL ////////////////////////////

                    $agent = $this->get_agent();

                    $audit_data = (object) array(
                        'datetime' => NOW,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                        'module' => "user",
                        'action' => "create account - " . $this->input->post('email_address'),
                    );

                    $this->audit($audit_data);

                    //////////////////////////// AUDIT TRAIL ////////////////////////////

                    $this->response(array(
                        'success' => array(
                            'status' => true,
                            'message' => 'Account created successfully!',
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
                    if ($this->UserModel->GetUser($id)) {

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $agent = $this->get_agent();

                        $audit_data = (object) array(
                            'datetime' => NOW,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                            'module' => "user",
                            'action' => "delete account - UID: " . $id,
                        );

                        $this->audit($audit_data);

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $this->UserModel->DeleteUser($id);

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
