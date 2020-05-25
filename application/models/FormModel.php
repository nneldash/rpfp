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
        $this->CI->load->library('formA/FormAMonthsClass');
        $this->CI->load->library('formA/IndividualsReproductiveAgeClass');
        $this->CI->load->library('formA/SoloCoupleDisaggregationClass');
        $this->CI->load->library('formA/SoloAttendeesClass');
        $this->CI->load->iface('common/TraditionalStatuses');

        $this->CI->load->library('couple_list/DuplicateCoupleClass');
        $this->CI->load->library('couple_list/DuplicateCoupleDetailsClass');
        $this->CI->load->library('accomplishment/AccomplishmentClass');
        $this->CI->load->library('accomplishment/lists/ReportAccomplishment');

        $this->CI->load->library('couple_list/DuplicateIndividualClass');

        $this->CI->load->library('common/Errors');

    }

    public function saveForm1(FormInterface $form) : ErrorInterface
    {
        $class = $this->saveSeminar($form->Seminar);

        if (empty($class->Code)) {
            $class->Message = 'CLASS IS SUCCESSFULLY SAVED';
            $class->Description = 'class is saved/updated successfully';
            $couples = $this->saveCoupleData(intval($class->ReturnValue), $form->ListCouple);
        }
        
        if (!empty($couples->Code)) {
           $class = $couples;
        }

       return $class;
    }

    private static function extractCode($code) : ErrorInterface
    {
        $ret_val = new Errors();
        $ret_val->Code = ErrorInterface::NO_ERROR;
        if (empty($code)) {
            $ret_val->Code = ErrorInterface::DATABASE_ERROR;
            $ret_val->Description = 'error0';
        } elseif ($code == 'INVALID LOCATION') {
            $ret_val->Code = ErrorInterface::INVALID_PARAMETER;
            $ret_val->Description = 'error1';
        } elseif ($code == 'INVALID ROLE') {
            $ret_val->Code = ErrorInterface::INVALID_ROLE;
            $ret_val->Description = 'error2';
        } elseif ($code == 'SAVE SUCCESSFUL') {
            $ret_val->ReturnValue = $code;
        } else {
            $new_code = explode(" ", $code);
            $ret_val->ReturnValue = $new_code[2];
        }

        return $ret_val;
    }

    private function saveSeminar(SeminarInterface $data) : ErrorInterface
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
        
        $class_id = $this->saveToDb($method, $params);
        $ret_val = $this->extractCode($class_id);
        
        if (empty($ret_val)) {
            $ret_val = $data->ClassId;
        }
        return $ret_val;
    }

    private function saveCoupleFPDetails(
        int $couple_id,
        ModernFpUserInterface $modern,
        TraditionalFpUserInterface $traditional
    ) : ErrorInterface
    {
        $errors = new Errors();

        $method3 = 'encoder_save_fp_details';
        $params3 = [
            $modern->Id == N_A ? BLANK : $modern->Id,
            $couple_id == 0 ? BLANK : $couple_id,
            $modern->MethodUsed == N_A ? BLANK : $modern->MethodUsed,
            $modern->IntentionToShift == N_A ? BLANK : $modern->IntentionToShift,

            $traditional->Type == N_A ? BLANK : $traditional->Type,
            $traditional->Status == N_A ? BLANK : $traditional->Status,
            $traditional->IntentionUse == N_A ? BLANK : $traditional->IntentionUse,
            $traditional->ReasonForUse == N_A ? BLANK : $traditional->ReasonForUse
        ];

        $saved = $this->saveToDb($method3, $params3);
        $errors->Message = $saved;
        if (empty($saved)) {
            $errors->Code = ErrorInterface::DATABASE_ERROR;
            $errors->Message = "DB ERROR FP DETAILS";
        }

        return $errors;
    }

    private function saveHusbandAndWife(int $couple_id, CoupleInterface $couple) : ErrorInterface
    {
        $errors = new Errors();

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
            gettype($husband->Attendee) == "string" ? "0" : "1",

            $wife->Id == N_A ? BLANK : $wife->Id,
            $wife->Name->Surname == N_A ? BLANK : $wife->Name->Surname,
            $wife->Name->Firstname == N_A ? BLANK : $wife->Name->Firstname,
            $wife->Name->Middlename == N_A ? BLANK : $wife->Name->Middlename,
            $wife->Age == N_A ? BLANK : $wife->Age,
            $wife->Birthdate == N_A ? BLANK : $wife->Birthdate->format('Y-m-d'),
            $wife->CivilStatus == N_A ? BLANK : $wife->CivilStatus,
            $wife->HighestEducation == N_A ? BLANK : $wife->HighestEducation,
            gettype($wife->Attendee) == "string" ? "0" : "1"
        ];
        $result = $this->saveToDb($method2, $params2);
        if (empty($result)) {
            $errors->Code = ErrorInterface::INVALID_RETURN_VALUE;
            $errors->Description = "DB ERROR INDIVIDUALS";
            $errors->Message = "DB ERROR INDIVIDUALS";
        }

        return $errors;
    }

    private  function saveCoupleCommonDetails(int $class_id, CoupleInterface $couple) : ErrorInterface
    {
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
        return $this->extractCode($couple_id);
    }

    private function saveCoupleData(int $class_id, ListCoupleInterface $listCouple) : ErrorInterface
    {
        $saved = new Errors();
        foreach ($listCouple as $couple) {
            $couple = CoupleClass::getFromVariable($couple);
            $saved = $this->saveCoupleCommonDetails($class_id, $couple);
            if (!empty($saved->Code)) {
                break;
            }
        
            $couple_id = intval($saved->ReturnValue);
            if ($couple_id == 0) {
                $couple_id = $couple->Id;
            }
            $saved = $this->saveHusbandAndWife($couple_id, $couple);
            if (!empty($saved->Code)) {
                break;
            }

            $saved = $this->saveCoupleFPDetails($couple_id, $couple->ModernFp, $couple->TraditionalFp);

        }
        return $saved;
    }

    /** end save form 1 */

    public function saveServiceSlip(int $couple_id, ServiceSlipInterface $data)
    {
        $method = "encoder_save_fp_service";

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
        
        $fp_service =  $this->saveToDb($method, $params);
        
        if ($fp_service == 'FP SERVICE ADDED') {
            return 'added';
        } else {
            return false;
        }
    }

    public function getServiceSlip(int $couple_id) : ServiceSlipInterface
    {
        return $this->fromDbGetSpecific(
            'ServiceSlipClass',
            array(
                'Id' => 'fpserviceid',
                'DateOfVisit' => 'datevisit',
                'MethodUsed' => 'fp_served',
                'ProviderType' => 'provider_type',
                'IsCounseling' => 'is_counselling',
                'OtherConcern' => 'other_concern',
                'CounseledToUse' => 'counseled_fp',
                'OtherSpecify' => 'other_specify',
                'IsProvided' => 'is_provided_service',
                'DateOfMethod' => 'dateserved',
                'ClientAdvised' => 'client_advise',
                'ReferralFacility' => 'referralname',
                'HealthServiceProvider' => 'providername'
            ),
            'encoder_get_fp_service',
            array(
                $couple_id
            )
        );
    }

    public function getForm1($classId,$status): FormInterface
    {
        $form1 = new FormClass();

        $form1->Seminar = $this->getForm1Seminar($classId);
        $classNo = $form1->Seminar->ClassNumber;

        $form1->ListCouple = $this->getForm1Couples($classNo,$status);

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
                    'Province' => array(
                        'Code' => 'province_id',
                        'Description' => 'province_name'
                    ),
                    'City' => array(
                        'Code' => 'municipality_id',
                        'Description' => 'municipality_name'
                    ),
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

    public function getForm1Couples($classNo = null,$status = null) : ListCoupleInterface
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
                    'IntentionUse' => 'mfp_intention_use',
                    'ReasonForUse' => 'tfp_reason'
                ),
                'FpServed' => 'fp_served',
                'IsActive' => 'is_active'
            ),
            'encoder_get_couples_with_fp_details',
            array($classNo,$status)
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
        $listMonth = new ListFormAMonthsClass();

        $month = new FormAMonthsClass();
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
        $h_fname    = $this->input->post('h_fname');
        $h_lname    = $this->input->post('h_lname');
        $h_ext      = $this->input->post('h_ext');
        $h_bday     = $this->input->post('h_bday');
        $w_fname    = $this->input->post('w_fname');
        $w_lname    = $this->input->post('w_lname');
        $w_bday     = $this->input->post('w_bday');

        return $this->fromDbGetSpecific(
            'DuplicateCoupleClass',
            array(
                'CheckDetails' => 'check_details',
                'CouplesId' => 'couplesid',
                'ActiveStatus' => 'active_status',
                'H_Last' => 'h_last',
                'H_First' => 'h_first',
                'H_Ext' => 'h_ext',
                'H_Bday' => 'h_bday',
                'H_Sex' => 'h_sex',
                'W_CouplesId' => 'w_couplesid',
                'W_Last' => 'w_last',
                'W_First' => 'w_first',
                'W_Bday' => 'w_bday',
                'W_Sex' => 'w_sex'
            ),
            'check_couples_details',
            array($h_fname, $h_lname, $h_ext, $h_bday, $w_fname, $w_lname, $w_bday)
        );
    }

    public function getDuplicateIndividual() : DuplicateIndividualInterface
    {
        $h_fname    = $this->input->post('h_fname');
        $h_lname    = $this->input->post('h_lname');
        $h_ext      = $this->input->post('h_ext');
        $h_bday     = $this->input->post('h_bday');
        $w_fname    = $this->input->post('w_fname');
        $w_lname    = $this->input->post('w_lname');
        $w_bday     = $this->input->post('w_bday');

        return $this->fromDbGetSpecific(
            'DuplicateIndividualClass',
            array(
                'CheckDetails' => 'check_details',
                'CouplesId' => 'couplesid',
                'ActiveStatus' => 'active_status',
                'W_couplesId' => 'w_couplesid',
                'W_Last' => 'w_last',
                'W_First' => 'w_first',
                'W_Bday' => 'w_bday',
                'W_Sex' => 'w_sex'
            ),
            'check_for_duplications',
            array($h_fname, $h_lname, $h_ext, $h_bday, $w_fname, $w_lname, $w_bday)
        );
    }

    public function getDuplicateDetails() : DuplicateCoupleDetailsInterface
    {
        $couplesId = $this->input->post('couplesId');

        return $this->fromDbGetSpecific(
            'DuplicateCoupleDetailsClass',
            array(
                'CouplesId' => 'couplesid',
                'Address_No_St' => 'address_no_st',
                'Address_Barangay' => 'address_barangay',
                'Address_City' => 'address_city',
                'Household_No' => 'household_no',
                'Number_Child' => 'number_child',
                'Status_Active' => 'status_active',
                'Fp_Details_Id' => 'fpdetailsid',
                'Mfp_Used' => 'mfp_used',
                'Mfp_Shift' => 'mfp_shift',
                'Tfp_Type' => 'tfp_type',
                'Tfp_Status' => 'tfp_status',
                'Mfp_Intention_Use' => 'mfp_intention_use',
                'Reason_Use' => 'reason_use'
            ),
            'encoder_get_duplicate_details',
            array($couplesId)
        );
    }

    public function approveCouple(ListCoupleInterface $listCouple) : ErrorInterface
    {
        foreach ($listCouple as $couple) {
            $couple = CoupleClass::getFromVariable($couple);
            
            $method = 'rdm_approve_couples';

            $param = [
                $couple->IsApproved == N_A ? BLANK : $couple->Id
            ];

            $couple = $this->saveToDb($method, $param);

            if ($couple == 'CANNOT SAVE RECORD WITH GIVEN PARAMETERS') {
                break;
            } else {
                $couple->Message = 'Couple is Approved!';
            }
        }

        return $couple;
    }
}
