<?php
$this->CI =& get_instance();
$this->CI->load->model('BaseModel');

class FormModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->CI->load->library('login/DbInstance');
        $this->CI->load->library('form1/FormClass');
        $this->CI->load->library('service_slip/ServiceSlipClass');
        $this->CI->load->library('formA/FormAClass');
        $this->CI->load->library('formA/SessionsHeldClass');
        $this->CI->load->library('formA/MonthsClass');
        $this->CI->load->library('formA/IndividualsReproductiveAgeClass');
        $this->CI->load->library('formA/SoloCoupleDisaggregationClass');
        $this->CI->load->library('formA/SoloAttendeesClass');
    }

    public function saveForm1(FormInterface $form)
    {
        $class_id = $this->saveSeminar($form->Seminar);
        if (!$class_id) {
            /** return exception or error message */
            return;
        }

        foreach ($form->ListCouple as $current_couple) {
            $current_couple = CoupleClass::getFromVariable($current_couple);
            if (!$this->saveCouple($class_id, $current_couple)) {
                return "yehey!!!";
            }
        }

        return true;
    }

    public function saveSeminar(SeminarInterface $data)
    {
        $method = "encoder_save_class";
        $with_id = [$data->ClassId == N_A ? BLANK : $data->ClassId];

        $params = $with_id + [
            $data->TypeOfClass->Type == N_A ? BLANK : $data->TypeOfClass->Type,
            $data->TypeOfClass->Others == N_A ? BLANK : $data->TypeOfClass->Others,
            $data->Location->SpecificLocation->Code  == N_A ? BLANK : $data->Location->SpecificLocation->Code,
            $data->ClassNumber == N_A ? BLANK : $data->ClassNumber,
            $data->DateConducted == N_A ? BLANK : $data->DateConducted
        ];

        return $this->saveToDb($method, $params);
    }

    public function saveCouple(int $class_id, CoupleInterface $couple)
    {
        $method = "encoder_save_couple";
        $husband = $couple->Husband();
        $wife = $couple->Wife();
        $traditional = $couple->TraditionalFp;
        $modern = $couple->ModernFp;

        $params = [
            $class_id == 0 ? BLANK : $class_id,
            $couple->Id == N_A ? BLANK : $couple->Id,

            $couple->Address_St == N_A ? BLANK : $couple->Address_St,
            $couple->Address_Brgy == N_A ? BLANK : $couple->Address_Brgy,
            $couple->Address_City == N_A ? BLANK : $couple->Address_City,
            $couple->Address_HH_No == N_A ? BLANK : $couple->Address_HH_No,
            $couple->NumberOfChildren == N_A ? BLANK : $couple->NumberOfChildren,

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
            $wife->Attendee == N_A ? BLANK : $wife->Attendee,

            $modern->MethodUsed == N_A ? BLANK : $modern->MethodUsed,
            $modern->IntentionToShift == N_A ? BLANK : $modern->IntentionToShift,

            $traditional->Type == N_A ? BLANK : $traditional->Id,
            $traditional->Status == N_A ? BLANK : $traditional->Status,
            $traditional->ReasonForUse == N_A ? BLANK : $traditional->ReasonForUse        
        ];

        return $this->saveToDb($method, $params);
    }

    public function saveServiceSlip(ServiceSlipInterface $data)
    {
        $method = "rpfp_save_service_slip";
        $with_id = [];

        $params = [
            $data->DateOfVisit == N_A ? BLANK : $data->DateOfVisit,
            $data->ClientName == N_A ? BLANK : $data->ClientName,
            $data->ClientAddress == N_A ? BLANK : $data->ClientAddress,
            $data->Method == N_A ? BLANK : $data->Method,
            $data->DateOfMethod == N_A ? BLANK : $data->DateOfMethod,
            $data->ReferralFacility == N_A ? BLANK : $data->ReferralFacility,
            $data->Name == N_A ? BLANK : $data->Name
        ];

        return $this->saveToDb($method, $params);
    }

    public function getForm1(): FormInterface
    {
        $form1 = new FormClass();

        $form1->Seminar = $this->getForm1Seminar();
        $form1->ListCouple = $this->getForm1Couple();
        return $form1;
    }

    public function getForm1Seminar() : SeminarInterface
    {
        $seminar = new SeminarClass();

        $seminar->TypeOfClass = '4ps';
        $seminar->ClassNumber = '12345';
        $seminar->Province = 'Bulacan';
        $seminar->Barangay = 'Sta.Ana';
        $seminar->DateConducted = '09/10/2019';

        return $seminar;

    }

    public function getForm1Couple() : ListCoupleInterface
    {
        // $couple = new CoupleClass();

        // return $this->fromDbGetList(
        //     'ListCoupleClass',
        //     'CoupleClass',
        //     array(
        //         'Address' => 'address',
        //         'NumberOfChildren' => 'no_of_children'
        //     ),
        //     'rpfp_form1_get_couple',
        //     array(),
        //     'couple'
        // );

        $listCouple = new ListCoupleClass();

        $couple = new CoupleClass();

        $couple->Address = 'Bulacan';
        $couple->NumberOfChildren = '12';

        $couple->ListHusband->append($this->getForm1Husband());
        $couple->ListWife->append($this->getForm1Wife());
        $couple->ListModernFp->append($this->getForm1ModernFpUser());
        $couple->ListTraditionalFp->append($this->getForm1TraditionalFpUser());
        $listCouple->append($couple);

        return $listCouple;
    }

    public function getForm1Husband() : IndividualInterface
    {   
        $husband = new IndividualClass();

        $husband->Name = 'Chou Fan';
        $husband->Sex = 'M';
        $husband->CivilStatus = 'Married';
        $husband->Age = '31';
        $husband->EducationalAttainment = '1';
        $husband->HasAttended = 'Yes';

        return $husband;
        
    }

    public function getForm1Wife() : IndividualInterface
    {
        $wife = new IndividualClass();

        $wife->Name = 'Hanabi Montana';
        $wife->Sex = 'F';
        $wife->CivilStatus = 'Married';
        $wife->Age = '31';
        $wife->EducationalAttainment = '1';
        $wife->HasAttended = 'Yes';

        return $wife;
    }

    public function getForm1ModernFpUser() : ModernFpUserInterface
    {
        $modernFp = new ModernFpUserClass();
        
        $modernFp->MethodUsed = '1';
        $modernFp->IntentionForUsing = '2';

        return $modernFp;
    }

    public function getForm1TraditionalFpUser() : TraditionalFpUserInterface
    {
        $traditionalFp = new TraditionalFpUserClass();
        
        $traditionalFp->Type  = '1';
        $traditionalFp->Status = '2';
        $traditionalFp->IntentionForUsing = '3';

        return $traditionalFp;
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

        $periodReport->MonthsPeriod = '1';
        $periodReport->RegionalOffice = 'III';

        return $periodReport;
    }

    public function getMonthlyData() : ListMonthsInterface
    {
        $listMonth = new ListMonthsClass();

        $month = new MonthsClass();
        $month->Month = '1';
 
        $month->ListSessionsHeld->append($this->getFormASessionsHeld());
        $month->ListIndividualsReproductiveAge->append($this->getFormAIndividualsReproductiveAge());
        $month->ListSoloCoupleDisaggregation->append($this->getFormASoloCoupleDisaggregation());
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
        $listDisaggregation = new ListSoloCoupleDisaggregationClass();
        $disaggregation = new SoloCoupleDisaggregationClass();

        $disaggregation->CoupleAttendees = '5';

        $solo = new SoloAttendeesClass();

        $solo->Male = '5';
        $solo->Female = '5';

        $disaggregation->ListSoloAttendees->append($solo);
        return $disaggregation;
    }
}
