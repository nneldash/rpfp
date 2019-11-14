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
    }

    public function getAccomplishmentList() : ListAccomplishmentInterface
    {
        $username = $_SESSION['username'];
        $page_no = 1;
        $items_per_page = 10;

        $accomplishment_list = $this->fromDbGetList(
            'ListAccomplishment',
            'AccomplishmentClass',
            array(
                'ReportID' => 'report_id',
                'ReportYear' => 'report_year',
                'ReportMonth' => 'report_month',
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

    public function getAccomplishmentReport($accomid) : ReportAccomplishmentInterface
    {
        $accomplishment_report = $this->fromDbGetReportList(
            'ReportAccomplishment',
            'AccomplishmentClass',
            array(
                'ClassNo' => 'class_no',
                'EncodedCouples' => 'encoded_couples',
                'ApprovedCouples' => 'approved_couples',
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
        $method = 'process_accomplishments';

        $params =[
            $username == N_A ? BLANK : $username,
            $data->ReportYear == N_A ? BLANK : $data->ReportYear,
            $data->ReportMonth == N_A ? BLANK : $data->ReportMonth,
            $pscgc_code == N_A ? BLANK : $pscgc_code
        ];

        return $this->saveToDb($method, $params);
    }
}