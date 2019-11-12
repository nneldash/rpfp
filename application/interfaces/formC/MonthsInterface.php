<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('base/BaseInterface');
$CI->load->iface('formB/lists/ListCouplesUnmetNeedInterface');
$CI->load->iface('formB/lists/ListClientsUnmetNeedInterface');
$CI->load->iface('formB/lists/ListCouplesUsingTraditionalFpInterface');
$CI->load->iface('formB/lists/ListClientsUsingTraditionalFpInterface');
$CI->load->iface('formB/lists/ListTotalUnmetNeedInterface');
$CI->load->iface('formB/lists/ListTotalClientsInterface');

abstract class MonthsInterface extends BaseInterface
{
    /** @var ListCouplesUnmetNeedInterface */
    public $ListCouplesUnmetNeed;
    /** @var ListClientsUnmetNeedInterface */
    public $ListClientsUnmetNeed;
    /** @var ListCouplesUsingTraditionalFpInterface */
    public $ListCouplesUsingTraditionalFp;
    /** @var ListClientsUsingTraditionalFpInterface */
    public $ListClientsUsingTraditionalFp;
    /** @var ListTotalUnmetNeedInterface */
    public $ListTotalUnmetNeed;
    /** @var ListTotalClientsInterface */
    public $ListTotalClients;
}
