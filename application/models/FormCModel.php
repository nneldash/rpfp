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

    public function saveFormC($served_id, $psgc_code, GenerateFormAInterface $data) 
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