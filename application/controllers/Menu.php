<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $header['title'] = 'RPFP Online | Pending';

        $this->load->view('includes/admin_header', $header);
        $this->load->view('menu/pending');
        $this->load->view('includes/admin_footer');
    }

    public function approve()
    {
        $header['title'] = 'RPFP Online | Approve';

        $this->load->view('includes/admin_header', $header);
        $this->load->view('menu/approve');
        $this->load->view('includes/admin_footer');
    }

    public function importExcel()
    {
        $header['title'] = 'RPFP Online | Import Excel';

        $this->load->view('includes/header', $header);
        $this->load->view('menu/import');
        $this->load->view('includes/footer');
    }
}
