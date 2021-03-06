<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FormGeneration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->LoginModel->isLoggedIn()) {
            redirect(site_url());
            return;
        }

        $this->load->library('formA/GenerateFormAClass');
        $this->load->library('formB/GenerateFormBClass');
        $this->load->library('formC/GenerateFormCClass');

        $this->load->model('FormAModel');
        $this->load->model('FormBModel');
        $this->load->model('FormCModel');
        $this->load->model('ProfileModel');
    }

    public function genFormA()
    {
        $demandgen_id = '';
        $genData = new GenerateFormAClass();

        $profile = $this->ProfileModel->getOwnProfile();
        $psgc_code = $profile->DesignatedLocation->Region->Code;

        $genData->ReportType = $this->input->post('repTypeSelect');
        $genData->ReportYear = $this->input->post('repYearSelect');
        $genData->ReportQuarter = $this->input->post('repQuarterSelect');
        $genData->ReportMonth = $this->input->post('repMonthSelect');

        if (!$this->FormAModel->saveFormA($psgc_code, $genData)) {
            $data = ['is_save' => false];
        } else {
            $data = ['is_save' => true];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function genFormB()
    {
        $unmet_id = '';
        $genData = new GenerateFormBClass();

        $profile = $this->ProfileModel->getOwnProfile();
        $psgc_code = $profile->DesignatedLocation->Region->Code;

        $genData->ReportType = $this->input->post('repTypeSelect');
        $genData->ReportYear = $this->input->post('repYearSelect');
        $genData->ReportQuarter = $this->input->post('repQuarterSelect');
        $genData->ReportMonth = $this->input->post('repMonthSelect');

        if (!$this->FormBModel->saveFormB($psgc_code, $genData)) {
            $data = ['is_save' => false];
        } else {
            $data = ['is_save' => true];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function genFormC()
    {
        $served_id = '';
        $genData = new GenerateFormCClass();

        $profile = $this->ProfileModel->getOwnProfile();
        $psgc_code = $profile->DesignatedLocation->Region->Code;
        
        $genData->ReportType = $this->input->post('repTypeSelect');
        $genData->ReportYear = $this->input->post('repYearSelect');
        $genData->ReportQuarter = $this->input->post('repQuarterSelect');
        $genData->ReportMonth = $this->input->post('repMonthSelect');

        if (!$this->FormCModel->saveFormC($psgc_code, $genData)) {
            $data = ['is_save' => false];
        } else {
            $data = ['is_save' => true];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

}
