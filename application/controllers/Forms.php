<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forms extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $header['title'] = 'RPFP Online | Form 1';

        $this->load->view('includes/header', $header);
        $this->load->view('forms/form1');
        $this->load->view('includes/footer');
    }
    
}