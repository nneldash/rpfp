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
    }

    public function saveProfile(UserProfile $profile)
    {
        return $this->saveToDb(
            'profile_save_profile',
            array(
                $profile->User_id == N_A ? BLANK : $profile->User_id,
                $profile->Lastname == N_A ? BLANK : $profile->Lastname,
                $profile->Firstname == N_A ? BLANK : $profile->Firstname,
                $profile->Email == N_A ? BLANK : $profile->Email,
                $profile->DesignatedLocation->Region->Code == N_A ? 
                    BLANK : 
                    $profile->DesignatedLocation->Region->Code
                ,
                $profile->DesignatedLocation->SpecificLocation->Code == N_A ?
                    BLANK :
                    $profile->DesignatedLocation->SpecificLocation->Code
            )
        );
    }

    public function saveOwnProfile(UserProfile $profile)
    {
        return $this->saveToDb(
        'profile_save_own_profile',
        array(
            $profile->Lastname == N_A ? BLANK : $profile->Lastname,
            $profile->Firstname == N_A ? BLANK : $profile->Firstname,
            $profile->Email == N_A ? BLANK : $profile->Email
            )
        );
    }

    public function getProfile(string $user_id) : UserProfile
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
                ),
                'Role' => 'my_role',
                'ScopeOfWork' => 'my_scope'
            ),
            'profile_get_profile',
            array($user_id),
            'profile'
        );
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
                ),
                'Role' => 'my_role',
                'ScopeOfWork' => 'my_scope'
            ),
            'profile_get_own_profile',
            array(),
            'profile'
        );
    }

    public function isEncoder()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            return false;
        }
        return $this->getFunctionResult('profile_check_if_encoder');
    }

    public function isFocalPerson()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            return false;
        }
        return $this->getFunctionResult('profile_check_if_focal');
    }

    public function isRegionalDataManager()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            return false;
        }
        return $this->getFunctionResult('profile_check_if_data_manager');
    }

    public function isPMED()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            return false;
        }
        return $this->getFunctionResult('profile_check_if_pmed');
    }

    public function isITDMU()
    {
        if (!$this->LoginModel->isLoggedIn()) {
            return false;
        }
        return $this->getFunctionResult('profile_check_if_itdmu');
    }
}
