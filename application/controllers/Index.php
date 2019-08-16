<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Index extends CI_Controller
{
    public function index()
    {
        redirect(site_url());
    }

    public function index()
    {   
        $header['title'] = 'RPFP - Homepage';

        $this->load->view("includes/header", $header);
        $this->load->view("index/landingPage");
        $this->load->view("includes/footer");
    }
}
