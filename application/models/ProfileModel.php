<?php
$CI =& get_instance();
$CI->load->model('BaseModel');

class ProfileModel extends BaseModel
{
    protected $CI;

    public function __construct()
    {
        parent::__construct();
        $this->CI =& get_instance();
        $this->CI->load->library('login/DbInstance');
        $this->CI->load->library('profile/UserProfile');
        $this->CI->load->model('LoginModel');
    }

    public function getProfile()
    {
        // asdf
    }

    public function getOwnProfile() : UserProfile
    {
        $a = new UserProfile();

        return $this->fromDbGetSpecific(
            'UserProfile',
            array(
                'Profile_id' => 'id',
                'User_id' => 'username',
                'Email' => 'email',
                'Lastname' => 'surname',
                'Firstname' => 'firstname',
                'DesignatedLocation' => array(
                    'Region' => array(
                        'Code' => 'region_id',
                        'Description' => 'region_name'
                    ),
                    'SpecificLocation' => array(
                        'Code' => 'location_code',
                        'Description' => 'location_name'
                    )
                )
            ),
            'get_own_profile',
            $params = array(),
            'profile'
        );
    }

    public function isEncoder()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            return false;
        }
        return $this->getFunctionResult('check_if_encoder');
    }

    public function isFocalPerson()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            return false;
        }
        return $this->getFunctionResult('check_if_focal');
    }

    public function isRegionalDataManager()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            return false;
        }
        return $this->getFunctionResult('check_if_data_manager');
    }

    public function isPMED()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            return false;
        }
        return $this->getFunctionResult('check_if_pmed');
    }

    public function isITDMU()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            return false;
        }
        return $this->getFunctionResult('check_if_itdmu');
    }
}
