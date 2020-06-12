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
        $this->load->model('CoupleModel');
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
            $this->load->view('menu/approve', array(RELOAD => true));
            $this->load->view('menu/approve_list', array('approve' => $approve));
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/approve');
        $this->load->view('menu/approve_list', array('approve' => $approve));
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
            $footer = '<html>
                            <head>
                            <style>
                                @page {
                                    size: auto;
                                    odd-footer-name: MyFooter1;
                                    margin-right: 20px;
                                    margin-left: 20px;
                                }
                            </style>
                            </head>
                            <body>
                                <pagefooter name="MyFooter1" content-right="{DATE M j,Y h:i a}"
                                footer-style="font-size: 7pt;" />
                            </body>
                        </html>';

            $mpdf->SetTitle('Online RPFP Monitoring System | Accomplishment Report');
            $mpdf->WriteHTML($footer);
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
        $profile = $this->ProfileModel->getOwnProfile();
        $profile = UserProfile::getFromVariable($profile);

        $isFocal = $profile->isFocal();

        $this->load->library('formA/FormAClass');

        $this->load->model('FormAModel');
        $forma = $this->FormAModel->getFormAList();
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/formAMenu', 
                    array('form_A' => $forma, 
                    RELOAD => true,
                    'isFocal' => $isFocal
                )
            );
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/formAMenu', 
            array(
                'form_A' => $forma,
                'isFocal' => $isFocal
            )
        );
        $this->footer();      
        
        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function formB()
    {
        $profile = $this->ProfileModel->getOwnProfile();
        $profile = UserProfile::getFromVariable($profile);

        $isFocal = $profile->isFocal();

        $this->load->library('formB/FormBClass');

        $this->load->model('FormBModel');
        $formb = $this->FormBModel->getFormBList();
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/formBMenu', 
                array(
                    'form_B' => $formb, 
                    RELOAD => true,
                    'isFocal' => $isFocal
                )
            );
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/formBMenu', 
            array(
                'form_B' => $formb,
                'isFocal' => $isFocal
            )
        );
        $this->footer();    
        
        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function formC()
    {
        $profile = $this->ProfileModel->getOwnProfile();
        $profile = UserProfile::getFromVariable($profile);

        $isFocal = $profile->isFocal();
        
        $this->load->library('formC/FormCClass');

        $this->load->model('FormCModel');
        $formc = $this->FormCModel->getFormCList();
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/formCMenu', 
                array(
                    'form_C' => $formc,
                    RELOAD => true,
                    'isFocal' => $isFocal
                )
            );
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/formCMenu', 
            array(
                'form_C' => $formc,
                'isFocal' => $isFocal
            )
        );
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

        $searchApprove->ProvinceCode = $this->input->post('province_search');
        $searchApprove->MunicipalityCode = $this->input->post('municipality_search');
        $searchApprove->BarangayCode = $this->input->post('barangay_search');
        $searchApprove->ClassNo = $this->input->post('classno_search');
        $searchApprove->DateConductedFrom = $this->input->post('datefrom_search');
        $searchApprove->DateConductedTo = $this->input->post('dateto_search');
        $searchApprove->TypeOfClass = $this->input->post('typeclass_search');
        $searchApprove->CoupleName = $this->input->post('name_search');
        $searchApprove->AgeFrom = $this->input->post('agefrom_search');
        $searchApprove->AgeTo = $this->input->post('ageto_search');
        $searchApprove->NoOfChildren = $this->input->post('no_children_search');
        $searchApprove->ModernFpUser = $this->input->post('modernfp_search');
        $searchApprove->NonModernFpUser = $this->input->post('nonmodern_search');
        $searchApprove->IntentionStatus = $this->input->post('intention_status_search');
        $searchApprove->IntentionToUse = $this->input->post('intention_to_use_search');
        $searchApprove->SearchStatus = $this->input->post('fpstatus_search');
        
        
        $ret_val = $this->CoupleModel->getSearchValues($searchApprove);

        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/approve_list', array('approve' => $ret_val));
            return;
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($ret_val));
    }
}
