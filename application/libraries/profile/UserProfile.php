<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('profile/UserProfileInterface');
$CI->load->library('common/SpecificLocation');

class UserProfile extends UserProfileInterface
{
    public function __construct($params = null)
    {
        parent::__construct($params);
        $this->DesignatedLocation = new SpecificLocation();
    }

    public static function getProfileFromVariable($profile) : UserProfile
    {
        if ($profile instanceof UserProfile) {
            return $profile;
        }
        return new UserProfile($profile);
    }

    public function isEncoder()
    {
        return $this->Role == Roles::ENCODER;
    }

    public function isFocal()
    {
        return $this->Role == Roles::FOCAL_PERSON;
    }

}
