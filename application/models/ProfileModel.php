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
        $this->CI->load->library('common/StringHolder');
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

    public function getProfile(string $user_id, bool $is_own = false) : UserProfileInterface
    {
        $prof = $this->fromDbGetSpecific(
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
                    'Barangay' => array(
                        'Code' => 'location_code',
                        'Description' => 'location_name'
                    )
                ),
                'Role' => 'my_role',
                'ScopeOfWork' => 'my_scope'
            ),
            $is_own ? 'profile_get_own_profile' : 'profile_get_profile',
            $is_own ? array() : array($user_id),
            'profile'
        );
        return UserProfile::getFromVariable($prof);
        
    }

    public function getOwnProfile() : UserProfile
    {
        $prof = $this->getProfile(BLANK, true);

        $prof->PicProfile = $this->getPicProfile(BLANK, true);

        return $prof;
    }

    private function getPicProfile(string $user_id, bool $is_own) : string
    {
        $temp = $this->fromDbGetSpecific(
            'StringHolder',
            array(
                'value' => 'pic_file',
            ),
            $is_own ? 'profile_get_own_pic' : 'profile_get_pic',
            $is_own ? array() : array($user_id),
            'common'
        );

        $da_string = StringHolder::getFromVariable($temp);
        if (empty($da_string->value)) {
            $da_string->value = BLANK;
        }

        return $da_string->value;
        /** should be in controller */
        /*
        if (($profile->PicProfile == N_A) || ($profile->PicProfile == BLANK)) {
            $this->load->view(
                'errors/html/error_404',
                array(
                    'heading' => 'Not Found',
                    'message' => 'The selected resource is not found on the server',
                )
            );
            return;
        }

        $this->load->library('helpers/FilenameHelper');
        $filename = new FilenameHelper($profile->PicProfile);

        if (!$filename->isValidFile()) {
            $this->load->view(
                'errors/html/error_general',
                array(
                    'heading' => '400 Bad Request',
                    'message' => 'Invalid Filename',
                )
            );
            return;
        }

        // read the file and return its contents as picture
        $local_file = IMAGES_FOLDER . DIRECTORY_SEPARATOR . $filename->Filename.'.'.$filename->Extension;
        if (!file_exists($local_file) && !is_file($local_file)) {
            $this->load->view(
                'errors/html/error_404',
                array(
                    'heading' => 'Not Found',
                    'message' => 'The resource is not found on the server',
                )
            );
            return;
        }

        header('Content-Type: image');
        header('Content-Length: ' . filesize($local_file));
        header('Content-Disposition: filename=profile_' . $profile->Profile_id);
        readfile($local_file);
        */
    }

    public function savePicProfileToDb($image_name, int $user_id, bool $is_own)
    {
        return $this->saveToDb(
            $is_own ? 'profile_save_own_pic' : 'profile_save_pic',
            array(
                $image_name == N_A ? BLANK : $image_name
            )
        );
    }
}
