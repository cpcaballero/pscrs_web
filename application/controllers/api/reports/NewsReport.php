<?php
require APPPATH . 'libraries/Rest_lib.php';
require APPPATH . '/libraries/CreatorJwt.php';
class NewsReport extends Rest_lib
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
        $token = null;
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $token = str_replace('Bearer ', '', trim($headers['Authorization']));
        }

        try {
            $token_data = (object) $this->objOfJwt->DecodeToken($token);

            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('active_user', 'Active Account', 'required|strip_tags|trim');
            $this->form_validation->set_rules('report_type', 'Report Type', 'required|strip_tags|trim');
            $this->form_validation->set_rules('report_date', 'Report Date', 'required|strip_tags|trim');

            if ($this->form_validation->run() == FALSE) {
                $this->response(array(
                    'error' => array(
                        'message' => validation_errors()
                    )
                ), Rest_lib::HTTP_OK);
            } else {

                if (($token_data->role == "superadmin" || $token_data->role == "admin") && $token_data->status) {
                    $report_type = $this->input->post('report_type');
                    $report_date = $this->input->post('report_date');
                    $report_name = "Tech_News_" . $report_date . ($report_type == "csv"   
                        ?  ".csv" 
                        : ".pdf");
                    if ($report_type == 'csv') {
                        
                        $report_content = $this->ReportsModel->GetNews($report_date, true);
                        // $this->load->helper('download');
                        // force_download($report_name, $report_content); //force download file from $csvContent, not storage

                        //////////////////////////// AUDIT TRAIL ////////////////////////////
                            $agent = $this->get_agent();
                            $audit_data = (object) array(
                                'datetime' => NOW,
                                'ip' => $_SERVER['REMOTE_ADDR'],
                                'device' => 'Platform: ' . $this->agent->platform() . ' - Agent: ' . $agent,
                                'module' => "report",
                                'action' => "tech news exported " . $report_type,
                            );
                            $this->audit($audit_data);
                        //////////////////////////// AUDIT TRAIL ////////////////////////////
                        $this->response(array(
                            'success' => array(
                                'message' => "Exported successfully",
                                'data' => base64_encode($report_content),
                                'filename' => $report_name
                            )
                        ), Rest_lib::HTTP_OK);
                        
                    } else if ($this->input->post('report_type') == 'pdf') {
                        require_once FCPATH . '/vendor/autoload.php';
                        $mpdf = new \Mpdf\Mpdf();
                        $report_content = $this->ReportsModel->GetNews($report_date);
                        $report_template = $this->load->view('report_formats/NewsReport_PDF', $report_content, TRUE);
                        $mpdf->WriteHTML($report_template);
                        $mpdf->Output(FCPATH . '/storage/' . $report_name, 'F');
                        $getFile = file_get_contents(FCPATH . '/storage/' . $report_name);
                        $output_pdf = chunk_split(base64_encode($getFile));


                        $this->response(array(
                            'success' => array(
                                'message' => "Exported successfully",
                                'data' => $output_pdf,
                                'filename' => $report_name
                            )
                        ), Rest_lib::HTTP_OK);
                    } else {
                        $this->response(array(
                            'error' => array(
                                'status' => false,
                                'message' => 'Bad Request',
                            )
                        ), Rest_lib::HTTP_BAD_REQUEST);
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
