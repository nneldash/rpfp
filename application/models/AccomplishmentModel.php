<?php
$this->CI =& get_instance();
$this->CI->load->model('BaseModel');

class AccomplishmentModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->CI->load->library('accomplishment_list/AccomplishmentClass');
        $this->CI->load->library('accomplishment_list/lists/ListAccomplishment');
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
}