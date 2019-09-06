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
            $this->load->view("includes/footer");
            return;
        }

        $this->load->view("login/homepage.php");
        return;
    }
}
