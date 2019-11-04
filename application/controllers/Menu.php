<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('CoupleModel');
        $this->load->library('couple_list/ApproveClass');
        $this->load->library('couple_list/PendingClass');
    }

    public function index()
    {
        return $this->pending();
    }

    public function pending()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            redirect('Welcome');
            return;
        }

        $pending = $this->CoupleModel->getPendingList();
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->load->view('menu/pending', array('pending' => $pending, 'reload' => true));
            return;
        }

        $this->load->model('ProfileModel');
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
        $this->load->view('menu/pending', array('pending' => $pending));
        $this->load->view('includes/admin_footer');
    }

    public function approve()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            redirect('Login');
            return;
        }

        $approve = $this->CoupleModel->getApproveList();
        if ($this->input->server('REQUEST_METHOD') == 'POST') {
            $this->load->view('menu/approve', array('approve' => $approve, 'reload' => true));
            return;
        }

        $this->load->model('CoupleModel');
        $approve = $this->CoupleModel->getApproveList();

        $this->load->model('ProfileModel');
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
        $this->load->view('menu/approve', array('approve' => $approve));
        $this->load->view('includes/admin_footer');
    }

    public function importExcel()
    {
        $this->load->view('menu/import');
    }

    public function summary()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            return;
        }

        $title = 'RPFP Online | Accomplishment Report';

        $this->load->model('ProfileModel');
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
                'isITDMU' => $isITDMU,
                'title' => $title
            )
        );
        $this->load->view('menu/summary', array('is_pdf' => false), false);
        $this->load->view('includes/admin_footer');
    }

    public function search()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            return;
        }

        $title = 'RPFP Online | Search Form 1';

        $this->load->model('ProfileModel');
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
                'isITDMU' => $isITDMU,
                'title' => $title
            )
        );
        $this->load->view('menu/search');
        $this->load->view('includes/admin_footer');
    }

    public function printSummary()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            return;
        }

        $mpdfConfig = array(
            'format' => 'A4',
            'orientation' => 'P'
        );
        
        try {
            $mpdf = new \Mpdf\Mpdf($mpdfConfig);
            $mpdf->debug = true;

            $html = $this->load->view('menu/summary', array('is_pdf' => true), true);

            $mpdf->SetTitle('RPFP Online | Accomplishment Report');
            $mpdf->WriteHTML($html);
            $mpdf->Output(date('Ymd') . ' - Accomplishment Report.pdf', 'I');
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }

    public function dashboard()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            return;
        }

        $title = 'RPFP Online | Dashboard';

        $this->load->model('ProfileModel');
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
                'isITDMU' => $isITDMU,
                'title' => $title
            )
        );
        $this->load->view('menu/dashboard');
        $this->load->view('includes/admin_footer');
    }

    public function formA()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            return;
        }

        $title = 'RPFP Online | Form A Data List';

        $this->load->model('ProfileModel');
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
                'isITDMU' => $isITDMU,
                'title' => $title
            )
        );
        $this->load->view('menu/formAMenu');
        $this->load->view('includes/admin_footer');
    }

    public function formB()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            return;
        }

        $title = 'RPFP Online | Form B Data List';

        $this->load->model('ProfileModel');
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
                'isITDMU' => $isITDMU,
                'title' => $title
            )
        );
        $this->load->view('menu/formBMenu');
        $this->load->view('includes/admin_footer');
    }

    public function formC()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            return;
        }

        $title = 'RPFP Online | Form C Data List';

        $this->load->model('ProfileModel');
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
                'isITDMU' => $isITDMU,
                'title' => $title
            )
        );
        $this->load->view('menu/formCMenu');
        $this->load->view('includes/admin_footer');
    }

    public function accomplishment()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');
            
            return;
        }

        $title = 'RPFP Online | Form Accomplishment Report Data List';

        $this->load->model('ProfileModel');
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
                'isITDMU' => $isITDMU,
                'title' => $title
            )
        );
        $this->load->view('menu/summary', array('is_pdf' => false), false);
        $this->load->view('includes/admin_footer');
    }

    public function pendingCoupleModal()
    {
        $this->load->view('menu/listTables/pendingTable');
    }

    public function approveCoupleModal()
    {
        $this->load->view('menu/listTables/approveTable');
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
