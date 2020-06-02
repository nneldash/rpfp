<?php
$this->CI =& get_instance();
$this->CI->load->model('BaseModel');

class AccomplishmentModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->CI->load->library('accomplishment/AccomplishmentClass');
        $this->CI->load->library('accomplishment/lists/ListAccomplishment');
        $this->CI->load->library('accomplishment/lists/ReportAccomplishment');
        $this->CI->load->library('accomplishment/GenerateAccomplishmentClass');
        $this->CI->load->library('report/DeleteReportClass');
    }

    public function getAccomplishmentList() : ListAccomplishmentInterface
    {
        $username = $this->session->userdata('username');
        $page_no = 1;
        $items_per_page = 10;

        $accomplishment_list = $this->fromDbGetList(
            'ListAccomplishment',
            'AccomplishmentClass',
            array(
                'ReportID' => 'report_id',
                'DateFrom' => 'date_from',
                'DateTo' => 'date_to',
                'ReportNo' => 'accom_id',
                'DateProcessed' => 'date_processed'
            ),
            'get_report_accomplishment_list',
            array($username, $page_no, $items_per_page)
        );

        $retval = new ListAccomplishment();

        foreach($accomplishment_list as $accomplishment) {
            $retval->append($accomplishment);
        }

        return $retval;
    }

    public function deleteReport($procName, ListDeleteReportInterface $listReport)
    {
        foreach ($listReport as $report) {
            $report = DeleteReportClass::getFromVariable($report);
            
            $method = $procName;

            $param = [
                $report->ReportNo == N_A ? BLANK : $report->ReportNo
            ];

            $data = $this->saveToDb($method, $param);

            if ($data == 'REPORT DELETED!') {
                $data = 'deleted';
            } else {
                $data = 'false';
            }
        }

        return $data;
    }

    public function getAccomplishmentReport($accomid) : ReportAccomplishmentInterface
    {
        $accomplishment_report = $this->fromDbGetReportList(
            'ReportAccomplishment',
            'AccomplishmentClass',
            array(
                'ClassNo' => 'class_no',
                'EncodedCouples' => 'encoded_couples',
                'ApprovedCouples' => 'approved_couples',
                'PendingCouples' => 'pending_couples',
                'ServedCouples' => 'served_couples',
                'Duplicates' => 'duplicates'
            ),
            'get_report_accomplishment_details',
            array($accomid)
        );

        $retval = new ReportAccomplishment();

        foreach($accomplishment_report as $accomplishment) {
            $retval->append($accomplishment);
        }

        return $retval;
    }

    public function saveAccomplishment($username, $psgc_code, GenerateAccomplishmentInterface $data) 
    {
        $method = 'process_accomplishment';

        $params =[
            $username == N_A ? BLANK : $username,
            $data->DateFrom == N_A ? BLANK : $data->DateFrom,
            $data->DateTo == N_A ? BLANK : $data->DateTo,
            $psgc_code == N_A ? BLANK : $psgc_code
        ];

        return $this->saveToDb($method, $params);
    }
}