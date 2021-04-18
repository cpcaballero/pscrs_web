<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/CreatorJwt.php';
class Login_FE extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function auth()
    {
        // $this->dd($_SESSION['account']['details']['role']);

        if (isset($_SESSION['account'])) {
            if ($_SESSION['account']['details']['role'] == "admin" || $_SESSION['account']['details']['role'] == "superadmin") {
                redirect('Admin_FE/dashboard');
            } else if ($_SESSION['account']['details']['role'] == "member") {
                redirect('Subscribers_FE/dashboard');
            } else {
            }
        }
    }

    // new format //////////////////////////

    public function index()
    {
        // $this->load->view("pscrs/includes/header");
        // $this->load->view("pscrs/login");
        // $this->load->view("pscrs/includes/footer");

        $this->auth();

        $view['css'] = 'pscrs/login/css';
        $view['js'] = 'pscrs/login/js';
        $view['content'] = 'pscrs/login/index';

        $this->load->view("pscrs/includes/main", $view);
    }

    // new format //////////////////////////

    public function forgotpassword()
    {
        $view['css'] = 'pscrs/changepassword/css';
        $view['js'] = 'pscrs/changepassword/js';
        $view['content'] = 'pscrs/changepassword/index';

        $this->load->view("pscrs/includes/main", $view);
    }

    public function signup()
    {
        $view['css'] = 'pscrs/signup/css';
        $view['js'] = 'pscrs/signup/js';
        $view['content'] = 'pscrs/signup/index';

        $this->load->view("pscrs/includes/main", $view);
    }

    public function entersecuritycode()
    {
        if ($this->session->userdata('temp_details')) {
            $view['css'] = 'pscrs/securitycode/css';
            $view['js'] = 'pscrs/securitycode/js';
            $view['content'] = 'pscrs/securitycode/index';

            $this->load->view("pscrs/includes/main", $view);
        } else {
            redirect(base_url('Login_FE'));
        }
    }

    public function dd($data)
    {
        echo '<pre>';
        print_r($data);
        echo '<pre>';
        die();
    }
}
