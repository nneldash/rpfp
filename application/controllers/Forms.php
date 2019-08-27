<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forms extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('FormModel');
        $this->load->library('form/FormClass');
        $this->load->library('form/CoupleClass');
    }

    public function index()
    {
        $header['title'] = 'RPFP Online | Form 1';

        $this->load->view('includes/header', $header);
        $this->load->view('forms/form1', array('is_pdf' => false));
        $this->load->view('includes/footer');
    }

    public function saveForm1()
    {
        $form1 = new FormClass();

        $form1->ListCouple = $this->getInputFromSeminar();
        echo '<pre>';
        print_r($form1);
        exit;
        if(!$this->FormModel->saveForm1()) {
            $data = ['is_save' => false];
        } else {
            $data = ['is_save' => true];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    
    public function getInputFromSeminar()
    {
        $listCouple = new ListCoupleClass();
        
        for ($i = 0; $i < $this->input->post('name_participant1'); $i++) {
            if (!$this->input->post('name_participant1')[$i] && !$this->input->post('name_participant2')[$i]) {
                break;
            }

            $couple = new CoupleClass();

            $couple->Husband = $this->input->post('name_participant1')[$i];
            $couple->Wife = $this->input->post('name_participant2')[$i];

            $listCouple->append($couple);
        }

        return $listCouple;
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

    public function formC()
    {
        $header['title'] = 'RPFP Online | Form C';

        $this->load->view('includes/header', $header);
        $this->load->view('forms/formc', array('is_pdf' => false));
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

    public function viewformc()
    {
        $mpdfConfig = array(
                'format' => 'A4',
                'orientation' => 'L'
            );
        
        $mpdf = new \Mpdf\Mpdf($mpdfConfig);
        $html = $this->load->view('forms/formC', array('is_pdf' => true), true);

        $mpdf->WriteHTML($html);
        $mpdf->Output('FormC.pdf', 'I');
    }   
}