<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class Marketplace extends Rest_lib
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
                    if ($this->MarketplaceModel->GetProduct($id)) {
                        $message = array(
                            'success' => array(
                                'message' => 'Record/s fetched successfully!',
                                'data' => $this->MarketplaceModel->GetProduct($id)
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
                    if ($this->MarketplaceModel->GetProducts()) {
                        $message = array(
                            'success' => array(
                                'message' => 'Record/s fetched successfully!',
                                'data' => $this->MarketplaceModel->GetProducts()
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
            $this->form_validation->set_rules('item_name', 'Product Name', 'required|strip_tags|max_length[255]|is_unique[marketplace.item_name]|trim');
            $this->form_validation->set_rules('description', 'Description', 'required|trim');
            $this->form_validation->set_rules('available_stocks', 'Available  Stocks', 'required|trim');
            $this->form_validation->set_rules('unit_price', 'Unit Price', 'required|trim');
            $this->form_validation->set_rules('product_image', 'Primary Product Image', '');

            if ($this->form_validation->run() == FALSE) {
                $this->response(array(
                    'error' => array(
                        'message' => validation_errors()
                    )
                ), Rest_lib::HTTP_OK);
            } else {

                if ($token_data->status) {
                    $config['upload_path'] = FCPATH . 'storage/images/products/original/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['file_ext_tolower'] = TRUE;
                    $config['overwrite'] = TRUE; 
                    $this->load->library("upload", $config);
                    if(!$this->upload->do_upload('product_image')){
                        $this->response(array(
                            'error' => array(
                                'message' => $this->upload->display_errors()
                            )
                        ), Rest_lib::HTTP_OK);
                    } 
                    else{  
                        
                        /////////// IMAGE RESIZE /////////////

                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $this->upload->data('full_path');
                        $config['new_image'] = FCPATH . 'storage/images/products/thumb/';
                        $config['create_thumb'] = TRUE;
                        $config['maintain_ratio'] = TRUE;
                        $config['width']         = 100;
                        $config['height']       = 60;
                        $this->load->library('image_lib', $config);
                        $this->image_lib->resize();

                        /////////// IMAGE RESIZE /////////////

                        $user_data = array(
                            'item_name' => $this->input->post('item_name'),
                            'description' => $this->input->post('description'),
                            'available_stocks' => $this->input->post('available_stocks'),
                            'unit_price' => $this->input->post('unit_price'),
                            'datetime_created' => NOW,
                            'seller_id' => $this->input->post('active_user'),
                            'status' => true,
                            'item_image_original' => 'storage/images/products/original/' . $this->upload->data('file_name'),
                            'item_image_thumb' =>'storage/images/products/thumb/'
                                . $this->upload->data('raw_name') . "_thumb" 
                                . $this->upload->data('file_ext')
                        );

                        $product_id = $this->MarketplaceModel->CreateProduct($user_data);

                        $total = count($_FILES['other_images']['name']);

                        for($i = 0; $i < $total; $i++){
                            $tmpFilePath = $_FILES['other_images']['name'][$i];
                            if(!empty($tmpFilePath)){
                                $_FILES['file']['name'] = $_FILES['other_images']['name'][$i];
                                $_FILES['file']['type'] = $_FILES['other_images']['type'][$i];
                                $_FILES['file']['tmp_name'] = $_FILES['other_images']['tmp_name'][$i];
                                $_FILES['file']['error'] = $_FILES['other_images']['error'][$i];
                                $_FILES['file']['size'] = $_FILES['other_images']['size'][$i];

                                $config['upload_path'] = FCPATH . 'storage/images/products/original/';
                                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                                $config['file_ext_tolower'] = TRUE;
                                $config['overwrite'] = TRUE; 
                                $this->load->library("upload", $config);
                                if(!$this->upload->do_upload('file')){
                                    $this->response(array(
                                        'error' => array(
                                            'message' => $this->upload->display_errors()
                                        )
                                    ), Rest_lib::HTTP_OK);
                                } 
                                else{  
                                    
                                    /////////// OTHER IMAGES RESIZE /////////////

                                    $config['image_library'] = 'gd2';
                                    $config['source_image'] = $this->upload->data('full_path');
                                    $config['new_image'] = FCPATH . 'storage/images/products/thumb/';
                                    $config['create_thumb'] = TRUE;
                                    $config['maintain_ratio'] = TRUE;
                                    $config['width']         = 100;
                                    $config['height']       = 60;
                                    $this->load->library('image_lib', $config);
                                    $this->image_lib->resize();

                                    /////////// OTHER IMAGES RESIZE /////////////

                                    $other_image_data = array(
                                        'marketplace_id' => $product_id,
                                        'datetime_created' => NOW,
                                        'created_by' => $this->input->post('active_user'),
                                        'image_path' => 'storage/images/products/original/' . $this->upload->data('file_name'),
                                        'thumbnail_path' =>'storage/images/products/thumb/'
                                            . $this->upload->data('raw_name') . "_thumb" 
                                            . $this->upload->data('file_ext')
                                    );

                                    $this->MarketplaceModel->InsertGalleryImage($other_image_data);
                                }
                            
                            }
                        }
                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $agent = $this->get_agent();

                        $audit_data = (object) array(
                            'datetime' => NOW,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                            'module' => "marketplace",
                            'action' => "create product - " . $this->input->post('item_name'),
                        );

                        $this->audit($audit_data);

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $this->response(array(
                            'success' => array(
                                'status' => true,
                                'message' => 'Product created successfully!'
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
                    if ($this->MarketplaceModel->GetProduct($id)) {

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $agent = $this->get_agent();

                        $audit_data = (object) array(
                            'datetime' => NOW,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                            'module' => "marketplace",
                            'action' => "delete marketplace - ID: " . $id,
                        );
                        $this->audit($audit_data);

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $this->MarketplaceModel->DeleteProduct($id);

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
}
