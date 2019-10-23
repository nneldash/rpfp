<?php
defined('BASEPATH') or exit('No direct script access allowed');
$CI =& get_instance();
$CI->load->iface('couple_list/lists/ListPendingCoupleInterface');

class ListPendingCouple extends ListPendingCoupleInterface
{
}
