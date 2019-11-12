<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->LoginModel->isLoggedIn()) {
            redirect('Login');
            return;
        }

        $this->load->model('ProfileModel');
        $this->load->model('CoupleModel');
        $this->load->library('couple_list/ApproveClass');
        $this->load->library('couple_list/PendingClass');
        $this->load->model('AccomplishmentModel');
        $this->load->library('accomplishment_list/AccomplishmentClass');
        $this->load->model('FormAModel');
        $this->load->library('formA/FormAClass');
        $this->load->model('FormBModel');
        $this->load->library('formB/FormBClass');
        $this->load->model('FormCModel');
        $this->load->library('formC/FormCClass');
    }

    public function index()
    {
        $isPMED = $this->ProfileModel->isPMED();
        $isEncoder = $this->ProfileModel->isEncoder();
        $isFocalPerson = $this->ProfileModel->isFocalPerson();
        $isRegionalDataManager = $this->ProfileModel->isRegionalDataManager();
        $isITDMU = $this->ProfileModel->isITDMU();

        $this->load->view(
            'includes/admin_header',
            array(
                'isEncoder' => $isEncoder,
                'isPMED' => $isPMED,
                'isFocalPerson' => $isFocalPerson,
                'isRegionalDataManager' => $isRegionalDataManager,
                'isITDMU' => $isITDMU
            )
        );

        if (empty($this->do_not_render_footer)) {
            $this->footer();
        }        
    }

    private function footer()
    {
        $this->load->view('includes/admin_footer');
    }

    public function pending()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            redirect('Welcome');
            return;
        }

        $pending = $this->CoupleModel->getPendingList();
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/pending', array('pending' => $pending, RELOAD => true));
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/pending', array('pending' => $pending));
        $this->footer();
    }

    public function approve()
    {
        $approve = $this->CoupleModel->getApproveList();
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/approve', array('approve' => $approve, RELOAD => true));
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/approve', array('approve' => $approve));
        $this->footer();        
    }

    public function importExcel()
    {
        $this->load->view('menu/import');
    }

    public function accomplishment()
    {
        $accomplishment = $this->AccomplishmentModel->getAccomplishmentList();
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/accomplishment', array('accomplishment' => $accomplishment, RELOAD => true));
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/accomplishment', array('accomplishment' => $accomplishment));
        $this->footer();        
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

            $html = $this->load->view('menu/accomplishment', array('is_pdf' => true), true);

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
    }

    public function formA()
    {
        $forma = $this->FormAModel->getFormAList();
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/formAMenu', array('form_A' => $forma, RELOAD => true));
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/formAMenu', array('form_A' => $forma));
        $this->footer();        
    }

    public function formB()
    {
        $formb = $this->FormBModel->getFormBList();
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/formBMenu', array('form_B' => $formb, RELOAD => true));
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/formBMenu', array('form_B' => $formb));
        $this->footer();        
    }

    public function formC()
    {
        $formc = $this->FormCModel->getFormCList();
        if ($this->input->server(REQUEST_METHOD) == POST) {
            $this->load->view('menu/formCMenu', array('form_C' => $formc, RELOAD => true));
            return;
        }

        $this->do_not_render_footer = true;
        $this->index();
        $this->load->view('menu/formCMenu', array('form_C' => $formc));
        $this->footer();        
    }

    public function pendingCoupleModal()
    {
        $classId = $this->input->post('classId');
        
        $formList = $this->CoupleModel->getFormList($classId);
        $this->load->view('menu/listTables/pendingTable', array('forms' => $formList));
    }

    public function approveCoupleModal()
    {
        $classId = $this->input->post('classId');
        
        $formList = $this->CoupleModel->getFormList($classId);
        $this->load->view('menu/listTables/approveTable', array('forms' => $formList));
    }

    public function profile()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            redirect('Login');
            return;
        }

        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            redirect(site_url('Menu'));
            return;
        }

        $this->load->model('ProfileModel');
        $profile = $this->ProfileModel->getOwnProfile();
        $this->load->view('profile/profile.php', array('profile' => $profile));
    }
}
