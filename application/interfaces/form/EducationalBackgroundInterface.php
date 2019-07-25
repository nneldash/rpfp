<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');

abstract class EducationalBackgroundInterface extends BaseInterface
{
    public $Id;
    public $Level;
    public $SchoolName;
    public $Degree;
    public $From;
    public $To;
    public $HighestLevel;
    public $YearGraduated;
    public $HonorsReceived;
}
