<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->LoginModel->isLoggedIn()) {
            redirect(site_url());
            return;
        }

        $this->load->library('report/DeleteReportClass');
        $this->load->library('report/lists/ListDeleteReportClass');

        $this->load->model('AccomplishmentModel');
        $this->load->model('ProfileModel');
    }

   public function deleteReport()
    {
        $deleteData = new DeleteReportClass();

        $user = $this->ProfileModel->getOwnProfile();
        $user = UserProfile::getFromVariable($user);

        if ($user->isRegionalDataManager()) {
            $formName = $this->input->post('reportName');
            
            if ($formName == 'formA') {
                $procName = 'delete_report_demandgen';
            } elseif ($formName == 'formB') {
                $procName = 'delete_report_unmet_need';
            } elseif ($formName == 'formC') {
                $procName = 'delete_report_served_method_mix';
            } elseif ($formName == 'accompReport') {
                $procName = 'delete_report_accomplishment';
            } else {
                return false;
            }

            $deleteData = $this->DeleteReportData();
            $delete = $this->AccomplishmentModel->deleteReport($procName, $deleteData);
            
            if ($delete == 'deleted') {
                $data = ['message' => 'deleted'];
            } else {
                $data = ['message' => false];
            }

            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($data));
        }        
    }

    private function DeleteReportData() : ListDeleteReportInterface
    {
        $report_list = new ListDeleteReportClass();
        $reports = $this->input->post('reportNo');

        foreach ($reports as $key => $value) {
            $report = new DeleteReportClass();
            $report->ReportNo = $value;

            $report_list->append($report);
        }

        return $report_list;
    }

}
