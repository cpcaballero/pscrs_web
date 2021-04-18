<?php
defined('BASEPATH') or exit('No direct script access allowed');
require APPPATH . '/libraries/CreatorJwt.php';
class Admin_FE extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function auth()
    {
        // $this->dd($_SESSION);

        if (isset($_SESSION['account'])) {
            if ($_SESSION['account']['details']['role'] == "admin" || $_SESSION['account']['details']['role'] == "superadmin") {
                // redirect('Admin_FE/dashboard');
            } else if ($_SESSION['account']['details']['role'] == "member") {
                redirect('Subscribers_FE/dashboard');
            } else {
                redirect(base_url('Login_FE'));
            }
        } else {
            redirect(base_url('Login_FE'));
        }
    }
    public function super_auth()
    {
        if (isset($_SESSION['account'])) {
            if ($_SESSION['account']['details']['role'] == "superadmin") {
                // redirect('Admin_FE/dashboard');
            } else if ($_SESSION['account']['details']['role'] == "member") {
                redirect('Subscribers_FE/dashboard');
            } else {
                redirect(base_url('Login_FE'));
            }
        } else {
            redirect(base_url('Login_FE'));
        }
    }

    public function index()
    {
        $this->load->view("pscrs/includes/header");
        $this->load->view("pscrs/login");
        $this->load->view("pscrs/includes/footer");
    }

    // new format //////////////////////

    public function dashboard()
    {

        $this->auth();

        $view['css'] = 'admin/dashboard/css';
        $view['js'] = 'admin/dashboard/js';
        $view['content'] = 'admin/dashboard/index';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    // new format //////////////////////

    public function about_pscrs()
    {
        $this->auth();
        $view['css'] = 'admin/about_pscrs/css';
        $view['js'] = 'admin/about_pscrs/js';
        $view['content'] = 'admin/about_pscrs/index';

        $view['about'] = $this->AboutModel->GetAbout(1);
        // $this->dd($view['about']);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }



    // NEWS START
    public function technology_news()
    {
        $this->auth();
        $view['css'] = 'admin/news/css';
        $view['js'] = 'admin/news/js';
        $view['content'] = 'admin/news/index';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function technology_news_create()
    {
        $this->auth();
        $view['css'] = 'admin/news/css';
        $view['js'] = 'admin/news/js';
        $view['content'] = 'admin/news/create';

        $view['users'] = $this->UserModel->GetUsers();

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function technology_news_view($id = null)
    {
        $this->auth();
        $view['css'] = 'admin/news/css';
        $view['js'] = 'admin/news/js';
        $view['content'] = 'admin/news/view';

        $view['users'] = $this->UserModel->GetUsers();
        $view['news'] = $this->NewsModel->GetNewsArticle($id);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function technology_news_update($id = null)
    {
        $this->auth();
        $view['css'] = 'admin/news/css';
        $view['js'] = 'admin/news/js';
        $view['content'] = 'admin/news/update';

        $view['users'] = $this->UserModel->GetUsers();
        $view['news'] = $this->NewsModel->GetNewsArticle($id);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function technology_news_report()
    {
        $this->auth();
        $extract = false;
        if ($_POST) {
            if (isset($_POST['report_date'])) {
                $view['news'] = $this->ReportsModel->GetNews($_POST['report_date'], $extract);
                $view['selected_date'] = $_POST['report_date'];
            } else {
                $view['selected_date'] = 'today';
            }
        } else {
            $view['selected_date'] = 'today';
            $view['news'] = $this->ReportsModel->GetNews('today', $extract);
        }

        $view['css'] = 'admin/news/css';
        $view['js'] = 'admin/news/js';
        $view['content'] = 'admin/news/report';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }
    // NEW END

    // ASK THE EXPERT START
    public function ask_the_experts()
    {
        $this->auth();
        $view['css'] = 'admin/ask_the_experts/css';
        $view['js'] = 'admin/ask_the_experts/js';
        $view['content'] = 'admin/ask_the_experts/index';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function ask_the_experts_create()
    {
        $this->auth();
        $view['css'] = 'admin/ask_the_experts/css';
        $view['js'] = 'admin/ask_the_experts/js';
        $view['content'] = 'admin/ask_the_experts/create';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function ask_the_experts_view($id)
    {
        $this->auth();
        $view['css'] = 'admin/ask_the_experts/css';
        $view['js'] = 'admin/ask_the_experts/js';
        $view['content'] = 'admin/ask_the_experts/view';

        $view['expert'] = $this->UserModel->GetUser($id);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function ask_the_experts_update($id)
    {
        $this->auth();
        $view['css'] = 'admin/ask_the_experts/css';
        $view['js'] = 'admin/ask_the_experts/js';
        $view['content'] = 'admin/ask_the_experts/update';

        $view['expert'] = $this->UserModel->GetUser($id);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function expert_report()
    {
        $this->auth();
        $extract = false;
        if ($_POST) {
            if (isset($_POST['report_date'])) {
                $view['expert_conversations'] = $this->ReportsModel->GetExpertConvos($_POST['report_date'], $extract);
                $view['selected_date'] = $_POST['report_date'];
            } else {
                $view['selected_date'] = 'today';
            }
        } else {
            $view['selected_date'] = 'today';
            $view['expert_conversations'] = $this->ReportsModel->GetExpertConvos('today', $extract);
        }
        $view['css'] = 'admin/ask_the_experts/css';
        $view['js'] = 'admin/ask_the_experts/js';
        $view['content'] = 'admin/ask_the_experts/report';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function ask_the_experts_user_view()
    {
        $this->auth();
        $view['css'] = 'admin/ask_the_experts/css';
        $view['js'] = 'admin/ask_the_experts/js';
        $view['content'] = 'admin/ask_the_experts/user_view';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }
    // NEW END

    // NEWS START
    public function member_settings()
    {
        $this->auth();
        $view['css'] = 'admin/member_settings/css';
        $view['js'] = 'admin/member_settings/js';
        $view['content'] = 'admin/member_settings/index';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function members_report(){
        $this->auth();
        $extract = false;
        if ($_POST) {
            if (isset($_POST['report_date'])) {
                $view['last_login'] = $this->ReportsModel->GetLastLogin($_POST['report_date'], $extract);
                $view['selected_date'] = $_POST['report_date'];
            } else {
                $view['selected_date'] = 'today';
            }
        } else {
            $view['selected_date'] = 'today';
            $view['last_login'] = $this->ReportsModel->GetLastLogin('today', $extract);
        }
        $view['css'] = 'admin/member_settings/css';
        $view['js'] = 'admin/member_settings/js';
        $view['content'] = 'admin/member_settings/report';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function member_settings_create()
    {
        $this->auth();
        $view['css'] = 'admin/member_settings/css';
        $view['js'] = 'admin/member_settings/js';
        $view['content'] = 'admin/member_settings/create';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function member_settings_view($id)
    {
        $this->auth();
        $view['css'] = 'admin/member_settings/css';
        $view['js'] = 'admin/member_settings/js';
        $view['content'] = 'admin/member_settings/view';

        $view['expert'] = $this->UserModel->GetUser($id);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function member_settings_update($id)
    {
        $this->auth();
        $view['css'] = 'admin/member_settings/css';
        $view['js'] = 'admin/member_settings/js';
        $view['content'] = 'admin/member_settings/update';

        $view['expert'] = $this->UserModel->GetUser($id);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function member_settings_faqs_update()
    {
        $this->auth();
        $view['css'] = 'admin/member_settings/css';
        $view['js'] = 'admin/member_settings/js';
        $view['content'] = 'admin/member_settings/faqs_update';

        $view['settings'] = $this->MemberSettingsModel->GetSetting(1);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function member_settings_terms_update()
    {
        $this->auth();
        $view['css'] = 'admin/member_settings/css';
        $view['js'] = 'admin/member_settings/js';
        $view['content'] = 'admin/member_settings/terms_update';
        $view['settings'] = $this->MemberSettingsModel->GetSetting(1);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function member_settings_privacy_update()
    {
        $this->auth();
        $view['css'] = 'admin/member_settings/css';
        $view['js'] = 'admin/member_settings/js';
        $view['content'] = 'admin/member_settings/privacy_update';

        $view['settings'] = $this->MemberSettingsModel->GetSetting(1);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function member_settings_changepass()
    {
        $this->auth();
        $view['css'] = 'admin/member_settings/css';
        $view['js'] = 'admin/member_settings/js';
        $view['content'] = 'admin/member_settings/changepass';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function member_settings_create_event()
    {
        $this->auth();
        $view['css'] = 'admin/member_settings/css';
        $view['js'] = 'admin/member_settings/js';
        $view['content'] = 'admin/member_settings/create_event';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function member_settings_update_event($id)
    {
        $this->auth();
        $view['css'] = 'admin/member_settings/css';
        $view['js'] = 'admin/member_settings/js';
        $view['content'] = 'admin/member_settings/update_event';

        $view['event'] = $this->CalendarModel->GetCalendarEvent($id);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function member_settings_view_event()
    {
        $this->auth();
        $view['css'] = 'admin/member_settings/css';
        $view['js'] = 'admin/member_settings/js';
        $view['content'] = 'admin/member_settings/view_event';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }
    // MEMBER SETTINGS END

    // SURGICAL VIDEOS START
    public function surgical_videos()
    {
        $this->auth();
        $view['css'] = 'admin/surgical/css';
        $view['js'] = 'admin/surgical/js';
        $view['content'] = 'admin/surgical/index';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function surgical_create()
    {
        $this->auth();
        $view['css'] = 'admin/surgical/css';
        $view['js'] = 'admin/surgical/js';
        $view['content'] = 'admin/surgical/create';
        $view['users'] = $this->UserModel->GetUsers();

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function surgical_view($id = null)
    {
        $this->auth();
        $view['css'] = 'admin/surgical/css';
        $view['js'] = 'admin/surgical/js';
        $view['content'] = 'admin/surgical/view';

        $view['users'] = $this->UserModel->GetUsers();
        $view['video'] = $this->VideoModel->GetVideo($id);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function surgical_update($id = null)
    {
        $this->auth();
        $view['css'] = 'admin/surgical/css';
        $view['js'] = 'admin/surgical/js';
        $view['content'] = 'admin/surgical/update';
        $view['users'] = $this->UserModel->GetUsers();
        $view['video'] = $this->VideoModel->GetVideo($id);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function surgical_user_view()
    {
        $this->auth();
        $view['css'] = 'admin/surgical/css';
        $view['js'] = 'admin/surgical/js';
        $view['content'] = 'admin/surgical/user_view';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function surgical_report()
    {
        $this->auth();
        $extract = false;
        if ($_POST) {
            if (isset($_POST['report_date'])) {
                $view['videos'] = $this->ReportsModel->GetVideos($_POST['report_date'], $extract);
                $view['selected_date'] = $_POST['report_date'];
            } else {
                $view['selected_date'] = 'today';
            }
        } else {
            $view['selected_date'] = 'today';
            $view['videos'] = $this->ReportsModel->GetVideos('today', $extract);
        }

        $view['css'] = 'admin/surgical/css';
        $view['js'] = 'admin/surgical/js';
        $view['content'] = 'admin/surgical/report';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    // SURGICAL VIDEOS END

    // LECTURES START //////////////////////

    public function instructional_lectures()
    {
        $this->auth();
        $view['css'] = 'admin/lectures/css';
        $view['js'] = 'admin/lectures/js';
        $view['content'] = 'admin/lectures/index';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function create_lecture()
    {
        $this->auth();
        $view['css'] = 'admin/lectures/css';
        $view['js'] = 'admin/lectures/js';
        $view['content'] = 'admin/lectures/create';

        $view['users'] = $this->UserModel->GetUsers();

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function edit_lecture($id)
    {
        $this->auth();
        $view['css'] = 'admin/lectures/css';
        $view['js'] = 'admin/lectures/js';
        $view['content'] = 'admin/lectures/update';

        $view['users'] = $this->UserModel->GetUsers();
        $view['lecture'] = $this->LectureModel->GetLecture($id);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function view_lecture($id)
    {
        $this->auth();
        $view['css'] = 'admin/lectures/css';
        $view['js'] = 'admin/lectures/js';
        $view['content'] = 'admin/lectures/view';

        $view['users'] = $this->UserModel->GetUsers();
        $view['lecture'] = $this->LectureModel->GetLecture($id);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function lecture_report()
    {
        $this->auth();
        $extract = false;
        if ($_POST) {
            if (isset($_POST['report_date'])) {
                $view['lectures'] = $this->ReportsModel->GetLectures($_POST['report_date'], $extract);
                $view['selected_date'] = $_POST['report_date'];
            } else {
                $view['selected_date'] = 'today';
            }
        } else {
            $view['selected_date'] = 'today';
            $view['lectures'] = $this->ReportsModel->GetLectures('today', $extract);
        }


        $view['css'] = 'admin/lectures/css';
        $view['js'] = 'admin/lectures/js';
        $view['content'] = 'admin/lectures/report';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    // LECTURES END //////////////////////

    // FEEDBACK AND SUGGESTIONS START
    public function feedback_and_suggestions()
    {
        $this->auth();
        $view['css'] = 'admin/feedback_and_suggestions/css';
        $view['js'] = 'admin/feedback_and_suggestions/js';
        $view['content'] = 'admin/feedback_and_suggestions/index';

        $view['feedbacks'] = $this->FeedbackModel->GetFeedbacks();

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function feedback_and_suggestions_report()
    {
        $this->auth();
        $extract = false;
        if ($_POST) {
            if (isset($_POST['report_date'])) {
                $view['feedbacks'] = $this->ReportsModel->GetFeedback($_POST['report_date'], $extract);
                $view['selected_date'] = $_POST['report_date'];
            } else {
                $view['selected_date'] = 'today';
            }
        } else {
            $view['selected_date'] = 'today';
            $view['feedbacks'] = $this->ReportsModel->GetFeedback('today', $extract);
        }

        $view['css'] = 'admin/feedback_and_suggestions/css';
        $view['js'] = 'admin/feedback_and_suggestions/js';
        $view['content'] = 'admin/feedback_and_suggestions/report';


        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function feedback_and_suggestions_create()
    {
        $this->auth();
        $view['css'] = 'admin/feedback_and_suggestions/css';
        $view['js'] = 'admin/feedback_and_suggestions/js';
        $view['content'] = 'admin/feedback_and_suggestions/create';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function feedback_and_suggestions_view()
    {
        $this->auth();
        $view['css'] = 'admin/feedback_and_suggestions/css';
        $view['js'] = 'admin/feedback_and_suggestions/js';
        $view['content'] = 'admin/feedback_and_suggestions/view';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function feedback_and_suggestions_update()
    {
        $this->auth();
        $view['css'] = 'admin/feedback_and_suggestions/css';
        $view['js'] = 'admin/feedback_and_suggestions/js';
        $view['content'] = 'admin/feedback_and_suggestions/update';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function feedback_and_suggestions_view_contact()
    {
        $this->auth();
        $view['css'] = 'admin/feedback_and_suggestions/css';
        $view['js'] = 'admin/feedback_and_suggestions/js';
        $view['content'] = 'admin/feedback_and_suggestions/view_contact';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function feedback_and_suggestions_update_contact()
    {
        $this->auth();
        $view['css'] = 'admin/feedback_and_suggestions/css';
        $view['js'] = 'admin/feedback_and_suggestions/js';
        $view['content'] = 'admin/feedback_and_suggestions/update_contact';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }
    // FEEDBACK AND SUGGESTIONS END

    // MARKETPLACE START
    public function marketplace()
    {
        $this->auth();
        $view['css'] = 'admin/marketplace/css';
        $view['js'] = 'admin/marketplace/js';
        $view['content'] = 'admin/marketplace/index';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    // view product from others
    public function marketplace_item_view($id)
    {
        $this->auth();
        $view['css'] = 'admin/marketplace/css';
        $view['js'] = 'admin/marketplace/js';
        $view['content'] = 'admin/marketplace/marketplace_item_view';

        $view['product'] = $this->MarketplaceModel->GetProduct($id);
        $view['gallery_images'] = $this->MarketplaceModel->GetGalleryImage($id);

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function marketplace_report(){
        $this->auth();
        $extract = false;
        if ($_POST) {
            if (isset($_POST['report_date'])) {
                $view['transactions'] = $this->ReportsModel->GetBilling($_POST['report_date'], $extract);
                $view['selected_date'] = $_POST['report_date'];
            } else {
                $view['selected_date'] = 'today';
            }
        } else {
            $view['selected_date'] = 'today';
            $view['transactions'] = $this->ReportsModel->GetBilling('today', $extract);
        }

        $view['css'] = 'admin/marketplace/css';
        $view['js'] = 'admin/marketplace/js';
        $view['content'] = 'admin/marketplace/report';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function marketplace_product_report(){
        $this->auth();
        $extract = false;
        if ($_POST) {
            if (isset($_POST['report_date'])) {
                $view['products'] = $this->ReportsModel->GetProducts($_POST['report_date'], $extract);
                $view['selected_date'] = $_POST['report_date'];
            } else {
                $view['selected_date'] = 'today';
            }
        } else {
            $view['selected_date'] = 'today';
            $view['products'] = $this->ReportsModel->GetProducts('today', $extract);
        }

        $view['css'] = 'admin/marketplace/css';
        $view['js'] = 'admin/marketplace/js';
        $view['content'] = 'admin/marketplace/report_products';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    // MARKETPLACE END

    // SYSTEM SETTINGS
    public function system_settings()
    {
        $this->auth();
        $view['css'] = 'admin/system_setting/css';
        $view['js'] = 'admin/system_setting/js';
        $view['content'] = 'admin/system_setting/index';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function createadmin()
    {
        $this->auth();
        $this->super_auth();
        $view['css'] = 'admin/system_setting/css';
        $view['js'] = 'admin/system_setting/js';
        $view['content'] = 'admin/system_setting/createadmin';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function editadmin($id)
    {
        $this->auth();
        $this->super_auth();
        if ($this->UserModel->GetUser($id)) {
            $view['css'] = 'admin/system_setting/css';
            $view['js'] = 'admin/system_setting/js';
            $view['content'] = 'admin/system_setting/editadmin';
            $view['admin'] = $this->UserModel->GetUser($id);
            $view['sidebar'] = 'admin/includes_v2/sidebar';
            $view['navbar'] = 'admin/includes_v2/navbar';
            $view['footer'] = 'admin/includes_v2/footer';


            $this->load->view("admin/main", $view);
        } else {
            redirect(base_url());
        }
    }
    public function adminprofile($id)
    {
        $this->auth();
        if ($this->UserModel->GetUser($id)) {
            if ($_SESSION['account']['details']['role'] == 'superadmin') {
                $view['css'] = 'admin/system_setting/css';
                $view['js'] = 'admin/system_setting/js';
                $view['content'] = 'admin/system_setting/adminprofile';
                $view['admin'] = $this->UserModel->GetUser($id);
                $view['sidebar'] = 'admin/includes_v2/sidebar';
                $view['navbar'] = 'admin/includes_v2/navbar';
                $view['footer'] = 'admin/includes_v2/footer';

                $this->load->view("admin/main", $view);
            } else if ($_SESSION['account']['details']['role'] == 'admin' && $id == $_SESSION['account']['details']['id']) {
                $view['css'] = 'admin/system_setting/css';
                $view['js'] = 'admin/system_setting/js';
                $view['content'] = 'admin/system_setting/adminprofile';
                $view['admin'] = $this->UserModel->GetUser($id);
                $view['sidebar'] = 'admin/includes_v2/sidebar';
                $view['navbar'] = 'admin/includes_v2/navbar';
                $view['footer'] = 'admin/includes_v2/footer';

                $this->load->view("admin/main", $view);
            } else {
                redirect(base_url('AdminFE/dashboard'));
            }
        } else {
            redirect(base_url());
        }
    }
    public function adminchangepassword()
    {
        $this->auth();
        $view['css'] = 'admin/system_setting/css';
        $view['js'] = 'admin/system_setting/js';
        $view['content'] = 'admin/system_setting/adminchangepassword';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }
    public function createbilling()
    {
        $this->auth();
        $view['css'] = 'admin/system_setting/css';
        $view['js'] = 'admin/system_setting/js';
        $view['content'] = 'admin/system_setting/createbilling';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }
    public function editbilling()
    {
        $this->auth();
        $view['css'] = 'admin/system_setting/css';
        $view['js'] = 'admin/system_setting/js';
        $view['content'] = 'admin/system_setting/editbilling';

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function viewbilling($id)
    {
        $this->auth();
        if ($this->BillingModel->GetBilling($id)) {
            $view['billing'] = $this->BillingModel->GetBilling($id);
        } else {
            redirect(base_url('Admin_FE/system_settings'));
        }
        $view['css'] = 'admin/system_setting/css';
        $view['js'] = 'admin/system_setting/js';
        $view['content'] = 'admin/system_setting/viewbilling';
        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function createnotification()
    {
        $this->auth();
        $view['css'] = 'admin/system_setting/css';
        $view['js'] = 'admin/system_setting/js';
        $view['content'] = 'admin/system_setting/createnotifications';
        $view['users'] = $this->UserModel->GetUsers();

        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function viewnotification($id)
    {
        $this->auth();
        $view['css'] = 'admin/system_setting/css';
        $view['js'] = 'admin/system_setting/js';
        $view['content'] = 'admin/system_setting/viewnotification';
        $view['users'] = $this->UserModel->GetUsers();
        $view['notif'] = $this->NotificationModel->GetNotification($id);
        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
    }

    public function editnotification($id)
    {
        $this->auth();
        $view['css'] = 'admin/system_setting/css';
        $view['js'] = 'admin/system_setting/js';
        $view['content'] = 'admin/system_setting/editnotifications';
        $view['users'] = $this->UserModel->GetUsers();
        $view['notif'] = $this->NotificationModel->GetNotification($id);
        $view['sidebar'] = 'admin/includes_v2/sidebar';
        $view['navbar'] = 'admin/includes_v2/navbar';
        $view['footer'] = 'admin/includes_v2/footer';

        $this->load->view("admin/main", $view);
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
