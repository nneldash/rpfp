<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->LoginModel->isLoggedIn()) {
            redirect(site_url());
            return;
        }

        $this->load->model('ProfileModel');
        $this->load->library('couple_list/SearchApproveClass');
    }

    public function index()
    {
        $profile = $this->ProfileModel->getOwnProfile();

        $this->load->view(
            'includes/admin_header',
            array('profile' => $profile)
        );

        if (empty($this->do_not_render_footer)) {
            $this->footer();
        }

        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    private function footer()
    {
        $this->load->view('includes/admin_footer');
    }

    public function pending()
    {
        $this->load->library('couple_list/PendingClass');

        $this->load->model('CoupleModel');
        $pending = $this->CoupleModel->getPendingList();
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/pending', array('pending' => $pending, RELOAD => true));
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/pending', array('pending' => $pending));
        $this->footer();

        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function approve()
    {
        $this->load->library('couple_list/ApproveClass');

        $this->load->model('CoupleModel');
        $approve = $this->CoupleModel->getApproveList();
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/approve', array('approve' => $approve, RELOAD => true));
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/approve', array('approve' => $approve));
        $this->footer();

        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function importExcel()
    {
        $this->load->view('menu/import');
    }

    public function accomplishment()
    {
        $this->load->model('AccomplishmentModel');
        $this->load->library('accomplishment/AccomplishmentClass');

        $accomplishment = $this->AccomplishmentModel->getAccomplishmentList();
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/accomplishment', array('accomplishment' => $accomplishment, RELOAD => true));
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/accomplishment', array('accomplishment' => $accomplishment));
        $this->footer();

        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }


    public function search()
    {
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/search', array(RELOAD => true));
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/search');
        $this->footer();

        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function printAccomplishment()
    {
        $mpdfConfig = array(
            'format' => 'A4',
            'orientation' => 'P'
        );
        
        try {
            $mpdf = new \Mpdf\Mpdf($mpdfConfig);
            $mpdf->debug = true;

            $reportNo = $this->input->get('ReportNo');

            $this->load->model('AccomplishmentModel');
            $accomplishment = $this->AccomplishmentModel->getAccomplishmentReport($reportNo);

            $html = $this->load->view('forms/accomplishment', array('is_pdf' => true, 'accomplishment' => $accomplishment), true);

            $mpdf->SetTitle('Online RPFP Monitoring System | Accomplishment Report');
            $mpdf->WriteHTML($html);
            $mpdf->Output(date('Ymd') . ' - Accomplishment Report.pdf', 'I');
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }

    public function dashboard()
    {
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/dashboard', array(RELOAD => true));
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/dashboard');
        $this->footer();

        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function formA()
    {
        $this->load->library('formA/FormAClass');

        $this->load->model('FormAModel');
        $forma = $this->FormAModel->getFormAList();
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/formAMenu', array('form_A' => $forma, RELOAD => true));
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/formAMenu', array('form_A' => $forma));
        $this->footer();      
        
        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function formB()
    {
        $this->load->library('formB/FormBClass');

        $this->load->model('FormBModel');
        $formb = $this->FormBModel->getFormBList();
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/formBMenu', array('form_B' => $formb, RELOAD => true));
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/formBMenu', array('form_B' => $formb));
        $this->footer();    
        
        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function formC()
    {
        $this->load->library('formC/FormCClass');

        $this->load->model('FormCModel');
        $formc = $this->FormCModel->getFormCList();
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/formCMenu', array('form_C' => $formc, RELOAD => true));
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/formCMenu', array('form_C' => $formc));
        $this->footer();
        
        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function pendingCoupleModal()
    {
        $classId = $this->input->post('classId');
        
        $this->load->model('CoupleModel');
        $formList = $this->CoupleModel->getFormList($classId);
        $this->load->view('menu/listTables/pendingTable', array('forms' => $formList));

        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function approveCoupleModal()
    {
        $classId = $this->input->post('classId');
        
        $this->load->model('CoupleModel');
        $formList = $this->CoupleModel->getFormList($classId);
        $this->load->view('menu/listTables/approveTable', array('forms' => $formList));
        
        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function profile()
    {
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            redirect(site_url('Menu'));
            return;
        }

        $this->load->model('ProfileModel');
        $profile = $this->ProfileModel->getOwnProfile();
        $this->load->view('profile/profile.php', array('profile' => $profile));

        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function barGraph()
    {
        $percentage_year = $this->input->post('percentage_year');

        $data = $this->CoupleModel->getPercentageYear($percentage_year);

        echo '<pre>';
        print_r($data);
    }

    public function approvedClassSearch()
    {
        $searchApprove = new SearchApproveClass();

        $searchApprove->LocationCode = $this->input->post('province_search');
        $searchApprove->ClassNo = $this->input->post('classno_search');
        $searchApprove->DateConductedFrom = $this->input->post('datefrom_search');
        $searchApprove->DateConductedTo = $this->input->post('dateto_search');
        $searchApprove->TypeOfClass = $this->input->post('typeclass_search');
        $searchApprove->Name = $this->input->post('name_search');
        $searchApprove->AgeFrom = $this->input->post('agefrom_search');
        $searchApprove->AgeTo = $this->input->post('ageto_search');
        $searchApprove->NoOfChildren = $this->input->post('no_children_search');
        $searchApprove->FpType = $this->input->post('fptype_search');
        $searchApprove->FpUser = $this->input->post('fpuser_search');
        $searchApprove->NonFpUser = $this->input->post('nonfpuser_search');
        $searchApprove->IntentionStatus = $this->input->post('intention_status_search');
        
        
        $ret_val = $this->CoupleModel->getSearchValues($searchApprove);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($ret_val));
    }
}
