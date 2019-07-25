<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('form/CoupleInterface');
$CI->load->iface('form/IndividualInterface');
$CI->load->iface('form/SeminarInterface');
$CI->load->iface('form/lists/ListEducationalBackgroundInterface');

abstract class FormInterface extends BaseInterface
{
    /** @var CoupleInterface */
    public $CoupleInterface;
    /** @var IndividualInterface */
    public $IndividualInterface;
    /** @var SeminarInterface */
    public $SeminarInterface;
    /** @var ListEducationalBackgroundInterface */
    public $ListEducationalBackgroundInterface;
}
