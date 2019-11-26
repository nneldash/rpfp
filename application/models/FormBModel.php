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

    public function saveFormB($unmet_id, $psgc_code, GenerateFormAInterface $data) 
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