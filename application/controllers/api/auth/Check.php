<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class Check extends Rest_lib
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
            ),
        );
        $this->response($message, Rest_lib::HTTP_METHOD_NOT_ALLOWED);
    }

    public function index_post()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('token', 'Token', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->response(array(
                'error' => array(
                    'message' => validation_errors()
                )
            ), Rest_lib::HTTP_OK);
        } else {
            try {
                $token_data = $this->objOfJwt->DecodeToken($this->input->post('token'));
                $this->response(array(
                    'success' => array(
                        'status' => true,
                        'message' => 'Token is valid',
                        'data' => $token_data,
                    )
                ), Rest_lib::HTTP_OK);
            } catch (Exception $e) {
                $this->response(array(
                    'error' => array(
                        'status' => false,
                        'message' => 'Invalid token',
                    )
                ), Rest_lib::HTTP_OK);
            }
        }
    }

    public function index_put()
    {
        $message = array(
            'error' => array(
                'message' => 'Method Not Allowed',
            ),
        );
        $this->response($message, Rest_lib::HTTP_METHOD_NOT_ALLOWED);
    }

    public function index_delete()
    {
        $message = array(
            'error' => array(
                'message' => 'Method Not Allowed',
            ),
        );
        $this->response($message, Rest_lib::HTTP_METHOD_NOT_ALLOWED);
    }
}
