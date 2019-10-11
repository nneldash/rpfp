<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forms extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
        $this->load->model('FormModel');
        $this->load->library('form1/FormClass');
        $this->load->library('form1/CoupleClass');
        // $this->load->library('form1/HusbandClass');
        // $this->load->library('form1/WifeClass');
        $this->load->library('form1/ProfileClass');
        $this->load->library('form1/ModernFpUserClass');
        $this->load->library('form1/TraditionalFpUserClass');
        $this->load->library('service_slip/ServiceSlipClass');
    }

    public function index()
    {

        $header['title'] =' RPFP Online | Form 1';

        if (isset($GLOBALS[NO_OUTPUT]) && $GLOBALS[NO_OUTPUT]) {
            return;
        }

        if (!$this->LoginModel->isLoggedIn()) {
            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');
            return;
        }

        $this->load->Model('ProfileModel');
        if ($this->ProfileModel->isEncoder()) {
            redirect(site_url('Forms'));
            return;
        }

        $this->load->model('FormModel');

        $form1 = $this->FormModel->getForm1();

        $this->load->view('includes/header', $header);
        $this->load->view('forms/form1', array('form1' => $form1, 'is_pdf' => false));
        $this->load->view('includes/footer');
        return;
    }

    public function formsample()
    {
        $header['title'] = 'RPFP Online | Form 1';

        $this->load->view('includes/header', $header);
        $this->load->view('forms/formsample', array('is_pdf' => false));
        $this->load->view('includes/footer');
    }

    public function saveForm1()
    {
        $form1 = new FormClass();

        $form1->Seminar = $this->getInputFromSeminar();
        $form1->ListCouple = $this->getInputFromListCouples();
        
        if(!$this->FormModel->saveForm1($form1)) {
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

        $seminar->TypeOfClass = $this->input->post('type_of_seminar');
        $seminar->ClassNumber = $this->input->post('class_no');
        $seminar->Province = $this->input->post('province');
        $seminar->Barangay = $this->input->post('barangay');
        $seminar->DateConducted = $this->input->post('date_conducted');

        return $seminar;
    }

    public function getInputFromListCouples() 
    {
        $listCouple = new ListCoupleClass();
        
        for ($i = 0; $i < $this->input->post('name_participant1'); $i++) {
            if (!$this->input->post('name_participant1')[$i] && !$this->input->post('name_participant2')[$i]) {
                break;
            }

            $couple = new CoupleClass();

            $couple->Address = $this->input->post('address')[$i];
            $couple->NumberOfChildren = $this->input->post('no_of_children')[$i];
        

            $husband = new HusbandClass();

            $husband->Name = $this->input->post('name_participant1')[$i];
            $husband->Sex = $this->input->post('sex1')[$i];
            $husband->CivilStatus = $this->input->post('civil_status1')[$i];
            $husband->Age = $this->input->post('age1')[$i];
            $husband->EducationalAttainment = $this->input->post('educ1')[$i];
            $husband->HasAttended = 'Yes';


            $wife = new WifeClass();

            $wife->Name = $this->input->post('name_participant2')[$i];
            $wife->Sex = $this->input->post('sex2')[$i];
            $wife->CivilStatus = $this->input->post('civil_status2')[$i];
            $wife->Age = $this->input->post('age2')[$i];
            $wife->EducationalAttainment = $this->input->post('educ2')[$i];
            $wife->HasAttended = 'Yes';
           

            $modernFp = new ModernFpUserClass();

            $modernFp->MethodUsed = $this->input->post('method')[$i];
            $modernFp->IntentionForUsing = $this->input->post('fp_method')[$i];


            $traditionalFp = new TraditionalFpUserClass();

            $traditionalFp->Type = $this->input->post('type')[$i];
            $traditionalFp->Status = $this->input->post('status')[$i];
            $traditionalFp->IntentionForUsing = $this->input->post('reason')[$i];


            $couple->ListHusband->append($husband);
            $couple->ListWife->append($wife);
            $couple->ListModernFp->append($modernFp);
            $couple->ListTraditionalFp->append($traditionalFp);
            $listCouple->append($couple); 
        }

        return $listCouple;
    }

    public function saveServiceSlip()
    {
        $couple_id = $this->input->post('couple_id');
        
        $slip = new ServiceSlipClass();

        $slip->DateOfVisit = $this->input->post('date_of_visit');
        $slip->ClientName = $this->input->post('client_name');
        $slip->ClientAddress = $this->input->post('client_address');
        $slip->MethodUsed = $this->input->post('method');
        $slip->DateOfMethod = $this->input->post('date_of_method');
        $slip->ClientAdvised = $this->input->post('client_advised');
        $slip->ReferralFacility = $this->input->post('referral_facility');
        $slip->Name = 'NA';

        if (!$this->FormModel->saveServiceSlip($couple_id, $slip)) {
            $data = ['is_save' => false];
        } else {
            $data = ['is_save' => true];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function formA()
    {
        $header['title'] = 'RPFP Online | Form A';

        $this->load->model('FormModel');

        $formA = $this->FormModel->getFormA();

        $this->load->view('includes/header', $header);
        $this->load->view('forms/forma', array('forma' => $formA, 'is_pdf' => false));
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
        $this->load->view('forms/serviceSlip', array('is_pdf' => false));
    }

    public function viewform1()
    {
        $this->load->model('FormModel');
        $form1 = $this->FormModel->getForm1();
        
        $mpdfConfig = array(
            'format' => 'A4',
            'orientation' => 'L'
        );

        try {
            $mpdf = new \Mpdf\Mpdf($mpdfConfig);
            $mpdf->debug = true;

            $html = $this->load->view('forms/form1', array('form1' => $form1, 'is_pdf' => true), true);

            $mpdf->setTitle('RPFP Online | Form 1');
            $mpdf->WriteHTML($html);
            $mpdf->Output(date('Ymd') . ' - Form 1.pdf', 'I');
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }

    public function viewforma()
    {
        $mpdfConfig = array(
            'format' => 'A4',
            'orientation' => 'L'
        );

        try {
            $mpdf = new \Mpdf\Mpdf($mpdfConfig);
            $mpdf->debug = true;

            $html = $this->load->view('forms/forma', array('is_pdf' => true), true);

            $mpdf->setTitle('RPFP Online | Form A');
            $mpdf->WriteHTML($html);
            $mpdf->Output(date('Ymd') . ' - Form A.pdf', 'I');
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
        
    }   

    public function viewformb()
    {
        $mpdfConfig = array(
            'format' => 'A4',
            'orientation' => 'L'
        );

        try {
            $mpdf = new \Mpdf\Mpdf($mpdfConfig);
            $mpdf->debug = true;

            $html = $this->load->view('forms/formb', array('is_pdf' => true), true);

            $mpdf->setTitle('RPFP Online | Form B');
            $mpdf->WriteHTML($html);
            $mpdf->Output(date('Ymd') . ' - Form B.pdf', 'I');
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }

    public function viewformc()
    {
        $mpdfConfig = array(
            'format' => 'A4',
            'orientation' => 'L'
        );

        try {
            $mpdf = new \Mpdf\Mpdf($mpdfConfig);
            $mpdf->debug = true;
            
            $html = $this->load->view('forms/formC', array('is_pdf' => true), true);

            $mpdf->setTitle('RPFP Online | Form C');
            $mpdf->WriteHTML($html);
            $mpdf->Output(date('Ymd') . ' - Form C.pdf', 'I');
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }
}