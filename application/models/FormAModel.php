<?php
$this->CI =& get_instance();
$this->CI->load->model('BaseModel');

class FormAModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->CI->load->library('formA/FormAClass');
        $this->CI->load->library('formA/lists/ListFormA');
        $this->CI->load->library('formA/lists/ReportFormA');
        $this->CI->load->library('formA/GenerateFormAClass');
    }

    public function getFormAList() : ListFormAInterface
    {
        $page_no = 1;
        $items_per_page = 10;

        $forma_list = $this->fromDbGetList(
            'ListFormA',
            'FormAClass',
            array(
                'ReportID' => 'report_id',
                'ReportNo' => 'report_no',
                'ReportYear' => 'report_year',
                'ReportCode' => 'report_code',
                'ReportMonth' => 'report_month',
                'RegionalOffice' => 'psgc_code',
                'DateProcessed' => 'date_processed'
            ),
            'get_report_demandgen_list',
            array($page_no, $items_per_page)
        );

        $retval = new ListFormA();

        foreach($forma_list as $form_A) {
            $retval->append($form_A);
        }

        return $retval;
    }

    public function getFormAReport(int $regionalOffice, string $report_no, string $report_month, int $report_year) : ReportFormAInterface
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

        $forma_report = $this->fromDbGetReportList(
            'ReportFormA',
            'FormAClass',
            array(
                'ReportDate' => 'report_month',
                'Class4Ps' => 'class_4ps',
                'ClassNon4Ps' => 'class_non4ps',
                'ClassUsapan' => 'class_usapan',
                'ClassPMC' => 'class_pmc',
                'ClassH2H' => 'class_h2h',
                'ClassProfiled' => 'class_profiled',
                'ClassTotal' => 'class_total',      
                'TargetCouples' => 'target_couples',             
                'WRA4Ps' => 'wra_4ps',
                'WRANon4Ps' => 'wra_non4ps',
                'WRAUsapan' => 'wra_usapan',
                'WRAPMC' => 'wra_pmc',
                'WRAH2H' => 'wra_h2h',
                'WRAProfiled' => 'wra_profiled',
                'WRATotal' => 'wra_total',
                'SoloMale' => 'solo_male',
                'SoloFemale' => 'solo_female',
                'CoupleAttendee' => 'couple_attendee',
                'TotalReached' => 'reached_total'
            ),
            'get_report_demandgen_details',
            array($report_no, $report_month, $report_year)
        );

        $retval = new ReportFormA();

        foreach($forma_report as $form_A) {
            $retval->append($form_A);
        }

        $retval->To = strtotime($report_year . '-' . $report_month . '-1');
        $retval->From = strtotime($report_year . '-' . $report_period . '-1');
        $retval->Header = $report_period;
        
        $retval->RegionalOffice = $regionalOffice;
        return $retval;
    }

    public function saveFormA($psgc_code, GenerateFormAInterface $data) 
    {
        $method = 'process_demandgen';

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