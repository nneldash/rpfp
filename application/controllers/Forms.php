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

    public function formB()
    {
        $header['title'] = 'RPFP Online | Form B';

        $this->load->view('includes/header', $header);
        $this->load->view('forms/formb', array('is_pdf' => false));
        $this->load->view('includes/footer');
    }


    public function viewpdf()
    {
        $mpdfConfig = array(
                'format' => 'A4',
                'orientation' => 'L'
            );
        
        $mpdf = new \Mpdf\Mpdf($mpdfConfig);
        $html = $this->load->view('forms/form1', array('is_pdf' => true), true);

        $mpdf->WriteHTML($html);
        $mpdf->Output('Form1.pdf', 'I');
    }

    public function viewforma()
    {
        $mpdfConfig = array(
                'format' => 'A4',
                'orientation' => 'L'
            );
        
        $mpdf = new \Mpdf\Mpdf($mpdfConfig);
        $html = $this->load->view('forms/forma', array('is_pdf' => true), true);

        $mpdf->WriteHTML($html);
        $mpdf->Output('FormA.pdf', 'I');
    }   

    public function viewformb()
    {
        $mpdfConfig = array(
                'format' => 'A4',
                'orientation' => 'L'
            );
        
        $mpdf = new \Mpdf\Mpdf($mpdfConfig);
        $html = $this->load->view('forms/formb', array('is_pdf' => true), true);

        $mpdf->WriteHTML($html);
        $mpdf->Output('FormB.pdf', 'I');
    }    
}