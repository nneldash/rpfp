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
        $header['title'] = 'Welcome | RPFP Online v.3';

        if (isset($GLOBALS[NO_OUTPUT]) && $GLOBALS[NO_OUTPUT]) {
            return;
        }

        if (!$this->LoginModel->isLoggedIn()) {
            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');
            return;
        }

        $this->load->Model('ProfileModel');
        if ($this->ProfileModel->isEncoder()) {
            redirect(site_url('Forms'));
            return;
        }

        $this->load->view("includes/header", $header);
        $this->load->view("menu/dashboard.php");
        $this->load->view('includes/footer');
        return;
    }
}
