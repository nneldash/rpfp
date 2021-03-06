<?php
$this->CI =& get_instance();
$this->CI->load->model('BaseModel');

class LocationModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->CI->load->library('common/lists/ListSpecificLocation');
        $this->CI->load->library('common/SpecificLocation');
        $this->initialize_cache();
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
            'common',
            array('Region', 'Code')
        );

        $retval = new ListSpecificLocation();
        foreach ($list as $location) {
            $location = SpecificLocation::getFromVariable($location);
            $retval->offsetSet($location->Region->Code, $location);
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
            array($region_code),
            'common',
            array('Province', 'Code')
        );

        $retval = new ListSpecificLocation();
        foreach ($list as $location) {
            $location = SpecificLocation::getFromVariable($location);
            $retval->offsetSet($location->Province->Code, $location);
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
        foreach ($list as $location) {
            $location = SpecificLocation::getFromVariable($location);
            $retval->offsetSet($location->City->Code, $location);
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
                'Barangay' => array(
                    'Code' => 'location_code',
                    'Description' => 'location_name',
                )
            ),
            'lib_list_brgy',
            array($city_code)
        );

        $retval = new ListSpecificLocation();
        foreach ($list as $location) {
            $location = SpecificLocation::getFromVariable($location);
            $retval->offsetSet($location->Barangay->Code, $location);
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
