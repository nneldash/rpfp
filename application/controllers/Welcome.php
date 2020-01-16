<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $header['title'] = 'Welcome | Online RPFP Monitoring System';

        if (isset($GLOBALS[NO_OUTPUT]) && $GLOBALS[NO_OUTPUT]) {
            return;
        }

        if (!$this->LoginModel->isLoggedIn()) {
            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');
            return;
        }

        $this->load->library('common/PageHandler');
        PageHandler::redirectToPreviousPageIfNotEmpty();

        $this->load->Model('ProfileModel');
        $profile = $this->ProfileModel->getOwnProfile();
        $profile = UserProfile::getFromVariable($profile);
        if ($profile->isEncoder()) {
            redirect(site_url('Forms'));
            return;
        }

        if ($profile->isPMED()) {
            redirect(site_url('Menu/formA'));
            return;
        }

        if ($profile->isRegionalDataManager()) {
            redirect(site_url('Menu'));
            return;
        }

        if ($profile->isITDMU()) {
            redirect(site_url('UserProfile'));
            return;
        }

        if ($profile->isFocal()) {
            redirect(site_url('Menu'));
            return;
        }

        $this->load->view("includes/header", $header);
        $this->load->view("menu/dashboard.php");
        $this->load->view('includes/footer');
        return;
    }
}
