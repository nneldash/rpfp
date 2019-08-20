<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forms extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $header['title'] = 'RPFP Online | Form 1';

        $this->load->view('includes/header', $header);
        $this->load->view('forms/form1', array('is_pdf' => false));
        $this->load->view('includes/footer');
    }

    public function formA()
    {
        $header['title'] = 'RPFP Online | Form A';

        $this->load->view('includes/header', $header);
        $this->load->view('forms/forma', array('is_pdf' => false));
        $this->load->view('includes/footer');
    }

    public function viewpdf()
    {
        $mpdfConfig = array(
                'mode' => 'utf-8', 
                'format' => 'A4', 
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_header' => 0,
                'margin_footer' => 0,
                'orientation' => 'L'
            );
        
        $mpdf = new \Mpdf\Mpdf($mpdfConfig);
        $html = $this->load->view('forms/form1', array('is_pdf' => true), true);

        $mpdf->WriteHTML($html);
        $mpdf->Output('Form-A.pdf', 'I');
    }
    
}