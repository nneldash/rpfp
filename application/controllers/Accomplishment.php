<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Accomplishment extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('AccomplishmentModel');
        $this->load->library('accomplishment_list/AccomplishmentClass');
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

        $header['title'] =' Online RPFP Monitoring System | Accomplishment Report';

        $this->load->model('ProfileModel');
        $this->load->model('AccomplishmentModel');

        $reportNo = $this->input->get('reportNo');
        
        $accomplishment = $this->AccomplishmentModel->getAccomplishmentList()($reportNo);

        $this->load->model('ProfileModel');
        $isEncoder = $this->ProfileModel->isEncoder();
        $isRegionalDataManager = $this->ProfileModel->isRegionalDataManager();

        $this->load->view('includes/header', $header);
        $this->load->view('menu/accomplishment', 
            array(
                'accomplishment' => $accomplishment, 
                'is_pdf' => false,
                'isEncoder' => $isEncoder,
                'isRegionalDataManager' => $isRegionalDataManager,
            )
        );
        $this->load->view('includes/footer');
        return;
    }

    // public function saveForm1()
    // {
    //     if (!$this->LoginModel->isLoggedIn()) {
    //         $header['title'] =' Online RPFP Monitoring System';

    //         $this->load->view("includes/header", $header);
    //         $this->load->view('index/landingPage');

    //         return;
    //     }

    //     $form1 = new FormClass();

    //     $form1->Seminar = $this->getInputFromSeminar();
    //     $form1->ListCouple = $this->getInputFromListCouples();
    //     print_r($this->FormModel->saveForm1($form1));exit;
    //     $data = ['is_save' => true];
    //     if (!$this->FormModel->saveForm1($form1)) {
    //         $data = ['is_save' => false];
    //     }

    //     $this->output
    //         ->set_content_type('application/json')
    //         ->set_output(json_encode($data));
    // }
    
    // public function getInputFromSeminar()
    // {
    //     $seminar = new SeminarClass();

    //     $seminar->ClassId = $this->input->post('class_id');
    //     $seminar->TypeOfClass->Type = $this->input->post('type_of_class');
    //     $seminar->TypeOfClass->Others = $this->input->post('others');
    //     $seminar->ClassNumber = $this->input->post('class_no');
    //     $seminar->Location->Barangay->Code = $this->input->post('barangay');
    //     $seminar->DateConducted = $this->input->post('date_conducted');

    //     return $seminar;
    // }

    public function getInputFromListAccomplishment() : ListAccomplishmentInterface
    {
        $listAccomplishment = new ListAccomplishmentClass();
        
        for ($i = 0; $i < $this->input->post('reportNo'); $i++) {
            if (!$this->input->post('reportNo')[$i]) {
                break;
            }

            $accomplishment = new AccomplishmentClass();

            $accomplishment->ReportNo = $this->input->post('accom_id')[$i];
            $accomplishment->ReportYear = $this->input->post('report_year')[$i];
            $accomplishment->ReportMonth = $this->input->post('report_month')[$i];
            $accomplishment->DateProcessed = $this->input->post('date_processed')[$i];

            $listAccomplishment->append($accomplishment);
        }

        return $listAccomplishment;
    }

    // public function getFirstEntry(int $i) : IndividualInterface
    // {

    //     $individual = new IndividualClass();
    //     if (!$this->input->post('name_participant1')[$i]) {
    //         return $individual;
    //     }

    //     // if ($this->input->post('sex1')[$i] != 1) {
    //     //     return $this->getSecondEntry($i);
    //     // }


    //     $individual->Id = $this->input->post('individual_id1')[$i];
        
    //     $name1 = explode(" ", $this->input->post('name_participant1')[$i]);
    //     $individual->Name->Surname = (empty($name1[0]) ? "" : $name1[0]);
    //     $individual->Name->Firstname = (empty($name1[1]) ? "" : $name1[1]);
    //     $individual->Name->Middlename = (empty($name1[2]) ? "" : $name1[2]);
    //     $individual->Name->Extname = (empty($name1[3]) ? "" : $name1[3]);

    //     $individual->Sex = $this->input->post('sex1')[$i];
    //     $individual->CivilStatus = $this->input->post('civil_status1')[$i];
    //     $individual->Birthdate = $this->input->post('birthdate')[$i];
    //     $individual->Age = $this->input->post('age1')[$i];
    //     $individual->HighestEducation = $this->input->post('educ1')[$i];
    //     $individual->Attendee = 'Yes';

    //     return $individual;
    // }

    // public function getSecondEntry(int $i) : IndividualInterface
    // {
    //     $individual = new IndividualClass();

    //     if (!$this->input->post('name_participant2')[$i]) {
    //         return $individual;
    //     }

    //     // if ($this->input->post('sex2')[$i] != 2) {
    //     //     return $this->getFirstEntry($i);
    //     // }

    //     $individual->Id = $this->input->post('individual_id2')[$i];

    //     $name2 = explode(" ", $this->input->post('name_participant2')[$i]);
    //     $individual->Name->Surname = (empty($name2[0]) ? "" : $name2[0]);
    //     $individual->Name->Firstname = (empty($name2[1]) ? "" : $name2[1]);
    //     $individual->Name->Middlename = (empty($name2[2]) ? "" : $name2[2]);

    //     $individual->Sex = $this->input->post('sex2')[$i];
    //     $individual->CivilStatus = $this->input->post('civil_status2')[$i];
    //     $individual->Birthdate = $this->input->post('birthdate')[$i];
    //     $individual->Age = $this->input->post('age2')[$i];
    //     $individual->HighestEducation = $this->input->post('educ2')[$i];
    //     $individual->Attendee = 'Yes';

    //     return $individual;
    // }

    // public function getModernFp(int $i) : ModernFpUserInterface
    // {
    //     $modernFp = new ModernFpUserClass();

    //     $modernFp->MethodUsed = $this->input->post('method')[$i];
    //     $modernFp->IntentionToShift = $this->input->post('fp_method')[$i];

    //     return $modernFp;
    // }

    // public function getTraditionalFp(int $i) : TraditionalFpUserInterface
    // {
    //     $traditionalFp = new TraditionalFpUserClass();

    //     $traditionalFp->Type = $this->input->post('type')[$i];
    //     $traditionalFp->Status = $this->input->post('status')[$i];
    //     $traditionalFp->ReasonForUse = $this->input->post('reason')[$i];

    //     return $traditionalFp;
    // }

    // public function saveServiceSlip()
    // {
    //     $couple_id = (!$this->input->post('couple_id') ? 0 : $this->input->post('couple_id'));
        
    //     $slip = new ServiceSlipClass();

    //     $slip->Id = $this->input->post('slip_id');
    //     $slip->DateOfVisit = $this->input->post('date_of_visit');
    //     $slip->ClientName = $this->input->post('client_name');
    //     $slip->ClientAddress = $this->input->post('client_address');
    //     $slip->MethodUsed = $this->input->post('method');
    //     $slip->CounseledToUse = $this->input->post('counseled_to_used');
    //     $slip->OtherReasons = $this->input->post('other_reason');
    //     $slip->DateOfMethod = $this->input->post('date_of_method');
    //     $slip->ClientAdvised = $this->input->post('client_advised');
    //     $slip->ReferralFacility = $this->input->post('referral_facility');
    //     $slip->Name = 'NA';

    //     $data = ['is_save' => true];
    //     if (!$this->FormModel->saveServiceSlip($couple_id, $slip)) {
    //         $data = ['is_save' => false];
    //     }

    //     $this->output
    //         ->set_content_type('application/json')
    //         ->set_output(json_encode($data));
    // }

    // public function formA()
    // {
    //     if (!$this->LoginModel->isLoggedIn()) {
    //         $header['title'] =' Online RPFP Monitoring System';

    //         $this->load->view("includes/header", $header);
    //         $this->load->view('index/landingPage');

    //         return;
    //     }

    //     $header['title'] = 'Online RPFP Monitoring System | Form A';

    //     $this->load->model('FormModel');

    //     $formA = $this->FormModel->getFormA();

    //     $this->load->view('includes/header', $header);
    //     $this->load->view('forms/forma', array('forma' => $formA, 'is_pdf' => false));
    //     $this->load->view('includes/footer');
    // }

    // public function formB()
    // {
    //     if (!$this->LoginModel->isLoggedIn()) {
    //         $header['title'] =' Online RPFP Monitoring System';

    //         $this->load->view("includes/header", $header);
    //         $this->load->view('index/landingPage');

    //         return;
    //     }

    //     $header['title'] = 'Online RPFP Monitoring System | Form B';

    //     $this->load->view('includes/header', $header);
    //     $this->load->view('forms/formb', array('is_pdf' => false));
    //     $this->load->view('includes/footer');
    // }

    // public function formC()
    // {
    //     if (!$this->LoginModel->isLoggedIn()) {
    //         $header['title'] =' Online RPFP Monitoring System';

    //         $this->load->view("includes/header", $header);
    //         $this->load->view('index/landingPage');

    //         return;
    //     }

    //     $header['title'] = 'Online RPFP Monitoring System | Form C';

    //     $this->load->view('includes/header', $header);
    //     $this->load->view('forms/formc', array('is_pdf' => false));
    //     $this->load->view('includes/footer');
    // }

    // public function serviceSlip()
    // {
    //     if (!$this->LoginModel->isLoggedIn()) {
    //         $header['title'] =' Online RPFP Monitoring System';

    //         $this->load->view("includes/header", $header);
    //         $this->load->view('index/landingPage');

    //         return;
    //     }

    //     $this->load->model('FormModel');

    //     $serviceSlip = $this->FormModel->getServiceSlip();

    //     $header['title'] = 'Online RPFP Monitoring System | Service Slip';
    //     $this->load->view('forms/serviceSlip', array('slip' => $serviceSlip, 'is_pdf' => false));
    // }

    // public function viewform1()
    // {
    //     if (!$this->LoginModel->isLoggedIn()) {
    //         $header['title'] =' Online RPFP Monitoring System';

    //         $this->load->view("includes/header", $header);
    //         $this->load->view('index/landingPage');

    //         return;
    //     }

    //     $this->load->model('FormModel');
    //     $form1 = $this->FormModel->getForm1();
        
    //     $mpdfConfig = array(
    //         'format' => 'A4',
    //         'orientation' => 'L'
    //     );

    //     try {
    //         $mpdf = new \Mpdf\Mpdf($mpdfConfig);
    //         $mpdf->debug = true;

    //         $html = $this->load->view('forms/form1', array('form1' => $form1, 'is_pdf' => true), true);

    //         $mpdf->setTitle('Online RPFP Monitoring System | Form 1');
    //         $mpdf->WriteHTML($html);
    //         $mpdf->Output(date('Ymd') . ' - Form 1.pdf', 'I');
    //     } catch (\Mpdf\MpdfException $e) {
    //         echo $e->getMessage();
    //     }
    // }

    // public function viewforma()
    // {
    //     if (!$this->LoginModel->isLoggedIn()) {
    //         $header['title'] =' Online RPFP Monitoring System';

    //         $this->load->view("includes/header", $header);
    //         $this->load->view('index/landingPage');

    //         return;
    //     }

    //     $mpdfConfig = array(
    //         'format' => 'A4',
    //         'orientation' => 'L'
    //     );

    //     try {
    //         $mpdf = new \Mpdf\Mpdf($mpdfConfig);
    //         $mpdf->debug = true;

    //         $html = $this->load->view('forms/forma', array('is_pdf' => true), true);

    //         $mpdf->setTitle('Online RPFP Monitoring System | Form A');
    //         $mpdf->WriteHTML($html);
    //         $mpdf->Output(date('Ymd') . ' - Form A.pdf', 'I');
    //     } catch (\Mpdf\MpdfException $e) {
    //         echo $e->getMessage();
    //     }
    // }

    // public function viewformb()
    // {
    //     if (!$this->LoginModel->isLoggedIn()) {
    //         $header['title'] =' Online RPFP Monitoring System';

    //         $this->load->view("includes/header", $header);
    //         $this->load->view('index/landingPage');

    //         return;
    //     }

    //     $mpdfConfig = array(
    //         'format' => 'A4',
    //         'orientation' => 'L'
    //     );

    //     try {
    //         $mpdf = new \Mpdf\Mpdf($mpdfConfig);
    //         $mpdf->debug = true;

    //         $html = $this->load->view('forms/formb', array('is_pdf' => true), true);

    //         $mpdf->setTitle('Online RPFP Monitoring System | Form B');
    //         $mpdf->WriteHTML($html);
    //         $mpdf->Output(date('Ymd') . ' - Form B.pdf', 'I');
    //     } catch (\Mpdf\MpdfException $e) {
    //         echo $e->getMessage();
    //     }
    // }

    // public function viewformc()
    // {
    //     if (!$this->LoginModel->isLoggedIn()) {
    //         $header['title'] =' Online RPFP Monitoring System';

    //         $this->load->view("includes/header", $header);
    //         $this->load->view('index/landingPage');
            
    //         return;
    //     }

    //     $mpdfConfig = array(
    //         'format' => 'A4',
    //         'orientation' => 'L'
    //     );

    //     try {
    //         $mpdf = new \Mpdf\Mpdf($mpdfConfig);
    //         $mpdf->debug = true;
            
    //         $html = $this->load->view('forms/formC', array('is_pdf' => true), true);

    //         $mpdf->setTitle('Online RPFP Monitoring System | Form C');
    //         $mpdf->WriteHTML($html);
    //         $mpdf->Output(date('Ymd') . ' - Form C.pdf', 'I');
    //     } catch (\Mpdf\MpdfException $e) {
    //         echo $e->getMessage();
    //     }
    // }

    // public function checkCoupleDuplicate()
    // {
    //     $this->load->model('FormModel');
    //     $count = $this->FormModel->getDuplicateCouple();

    //     echo $count->CheckDetails;
    // }
}
