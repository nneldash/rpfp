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

        $this->load->model('AccomplishmentModel');
        $this->load->model('ProfileModel');
    }

    public function genAccompData()
    {
        $username = $this->session->userdata('username');
        $genData = new GenerateAccomplishmentClass();

        $profile = $this->ProfileModel->getOwnProfile();
        $pscgc_code = $profile->DesignatedLocation->Region->Code;

        $genData->ReportYear = $this->input->post('accompYearSelect');
        $genData->ReportMonth = $this->input->post('accompMonthSelect');

        $data = $this->AccomplishmentModel->saveAccomplishment($username, $pscgc_code, $genData);
        $data = explode(': ', $data);

        if($data[1] > 0) {
            $data = ['is_save' => true];
        } else {
            $data = ['is_save' => false];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

}
