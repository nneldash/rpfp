<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form1/NameInterface');
$CI->load->iface('form1/AddressInterface');
$CI->load->iface('common/Sexes');
$CI->load->iface('common/CivilStatuses');
$CI->load->iface('common/EducationBackgrounds');


abstract class IndividualInterface extends BaseInterface
{
    public $Id;

    /** @var NameInterface */
    public $Name;
    
    /** @var Sexes */
    public $Sex;

    /** @var CivilStatuses  */
    public $CivilStatus;

    /** @var DateTime */
    public $Birthdate;

    /** @var string */
    public $ResidentialAddress;

    /** @var EducationBackgrounds */
    public $HighestEducation;

    /** @var bool */
    public $Attendee;
}
