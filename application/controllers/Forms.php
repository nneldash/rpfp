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
        $this->load->library('form/ProfileClass');
        $this->load->library('form/ModernFpUserClass');
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

        $form1->Seminar = $this->getInputFromSeminar();
        $form1->ListCouple = $this->getInputFromCouples();
        $form1->ListProfile = $this->getInputFromProfiles();
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
        $seminar = new SeminarClass();

        $seminar->TypeOfClass = $this->input->post('4Ps');
        $seminar->ClassNumber = $this->input->post('class_no');
        $seminar->Province = $this->input->post('province');
        $seminar->Barangay = $this->input->post('barangay');
        $seminar->DateConducted = $this->input->post('date_conducted');

        return $seminar;
    }

    public function getInputFromCouples() 
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

    public function getInputFromProfiles()
    {
        $listProfile = new ListProfileClass();

        for ($i = 0; $i <  $this->input->post('sex1'); $i++) {
            if (!$this->input->post('sex1')[$i] && !$this->input->post('civil_status1')[$i] && !$this->input->post('age1')[$i] && !$this->input->post('address')[$i] && !$this->input->post('educ1')[$i] && !$this->input->post('no_of_children')[$i]) {
                break;
            }

            $profile = new ProfileClass();

            $profile->Sex = $this->input->post('sex1')[$i];
            $profile->Sex = $this->input->post('sex2')[$i];
            $profile->CivilStatus = $this->input->post('civil_status1')[$i];
            $profile->CivilStatus = $this->input->post('civil_status2')[$i];
            $profile->Age = $this->input->post('age1')[$i];
            $profile->Age = $this->input->post('age2')[$i];
            $profile->Address = $this->input->post('address')[$i];
            $profile->EducationalAttainment = $this->input->post('educ1')[$i];
            $profile->EducationalAttainment = $this->input->post('educ2')[$i];
            $profile->NumberOfChildren = $this->input->post('no_of_children')[$i];

            $listProfile->append($profile);
        }

        return $listProfile;
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

    public function serviceSlip()
    {
        $header['title'] = 'RPFP Online | Service Slip';

        $this->load->view('includes/header', $header);
        $this->load->view('forms/serviceSlip', array('is_pdf' => false));
        $this->load->view('includes/footer');
    }

    public function viewform1()
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