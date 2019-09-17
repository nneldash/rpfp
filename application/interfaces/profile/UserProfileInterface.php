<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('common/Roles');
$CI->load->iface('common/Scopes');
$CI->load->iface('common/LocationInterface');

abstract class UserProfileInterface extends BaseInterface
{
    public $Profile_id;
    public $User_id;
    public $Email;
    public $Lastname;
    public $Firstname;

    /** @var LocationInterface */
    public $DesignatedLocation;

    /** @var Roles */
    public $Role;

    /** @var Scopes */
    public $ScopeOfWork;
}
