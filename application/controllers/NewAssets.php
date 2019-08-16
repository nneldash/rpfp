<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NewAssets extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('login/homepage');
    }

    public function bootstrapCss()
    {
        header('Content-Type: text/css');
        readfile(BASEPATH . BOOTSRAP_CSS);
    }

    public function bootstrapJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . BOOTSRAP_JS);
    }

    public function jquery()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . JQUERY_JS);
    }
    
}