<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pending extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $header['title'] = 'RPFP Online | Pending';

        $this->load->view('includes/admin_header', $header);
        $this->load->view('pending');
        $this->load->view('includes/admin_footer');
    }
}
