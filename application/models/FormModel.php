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
    }

    public function saveForm1(FormInterface $form)
    {
        // $db = $this->LoginModel->reconnect();

        if (!$this->saveSeminar($form->Seminar)) {
            return;
        }
        if (!$this->saveHusband($form->ListCouple)) {
            return;
        }
        if (!$this->saveWife($form->ListCouple)) {
            return;
        }
        if (!$this->saveModernFpUser($form->ListCouple)) {
            return;
        }
        if (!$this->saveTraditionalFpUser($form->ListCouple)) {
            return;
        }

        return true;
    }

    public function saveSeminar(SeminarInterface $data)
    {
        $method = "rpfp_form1_save_seminar";
        $with_id = [];

        $params = [
            $data->TypeOfClass == N_A ? BLANK : $data->TypeOfClass,
            $data->ClassNumber == N_A ? BLANK : $data->ClassNumber,
            $data->Province == N_A ? BLANK : $data->Province,
            $data->Barangay == N_A ? BLANK : $data->Barangay,
            $data->DateConducted == N_A ? BLANK : $data->DateConducted
        ];

        return $this->saveToDb($method, $params);
    }

    public function saveHusband(ListCoupleInterface $data)
    {
        $method = "rpfp_form1_save_husband";
        $with_id = [];

        foreach ($data as $newData)
        {
           foreach ($newData->ListHusband as $husband)
           {
              $params = [
                  $husband->Name == N_A ? BLANK : $husband->Name,
                  $husband->Sex == N_A ? BLANK : $husband->Sex,
                  $husband->CivilStatus == N_A ? BLANK : $husband->CivilStatus,
                  $husband->Age == N_A ? BLANK : $husband->Age,
                  $husband->EducationalAttainment == N_A ? BLANK : $husband->EducationalAttainment,
                  $husband->HasAttended == N_A ? BLANK : $husband->HasAttended
              ];
           }
        }

        return $this->saveToDb($method, $params);
    }

    public function saveWife(ListCoupleInterface $data)
    {
        $method = "rpfp_form1_save_wife";
        $with_id = [];

        foreach ($data as $newData)
        {
           foreach ($newData->ListWife as $wife)
           {
              $params = [
                  $wife->Name == N_A ? BLANK : $wife->Name,
                  $wife->Sex == N_A ? BLANK : $wife->Sex,
                  $wife->CivilStatus == N_A ? BLANK : $wife->CivilStatus,
                  $wife->Age == N_A ? BLANK : $wife->Age,
                  $wife->EducationalAttainment == N_A ? BLANK : $wife->EducationalAttainment,
                  $wife->HasAttended == N_A ? BLANK : $wife->HasAttended
              ];
           }
        }

        return $this->saveToDb($method, $params);
    }

    public function saveModernFpUser(ListCoupleInterface $data)
    {
        $method = "rpfp_form1_save_modern_fp_user";
        $with_id = [];

        foreach ($data as $newData)
        {
           foreach ($newData->ListModernFp as $modernFp)
           {
            $params = [
                $modernFp->MethodUsed == N_A ? BLANK : $modernFp->MethodUsed,
                $modernFp->IntentionForUsing == N_A ? BLANK : $modernFp->IntentionForUsing
            ];
           }
        }

        return $this->saveToDb($method, $params);
    }

    public function saveTraditionalFpUser(ListCoupleInterface $data)
    {
        $method = "rpfp_form1_save_traditional_fp_user";
        $with_id = [];

        foreach ($data as $newData)
        {
           foreach ($newData->ListTraditionalFp as $traditionalFp)
           {
            $params = [
                $traditionalFp->Type == N_A ? BLANK : $traditionalFp->Type,
                $traditionalFp->Status == N_A ? BLANK : $traditionalFp->Status,
                $traditionalFp->IntentionForUsing == N_A ? BLANK : $traditionalFp->IntentionForUsing
            ];
           }
        }

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
        $listCouple = new ListCoupleClass();

            $couple = new CoupleClass();

            $couple->Address = 'Bulacan';
            $couple->NumberOfChildren = '12';

            $husband = new HusbandClass();

            $husband->Name = 'Chou Fan';
            $husband->Sex = 'M';
            $husband->CivilStatus = 'Married';
            $husband->Age = '31';
            $husband->EducationalAttainment = '1';
            $husband->HasAttended = 'Yes';

            $wife = new WifeClass();
                         
            $wife->Name = 'Hanabi Montana';
            $wife->Sex = 'F';
            $wife->CivilStatus = 'Married';
            $wife->Age = '31';
            $wife->EducationalAttainment = '1';
            $wife->HasAttended = 'Yes';

            $modernFp = new ModernFpUserClass();

            $modernFp->MethodUsed = '1';
            $modernFp->IntentionForUsing = '2';

            $traditionalFp = new TraditionalFpUserClass();

            $traditionalFp->Type = '1';
            $traditionalFp->Status = '2'; 
            $traditionalFp->IntentionForUsing = '3';

            $couple->ListHusband->append($husband);
            $couple->ListWife->append($wife);
            $couple->ListModernFp->append($modernFp);
            $couple->ListTraditionalFp->append($traditionalFp);
            $listCouple->append($couple);

        return $listCouple;
    }

    public function getFormA(): FormAInterface
    {
        $formA = new FormAClass();
       
        $formA->ListMonth = $this->getMonthlyData();
        return $formA;
    }

    public function getMonthlyData(): ListMonthsInterface
    {
        $listMonth = new ListMonthsClass();

            $month = new MonthsClass();

            $sessions = new SessionsHeldClass();
            $sessions->SubModule = '1';
            $sessions->Non4ps = '1';
            $sessions->Usapan = '1';
            $sessions->Pmc = '1';
            $sessions->H2h = '1';
            $sessions->ProfitedOnly = '1';
            $sessions->Total = '1';

            $individuals = new IndividualsReproductiveAgeClass();
            $individuals->SubModule = '2';
            $individuals->Non4ps = '2';
            $individuals->Usapan = '2';
            $individuals->Pmc = '2';
            $individuals->H2h = '2';
            $individuals->ProfitedOnly = '2';
            $individuals->Total = '2';


            $month->ListSessionsHeld->append($sessions);
            $month->ListIndividualsReproductiveAge->append($individuals);
            $listMonth->append($month);

        return $listMonth;
    }
}
?>