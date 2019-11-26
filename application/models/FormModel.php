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
        $this->CI->load->library('accomplishment/AccomplishmentClass');
        $this->CI->load->library('accomplishment/lists/ReportAccomplishment');
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

       $couple = $this->saveCouple($class_id, $form->ListCouple);
        print_r($couple);exit;
       if (!$couple) {
           return false;
       }

       return true; 
  
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

            if ($couple_id == 'CANNOT SAVE RECORD WITH GIVEN PARAMETERS') {
                return false;
            } elseif ($couple_id == 'UPDATED!') {
                $couple_id = $couple->Id;
            } else {
                $couple_id = explode(" ", $couple_id);
                $couple_id = $couple_id[2];
            }
            
            $husband = $couple->Husband();
            $wife = $couple->Wife();

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

        //    $this->saveToDb($method3, $params3);
        }
    }

    public function saveServiceSlip(int $couple_id, ServiceSlipInterface $data)
    {
        
        $method = "encoder_save_service_slip";

        $params = [
            $data->Id == N_A ? BLANK : $data->Id,
            $couple_id == 0 ? BLANK : $couple_id,

            $data->DateOfVisit == N_A ? BLANK : $data->DateOfVisit,
            $data->MethodUsed == N_A ? BLANK : $data->MethodUsed,
            $data->ProviderType == N_A ? BLANK : $data->ProviderType,
            $data->IsCounseling == N_A ? BLANK : $data->IsCounseling,
            $data->OtherConcern == N_A ? BLANK : $data->OtherConcern,
            $data->CounseledToUse == N_A ? BLANK : $data->CounseledToUse,
            $data->OtherSpecify == N_A ? BLANK : $data->OtherSpecify,
            $data->IsProvided == N_A ? BLANK : $data->IsProvided,
            $data->DateOfMethod == N_A ? BLANK : $data->DateOfMethod,
            $data->ClientAdvised == N_A ? BLANK : $data->ClientAdvised,
            $data->ReferralFacility == N_A ? BLANK : $data->ReferralFacility,
            $data->HealthServiceProvider == N_A ? BLANK : $data->HealthServiceProvider
        ];
        
        return $this->saveToDb($method, $params);
    }

    public function getServiceSlip() : ServiceSlipInterface
    {
        $slip = new ServiceSlipClass();

        $slip->Id = '1';
        $slip->DateOfVisit = '10/21/2019';
        $slip->MethodUsed = 'SDM';
        $slip->CounseledToUse = '1';
        $slip->OtherSpecify = '2';
        $slip->DateOfMethod = '10/21/2019';
        $slip->ClientAdvised = 'OK';
        $slip->ReferralFacility = 'CLAUDE GUSION';
        $slip->HealthServiceProvider = 'CHOU FAN';

        return $slip;
    }

    public function getForm1($classId): FormInterface
    {
        $form1 = new FormClass();

        $form1->Seminar = $this->getForm1Seminar($classId);
        $classNo = $form1->Seminar->ClassNumber;

        $form1->ListCouple = $this->getForm1Couples($classNo);

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

    public function getForm1Couples($classNo = null) : ListCoupleInterface
    {

        return $this->fromDbGetList(
            'ListCoupleClass',
            'CoupleClass',
            array(
                'Id' => 'couplesid',
                'FirstEntry' => array (
                    'Id' => 'indvid_female',
                    'Name' => array(
                        'Surname' => 'lastname_female',
                        'Firstname' => 'firstname_female', 
                        'Middlename' => 'middle_female',
                        'Extname' => 'ext_female'
                    ),
                    'Age' => 'age_female',
                    'Sex' => 'sex_female',
                    'Birthdate' => 'birth_month_female',
                    'CivilStatus' => 'civil_female',
                    'HighestEducation' => 'educ_bckgrnd_female',
                    'Attendee' => 'attendee_female'
                ),
                'SecondEntry' => array (
                    'Id' => 'indvid_male',
                    'Name' => array(
                        'Surname' => 'lastname_male',
                        'Firstname' => 'firstname_male', 
                        'Middlename' => 'middle_male',
                        'Extname' => 'ext_male'
                    ),
                    'Age' => 'age_male',
                    'Sex' => 'sex_male',
                    'Birthdate' => 'birth_month_male',
                    'CivilStatus' => 'civil_male',
                    'HighestEducation' => 'educ_bckgrnd_male',
                    'Attendee' => 'attendee_male'
                ),
                'Address_St' => 'address_no_st',
                'Address_Brgy' => 'address_brgy',
                'Address_City' => 'address_city',
                'Address_HH_No' => 'household_no',
                'NumberOfChildren' => 'number_child',
                'ModernFp' => array(
                    'Id' => 'fp_id',
                    'MethodUsed' => 'mfp_method',
                    'IntentionToShift' => 'mfp_intention_shift'
                ),
                'TraditionalFp' => array(
                    'Type' => 'tfp_type',
                    'Status' => 'tfp_status',
                    'ReasonForUse' => 'tfp_reason'
                )
            ),
            'encoder_get_couples_with_fp_details',
            array($classNo)
        );
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
