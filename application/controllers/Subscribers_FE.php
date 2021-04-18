<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/CreatorJwt.php';

class Subscribers_FE extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function auth()
    {
        // $this->dd($_SESSION);

        if (isset($_SESSION['account'])) {
            if ($_SESSION['account']['details']['role'] == "admin") {
                redirect('Admin_FE/dashboard');
            } else if ($_SESSION['account']['details']['role'] == "member") {
            } else {
                redirect(base_url('Login_FE'));
            }
        } else {
            redirect(base_url('Login_FE'));
        }
    }

    public function index()
    {
        $this->auth();

        $this->load->view('subscribers/includes/header');
        $this->load->view('subscribers/includes/navbar');
        // $this->load->view('subscribers/about');
        $this->load->view('subscribers/includes/footer');
    }

    public function dashboard()
    {
        $this->auth();
        $view['css'] = 'subscribers/dashboard/css';
        $view['js'] = 'subscribers/dashboard/js';
        $view['content'] = 'subscribers/dashboard/index';

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function surgical_videos()
    {
        $this->auth();
        $view['css'] = 'subscribers/surgical_videos/css';
        $view['js'] = 'subscribers/surgical_videos/js';
        $view['content'] = 'subscribers/surgical_videos/index';

        $view['videos'] = $this->VideoModel->GetActiveVideos();
        $view['ratings'] = $this->VideoModel->GetVideoRatings();

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function instructional_lectures()
    {
        $this->auth();
        $view['css'] = 'subscribers/instructional_lectures/css';
        $view['js'] = 'subscribers/instructional_lectures/js';
        $view['content'] = 'subscribers/instructional_lectures/index';

        $view['videos'] = $this->LectureModel->GetActiveLectures();
        $view['ratings'] = $this->LectureModel->GetLectureRatings();

        // $this->dd($view);

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function technology_news()
    {
        $this->auth();
        $view['css'] = 'subscribers/technology_news/css';
        $view['js'] = 'subscribers/technology_news/js';
        $view['content'] = 'subscribers/technology_news/index';

        $view['news'] = $this->NewsModel->GetActiveNews();
        // $this->dd($view['news']);
        $view['ratings'] = $this->NewsModel->GetNewsRatings();

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    //view all products from others
    public function marketplace()
    {
        $this->auth();
        $view['css'] = 'subscribers/marketplace/css';
        $view['js'] = 'subscribers/marketplace/js';
        $view['content'] = 'subscribers/marketplace/index';

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    //view all your own products
    public function marketplace_manage()
    {
        $this->auth();
        $view['css'] = 'subscribers/marketplace/css';
        $view['js'] = 'subscribers/marketplace/js';
        $view['content'] = 'subscribers/marketplace/manage';

        $view['products'] = $this->MarketplaceModel->GetProducts();

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function marketplace_create()
    {
        $this->auth();
        $view['css'] = 'subscribers/marketplace/css';
        $view['js'] = 'subscribers/marketplace/js';
        $view['content'] = 'subscribers/marketplace/create';

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function marketplace_update($id)
    {
        $this->auth();
        $view['css'] = 'subscribers/marketplace/css';
        $view['js'] = 'subscribers/marketplace/js';
        $view['content'] = 'subscribers/marketplace/update';

        $view['product'] = $this->MarketplaceModel->GetProduct($id);
        $view['gallery_images'] = $this->MarketplaceModel->GetGalleryImage($id);

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    //view a product from yourself
    public function marketplace_view($id)
    {
        $this->auth();
        $view['css'] = 'subscribers/marketplace/css';
        $view['js'] = 'subscribers/marketplace/js';
        $view['content'] = 'subscribers/marketplace/view';

        $view['product'] = $this->MarketplaceModel->GetProduct($id);
        $view['gallery_images'] = $this->MarketplaceModel->GetGalleryImage($id);

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    // view product from others
    public function marketplace_item_view($id)
    {
        $this->auth();
        $view['css'] = 'subscribers/marketplace/css';
        $view['js'] = 'subscribers/marketplace/js';
        $view['content'] = 'subscribers/marketplace/marketplace_item_view';

        $view['product'] = $this->MarketplaceModel->GetProduct($id);
        $view['gallery_images'] = $this->MarketplaceModel->GetGalleryImage($id);

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function marketplace_messages()
    {
        $this->auth();
        $view['css'] = 'subscribers/marketplace/css';
        $view['js'] = 'subscribers/marketplace/js';
        $view['content'] = 'subscribers/marketplace/messages';

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function marketplace_messages_view($id, $id2)
    {
        $this->auth();
        $view['css'] = 'subscribers/marketplace/css';
        $view['js'] = 'subscribers/marketplace/js';
        $view['content'] = 'subscribers/marketplace/messages_view';

        $view['seller'] = $this->UserModel->GetUser($id);
        $convo_id = $id . '_' . $id2;

        $view['convo_id'] = $convo_id;

        $view['thread'] = $this->MessageModel->MP_GetMessages($id, $id2);

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function ask_the_experts()
    {
        $this->auth();
        $view['css'] = 'subscribers/ask_the_experts/css';
        $view['js'] = 'subscribers/ask_the_experts/js';

        $view['content'] = 'subscribers/ask_the_experts/index';

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function ask_the_experts_message($id)
    {
        $this->auth();
        $view['css'] = 'subscribers/ask_the_experts/css';
        $view['js'] = 'subscribers/ask_the_experts/js';
        $view['content'] = 'subscribers/ask_the_experts/message';

        $view['expert'] = $this->UserModel->GetUser($id);

        if ($_SESSION['account']['details']['is_expert']) {
            $convo_id = $id . '' . $_SESSION['account']['details']['id'];
        } else {
            $convo_id = $_SESSION['account']['details']['id'] . '' . $id;
        }

        $view['convo_id'] = $convo_id;

        $view['thread'] = $this->MessageModel->GetMessages(sha1($convo_id));
        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function about_pscrs()
    {
        $this->auth();
        $view['css'] = 'subscribers/about_pscrs/css';
        $view['js'] = 'subscribers/about_pscrs/js';
        $view['content'] = 'subscribers/about_pscrs/index';

        $view['about'] = $this->AboutModel->GetAbout(1);

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function profile_settings()
    {
        $this->auth();
        $view['css'] = 'subscribers/profile_settings/css';
        $view['js'] = 'subscribers/profile_settings/js';
        $view['content'] = 'subscribers/profile_settings/index';

        $view['events'] = $this->CalendarModel->GetCalendar();

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function profile_settings_faqs()
    {
        $this->auth();
        $view['css'] = 'subscribers/profile_settings/css';
        $view['js'] = 'subscribers/profile_settings/js';
        $view['content'] = 'subscribers/profile_settings/FAQs';

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function profile_settings_terms_and_conditions()
    {
        $this->auth();
        $view['css'] = 'subscribers/profile_settings/css';
        $view['js'] = 'subscribers/profile_settings/js';
        $view['content'] = 'subscribers/profile_settings/terms_and_conditions';

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function profile_settings_privacy_policy()
    {
        $this->auth();
        $view['css'] = 'subscribers/profile_settings/css';
        $view['js'] = 'subscribers/profile_settings/js';
        $view['content'] = 'subscribers/profile_settings/privacy_policy';

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function profile_settings_billing($id)
    {
        $this->auth();
        if ($this->BillingModel->GetBilling($id)) {
            $view['billing'] = $this->BillingModel->GetBilling($id);
        } else {
            redirect(base_url('Admin_FE/system_settings'));
        }
        $view['css'] = 'subscribers/profile_settings/css';
        $view['js'] = 'subscribers/profile_settings/js';
        $view['content'] = 'subscribers/profile_settings/billing_info';

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function feedback_and_suggestions()
    {
        $this->auth();
        $view['css'] = 'subscribers/feedback_and_suggestions/css';
        $view['js'] = 'subscribers/feedback_and_suggestions/js';
        $view['content'] = 'subscribers/feedback_and_suggestions/index';

        $view['contact'] = $this->ContactModel->GetContact();

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    public function notifications()
    {
        $this->auth();
        $view['css'] = 'subscribers/notifications/css';
        $view['js'] = 'subscribers/notifications/js';
        $view['content'] = 'subscribers/notifications/index';

        $view['notifs'] = $this->NotificationModel->GetNotifications();

        $view['sidebar'] = 'subscribers/includes/sidebar';
        $view['navbar'] = 'subscribers/includes/navbar';
        $view['footer'] = 'subscribers/includes/footer';

        $this->load->view("subscribers/includes/main", $view);
    }

    // LOGOUT //////////////////////
    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url('Login_FE'));
    }

    // LOGOUT //////////////////////

    public function dd($data)
    {
        echo "<pre>";
        print_r($data);
        echo "<pre>";
        die();
    }
}
