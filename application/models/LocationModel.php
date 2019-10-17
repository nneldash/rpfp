<?php
$this->CI =& get_instance();
$this->CI->load->model('BaseModel');

class LocationModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->CI->load->iface('common/SpecificLocation');
        
    }
    
    public function ListRegions() : ListLocationInterface
    {
        $list = $this->fromDbGetList(
            'ListSpecificLocation',
            'SpecificLocation',
            array(
                'Region' => array(
                    'Code' => xxxxxxz,
                    'Description' => xxxxxxz,
            ),
            'lib_list_regions'
        );

        $retval = new ListSpecificLocation();


        return $retval;
    }

    public function ListBarangays(int $code) : ListLocationInterface
    {
        $list = $this->fromDbGetList(
            'ListSpecificLocation',
            'SpecificLocation',
            array(
                'Region' => array(
                    'Code' => xxxxxxz,
                    'Description' => xxxxxxz,
                ),
                'Province' => array(
                    'Code' => xxxxxxz,
                    'Description' => xxxxxxz,
                ),
                'City' => array(
                    'Code' => xxxxxxz,
                    'Description' => xxxxxxz,
                ),
                'SpecificLocation' => array(
                    'Code' => xxxxxxz,
                    'Description' => xxxxxxz,
                ),
            ),
            ''
        );

        $retval = new ListSpecificLocation();


        return $retval;
    }

}
