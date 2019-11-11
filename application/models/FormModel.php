<?php
$this->CI =& get_instance();
$this->CI->load->model('BaseModel');

class FormModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->CI->load->library('form1/FormClass');
        $this->CI->load->library('service_slip/ServiceSlipClass');
        $this->CI->load->library('formA/FormAClass');
        $this->CI->load->library('formA/SessionsHeldClass');
        $this->CI->load->library('formA/MonthsClass');
        $this->CI->load->library('formA/IndividualsReproductiveAgeClass');
        $this->CI->load->library('formA/SoloCoupleDisaggregationClass');
        $this->CI->load->library('formA/SoloAttendeesClass');
        $this->CI->load->iface('common/TraditionalStatuses');

        $this->CI->load->library('couple_list/DuplicateCoupleClass');
        $this->CI->load->library('accomplishment_list/AccomplishmentClass');
    }

    public function saveForm1(FormInterface $form)
    {
        $class_id = $this->saveSeminar($form->Seminar);

        if ($class_id == 'INVALID LOCATION') {
            return 'error1';
            exit;
        } elseif ($class_id == 'INVALID ROLE') {
            return 'error2';
            exit;
        } elseif ($class_id == 'SAVE SUCCESSFUL') {
            $class_id = $form->Seminar->ClassId;
        } else {
            $class_id = explode(" ", $class_id);
            $class_id = $class_id[2];
        }

        if (!$class_id) { 
            /** return exception or error message */
            return;
        }

        print_r($this->saveCouple($class_id, $form->ListCouple));
  
    }

    public function saveSeminar(SeminarInterface $data)
    {
        $method = "encoder_save_class";

        $params = [
            $data->ClassId == N_A ? BLANK : $data->ClassId,
            $data->TypeOfClass->Type == N_A ? BLANK : $data->TypeOfClass->Type,
            $data->TypeOfClass->Type != 7 ? BLANK : $data->TypeOfClass->Others,
            $data->Location->Barangay->Code  == N_A ? BLANK : $data->Location->Barangay->Code,
            $data->ClassNumber == N_A ? BLANK : $data->ClassNumber,
            $data->DateConducted == N_A ? BLANK : $data->DateConducted
        ];
        
        return $this->saveToDb($method, $params);
    }

    public function saveCouple(int $class_id, ListCoupleInterface $listCouple)
    {
        foreach ($listCouple as $current_couple) {
            $couple = CoupleClass::getFromVariable($current_couple);
            
            $method = "encoder_save_couple";

            $params1 = [
                $couple->Id == N_A ? BLANK : $couple->Id,
                $class_id == 0 ? BLANK : $class_id,
                
                $couple->Address_St == N_A ? BLANK : $couple->Address_St,
                $couple->Address_Brgy == N_A ? BLANK : $couple->Address_Brgy,
                $couple->Address_City == N_A ? BLANK : $couple->Address_City,
                $couple->Address_HH_No == N_A ? BLANK : $couple->Address_HH_No,
                $couple->NumberOfChildren == N_A ? BLANK : $couple->NumberOfChildren
            ];
            
            $couple_id = $this->saveToDb($method, $params1);
            
            $couple_id = explode(" ", $couple_id);
            $couple_id = $couple_id[2];
            
            $husband = $couple->FirstEntry;
            $wife = $couple->SecondEntry;

            $method2 = 'encoder_save_individual';

            $params2 = [
                $couple_id == 0 ? BLANK : $couple_id,
                $husband->Id == N_A ? BLANK : $husband->Id,
                $husband->Name->Surname == N_A ? BLANK : $husband->Name->Surname,
                $husband->Name->Firstname == N_A ? BLANK : $husband->Name->Firstname,
                $husband->Name->Middlename == N_A ? BLANK : $husband->Name->Middlename,
                $husband->Name->Extname == N_A ? BLANK : $husband->Name->Extname,
                $husband->Age == N_A ? BLANK : $husband->Age,
                $husband->Birthdate == N_A ? BLANK : $husband->Birthdate->format('Y-m-d'),
                $husband->CivilStatus == N_A ? BLANK : $husband->CivilStatus,
                $husband->HighestEducation == N_A ? BLANK : $husband->HighestEducation,
                $husband->Attendee == N_A ? BLANK : $husband->Attendee,

                $wife->Id == N_A ? BLANK : $wife->Id,
                $wife->Name->Surname == N_A ? BLANK : $wife->Name->Surname,
                $wife->Name->Firstname == N_A ? BLANK : $wife->Name->Firstname,
                $wife->Name->Middlename == N_A ? BLANK : $wife->Name->Middlename,
                $wife->Age == N_A ? BLANK : $wife->Age,
                $wife->Birthdate == N_A ? BLANK : $wife->Birthdate->format('Y-m-d'),
                $wife->CivilStatus == N_A ? BLANK : $wife->CivilStatus,
                $wife->HighestEducation == N_A ? BLANK : $wife->HighestEducation,
                $wife->Attendee == N_A ? BLANK : $wife->Attendee
            ];
            
            $this->saveToDb($method2, $params2);

            $modern = $couple->ModernFp;
            $traditional = $couple->TraditionalFp;

            $method3 = 'encoder_save_fp_details';

            $params3 = [
                $modern->Id == N_A ? BLANK : $modern->Id,
                $couple_id == 0 ? BLANK : $couple_id,
                $modern->MethodUsed == N_A ? BLANK : $modern->MethodUsed,
                $modern->IntentionToShift == N_A ? BLANK : $modern->IntentionToShift,

                $traditional->Type == N_A ? BLANK : $traditional->Type,
                $traditional->Status == N_A ? BLANK : $traditional->Status,
                $traditional->ReasonForUse == N_A ? BLANK : $traditional->ReasonForUse
            ];

           $this->saveToDb($method3, $params3);
        }
    }

    public function saveServiceSlip(int $couple_id, ServiceSlipInterface $data)
    {
        $method = "encoder_save_service_slip";

        $params = [
            $couple_id == 0 ? BLANK : $couple_id,
            $data->Id == N_A ? BLANK : $data->Id,

            $data->DateOfVisit == N_A ? BLANK : $data->DateOfVisit->format('Y-m-d'),
            $data->ClientName == N_A ? BLANK : $data->ClientName,
            $data->ClientAddress == N_A ? BLANK : $data->ClientAddress,
            $data->MethodUsed == N_A ? BLANK : $data->MethodUsed,
            $data->CounseledToUse == N_A ? BLANK : $data->CounseledToUse,
            $data->OtherReasons == N_A ? BLANK : $data->OtherReasons,
            $data->DateOfMethod == N_A ? BLANK : $data->DateOfMethod->format('Y-m-d'),
            $data->ReferralFacility == N_A ? BLANK : $data->ReferralFacility,

            $data->Name == N_A ? BLANK : $data->Name,
            // $data->Name->Firstname == N_A ? BLANK : $data->Name->Firstname,
            // $data->Name->Middlename == N_A ? BLANK : $data->Name->Middlename,
            // $data->Name->Extname == N_A ? BLANK : $data->Name->Extname
        ];

        return $this->saveToDb($method, $params);
    }

    public function getServiceSlip() : ServiceSlipInterface
    {
        $slip = new ServiceSlipClass();

        $slip->Id = '1';
        $slip->DateOfVisit = '10/21/2019';
        $slip->ClientName = 'CHOU FAN';
        $slip->ClientAddress = 'Mandaluyong City';
        $slip->MethodUsed = 'SDM';
        $slip->CounseledToUse = '1';
        $slip->OtherReasons = '2';
        $slip->DateOfMethod = '10/21/2019';
        $slip->ClientAdvised = 'OK';
        $slip->ReferralFacility = 'CLAUDE GUSION';
        $slip->Name = 'CHOU FAN';

        return $slip;
    }

    public function getForm1($classId): FormInterface
    {
        $form1 = new FormClass();

        $form1->Seminar = $this->getForm1Seminar($classId);
        $form1->ListCouple = $this->getForm1Couples();
        return $form1;
    }

    public function getForm1Seminar($classId = null) : SeminarInterface
    {
        return $this->fromDbGetSpecific(
            'SeminarClass',
            array(
                'ClassId' => 'rpfpclass',
                'TypeOfClass' => array(
                    'Type' => 'typeclass',
                    'Others' => 'others_specify'
                ),
                'ClassNumber' => 'class_no',
                'DateConducted' => 'date_conduct',
                'Location' => array(
                    'Barangay' => array(
                        'Code' => 'psgc_code',
                        'Description' => 'barangay'
                    )
                )
            ),
            'get_class_details',
            array(
                $classId
            )
        );
    }

    public function getForm1Couples() : ListCoupleInterface
    {
        $list = new ListCoupleClass();
        $couple = new CoupleClass();
        
        $couple->Id = '1';
        $couple->Address_St = 'Bulacan St';
        $couple->Address_Brgy = 'Barangay Bulacan';
        $couple->Address_City = 'Bulacan City';
        $couple->Address_HH_No = '0000';
        $couple->NumberOfChildren = '12';


        $couple->FirstEntry = $this->getForm1Husband();
        $couple->SecondEntry = $this->getForm1Wife();
        $couple->ModernFp = $this->getForm1ModernFpUser();
        $couple->TraditionalFp = $this->getForm1TraditionalFpUser();

        $list->append($couple);
        return $list;
    }

    public function getForm1Husband() : IndividualInterface
    {
        $individual = new IndividualClass();

        $individual->Id = '1';
        $individual->Name->Surname = 'Fan';
        $individual->Name->Firstname = 'Chou';
        $individual->Name->Middlename = '';
        $individual->Name->Extname = '';
        $individual->Sex = Sexes::MALE;
        $individual->CivilStatus = CivilStatuses::MARRIED;
        $individual->Birthdate = '12/31/1996';
        $individual->Age = '22';
        $individual->ResidentialAddress = 'Mandaluyong City, Metro Manila';
        $individual->HighestEducation = EducationBackgrounds::HIGH_SCHOOL_GRADUATE;
        $individual->Attendee = true;

        return $individual;
    }

    public function getForm1Wife() : IndividualInterface
    {
        $individual = new IndividualClass();

        $individual->Id = '2';
        $individual->Name->Surname = 'Montana';
        $individual->Name->Firstname = 'Hanabi';
        $individual->Name->Middlename = '';
        $individual->Name->Extname = '';
        $individual->Sex = Sexes::FEMALE;
        $individual->CivilStatus = CivilStatuses::MARRIED;
        $individual->Birthdate = '12/31/1996';
        $individual->Age = '22';
        $individual->ResidentialAddress = 'Mandaluyong City, Metro Manila';
        $individual->HighestEducation = EducationBackgrounds::VOCATIONAL;
        $individual->Attendee = true;

        return $individual;
    }

    public function getForm1ModernFpUser() : ModernFpUserInterface
    {
        $modernFp = new ModernFpUserClass();
        
        $modernFp->MethodUsed = ModernMethods::CONDOM;
        $modernFp->IntentionToShift = ModernMethods::IUD;

        return $modernFp;
    }

    public function getForm1TraditionalFpUser() : TraditionalFpUserInterface
    {
        $traditionalFp = new TraditionalFpUserClass();
        
        $traditionalFp->Type  = TraditionalMethods::WITHDRAWAL;
        $traditionalFp->Status = TraditionalStatuses::UNDECIDED;
        $traditionalFp->ReasonForUse = ReasonsForUsing::LIMITING;

        return $traditionalFp;
    }

    public function getAccomplishment(): AccomplishmentInterface
    {
        $accomplishment = new AccomplishmentClass();
       
        // $accomplishment->Period = $this->getPeriodReport();
        // $accomplishment->ListMonth = $this->getMonthlyData();
        return $accomplishment;
    }

    public function getFormA(): FormAInterface
    {
        $formA = new FormAClass();
       
        $formA->Period = $this->getPeriodReport();
        $formA->ListMonth = $this->getMonthlyData();
        return $formA;
    }

    public function getPeriodReport() : PeriodReportInterface
    {
        $periodReport = new PeriodReportClass();

        $periodReport->MonthsPeriod = Periods::MONTHLY;
        $periodReport->RegionalOffice = 30000000;
        $periodReport->RegionalOffice = 'Central Luzon Region';

        return $periodReport;
    }

    public function getMonthlyData() : ListMonthsInterface
    {
        $listMonth = new ListMonthsClass();

        $month = new MonthsClass();
        $month->Month = '1';
 
        $month->SessionsHeld = $this->getFormASessionsHeld();
        $month->IndividualsReproductiveAge = $this->getFormAIndividualsReproductiveAge();
        $month->SoloCoupleDisaggregation = $this->getFormASoloCoupleDisaggregation();
        $listMonth->append($month);

        return $listMonth;
    }

    public function getFormASessionsHeld() : SessionsHeldInterface
    {
        $sessions = new SessionsHeldClass();

        $sessions->SubModule = '1';
        $sessions->Non4ps = '1';
        $sessions->Usapan = '1';
        $sessions->Pmc = '1';
        $sessions->H2h = '1';
        $sessions->ProfitedOnly = '1';
        $sessions->Total = '1';

        return $sessions;
    }

    public function getFormAIndividualsReproductiveAge() : IndividualsReproductiveAgeInterface
    {
        $individuals = new IndividualsReproductiveAgeClass();

        $individuals->SubModule = '2';
        $individuals->Non4ps = '2';
        $individuals->Usapan = '2';
        $individuals->Pmc = '2';
        $individuals->H2h = '2';
        $individuals->ProfitedOnly = '2';
        $individuals->Total = '2';
        
        return $individuals;
    }

    public function getFormASoloCoupleDisaggregation() : SoloCoupleDisaggregationInterface
    {
        $disaggregation = new SoloCoupleDisaggregationClass();

        $disaggregation->CoupleAttendees = '5';

        $solo = new SoloAttendeesClass();

        $solo->Male = '5';
        $solo->Female = '5';

        $disaggregation->ListSoloAttendees->append($solo);
        return $disaggregation;
    }

    public function getDuplicateCouple() : DuplicateCoupleInterface
    {
        $firstname  = $this->input->post('firstname');
        $surname    = $this->input->post('surname');
        $extname    = $this->input->post('extname');
        $bday       = $this->input->post('bday');
        $sex        = $this->input->post('sex');
        
        return $this->fromDbGetSpecific(
            'DuplicateCoupleClass',
            array(
                'CheckDetails' => 'check_details'
            ),
            'encoder_check_couples_details',
            array($firstname, $surname, $extname, $bday, $sex)
        );
    }
}
