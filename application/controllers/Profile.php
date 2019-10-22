<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->LoginModel->isLoggedIn()) {
            redirect(site_url());
            return;
        }

        $this->load->model('ProfileModel');
    }

    public function index($params = array()) {
        $profile = $this->getOwnProfile();
        $the_title = 'Profile | RPFP Online';

        $this->load->view('includes/header', array('title' => $the_title));
        $this->load->view('profile/profile.php', array('profile' => $profile));
        $this->load->view('includes/footer');
        return;
    }

    public function getProfile($user_id = BLANK)
    {
        if (!$this->ProfileModel->isITDMU()) {
            return "ERROR NOT ALLOWED";
        }

        if ($user_id == BLANK) {
            return "ERROR NO USER SPECIFIED";
        }

        return $this->ProfileModel->getProfile($user_id);
    }

    public function getOwnProfile()
    {
        return $this->ProfileModel->getOwnProfile();
    }

}
