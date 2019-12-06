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

    public static function getFromVariable($variable) : UserProfile
    {
        if ($variable instanceof UserProfile) {
            return $variable;
        }
        return new UserProfile($variable);
    }

    public function isEncoder()
    {
        return $this->Role == Roles::ENCODER;
    }

    public function isPartner()
    {
        return $this->Role == Roles::PARTNER;
    }

    public function isFocal()
    {
        return $this->Role == roles::FOCAL_PERSON;
    }

    public function isRegionalDataManager()
    {
        return $this->Role == roles::DATA_MANAGER;
    }

    public function isPMED()
    {
        return $this->Role == roles::PMED_STAFF;
    }

    public function isITDMU()
    {
        return $this->Role == roles::ITDMU_STAFF;
    }
}
