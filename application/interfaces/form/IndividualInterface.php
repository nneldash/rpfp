<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form/NameInterface');
// $CI->load->iface('form/CitizenshipInterface');
$CI->load->iface('form/AddressInterface');

abstract class IndividualInterface extends BaseInterface
{
    public $Id;
    /** @var NameInterface */
    public $Name;
    public $Birthdate;
    public $Birthplace;
    public $Sex;
    public $CivilStatus;
    /** @var AddressInterface */
    public $ResidentialAddress;
    /** @var AddressInterface */
    public $PermanentAddress;
    public $Etnicity;
}
