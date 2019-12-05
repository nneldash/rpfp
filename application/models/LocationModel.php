<?php
$this->CI =& get_instance();
$this->CI->load->model('BaseModel');

class LocationModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->CI->load->library('common/lists/ListSpecificLocation');
    }
    
    public function listRegions() : ListLocationInterface
    {
        $list = $this->fromDbGetList(
            'ListSpecificLocation',
            'SpecificLocation',
            array(
                'Region' => array(
                    'Code' => 'region_id',
                    'Description' => 'location_name',
                )
                ),
            'lib_list_regions',
            array(),
            'common'
        );

        $retval = new ListSpecificLocation();
        foreach ($list as $region) {
            $retval->append($region);
        }

        return $retval;
    }

    public function listProvinces(int $region_code) : ListLocationInterface
    {
        $list = $this->fromDbGetList(
            'ListSpecificLocation',
            'SpecificLocation',
            array(
                'Region' => array(
                    'Code' => 'region_id',
                    'Description' => 'region_name',
                ),
                'Province' => array(
                    'Code' => 'location_code',
                    'Description' => 'location_name',
                )
            ),
            'lib_list_provinces',
            array($region_code)
        );

        $retval = new ListSpecificLocation();
        foreach ($list as $province) {
            $retval->append($province);
        }

        return $retval;
    }

    public function listMunicipalities(int $province_code) : ListLocationInterface
    {
        $list = $this->fromDbGetList(
            'ListSpecificLocation',
            'SpecificLocation',
            array(
                'Region' => array(
                    'Code' => 'region_id',
                    'Description' => 'region_name',
                ),
                'Province' => array(
                    'Code' => 'province_id',
                    'Description' => 'province_name',
                ),
                'City' => array(
                    'Code' => 'location_code',
                    'Description' => 'location_name',
                )
            ),
            'lib_list_cities',
            array($province_code)
        );

        $retval = new ListSpecificLocation();
        foreach ($list as $municipality) {
            $retval->append($municipality);
        }

        return $retval;
    }

    public function listBaranggays(int $city_code) : ListLocationInterface
    {
        $list = $this->fromDbGetList(
            'ListSpecificLocation',
            'SpecificLocation',
            array(
                'Region' => array(
                    'Code' => 'region_id',
                    'Description' => 'region_name',
                ),
                'Province' => array(
                    'Code' => 'province_id',
                    'Description' => 'province_name',
                ),
                'City' => array(
                    'Code' => 'municipality_id',
                    'Description' => 'municipality_name',
                ),
                'SpecificLocation' => array(
                    'Code' => 'location_code',
                    'Description' => 'location_name',
                )
            ),
            'lib_list_brgy',
            array($city_code)
        );

        $retval = new ListSpecificLocation();
        foreach ($list as $barangay) {
            $retval->append($barangay);
        }

        return $retval;
    }

    public function getFullLocation(int $barangay_id) : LocationInterface
    {
        $barangay = $this->fromDbGetSpecific(
            'SpecificLocation',
            array(
                'Region' => array(
                    'Code' => 'region_id',
                    'Description' => 'region_name',
                ),
                'Province' => array(
                    'Code' => 'province_id',
                    'Description' => 'province_name',
                ),
                'City' => array(
                    'Code' => 'municipality_id',
                    'Description' => 'municipality_name',
                ),
                'Barangay' => array(
                    'Code' => 'location_code',
                    'Description' => 'location_name',
                )
            ),
            'lib_get_full_location',
            array($barangay_id)
        );

        $retval = SpecificLocation::getFromVariable($barangay);

        if (!empty($barangay)) {
            if (empty($retval->Barangay->Code) && empty($retval->City->Code) && empty($retval->Province->Code)) {
                $retval->Region->Description = $retval->Barangay->Description;
            } elseif (empty($retval->Barangay->Code) && empty($retval->City->Code)) {
                $retval->Province->Description = $retval->Barangay->Description;
            } elseif (empty($retval->Barangay->Code)) {
                $retval->City->Description = $retval->Barangay->Description;
            }
        }

        return $retval;
    }
}
