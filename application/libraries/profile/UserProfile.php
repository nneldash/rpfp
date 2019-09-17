<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('profile/UserProfileInterface');
$CI->load->library('common/Location');

class UserProfile extends UserProfileInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
        $this->DesignatedLocation = new Location();
    }
}
