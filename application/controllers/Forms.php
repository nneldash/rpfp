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
        $this->load->library('form1/ProfileClass');
        $this->load->library('form1/ModernFpUserClass');
        $this->load->library('form1/TraditionalFpUserClass');
        $this->load->library('service_slip/ServiceSlipClass');
    }

    public function index()
    {
        if (isset($GLOBALS[NO_OUTPUT]) && $GLOBALS[NO_OUTPUT]) {
            return;
        }

        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            redirect(site_url());
            return;
        }

        $header['title'] =' RPFP Online | Form 1';

        $this->load->Model('ProfileModel');
        $this->load->model('FormModel');

        $form1 = $this->FormModel->getForm1();

        $this->load->view('includes/header', $header);
        $this->load->view('forms/form1', array('form1' => $form1, 'is_pdf' => false));
        $this->load->view('includes/footer');
        return;
    }

    public function saveForm1()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            redirect(site_url());
            return;
        }

        $form1 = new FormClass();

        $form1->Seminar = $this->getInputFromSeminar();
        $form1->ListCouple = $this->getInputFromListCouples();

        $data = ['is_save' => true];
        if(!$this->FormModel->saveForm1($form1)) {
            $data = ['is_save' => false];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    
    public function getInputFromSeminar()
    {
        $seminar = new SeminarClass();

        $seminar->ClassId = $this->input->post('class_id');
        $seminar->TypeOfClass->Type = $this->input->post('type_of_class');
        $seminar->TypeOfClass->Others = $this->input->post('others');
        $seminar->ClassNumber = $this->input->post('class_no');
        $seminar->Location->Region->Description = $this->input->post('province');
        $seminar->Location->SpecificLocation->Description = $this->input->post('barangay');
        $seminar->DateConducted = $this->input->post('date_conducted');

        return $seminar;
    }

    public function getInputFromListCouples() : ListCoupleInterface
    {
        $listCouple = new ListCoupleClass();
        
        for ($i = 0; $i < $this->input->post('name_participant1'); $i++) {
            if (!$this->input->post('name_participant1')[$i] && !$this->input->post('name_participant2')[$i]) {
                break;
            }

            $couple = new CoupleClass();

            $couple->Id = $this->input->post('couple_id')[$i];
            $couple->Address_St = $this->input->post('address')[$i];
            $couple->Address_Brgy = $this->input->post('address')[$i];
            $couple->Address_City = $this->input->post('address')[$i];
            $couple->Address_HH_No = $this->input->post('address')[$i];
            $couple->NumberOfChildren = $this->input->post('no_of_children')[$i];

            $couple->FirstEntry = $this->getFirstEntry($i);
            $couple->SecondEntry = $this->getSecondEntry($i);
            $couple->ModernFp = $this->getModernFp ($i);
            $couple->TraditionalFp = $this->getTraditionalFp($i);

            $listCouple->append($couple);
        }

        return $listCouple;
    }

    public function getFirstEntry(int $i) : IndividualInterface
    {

        $individual = new IndividualClass();
        if (!$this->input->post('name_participant1')[$i]) {
            return $individual;
        }

        $individual->Id = $this->input->post('individual_id1')[$i];
        $individual->Name = $this->input->post('name_participant1')[$i];
        $individual->Sex = $this->input->post('sex1')[$i];
        $individual->CivilStatus = $this->input->post('civil_status1')[$i];
        $individual->Birthdate = $this->input->post('birthdate')[$i];
        $individual->Age = $this->input->post('age1')[$i];
        $individual->HighestEducation = $this->input->post('educ1')[$i];
        $individual->Attendee = 'Yes';

        return $individual;
    }

    public function getSecondEntry(int $i) : IndividualInterface
    {
        $individual = new IndividualClass();

        if (!$this->input->post('name_participant2')[$i]) {
            return $individual;
        }

        $individual->Id = $this->input->post('individual_id2')[$i];
        $individual->Name = $this->input->post('name_participant2')[$i];
        $individual->Sex = $this->input->post('sex2')[$i];
        $individual->CivilStatus = $this->input->post('civil_status2')[$i];
        $individual->Birthdate = $this->input->post('birthdate')[$i];
        $individual->Age = $this->input->post('age2')[$i];
        $individual->HighestEducation = $this->input->post('educ2')[$i];
        $individual->Attendee = 'Yes';

        return $individual;
    }

    public function getModernFp(int $i) : ModernFpUserInterface
    {
        $modernFp = new ModernFpUserClass();

        $modernFp->MethodUsed = $this->input->post('method')[$i];
        $modernFp->IntentionToShift = $this->input->post('fp_method')[$i];

        return $modernFp;        
    }

    public function getTraditionalFp(int $i) : TraditionalFpUserInterface
    {
        $traditionalFp = new TraditionalFpUserClass();

        $traditionalFp->Type = $this->input->post('type')[$i];
        $traditionalFp->Status = $this->input->post('status')[$i];
        $traditionalFp->ReasonForUse = $this->input->post('reason')[$i];

        return $traditionalFp;        
    }

    public function saveServiceSlip()
    {
        $couple_id = (!$this->input->post('couple_id') ? 0 : $this->input->post('couple_id'));
        
        $slip = new ServiceSlipClass();

        $slip->Id = $this->input->post('slip_id');
        $slip->DateOfVisit = $this->input->post('date_of_visit');
        $slip->ClientName = $this->input->post('client_name');
        $slip->ClientAddress = $this->input->post('client_address');
        $slip->MethodUsed = $this->input->post('method');
        $slip->CounseledToUse = $this->input->post('counseled_to_used');
        $slip->OtherReasons = $this->input->post('other_reason');
        $slip->DateOfMethod = $this->input->post('date_of_method');
        $slip->ClientAdvised = $this->input->post('client_advised');
        $slip->ReferralFacility = $this->input->post('referral_facility');
        $slip->Name = 'NA';

        $data = ['is_save' => true];
        if (!$this->FormModel->saveServiceSlip($couple_id, $slip)) {
            $data = ['is_save' => false];
        } 

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function formA()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            redirect(site_url());
            return;
        }

        $header['title'] = 'RPFP Online | Form A';

        $this->load->model('FormModel');

        $formA = $this->FormModel->getFormA();

        $this->load->view('includes/header', $header);
        $this->load->view('forms/forma', array('forma' => $formA, 'is_pdf' => false));
        $this->load->view('includes/footer');
    }

    public function formB()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            redirect(site_url());
            return;
        }

        $header['title'] = 'RPFP Online | Form B';

        $this->load->view('includes/header', $header);
        $this->load->view('forms/formb', array('is_pdf' => false));
        $this->load->view('includes/footer');
    }

    public function formC()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            redirect(site_url());
            return;
        }

        $header['title'] = 'RPFP Online | Form C';

        $this->load->view('includes/header', $header);
        $this->load->view('forms/formc', array('is_pdf' => false));
        $this->load->view('includes/footer');
    }

    public function serviceSlip()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            redirect(site_url());
            return;
        }

        $this->load->model('FormModel');

        $serviceSlip = $this->FormModel->getServiceSlip();

        $header['title'] = 'RPFP Online | Service Slip';
        $this->load->view('forms/serviceSlip', array('slip' => $serviceSlip, 'is_pdf' => false));
    }

    public function viewform1()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            redirect(site_url());
            return;
        }

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
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            redirect(site_url());
            return;
        }

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
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            redirect(site_url());
            return;
        }

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
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' RPFP Online';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');
            
            redirect(site_url());
            return;
        }

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

    public function checkDuplicate()
    {
        $count = 1;
        echo json_encode($count);
    }
}