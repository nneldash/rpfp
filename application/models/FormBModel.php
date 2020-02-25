<?php
$this->CI =& get_instance();
$this->CI->load->model('BaseModel');

class FormBModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->CI->load->library('formB/FormBClass');
        $this->CI->load->library('formB/lists/ListFormB');
        $this->CI->load->library('formB/lists/ReportFormB');
        $this->CI->load->library('formB/GenerateFormBClass');
    }

    public function getFormBList() : ListFormBInterface
    {
        $page_no = 1;
        $items_per_page = 10;

        $formb_list = $this->fromDbGetList(
            'ListFormB',
            'FormBClass',
            array(
                'ReportID' => 'report_id',
                'ReportYear' => 'report_year',
                'ReportMonth' => 'report_month',
                // 'ReportNo' => 'demandgen_id',
                'DateProcessed' => 'date_processed'
            ),
            'get_report_unmet_need_list',
            array($page_no, $items_per_page)
        );

        $retval = new ListFormB();

        foreach($formb_list as $form_B) {
            $retval->append($form_B);
        }

        return $retval;
    }

    public function getFormBReport(int $report_id, int $report_month, int $report_year) : ReportFormBInterface
    {
        $formb_report = $this->fromDbGetReportList(
            'ReportFormB',
            'FormBClass',
            array(
                'UnmetModern' => 'unmet_modern',
                'ServedModern' => 'served_modern',
                'NoIntention' => 'no_intention',
                'WithIntention' => 'w_intention',
                'ServedTraditional' => 'served_traditional',
                'TotalUnmet' => 'total_unmet',      
                'TotalServed' => 'total_served'
            ),
            'get_report_unmet_need_details',
            array($report_id, $report_month, $report_year)
        );

        $retval = new ReportFormB();

        foreach($formb_report as $form_B) {
            $retval->append($form_B);
        }

        $retval->From = strtotime($report_year . '-' . $report_month . '-1');
        return $retval;
    }

    public function saveFormB($unmet_id, $psgc_code, GenerateFormBInterface $data) 
    {
        $method = 'process_unmet_need';

        $params =[
            $unmet_id == N_A ? BLANK : $unmet_id,
            $data->ReportYear == N_A ? BLANK : $data->ReportYear,
            $data->ReportMonth == N_A ? BLANK : $data->ReportMonth,
            $psgc_code == N_A ? BLANK : $psgc_code
        ];

        return $this->saveToDb($method, $params);
    }
}