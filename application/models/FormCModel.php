<?php
$this->CI =& get_instance();
$this->CI->load->model('BaseModel');

class FormCModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->CI->load->library('formC/FormCClass');
        $this->CI->load->library('formC/lists/ListFormC');
        $this->CI->load->library('formC/lists/ReportFormC');
        $this->CI->load->library('formC/GenerateFormCClass');
    }

    public function getFormCList() : ListFormCInterface
    {
        // $username = $_SESSION['username'];
        $page_no = 1;
        $items_per_page = 10;

        $formc_list = $this->fromDbGetList(
            'ListFormC',
            'FormCClass',
            array(
                'ReportID' => 'report_id',
                'ReportNo' => 'report_no',
                'ReportYear' => 'report_year',
                'ReportCode' => 'report_code',
                'ReportMonth' => 'report_month',
                'RegionalOffice' => 'psgc_code',
                'DateProcessed' => 'date_processed'
            ),
            'get_report_served_method_mix_list',
            array($page_no, $items_per_page)
        );

        $retval = new ListFormC();

        foreach($formc_list as $form_C) {
            $retval->append($form_C);
        }

        return $retval;
    }

    public function getFormCReport(int $regionalOffice, string $report_no, string $report_month, int $report_year) : ReportFormCInterface
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

        $formc_report = $this->fromDbGetReportList(
            'ReportFormC',
            'FormCClass',
            array(
                'ReportDate' => 'report_month',
                'ServedCondom' => 'served_condom',
                'ServedIUD' => 'served_iud',
                'ServedPills' => 'served_pills',
                'ServedInjectables' => 'served_injectables',
                'ServedNSV' => 'served_nsv',
                'ServedBTL' => 'served_btl',
                'ServedImplant' => 'served_implant',
                'ServedCMM' => 'served_cmm',
                'ServedBBT' => 'served_bbt',
                'ServedSymptoThermal' => 'served_symptothermal',
                'ServedSDM' => 'served_sdm',
                'ServedLAM' => 'served_lam',
                'TotalServed' => 'total_served'
            ),
            'get_report_served_method_mix_details',
            array($report_no, $report_month, $report_year)
        );

        $retval = new ReportFormC();

        foreach($formc_report as $form_C) {
            $retval->append($form_C);
        }

        $retval->To = strtotime($report_year . '-' . $report_month . '-1');
        $retval->From = strtotime($report_year . '-' . $report_period . '-1');
        $retval->Header = $report_period;
        
        $retval->RegionalOffice = $regionalOffice;
        return $retval;
    }

    public function saveFormC($psgc_code, GenerateFormCInterface $data) 
    {
        $method = 'process_served_method_mix';

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