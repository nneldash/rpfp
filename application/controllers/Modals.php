<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Modals extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function viewAccompModal()
    {
        $this->load->view('menu/modals/accomplishmentModal');
    }

    public function viewFormAModal()
    {
        $this->load->view('menu/modals/reportAModal');
    }

    public function viewFormBModal()
    {
        $this->load->view('menu/modals/reportBModal');
    }

    public function viewFormCModal()
    {
        $this->load->view('menu/modals/reportCModal');
    }

}
