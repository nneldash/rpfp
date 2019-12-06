<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location extends CI_Controller
{
    private $user;

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

    private function loadPage($data, $errors = "NO ERRORS")
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

    private function loadJSON($data, $errors = "NO ERRORS")
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

    public function getProvinces()
    {
        /**
         * FOR SPECIFIC PROVINCE WITHIN THE ASSIGNED REGION
         * $.ajax('Location/getRegion', {'method': 'POST', 'data': {'PROVINCE': 1702}});
         * 
         * FOR LIST OF PROVINCES
         * $.ajax('Location/getRegion', {'method': 'POST'});
         * 
        */
        $this->load->model('ProfileModel');
        $profile = $this->ProfileModel->getOwnProfile();
        $profile = UserProfile::getFromVariable($profile);

        $region = $profile->DesignatedLocation->Region->Code;
        $locs = ListSpecificLocation::getFromVariable($this->LocationModel->listProvinces($region));
        $ret_val = $this->getLocation($locs, intval($this->input->post(LOC_PROVINCE)));
        
        if ($this->input->server(REQUEST_METHOD) != POST) {
            $this->loadPage($ret_val);
            return;
        }

        $this->loadJSON($ret_val);
        return;
    }

    
}
