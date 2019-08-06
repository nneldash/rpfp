<?php
defined('BASEPATH') or exit('No direct script access allowed');

/* https://www.quora.com/How-can-I-use-interface-in-Codeigniter-a-framework-for-PHP */

class MY_Loader extends CI_Loader
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function iface($strInterfaceName)
    {
        require_once APPPATH . '/interfaces/' . $strInterfaceName . '.php';
    }
}
