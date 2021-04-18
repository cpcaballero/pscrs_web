<?php
require APPPATH . '/libraries/CreatorJwt.php';

class JwtToken extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->objOfJwt = new CreatorJwt();
        header('Content-Type: application/json');
    }

    /*************Ganerate token this function use**************/

    public function LoginToken()
    {
        $has_input = false;
        if (!empty($this->input->post())) {
            $has_input = true;
            $input = (object) $this->input->post();
        } else if (!empty(file_get_contents('php://input'))) {
            $has_input = true;
            $input = (object) json_decode(file_get_contents('php://input'));
        } else {
        }

        if ($has_input) {
            $tokenData['user'] = $input->user;
            $tokenData['timeStamp'] = Date('Y-m-d h:i:s');
            $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
            echo json_encode(array('Token' => $jwtToken));
        }
    }



    /*************Use for token then fetch the data**************/

    public function GetTokenData()
    {
        $received_Token = $this->input->request_headers('Authorization');
        $token = explode(' ', $received_Token['Authorization']);
        try {
            $jwtData = $this->objOfJwt->DecodeToken($token[1]);
            echo json_encode($jwtData);
        } catch (Exception $e) {
            http_response_code('401');
            echo json_encode(array("status" => false, "message" => $e->getMessage()));
            exit;
        }
    }
}
