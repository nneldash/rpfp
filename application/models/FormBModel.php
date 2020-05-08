<?php
$this->CI =& get_instance();
$this->CI->load->model('BaseModel');

class FormBModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->CI->load->library('formB/FormBClass');
        $this->CI->load->library('formB/lists/ListFormBClass');
        $this->CI->load->library('formB/lists/ReportFormBClass');
        $this->CI->load->library('formB/GenerateFormBClass');
    }

    public function getFormBList() : ListFormBInterface
    {
        $page_no = 1;
        $items_per_page = 10;

        $formb_list = $this->fromDbGetList(
            'ListFormBClass',
            'FormBClass',
            array(
                'ReportID' => 'report_id',
                'ReportNo' => 'report_no',
                'ReportYear' => 'report_year',
                'ReportCode' => 'report_code',
                'ReportMonth' => 'report_month',
                'RegionalOffice' => 'psgc_code',
                'DateProcessed' => 'date_processed'
            ),
            'get_report_unmet_need_list',
            array($page_no, $items_per_page)
        );

        $retval = new ListFormBClass();

        foreach($formb_list as $form_B) {
            $retval->append($form_B);
        }

        return $retval;
    }

    public function getFormBReport(int $regionalOffice, string $report_no, string $report_month, int $report_year) : ReportFormBInterface
    {
        switch ($report_month){
            case 'Quarter 1':
                $report_month = 3;
                $report_period = 1;
                break;
            case 'Quarter 2':
                $report_month = 6;
                $report_period = 4;
                break;
            case 'Quarter 3':
                $report_month = 9;
                $report_period = 7;
                break;
            case 'Quarter 4':
                $report_month = 12;
                $report_period = 10;
                break;
            case 'Annual':
                $report_month = 12;
                $report_period = 1;
                break;
            default:
                $report_month = date('m', strtotime($report_month));
                $report_period = 0;
                break;
        }

        $formb_report = $this->fromDbGetReportList(
            'ReportFormBClass',
            'FormBClass',
            array(
                'ReportDate' => 'report_month',
                'UnmetModern' => 'unmet_modern',
                'ServedModern' => 'served_modern',
                'NoIntention' => 'no_intention',
                'WithIntention' => 'w_intention',
                'ServedTraditional' => 'served_traditional',
                'TotalUnmet' => 'total_unmet',      
                'TotalServed' => 'total_served'
            ),
            'get_report_unmet_need_details',
            array($report_no, $report_month, $report_year)
        );

        $retval = new ReportFormBClass();

        foreach($formb_report as $form_B) {
            $retval->append($form_B);
        }

        $retval->To = strtotime($report_year . '-' . $report_month . '-1');
        $retval->From = strtotime($report_year . '-' . $report_period . '-1');
        $retval->Header = $report_period;
        
        $retval->From = strtotime($report_year . '-' . $report_month . '-1');
        return $retval;
    }

    public function saveFormB($psgc_code, GenerateFormBInterface $data) 
    {
        $method = 'process_unmet_need';

        $params =[
            $data->ReportType == N_A ? BLANK : $data->ReportType,
            $data->ReportYear == N_A ? BLANK : $data->ReportYear,
            $data->ReportQuarter == N_A ? BLANK : $data->ReportQuarter,
            $data->ReportMonth == N_A ? BLANK : $data->ReportMonth,
            $psgc_code == N_A ? BLANK : $psgc_code
        ];

        return $this->saveToDb($method, $params);
    }
}