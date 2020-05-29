<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Accomplishment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->LoginModel->isLoggedIn()) {
            redirect(site_url());
            return;
        }

        $this->load->library('accomplishment/AccomplishmentClass');

        $this->load->model('AccomplishmentModel');
        $this->load->model('ProfileModel');
    }

    public function genAccompData()
    {
        $username = $this->session->userdata('username');
        $genData = new GenerateAccomplishmentClass();

        $profile = $this->ProfileModel->getOwnProfile();
        $pscgc_code = $profile->DesignatedLocation->Region->Code;

        $genData->DateFrom = $this->input->post('accompDateFromSelect');
        $genData->DateTo = $this->input->post('accompDateToSelect');

        $rows = $this->AccomplishmentModel->saveAccomplishment($username, $pscgc_code, $genData);
        $rowdata = $rows;
        if (is_array($rows)) {
            $rowdata = $rows[0];
        }
        $data = array('is_save' => true);
        if (!empty($rowdata->message) && (strcmp($rowdata->message, "NEW ENTRY: 0") == 0)) {
            $data = array('is_save' => false);
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
