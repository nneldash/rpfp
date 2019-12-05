<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Location extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->LoginModel->isLoggedIn()) {
            redirect(site_url());
            return;
        }
        $this->load->model('LocationModel');
    }

    public function getRegion()
    {
        /**
         * FOR SPECIFIC REGION
         * $.ajax('Location/getRegion', {'method': 'POST', 'data': {'REGION': 17}});
         * 
         * FOR LIST OF REGIONS
         * $.ajax('Location/getRegion', {'method': 'POST'});
         * 
        */
        $user = empty($this->LoginModel->getUserName()) ? BLANK : $this->LoginModel->getUserName();
        $locs = $this->LocationModel->listRegions();
        $ret_val = $locs;

        if (!empty($this->input->post(LOC_REGION))) {
            $specific = intval($this->input->post(LOC_REGION));
            $ret_val = array();
            foreach ($locs as $reg) {
                $reg = SpecificLocation::getFromVariable($reg);
                if ($reg->Region->Code == $specific) {
                    $ret_val[] = $reg;
                    break;
                }
            }            
        }
        
        if ($this->input->server(REQUEST_METHOD) != POST) {
            $this->load->view('includes/header', array('title' => 'RPFP Online - Regions List'));
            $this->load->view(
                'location/location',
                array(
                    'data' => array(
                        USERNAME => $user,
                        TIME_STAMP => date('Y-m-d H-i-s e'),
                        LOC_LIST => $ret_val
                    )
                )
            );
            $this->load->view('includes/footer');
            return;
        }

        $new_retval = array();
        foreach ($ret_val as $reg) {
            $reg = SpecificLocation::getFromVariable($reg);
            $new_retval[$reg->Region->Code] = $reg->Region->Description;
        }

        $new_retval = array(
            USERNAME => $user,
            TIME_STAMP => date('Y-m-d H-i-s e'),
            LOC_LIST => $new_retval
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($new_retval));
        return;
    }
}
