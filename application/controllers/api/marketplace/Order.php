<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class Order extends Rest_lib
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Manila');
        $this->objOfJwt = new CreatorJwt();
    }

    public function index_get()
    {
        $message = array(
            'error' => array(
                'message' => 'Method Not Allowed',
            )
        );
        $this->response($message, Rest_lib::HTTP_METHOD_NOT_ALLOWED);
    }

    public function index_post()
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

                $this->form_validation->set_error_delimiters('', '');
                $this->form_validation->set_rules('id', 'Product', 'required|strip_tags|trim');
                $this->form_validation->set_rules('quantity', 'Product', 'required|strip_tags|trim');
                $this->form_validation->set_rules('active_user', 'Active user', 'required|strip_tags|trim');

                if ($this->form_validation->run() == FALSE) {
                    $this->response(array(
                        'error' => array(
                            'message' => validation_errors()
                        )
                    ), Rest_lib::HTTP_OK);
                } else {

                    $id = $this->input->post('id');
                    // var_dump($this->MarketplaceModel->GetProduct($id));
                    if ($this->MarketplaceModel->GetProduct($id)) {

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $agent = $this->get_agent();

                        $audit_data = (object) array(
                            'datetime' => NOW,
                            'ip' => $_SERVER['REMOTE_ADDR'],
                            'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                            'module' => "marketplace",
                            'action' => "Ordered product - ID: " . $id,
                        );

                        $this->audit($audit_data);

                        //////////////////////////// AUDIT TRAIL ////////////////////////////

                        $data = array(
                            'marketplace_id' => $this->input->post("id"),
                            'buyer_id' => $this->input->post("active_user"),
                            'quantity' => $this->input->post("quantity"),
                            'total' => $this->input->post("total"),
                            'mode_of_payment' => $this->input->post("mode_of_payment"),
                            'datetime_ordered' => NOW,
                            'datetime_created' => NOW
                            // 'modified_by' => $this->input->post('active_user'),
                        );

                        $marketplace_transaction_id = $this->MarketplaceModel->CreateOrder($data);
                        $timestamp = strtotime(NOW);
 
                        // Creating new date format from that timestamp
                        $order_reference = date("Ymd", $timestamp);
                        $message = array(
                            'success' => array(
                                'message' => 'Product/s ordered successfully!',
                                'order_reference' => $order_reference . "-" . $marketplace_transaction_id
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

    public function index_put()
    {
        $message = array(
            'error' => array(
                'message' => 'Method Not Allowed',
            )
        );
        $this->response($message, Rest_lib::HTTP_METHOD_NOT_ALLOWED);
    }

    public function index_delete()
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
}
