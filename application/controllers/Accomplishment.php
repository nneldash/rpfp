<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Accomplishment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('accomplishment/AccomplishmentClass');

        if (!$this->LoginModel->isLoggedIn()) {
            redirect(site_url());
            return;
        }

        $this->load->model('ProfileModel');
        $this->load->model('AccomplishmentModel');
    }

    public function viewAccompModal()
    {
        $this->load->view('menu/listTables/accomplishmentModal');
    }

    public function genAccompData()
    {
        $username = $_SESSION['username'];
        $pscgc_code = 8;
        $genData = new GenerateAccomplishmentClass();

        $genData->ReportYear = $this->input->post('year');
        $genData->ReportMonth = $this->input->post('month');

        $data = ['is_save' => true];
        if (!$this->AccomplishmentModel->saveAccomplishment($username, $pscgc_code, $genData)) {
            $data = ['is_save' => false];
        }

        print_r($data);
        exit;

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

}
