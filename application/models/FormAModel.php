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
    }

    public function getFormAList() : ListFormAInterface
    {
        $username = $_SESSION['username'];
        $page_no = 1;
        $items_per_page = 10;

        $forma_list = $this->fromDbGetList(
            'ListFormA',
            'FormAClass',
            array(
                'ReportID' => 'report_id',
                'ReportYear' => 'report_year',
                'ReportMonth' => 'report_month',
                // 'ReportNo' => 'demandgen_id',
                'DateProcessed' => 'date_processed'
            ),
            'get_report_demandgen_list',
            array($username, $page_no, $items_per_page)
        );

        $retval = new ListFormA();

        foreach($forma_list as $form_A) {
            $retval->append($form_A);
        }

        return $retval;
    }
}