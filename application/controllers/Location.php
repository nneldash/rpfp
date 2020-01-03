<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location extends CI_Controller
{
    private $user;
    const REGIONAL = 0;
    const PROVINCIAL = 1;
    const MUNICIPAL = 2;
    const BARANGAY_LEVEL = 3;

    public function __construct()
    {
        parent::__construct();

        if (!$this->LoginModel->isLoggedIn()) {
            redirect(site_url());
            return;
        }
        $this->load->model('LocationModel');
        $this->user = $this->LoginModel->getUserName();
        $this->user = empty($this->user) ? BLANK : $this->user;
    }

    private function loadPage(ListSpecificLocation $data, $errors = "NO ERRORS")
    {
        $this->load->view('includes/header', array('title' => 'RPFP Online - Regions List'));
        $this->load->view(
            'location/location',
            array(
                'data' => array(
                    USERNAME => $this->user,
                    TIME_STAMP => date('Y-m-d H-i-s e'),
                    LOC_LIST => $data,
                    LOC_ERRORS => $errors
                )
            )
        );
        $this->load->view('includes/footer');
    }

    private function loadJSON(ListSpecificLocation $data, $errors = "NO ERRORS")
    {
        $retval = array();
        foreach ($data as $location) {
            $location = SpecificLocation::getFromVariable($location);
            $barangay = $location->Barangay->Code;
            $city = $location->City->Code;
            $province = $location->Province->Code;
            $region = $location->Region->Code;
            if ($barangay != N_A) {
                $retval[$barangay] = array(
                    LOC_REGION => $location->Region->Code,
                    LOC_PROVINCE => $location->Province->Code,
                    LOC_MUNICIPALITY => $location->City->Code,
                    LOC_BARANGAY => $location->Barangay->Code,
                    LOC_SPECIFIC => $location->Barangay->Description
                );
            } elseif ($city != N_A) {
                $retval[$city] = array(
                    LOC_REGION => $location->Region->Code,
                    LOC_PROVINCE => $location->Province->Code,
                    LOC_MUNICIPALITY => $location->City->Code,
                    LOC_SPECIFIC => $location->City->Description
                );
            } elseif ($province != N_A) {
                $retval[$province] = array(
                    LOC_REGION => $location->Region->Code,
                    LOC_PROVINCE => $location->Province->Code,
                    LOC_SPECIFIC => $location->Province->Description
                );
            } elseif ($region != N_A) {
                $retval[$region] = array(
                    LOC_REGION => $location->Region->Code,
                    LOC_SPECIFIC => $location->Region->Description
                );
            }
        }

        $new_retval = array(
            USERNAME => $this->user,
            TIME_STAMP => date('Y-m-d H-i-s e'),
            LOC_LIST => $retval,
            LOC_ERRORS => $errors
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($new_retval));
    }

    private function getLocation($locs, $specific_code) : ListSpecificLocation
    {
        $retval = $locs;
        if (!empty($specific_code)) {
            if ($locs->offsetExists($specific_code)) {
                $location = SpecificLocation::getFromVariable($locs->offsetGet($specific_code));
                $retval = new ListSpecificLocation();
                $retval->offsetSet($specific_code, $location);
            }
        }
        return $retval;
    }

    private static function extractRegion(int $level, int $specific_code) : int
    {
        $specific_region = 0;
        switch ($level) {
            case self::PROVINCIAL :
                $specific_region = intdiv($specific_code, 100);
            break;
            case self::MUNICIPAL :
                $specific_region = intdiv($specific_code, 10000);
            break;
            case self::BARANGAY_LEVEL :
                $specific_region = intdiv($specific_code, 10000000);
            break;
        }

        return $specific_region;
    }

    private static function validateProvinceForRegion(int $region, $province) : string
    {
        $errors = BLANK;
        if (($region != 0) &&
            (!empty($province) &&
            (self::extractRegion(self::PROVINCIAL, $province) != $region))
        ) {
            $errors = "INVALID PROVINCE FOR USER";
        }
        return $errors;
    }

    private static function validateMunicipalityForRegion(int $region, $municipality) : string
    {
        $errors = BLANK;
        if (($region != 0) &&
            (!empty($province) &&
            (self::extractRegion(self::MUNICIPAL, $municipality) != $region))
        ) {
            $errors = "INVALID MUNICIPALITY FOR USER";
        }
        return $errors;
    }

    private static function validateEmptyLocation(int $region, int $province, int $municipality, int $barangay = 0) : string
    {
        $errors = BLANK;
        if (($region != 0) &&
            ($errors == BLANK && empty($province) && empty($municipality) && empty($barangay))
        ) {
            $errors = "GENERAL LOCATION NOT SPECIFIED";
        }
        return $errors;
    }

    private static function validateLocationMunicipality(int $region, int $province, int $municipality, int $barangay = 0) : string
    {
        $errors = self::validateProvinceForRegion($region, $province);

        if ($errors == BLANK) {
            $errors = self::validateEmptyLocation($region, $province, $municipality);
        }
        
        if ($errors == BLANK) {
            $errors = self::validateMunicipalityForRegion($region, $municipality);
        }
        
        return $errors;
    }

    public function getRegions()
    {
        /**
         * FOR SPECIFIC REGION
         * $.ajax('Location/getRegion', {'method': 'POST', 'data': {'REGION': 17}});
         * 
         * FOR LIST OF REGIONS
         * $.ajax('Location/getRegion', {'method': 'POST'});
         * 
        */

        $locs = ListSpecificLocation::getFromVariable($this->LocationModel->listRegions());
        $ret_val = $this->getLocation($locs, intval($this->input->post(LOC_REGION)));
        
        if ($this->input->server(REQUEST_METHOD) != POST) {
            $this->loadPage($ret_val);
            return;
        }

        $this->loadJSON($ret_val);
        return;
    }

    public function getProvinces(bool $with_ret_val = false)
    {
        /**
         * FOR SPECIFIC PROVINCE WITHIN THE ASSIGNED REGION
         * $.ajax('Location/getProvinces', {'method': 'POST', 'data': {'PROVINCE': 1702}});
         * 
         * FOR LIST OF PROVINCES
         * $.ajax('Location/getProvinces', {'method': 'POST'});
         * 
        */
        $this->load->model('ProfileModel');
        $profile = $this->ProfileModel->getOwnProfile();
        $profile = UserProfile::getFromVariable($profile);

        $region = $profile->DesignatedLocation->Region->Code;
        $locs = ListSpecificLocation::getFromVariable($this->LocationModel->listProvinces($region));
        $ret_val = $this->getLocation($locs, intval($this->input->post(LOC_PROVINCE)));
        
        if ($with_ret_val) {
            return $ret_val;
        } else {
            if ($this->input->server(REQUEST_METHOD) != POST) {
                $this->loadPage($ret_val);
                return;
            }
    
            $this->loadJSON($ret_val);
            return;
        }
    }

    public function getMunicipalities()
    {
        /**
         * FOR SPECIFIC MUNICIPALITY WITHIN THE ASSIGNED REGION
         * $.ajax('Location/getMunicipalities', {'method': 'POST', 'data': {'MUNICIPALITY': 170203}});
         * 
         * FOR LIST OF MUNICIPALITIES WITHIN A PROVINCE
         * $.ajax('Location/getMunicipalities', {'method': 'POST', 'data': {'PROVINCE': 170203}});
         * 
        */

        $errors = BLANK;
        $locs = array();

        $this->load->model('ProfileModel');
        $profile = $this->ProfileModel->getOwnProfile();
        $profile = UserProfile::getFromVariable($profile);
        $region_code = $profile->DesignatedLocation->Region->Code;

        $province_code = intval($this->input->post(LOC_PROVINCE));
        $municipality_code = intval($this->input->post(LOC_MUNICIPALITY));
        
        $errors = self::validateLocationMunicipality($region_code, $province_code, $municipality_code);

        if ($errors == BLANK && empty($province_code)) {
            $province_code = intdiv($municipality_code, 100);
        }

        $ret_val = new ListSpecificLocation();
        if ($errors == BLANK) {
            $locs = ListSpecificLocation::getFromVariable($this->LocationModel->listMunicipalities(($province_code)));
            $ret_val = $this->getLocation($locs, $municipality_code);
        }

        if ($this->input->server(REQUEST_METHOD) != POST) {
            $this->loadPage($ret_val, $errors);
            return;
        }

        $this->loadJSON($ret_val, $errors);
        return;    
    }

    public function getBarangays()
    {
        /**
         * FOR SPECIFIC BARANGAY WITHIN THE ASSIGNED REGION
         * $.ajax('Location/getBarangays', {'method': 'POST', 'data': {'BARANGAY': 170203013}});
         * 
         * FOR LIST OF BARANGAYS WITHIN A MUNICIPALITY
         * $.ajax('Location/getBarangays', {'method': 'POST', 'data': {'MUNICIPALITY': 170203}});
         * 
        */

        $errors = BLANK;
        $locs = array();

        $this->load->model('ProfileModel');
        $profile = $this->ProfileModel->getOwnProfile();
        $profile = UserProfile::getFromVariable($profile);
        $region_code = $profile->DesignatedLocation->Region->Code;

        $province_code = intval($this->input->post(LOC_PROVINCE));
        $municipality_code = intval($this->input->post(LOC_MUNICIPALITY));
        $barangay_code = intval($this->input->post(LOC_BARANGAY));
        
        $errors = self::validateLocationMunicipality($region_code, $province_code, $municipality_code, $barangay_code);

        if ($errors == BLANK && empty($municipality_code)) {
            $municipality_code = intdiv($barangay_code, 1000);
        }

        $ret_val = new ListSpecificLocation();
        if ($errors == BLANK) {
            $locs = ListSpecificLocation::getFromVariable($this->LocationModel->listBaranggays($municipality_code));
            $ret_val = $this->getLocation($locs, $barangay_code);
        }

        if ($this->input->server(REQUEST_METHOD) != POST) {
            $this->loadPage($ret_val, $errors);
            return;
        }

        $this->loadJSON($ret_val, $errors);
        return;    
    }
}
