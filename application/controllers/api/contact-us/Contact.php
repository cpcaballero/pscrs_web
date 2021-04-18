<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class Contact extends Rest_lib
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        $this->objOfJwt = new CreatorJwt();
    }

    public function index_get()
    {
        $token = null;
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', trim($headers['Authorization']));
        }

        try {
            $token_data = (object) $this->objOfJwt->DecodeToken($token);

            if ($token_data->status) {
                if ($this->ContactModel->GetContact()) {
                    $message = array(
                        'success' => array(
                            'message' => 'Record/s fetched successfully!',
                            'data' => $this->ContactModel->GetContact()
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

            $this->form_validation->set_rules('telephone', 'Contact Number', 'required|strip_tags|max_length[255]|trim');
            $this->form_validation->set_rules('email', 'Email Address', 'required|strip_tags|trim|valid_email');
            $this->form_validation->set_rules('address', 'Address', 'required|strip_tags|trim');
            
            if ($this->form_validation->run() == FALSE) {
                $this->response(array(
                    'error' => array(
                        'message' => validation_errors()
                    )
                ), Rest_lib::HTTP_OK);
            } else {
                if (($token_data->role == "superadmin" || $token_data->role == "admin") && $token_data->status) {

                    $user_data = array(
                        'telephone' => $this->input->post('telephone'),
                        'email' => $this->input->post('email'),
                        'address' => $this->input->post('address')
                    );
                    $res = $this->ContactModel->GetContact();
                    
                    // Contact Info Exists, update
                    if($res){
                        $existing_record = $this->ContactModel->GetContact()[0];
                        // log_message("INFO", $existing_record);
                        if (strtolower($existing_record->telephone) != strtolower($this->input->post('telephone'))) {
                            $user_data['telephone_datetime_modified'] = NOW;
                        }

                        if (strtolower($existing_record->email) != strtolower($this->input->post('email'))) {
                            $user_data['email_datetime_modified'] = NOW;
                        }

                        if (strtolower($existing_record->address) != strtolower($this->input->post('address'))) {
                            $user_data['address_datetime_modified'] = NOW;
                        }
                        
                        $this->ContactModel->UpdateContact($user_data);

                        $agent = $this->get_agent();

                        $audit_data = (object) array(
                            'datetime' => NOW,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                            'module' => "contact",
                            'action' => "updated contact - ",
                        );

                        $this->audit($audit_data);

                        //////////////////////////// AUDIT TRAIL ///////////////////////////

                        $this->response(array(
                            'success' => array(
                                'status' => true,
                                'message' => 'Contact updated successfully!',
                            )
                        ), Rest_lib::HTTP_OK);
                    }
                    else{
                        // contact info doesnt exist, create
                        $user_data = array(
                            'telephone' => $this->input->post('telephone'),
                            'email' => $this->input->post('email'),
                            'address' => $this->input->post('address'),
                            'telephone_datetime_created' => NOW,
                            'email_datetime_created' => NOW,
                            'address_datetime_created' => NOW
                        );
                        $this->ContactModel->CreateContact($user_data);
                        $agent = $this->get_agent();

                        $audit_data = (object) array(
                            'datetime' => NOW,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                            'module' => "contact",
                            'action' => "create contact - ",
                        );

                        $this->audit($audit_data);

                        //////////////////////////// AUDIT TRAIL ///////////////////////////

                        $this->response(array(
                            'success' => array(
                                'status' => true,
                                'message' => 'Contact created successfully!',
                            )
                        ), Rest_lib::HTTP_OK);

                        
                    } 

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
