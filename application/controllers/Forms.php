<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forms extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->LoginModel->isLoggedIn()) {
            redirect(site_url());
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
        $header['title'] =' Online RPFP Monitoring System | Form 1';

        $this->load->model('ProfileModel');
        $this->load->model('FormModel');

        $classId = $this->input->get('rpfpId');
        $status = $this->input->get('status');
        
        $form1 = $this->FormModel->getForm1($classId,$status);
        $form1 = FormClass::getFromVariable($form1);

        $this->load->model('ProfileModel');
        $profile = $this->ProfileModel->getOwnProfile();
        $profile = UserProfile::getFromVariable($profile);

        if ($form1->Seminar->Location->Region->Code == N_A) {
            $form1->Seminar->Location->Region->Code = $profile->DesignatedLocation->Region->Code;
            $form1->Seminar->Location->Region->Description = $profile->DesignatedLocation->Region->Description;
        }

        $isEncoder = $profile->isEncoder();
        $isRegionalDataManager = $profile->isRegionalDataManager();
        $isFocalPerson = $profile->isFocal();

        $is_new = BLANK;
        if (isset($_SESSION[IS_NEW])) {
            $is_new = IS_NEW;
            unset($_SESSION[IS_NEW]);
        }

        $this->load->view('includes/header', $header);
        $this->load->view('forms/form1', 
            array(
                'form1' => $form1, 
                'is_pdf' => false,
                'isEncoder' => $isEncoder,
                'isRegionalDataManager' => $isRegionalDataManager,
                'isFocalPerson' => $isFocalPerson,
                'is_new' => $is_new
            )
        );
        $this->load->view('includes/footer');

        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function new()
    {
        $_SESSION[IS_NEW] = IS_NEW;
        redirect('Forms');
    }

    public function saveForm1()
    {
        $form1 = new FormClass();

        $form1->Seminar = $this->getInputFromSeminar();
        $form1->ListCouple = $this->getInputFromListCouples();
        $errors = $this->FormModel->saveForm1($form1);
        if (!empty($errors)) {
            $data = ['is_save' => false, 'message' => $errors];
        } else {
            $data = ['is_save' => true, 'message' => "SUCCESS!!!"];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    
    private function getInputFromSeminar() : SeminarInterface
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

    private function getInputFromListCouples() : ListCoupleInterface
    {
        $listCouple = new ListCoupleClass();
        
        for ($i = 0; $i < 10; $i++) {
            // if (!$this->input->post('firstname1')[$i] && !$this->input->post('firstname2')[$i]) {
            //     break;
            // }

            $couple = new CoupleClass();

            $couple->FirstEntry = $this->getIndividual(1, $i);
            $couple->SecondEntry = $this->getIndividual(2, $i);

            if (($couple->FirstEntry->Name->Firstname == N_A) &&
                ($couple->FirstEntry->Name->Surname == N_A) &&
                ($couple->SecondEntry->Name->Firstname == N_A) &&
                ($couple->SecondEntry->Name->Surname == N_A)
            ) {
                continue;
            }

            $couple->Id = $this->input->post('couple_id')[$i];
            $couple->Address_St = $this->input->post('house_no_st')[$i];
            $couple->Address_Brgy = $this->input->post('brgy')[$i];
            $couple->Address_City = $this->input->post('city')[$i];
            $couple->Address_HH_No = $this->input->post('household_id')[$i];
            $couple->NumberOfChildren = $this->input->post('no_of_children')[$i];

            $couple->ModernFp = $this->getModernFp($i);
            $couple->TraditionalFp = $this->getTraditionalFp($i);

            $listCouple->append($couple);
        }

        return $listCouple;
    }

    private function getIndividual(int $entry_num, int $index) : IndividualInterface
    {
        $individual = new IndividualClass();
        if (!$this->input->post('firstname' . $entry_num)[$index] && !$this->input->post('lastname' . $entry_num)[$index]) {
            return $individual;
        }

        $individual->Id = $this->input->post('individual_id' . $entry_num)[$index];
        
        $individual->Name->Surname      = (empty($this->input->post('lastname' . $entry_num)[$index]) ? BLANK : $this->input->post('lastname' . $entry_num)[$index]);
        $individual->Name->Firstname    = (empty($this->input->post('firstname' . $entry_num)[$index]) ? BLANK : $this->input->post('firstname' . $entry_num)[$index]);
        $individual->Name->Middlename   = (empty($this->input->post('middlename' . $entry_num)[$index]) ? BLANK : $this->input->post('middlename' . $entry_num)[$index]);
        $individual->Name->Extname      = (empty($this->input->post('extname' . $entry_num)[$index]) ? BLANK : $this->input->post('extname' . $entry_num)[$index]);

        $temp_sex = strtoupper($this->input->post('sex' . $entry_num)[$index]);
        $individual->Sex = (!in_array($temp_sex, Sexes::UI_Enumerate()) ? 0 :  ($temp_sex == Sexes::UI_FEMALE ? Sexes::FEMALE : Sexes::MALE));
        $individual->CivilStatus = $this->input->post('civil_status' . $entry_num)[$index];
        $individual->Birthdate = DateTime::createFromFormat('n-j-Y', $this->input->post('bday' . $entry_num)[$index]);
        $individual->Age = $this->input->post('age' . $entry_num)[$index];
        $individual->HighestEducation = $this->input->post('educ' . $entry_num)[$index];
        $individual->Attendee = $this->input->post('attendee1' . $entry_num)[$index];

        return $individual;
    }

    private function getModernFp(int $i) : ModernFpUserInterface
    {
        $modernFp = new ModernFpUserClass();

        $modernFp->Id = $this->input->post('fp_id')[$i];
        $modernFp->MethodUsed = $this->input->post('method')[$i];
        $modernFp->IntentionToShift = $this->input->post('fp_method')[$i];

        return $modernFp;
    }

    private function getTraditionalFp(int $i) : TraditionalFpUserInterface
    {
        $traditionalFp = new TraditionalFpUserClass();

        $traditionalFp->Type = $this->input->post('type')[$i];

        $temp_status = strtoupper($this->input->post('status')[$i]);
        $new_status = 0;
        if (!in_array($temp_status, TraditionalStatuses::UI_Enumerate())) {
            switch ($temp_status) {
                case TraditionalStatuses::UI_EXPRESSING_INTENTION:
                    $new_status = TraditionalStatuses::EXPRESSING_INTENTION;
                break;
                case TraditionalStatuses::UI_UNDECIDED:
                    $new_status = TraditionalStatuses::UNDECIDED;
                break;
                case TraditionalStatuses::UI_CURRENTLY_PREGNANT:
                    $new_status = TraditionalStatuses::CURRENTLY_PREGNANT;
                break;
                case TraditionalStatuses::UI_NO_INTENTION:
                    $new_status = TraditionalStatuses::NO_INTENTION;
                break;
            }
        }
        $traditionalFp->Status = $new_status;

        $traditionalFp->IntentionUse = $this->input->post('intention_use')[$i];

        $traditionalFp->ReasonForUse = $this->input->post('reason')[$i];

        return $traditionalFp;
    }

    public function saveServiceSlip()
    {  
        
        $couple_id = (!$this->input->post('couple_id') ? 0 : $this->input->post('couple_id'));
        
        $slip = new ServiceSlipClass();

        if (!$this->input->post('date_of_visit') || !$this->input->post('referral_facility') || !$this->input->post('health_service_provider')|| $couple_id == 0) {
            return $slip;
        }

        if (!empty($this->input->post('date_of_method'))) {
            $date_method = explode('/', $this->input->post('date_of_method'));
            $date_accepting_method = $date_method[2].'-'.$date_method[1].'-'.$date_method[0];
        }

        $slip->Id = $this->input->post('slip_id');
        $slip->DateOfVisit = $this->input->post('date_of_visit');
        $slip->MethodUsed = $this->input->post('method');
        $slip->IsCounseling = $this->input->post('is_counseling');
        $slip->OtherConcern = $this->input->post('other_concern');
        $slip->CounseledToUse = $this->input->post('counseled_to_use');
        $slip->OtherSpecify = $this->input->post('other_specify');
        $slip->IsProvided = $this->input->post('is_provided_service');
        $slip->DateOfMethod = $date_accepting_method;
        $slip->ClientAdvised = $this->input->post('client_advised');
        $slip->ReferralFacility = $this->input->post('referral_facility');
        $slip->HealthServiceProvider = $this->input->post('health_service_provider');

        $serviceSlip = $this->FormModel->saveServiceSlip($couple_id, $slip);
        
        if ($serviceSlip == 'added') {
            $data = ['is_save' => 'added'];
        } else if ($serviceSlip == 'existed') {
            $data = ['is_save' => 'existed'];
        } else {
            $data = ['is_save' => false];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function accomplishment()
    {
        $header['title'] = 'Online RPFP Monitoring System | Form A';

        $this->load->model('FormModel');

        $reportNo = $this->input->get('ReportNo');
        $accomplishment = $this->AccomplishmentModel->getAccomplishmentReport($reportNo);

        $this->load->view('includes/header', $header);
        $this->load->view('forms/accomplishment', array('accomplishment' => $accomplishment, 'is_pdf' => false));
        $this->load->view('includes/footer');

        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function formA()
    {
        $header['title'] = 'Online RPFP Monitoring System | Form A';

        $this->load->model('FormAModel');

        $reportMonth = $this->input->get('ReportMonth');
        $reportYear = $this->input->get('ReportYear');
        $formA = $this->FormAModel->getFormAReport($reportMonth,$reportYear);

        $this->load->view('includes/header', $header);
        $this->load->view('forms/forma', array('form_A' => $formA, 'is_pdf' => false, RELOAD => true));
        $this->load->view('includes/footer');

        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function formB()
    {
        $header['title'] = 'Online RPFP Monitoring System | Form B';

        $this->load->view('includes/header', $header);
        $this->load->view('forms/formb', array('is_pdf' => false));
        $this->load->view('includes/footer');

        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function formC()
    {
        $header['title'] = 'Online RPFP Monitoring System | Form C';

        $this->load->view('includes/header', $header);
        $this->load->view('forms/formc', array('is_pdf' => false));
        $this->load->view('includes/footer');

        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function serviceSlip()
    {
        $couple_id = $this->input->post('couple_id') != 'N/A' ? $this->input->post('couple_id') : 0;
        $couple_name = $this->input->post('couple_name') != 'N/A' ? $this->input->post('couple_name') : '';
        $address = $this->input->post('address') != 'N/A' ? $this->input->post('address') : '';
        
        $this->load->model('FormModel');

        $serviceSlip = $this->FormModel->getServiceSlip($couple_id);

        $header['title'] = 'Online RPFP Monitoring System | Service Slip';
        $this->load->view('forms/serviceSlip',
            array(
                'slip' => $serviceSlip,
                'couple_id' => $couple_id,
                'couple_name' => $couple_name,
                'address' => $address,
                'is_pdf' => false
            )
        );

        $this->load->library('common/PageHandler');
        PageHandler::setCurrentPage();
    }

    public function viewform1()
    {
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
        $data = $this->FormModel->getDuplicateCouple();

        $husband = $data->H_First . ' ' . $data->H_Last;
        $wife = $data->W_First . ' ' . $data->W_Last;

        $data = [  
                    'CheckCount' => $data->CheckDetails,
                    'CouplesId' => $data->CouplesId,
                    'ActiveStatus' => $data->ActiveStatus,
                    'Husband' => $husband,
                    'Wife' => $wife
                ];

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
