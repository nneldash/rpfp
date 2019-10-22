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
    }

    public function getPendingList() : PendingInterface
    {
        $pending = new PendingClass();

        $pending->RpfpClass = '1';
        $pending->TypeClass = '';
        $pending->OthersSpecify = 'RPFP';
        $pending->Barangay = 'Addition Hills';
        $pending->ClassNo = 'RPFP-AH-2019-00001';
        $pending->DateConduct = '10/21/2019';

        return $pending;
    }

    public function getApproveList() : ApproveInterface
    {
        $pending = new ApproveClass();

        $pending->RpfpClass = '1';
        $pending->TypeClass = '';
        $pending->OthersSpecify = 'RPFP';
        $pending->Barangay = 'Addition Hills';
        $pending->ClassNo = 'RPFP-AH-2019-00001';
        $pending->DateConduct = '10/21/2019';

        return $pending;
    }
}