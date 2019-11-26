<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FormGeneration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('formA/GenerateFormAClass');
        $this->load->library('formB/GenerateFormBClass');
        $this->load->library('formC/GenerateFormCClass');

        if (!$this->LoginModel->isLoggedIn()) {
            redirect(site_url());
            return;
        }

        $this->load->model('FormAModel');
        $this->load->model('FormBModel');
        $this->load->model('FormCModel');
    }

    public function genFormA()
    {
        $pscgc_code = 8;
        $genData = new GenerateFormAClass();

        $genData->ReportYear = $this->input->post('year');
        $genData->ReportMonth = $this->input->post('month');

        if (!$this->FormAModel->saveFormA($pscgc_code, $genData)) {
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
        $pscgc_code = 8;
        $genData = new GenerateFormBClass();

        $genData->ReportYear = $this->input->post('year');
        $genData->ReportMonth = $this->input->post('month');

        if (!$this->FormBModel->saveFormB($unmet_id, $pscgc_code, $genData)) {
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
        $pscgc_code = 8;
        $genData = new GenerateFormCClass();

        $genData->ReportYear = $this->input->post('year');
        $genData->ReportMonth = $this->input->post('month');

        if (!$this->FormBModel->saveFormC($served_id, $pscgc_code, $genData)) {
            $data = ['is_save' => false];
        } else {
            $data = ['is_save' => true];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

}
