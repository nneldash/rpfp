<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forms extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->LoginModel->isLoggedIn()) {
            redirect('Login');
            return;
        }

        $this->load->model('ProfileModel');
        $this->load->model('FormModel');
        $this->load->library('form1/FormClass');
        $this->load->library('form1/CoupleClass');
        $this->load->library('form1/ProfileClass');
        $this->load->library('form1/ModernFpUserClass');
        $this->load->library('form1/TraditionalFpUserClass');
        $this->load->library('service_slip/ServiceSlipClass');
        $this->load->model('AccomplishmentModel');
        $this->load->library('accomplishment/AccomplishmentClass');
        $this->load->model('FormAModel');
        $this->load->library('formA/FormAClass');
    }

    public function index()
    {
        if (isset($GLOBALS[NO_OUTPUT]) && $GLOBALS[NO_OUTPUT]) {
            return;
        }

        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' Online RPFP Monitoring System';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            return;
        }

        $header['title'] =' Online RPFP Monitoring System | Form 1';

        $this->load->model('ProfileModel');
        $this->load->model('FormModel');

        $classId = $this->input->get('rpfpId');
        
        $form1 = $this->FormModel->getForm1($classId);

        $this->load->model('ProfileModel');
        $profile = $this->ProfileModel->getOwnProfile();
        $profile = UserProfile::getFromVariable($profile);

        if ($form1->Seminar->Location->Region->Code == N_A) {
            $form1->Seminar->Location->Region->Code = $profile->DesignatedLocation->Region->Code;
            $form1->Seminar->Location->Region->Description = $profile->DesignatedLocation->Region->Description;
        }

        $isEncoder = $profile->isEncoder();
        $isRegionalDataManager = $profile->isRegionalDataManager();

        $this->load->view('includes/header', $header);
        $this->load->view('forms/form1', 
            array(
                'form1' => $form1, 
                'is_pdf' => false,
                'isEncoder' => $isEncoder,
                'isRegionalDataManager' => $isRegionalDataManager
            )
        );
        $this->load->view('includes/footer');
        return;
    }

    public function saveForm1()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' Online RPFP Monitoring System';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            return;
        }

        $form1 = new FormClass();

        $form1->Seminar = $this->getInputFromSeminar();
        $form1->ListCouple = $this->getInputFromListCouples();
        // echo '<pre>';
        // print_r($form1);exit;
        // print_r($this->FormModel->saveForm1($form1));exit;
        if (!$this->FormModel->saveForm1($form1)) {
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

        $seminar->ClassId = $this->input->post('class_id');
        $seminar->TypeOfClass->Type = $this->input->post('type_of_class');
        $seminar->TypeOfClass->Others = $this->input->post('others');
        $seminar->ClassNumber = $this->input->post('class_no');
        $seminar->Location->Barangay->Code = $this->input->post('barangay');
        $seminar->DateConducted = $this->input->post('date_conducted');

        return $seminar;
    }

    public function getInputFromListCouples() : ListCoupleInterface
    {
        $listCouple = new ListCoupleClass();
        
        for ($i = 0; $i <= 9; $i++) {
            if (!$this->input->post('firstname1')[$i] && !$this->input->post('firstname2')[$i]) {
                break;
            }

            $couple = new CoupleClass();

            $couple->Id = $this->input->post('couple_id')[$i];
            $couple->Address_St = $this->input->post('house_no_st')[$i];
            $couple->Address_Brgy = $this->input->post('brgy')[$i];
            $couple->Address_City = $this->input->post('city')[$i];
            $couple->Address_HH_No = $this->input->post('household_id')[$i];
            $couple->NumberOfChildren = $this->input->post('no_of_children')[$i];

            $couple->FirstEntry = $this->getFirstEntry($i);
            $couple->SecondEntry = $this->getSecondEntry($i);
            $couple->ModernFp = $this->getModernFp($i);
            $couple->TraditionalFp = $this->getTraditionalFp($i);

            $listCouple->append($couple);
        }

        return $listCouple;
    }

    public function getFirstEntry(int $i) : IndividualInterface
    {

        $individual = new IndividualClass();
        if (!$this->input->post('firstname1')[$i] && !$this->input->post('lastname1')[$i]) {
            return $individual;
        }

        if ($this->input->post('sex1')[$i] == 'F') {
            return $this->getSecondEntry($i);
        }


        $individual->Id = $this->input->post('individual_id1')[$i];
        
        $individual->Name->Surname      = (empty($this->input->post('lastname1')[$i]) ? "" : $this->input->post('lastname1')[$i]);
        $individual->Name->Firstname    = (empty($this->input->post('firstname1')[$i]) ? "" : $this->input->post('firstname1')[$i]);
        $individual->Name->Middlename   = (empty($this->input->post('middlename1')[$i]) ? "" : $this->input->post('middlename1')[$i]);
        $individual->Name->Extname      = (empty($this->input->post('extname1')[$i]) ? "" : $this->input->post('extname1')[$i]);

        $individual->Sex = $this->input->post('sex1')[$i];
        $individual->CivilStatus = $this->input->post('civil_status1')[$i];
        $individual->Birthdate = $this->input->post('bday1')[$i];
        $individual->Age = $this->input->post('age1')[$i];
        $individual->HighestEducation = $this->input->post('educ1')[$i];
        $individual->Attendee = 'Yes';

        return $individual;
    }

    public function getSecondEntry(int $i) : IndividualInterface
    {
        $individual = new IndividualClass();

        if (!$this->input->post('firstname2')[$i] && !$this->input->post('lastname2')[$i]) {
            return $individual;
        }

        $individual->Id = $this->input->post('individual_id2')[$i];

        $individual->Name->Surname      = (empty($this->input->post('lastname2')[$i]) ? "" : $this->input->post('lastname2')[$i]);
        $individual->Name->Firstname    = (empty($this->input->post('firstname2')[$i]) ? "" : $this->input->post('firstname2')[$i]);
        $individual->Name->Middlename   = (empty($this->input->post('middlename2')[$i]) ? "" : $this->input->post('middlename2')[$i]);
        $individual->Name->Extname      = (empty($this->input->post('extname2')[$i]) ? "" : $this->input->post('extname2')[$i]);

        $individual->Sex = $this->input->post('sex2')[$i];
        $individual->CivilStatus = $this->input->post('civil_status2')[$i];
        $individual->Birthdate = $this->input->post('bday2')[$i];
        $individual->Age = $this->input->post('age2')[$i];
        $individual->HighestEducation = $this->input->post('educ2')[$i];
        $individual->Attendee = 'Yes';

        return $individual;
    }

    public function getModernFp(int $i) : ModernFpUserInterface
    {
        $modernFp = new ModernFpUserClass();

        $modernFp->Id = $this->input->post('fp_id')[$i];
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
        $slip->MethodUsed = $this->input->post('method');
        $slip->IsCounseling = $this->input->post('is_counseling');
        $slip->OtherConcern = $this->input->post('other_concern');
        $slip->CounseledToUse = $this->input->post('counseled_to_use');
        $slip->OtherSpecify = $this->input->post('other_specify');
        $slip->IsProvided = $this->input->post('is_provided_service');
        $slip->DateOfMethod = $this->input->post('date_of_method');
        $slip->ClientAdvised = $this->input->post('client_advised');
        $slip->ReferralFacility = $this->input->post('referral_facility');
        $slip->HealthServiceProvider = $this->input->post('health_service_provider');

        
        if (!$this->FormModel->saveServiceSlip($couple_id, $slip)) {
            $data = ['is_save' => false];
        } else {
            $data = ['is_save' => true];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function accomplishment()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' Online RPFP Monitoring System';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            return;
        }

        $header['title'] = 'Online RPFP Monitoring System | Form A';

        $this->load->model('FormModel');

        $reportNo = $this->input->get('ReportNo');
        $accomplishment = $this->AccomplishmentModel->getAccomplishmentReport($reportNo);

        $this->load->view('includes/header', $header);
        $this->load->view('forms/accomplishment', array('accomplishment' => $accomplishment, 'is_pdf' => false));
        $this->load->view('includes/footer');     
    }

    public function formA()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' Online RPFP Monitoring System';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            return;
        }

        $header['title'] = 'Online RPFP Monitoring System | Form A';

        $this->load->model('FormAModel');

        $reportMonth = $this->input->get('ReportMonth');
        $reportYear = $this->input->get('ReportYear');
        $formA = $this->FormAModel->getFormAReport($reportMonth,$reportYear);

        $this->load->view('includes/header', $header);
        $this->load->view('forms/forma', array('form_A' => $formA, 'is_pdf' => false, RELOAD => true));
        $this->load->view('includes/footer');
    }

    public function formB()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' Online RPFP Monitoring System';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            return;
        }

        $header['title'] = 'Online RPFP Monitoring System | Form B';

        $this->load->view('includes/header', $header);
        $this->load->view('forms/formb', array('is_pdf' => false));
        $this->load->view('includes/footer');
    }

    public function formC()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' Online RPFP Monitoring System';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            return;
        }

        $header['title'] = 'Online RPFP Monitoring System | Form C';

        $this->load->view('includes/header', $header);
        $this->load->view('forms/formc', array('is_pdf' => false));
        $this->load->view('includes/footer');
    }

    public function serviceSlip()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' Online RPFP Monitoring System';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            return;
        }
        $couple_id = $this->input->post('couple_id') != 'N/A' ? $this->input->post('couple_id') : 0;
        $couple_name = $this->input->post('couple_name') != 'N/A' ? $this->input->post('couple_name') : '';
        $address = $this->input->post('address') != 'N/A' ? $this->input->post('address') : '';
        
        $this->load->model('FormModel');

        $serviceSlip = $this->FormModel->getServiceSlip($couple_id);

        $header['title'] = 'Online RPFP Monitoring System | Service Slip';
        $this->load->view('forms/serviceSlip', array('slip' => $serviceSlip, 'couple_id' => $couple_id, 'couple_name' => $couple_name, 'address' => $address, 'is_pdf' => false));
    }

    public function viewform1()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' Online RPFP Monitoring System';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

            return;
        }

        $this->load->model('FormModel');
        $form1 = $this->FormModel->getForm1();
        $form1 = FormClass::getFromVariable($form1);

        $this->load->model('ProfileModel');
        $profile = $this->ProfileModel->getOwnProfile();
        $profile = UserProfile::getFromVariable($profile);

        if ($form1->Seminar->Location->Region->Code == N_A) {
            $form1->Seminar->Location->Region->Code = $profile->DesignatedLocation->Region->Code;
            $form1->Seminar->Location->Region->Description = $profile->DesignatedLocation->Region->Description;
        }
        
        $mpdfConfig = array(
            'format' => 'A4',
            'orientation' => 'L'
        );

        try {
            $mpdf = new \Mpdf\Mpdf($mpdfConfig);
            $mpdf->debug = true;

            $html = $this->load->view('forms/form1', array('form1' => $form1, 'is_pdf' => true), true);

            $mpdf->setTitle('Online RPFP Monitoring System | Form 1');
            $mpdf->WriteHTML($html);
            $mpdf->Output(date('Ymd') . ' - Form 1.pdf', 'I');
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }

    public function viewforma()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' Online RPFP Monitoring System';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

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

            $mpdf->setTitle('Online RPFP Monitoring System | Form A');
            $mpdf->WriteHTML($html);
            $mpdf->Output(date('Ymd') . ' - Form A.pdf', 'I');
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }

    public function viewformb()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' Online RPFP Monitoring System';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');

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

            $mpdf->setTitle('Online RPFP Monitoring System | Form B');
            $mpdf->WriteHTML($html);
            $mpdf->Output(date('Ymd') . ' - Form B.pdf', 'I');
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }

    public function viewformc()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            $header['title'] =' Online RPFP Monitoring System';

            $this->load->view("includes/header", $header);
            $this->load->view('index/landingPage');
            
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

            $mpdf->setTitle('Online RPFP Monitoring System | Form C');
            $mpdf->WriteHTML($html);
            $mpdf->Output(date('Ymd') . ' - Form C.pdf', 'I');
        } catch (\Mpdf\MpdfException $e) {
            echo $e->getMessage();
        }
    }

    public function checkCoupleDuplicate()
    {
        $this->load->model('FormModel');
        $count = $this->FormModel->getDuplicateCouple();

        echo $count->CheckDetails;
    }
}
