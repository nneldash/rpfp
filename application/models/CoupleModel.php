<?php
$this->CI =& get_instance();
$this->CI->load->model('BaseModel');

class CoupleModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->CI->load->library('couple_list/PendingClass');
        $this->CI->load->library('couple_list/ApproveClass');
        $this->CI->load->library('couple_list/SearchApproveClass');
        $this->CI->load->library('couple_list/SearchPendingClass');
        $this->CI->load->library('couple_list/lists/ListPendingCouple');
        $this->CI->load->library('couple_list/lists/ListApproveCouple');
        $this->CI->load->library('dashboard/PercentageYearClass');
    }

    public function getPendingList() : ListPendingCoupleInterface
    {
        $page_no = 1;
        $items_per_page = 10;

        $pending_list = $this->fromDbGetList(
            'ListPendingCouple',
            'PendingClass',
            array(
                'RpfpClass' => 'rpfpclass',
                'TypeClass' => 'typeclass',
                'OthersSpecify' => 'others_specify',
                'Province' => 'province_name',
                'Municipality' => 'municipality_name',
                'Barangay' => 'barangay',
                'ClassNo' => 'class_no',
                'CouplesEncoded' => 'couples_encoded',
                'CouplesServed' => 'served_count',
                'DateConduct' => 'date_conduct',
                'LastName' => 'lastname',
                'FirstName' => 'firstname'
            ),
            'encoder_get_class_list_pending',
            array($page_no, $items_per_page)
        );

        $retval = new ListPendingCouple();

        foreach($pending_list as $pendingCouples) {
            $retval->append($pendingCouples);
        }

        return $retval;
    }

    public function getApproveList() : ListApproveCoupleInterface
    {
        $page_no = 1;
        $items_per_page = 10;

        $approve_list = $this->fromDbGetList(
            'ListApproveCouple',
            'ApproveClass',
            array(
                'RpfpClass' => 'rpfpclass',
                'TypeClass' => 'typeclass',
                'OthersSpecify' => 'others_specify',
                'Province' => 'province_name',
                'Municipality' => 'municipality_name',
                'Barangay' => 'barangay',
                'ClassNo' => 'class_no',
                'CouplesEncoded' => 'couples_encoded',
                'CouplesServed' => 'served_count',
                'DateConduct' => 'date_conduct',
                'LastName' => 'lastname',
                'FirstName' => 'firstname'
            ),
            'encoder_get_class_list_approved',
            array($page_no, $items_per_page)
        );

        $retval = new ListApproveCouple();

        foreach($approve_list as $approveCouples) {
            $retval->append($approveCouples);
        }

        return $retval;
    }

    public function getFormList($classId) : ListPendingCoupleInterface
    {
        $is_active = 0;
        $page_no = 1;
        $items_per_page = 10;
        
        $pending_list = $this->fromDbGetList(
            'ListPendingCouple',
            'PendingClass',
            array(
                'RpfpClass' => 'rpfpclass',
                'TypeClass' => 'typeclass',
                'OthersSpecify' => 'others_specify',
                'Barangay' => 'barangay',
                'ClassNo' => 'class_no',
                'CouplesEncoded' => 'couples_encoded',
                'CouplesServed' => 'served_count',
                'DateConduct' => 'date_conduct',
                'LastName' => 'lastname',
                'FirstName' => 'firstname'
            ),
            'get_forms_list',
            array($classId, $is_active, $page_no, $items_per_page)
        );

        $retval = new ListPendingCouple();

        foreach($pending_list as $pendingCouples) {
            $retval->append($pendingCouples);
        }

        return $retval;
    }

    public function getPercentageYear($percentage_year) : PercentageYearInterface
    {
        return $this->fromDbGetSpecific(
            'PercentageYearClass',
            array(
                'Region1' => 'couples_encoded_r01',
                'Region2' => 'couples_encoded_r02',
                'Region3' => 'couples_encoded_r03',
                'Region4a' => 'couples_encoded_r4a',
                'Region4b' => 'couples_encoded_r4b',
                'Region5' => 'couples_encoded_r05',
                'Region6' => 'couples_encoded_r06',
                'Region7' => 'couples_encoded_r07',
                'Region8' => 'couples_encoded_r08',
                'Region9' => 'couples_encoded_r09',
                'Region10' => 'couples_encoded_r10',
                'Region11' => 'couples_encoded_r11',
                'Region12' => 'couples_encoded_r12',
                'Region13' => 'couples_encoded_r13',
                'Barmm' => 'couples_encoded_barmm',
                'Car' => 'couples_encoded_car',
                'Ncr' => 'couples_encoded_ncr'
            ),
            'get_percentage_encoded',
            array(
                $percentage_year
            )
        );
    }

    public function getSearchValuesForPending($data) : ListPendingCoupleInterface
    {
        $status_active = 0;
        $page_no = 1;
        $items_per_page = 10;

        $result = $this->fromDbGetList(
            'ListPendingCouple',
            'PendingClass',
            array(
                'RpfpClass' => 'rpfpclass',
                'TypeClass' => 'typeclass',
                'OthersSpecify' => 'others_specify',
                'Province' => 'province_name',
                'Municipality' => 'municipality_name',
                'Barangay' => 'barangay',
                'ClassNo' => 'class_no',
                'CouplesEncoded' => 'couples_encoded',
                'CouplesServed' => 'served_count',
                'DateConduct' => 'date_conduct',
                'LastName' => 'lastname',
                'FirstName' => 'firstname'
            ),
            'search_data',
            array(
                $data->ProvinceCode == N_A ? BLANK : $data->ProvinceCode,
                $data->MunicipalityCode == N_A ? BLANK : $data->MunicipalityCode,
                $data->BarangayCode == N_A ? BLANK : $data->BarangayCode,
                $data->ClassNo == N_A ? BLANK : $data->ClassNo,
                $data->DateConductedFrom == N_A ? BLANK : $data->DateConductedFrom,
                $data->DateConductedTo == N_A ? BLANK : $data->DateConductedTo,
                $data->TypeOfClass == N_A ? BLANK : $data->TypeOfClass,
                N_A,
                N_A,
                N_A,
                N_A,
                N_A,
                N_A,
                N_A,
                N_A,
                N_A,
                $status_active,
                $page_no,
                $items_per_page
            ),
            'pending_couple_list'
        );

        $listPending = new ListPendingCouple();

        foreach ($result as $item) {
            $listPending->append($item);
        } 
        
        return $listPending;
    }

    public function getSearchValuesForApproved($data) : ListApproveCoupleInterface
    {
        $status_active = 0;
        $page_no = 1;
        $items_per_page = 10;

        $result = $this->fromDbGetList(
            'ListApproveCouple',
            'ApproveClass',
            array(
                'RpfpClass' => 'rpfpclass',
                'TypeClass' => 'typeclass',
                'OthersSpecify' => 'others_specify',
                'Province' => 'province_name',
                'Municipality' => 'municipality_name',
                'Barangay' => 'barangay',
                'ClassNo' => 'class_no',
                'CouplesEncoded' => 'couples_encoded',
                'CouplesServed' => 'served_count',
                'DateConduct' => 'date_conduct',
                'LastName' => 'lastname',
                'FirstName' => 'firstname'
            ),
            'search_data',
            array(
                $data->ProvinceCode == N_A ? BLANK : $data->ProvinceCode,
                $data->MunicipalityCode == N_A ? BLANK : $data->MunicipalityCode,
                $data->BarangayCode == N_A ? BLANK : $data->BarangayCode,
                $data->ClassNo == N_A ? BLANK : $data->ClassNo,
                $data->DateConductedFrom == N_A ? BLANK : $data->DateConductedFrom,
                $data->DateConductedTo == N_A ? BLANK : $data->DateConductedTo,
                $data->TypeOfClass == N_A ? BLANK : $data->TypeOfClass,
                $data->CoupleName == N_A ? BLANK : $data->CoupleName,
                $data->AgeFrom == N_A ? BLANK : $data->AgeFrom,
                $data->AgeTo == N_A ? BLANK : $data->AgeTo,
                $data->NoOfChildren == N_A ? BLANK : $data->NoOfChildren,
                $data->ModernFpUser == N_A ? BLANK : $data->ModernFpUser,
                $data->NonModernFpUser == N_A ? BLANK : $data->NonModernFpUser,
                $data->IntentionStatus == N_A ? BLANK : $data->IntentionStatus,
                $data->IntentionToUse == N_A ? BLANK : $data->IntentionToUse,
                $data->SearchStatus == N_A ? BLANK : $data->SearchStatus,
                $status_active,
                $page_no,
                $items_per_page
            ),
            'couple_list'
        );

        $listApprove = new ListApproveCouple();

        foreach ($result as $item) {
            $listApprove->append($item);
        } 
        
        return $listApprove;
    }
} 