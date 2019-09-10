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

    public function datatablesBootstrap()
    {
        header('Content-Type: text/css');
        readfile(BASEPATH . DATATABLES_BOOTSTRAP);
    }

    public function datatablesResponsive()
    {
        header('Content-Type: text/css');
        readfile(BASEPATH . DATATABLES_RESPONSIVE);
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

    public function templateJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . TEMPLATE_JS);
    }
    
    public function popper()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . POPPER_JS);
    }

    public function sweetalertCss()
    {
        header('Content-Type: text/css');
        readfile(BASEPATH . SWEETALERT_CSS);
    }

    public function fontAwesome()
    {
        header('Content-Type: text/css');
        readfile(BASEPATH . FONT_AWESOME);
    }

    public function nProgress()
    {
        header('Content-Type: text/css');
        readfile(BASEPATH . NPROGRESS);
    }

    public function customCss()
    {
        header('Content-Type: text/css');
        readfile(BASEPATH . CUSTOM);
    }

    public function sweetalertJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . SWEETALERT_JS);
    }

    public function datatableJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . DATATABLES_JS);
    }

    public function datatableBtJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . DATATABLES_BOOTSTRAP_JS);
    }

    public function datatableRpJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . DATATABLES_RESPONSIVE_JS);
    }

    public function datatableBtrpJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . DATATABLES_BTRP_JS);
    }

    public function nProgressJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . NPROGRESS_JS);
    }

    public function progressBarJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . PROGRESSBAR_JS);
    }

    public function customJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . CUSTOM_JS);
    }
}