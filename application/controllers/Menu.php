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
        $header['title'] = 'RPFP Online | Pending';

        $this->load->model('CoupleModel');
        $pending = $this->CoupleModel->getPendingList();
        
        $this->load->view('includes/admin_header', $header);
        $this->load->view('menu/pending', array('pending' => $pending));
        $this->load->view('includes/admin_footer');
    }

    public function approve()
    {
        $header['title'] = 'RPFP Online | Approve';

        $this->load->model('CoupleModel');
        $approve = $this->CoupleModel->getApproveList();

        $this->load->view('includes/admin_header', $header);
        $this->load->view('menu/approve', array('approve' => $approve));
        $this->load->view('includes/admin_footer');
    }

    public function importExcel()
    {
        $this->load->view('menu/import');
    }

    public function summary()
    {
        $header['title'] = 'RPFP Online | Accomplishment Report';

        $this->load->view('includes/header', $header);
        $this->load->view('menu/summary', array('is_pdf' => false), false);
        $this->load->view('includes/footer');
    }

    public function search()
    {
        $header['title'] = 'RPFP Online | Search Form 1';

        $this->load->view('includes/admin_header', $header);
        $this->load->view('menu/search');
        $this->load->view('includes/admin_footer');
    }

    public function printSummary()
    {
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
        $header['title'] = 'RPFP Online | Dashboard';

        $this->load->view('includes/admin_header', $header);
        $this->load->view('menu/dashboard');
        $this->load->view('includes/admin_footer');
    }

    public function formA()
    {
        $header['title'] = 'RPFP Online | Form A Data List';

        $this->load->view('includes/admin_header', $header);
        $this->load->view('menu/formAMenu');
        $this->load->view('includes/admin_footer');
    }

    public function formB()
    {
        $header['title'] = 'RPFP Online | Form B Data List';

        $this->load->view('includes/admin_header', $header);
        $this->load->view('menu/formBMenu');
        $this->load->view('includes/admin_footer');
    }

    public function formC()
    {
        $header['title'] = 'RPFP Online | Form C Data List';

        $this->load->view('includes/admin_header', $header);
        $this->load->view('menu/formCMenu');
        $this->load->view('includes/admin_footer');
    }

    public function accomplishment()
    {
        $header['title'] = 'RPFP Online | Form Accomplishment Report Data List';

        $this->load->view('includes/admin_header', $header);
        $this->load->view('menu/summary', array('is_pdf' => false), false);
        $this->load->view('includes/admin_footer');
    }
}
