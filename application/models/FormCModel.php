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
                'ReportYear' => 'report_year',
                'ReportMonth' => 'report_month',
                // 'ReportNo' => 'demandgen_id',
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

    public function getFormCReport(int $report_id, int $report_month, int $report_year) : ReportFormCInterface
    {
        $formc_report = $this->fromDbGetReportList(
            'ReportFormC',
            'FormCClass',
            array(
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
            array($report_id, $report_month, $report_year)
        );

        $retval = new ReportFormC();

        foreach($formc_report as $form_C) {
            $retval->append($form_C);
        }

        $retval->From = strtotime($report_year . '-' . $report_month . '-1');
        return $retval;
    }

    public function saveFormC($served_id, $psgc_code, GenerateFormCInterface $data) 
    {
        $method = 'process_served_method_mix';

        $params =[
            $served_id == N_A ? BLANK : $served_id,
            $data->ReportYear == N_A ? BLANK : $data->ReportYear,
            $data->ReportMonth == N_A ? BLANK : $data->ReportMonth,
            $psgc_code == N_A ? BLANK : $psgc_code
        ];

        return $this->saveToDb($method, $params);
    }
}