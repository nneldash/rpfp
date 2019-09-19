<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $header['title'] = 'RPFP Online | Pending';

        $this->load->view('includes/admin_header', $header);
        $this->load->view('menu/pending');
        $this->load->view('includes/admin_footer');
    }

    public function approve()
    {
        $header['title'] = 'RPFP Online | Approve';

        $this->load->view('includes/admin_header', $header);
        $this->load->view('menu/approve');
        $this->load->view('includes/admin_footer');
    }

    public function importExcel()
    {
        // $header['title'] = 'RPFP Online | Approve';

        // $this->load->view('includes/header', $header);
        $this->load->view('menu/import');
        // $this->load->view('includes/footer');
    }

    public function summary()
    {
        $header['title'] = 'RPFP Online | Accomplishment Report';

        $this->load->view('includes/header', $header);
        $this->load->view('menu/summary', array('is_pdf' => false), false);
        $this->load->view('includes/footer');
    }

    public function printSummary()
    {
        $mpdfConfig = array(
            'format' => 'A4',
            'orientation' => 'P'
        );
        
        $mpdf = new \Mpdf\Mpdf($mpdfConfig);
        $html = $this->load->view('menu/summary', array('is_pdf' => true), true);

        $mpdf->WriteHTML($html);
        $mpdf->Output('Summary.pdf', 'I');
    }

    public function dashboard()
    {
        $header['title'] = 'RPFP Online | Dashboard';

        $this->load->view('includes/admin_header', $header);
        $this->load->view('menu/dashboard');
        $this->load->view('includes/admin_footer');
    }
}
