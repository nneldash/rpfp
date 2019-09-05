<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view("includes/admin_header");
        $this->load->view("admin/admin");
        $this->load->view("includes/admin_footer");
    }
}
