<?php
$this->CI =& get_instance();
$this->CI->load->model('BaseModel');

class FormModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->CI->load->library('login/DbInstance');
        $this->CI->load->library('form/FormClass');
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
        if ($this->saveTraditionalFpUser($form->ListCouple)) {
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

        // return $this->saveToDb($method, $params);
        return $params;
    }

    public function saveHusband(ListCoupleInterface $data)
    {
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

        return $params;
    }

    public function saveWife(ListCoupleInterface $data)
    {
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

        return $params;
    }

    public function saveModernFpUser(ListCoupleInterface $data)
    {
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

        return $params;
    }

    public function saveTraditionalFpUser(ListCoupleInterface $data)
    {
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

        return $params;
    }
}
?>