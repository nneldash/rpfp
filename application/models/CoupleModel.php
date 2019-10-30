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
        $this->CI->load->library('couple_list/lists/ListPendingCouple');
        $this->CI->load->library('couple_list/lists/ListApproveCouple');
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
                'Barangay' => 'barangay',
                'ClassNo' => 'class_no',
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
                'Barangay' => 'barangay',
                'ClassNo' => 'class_no',
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
}