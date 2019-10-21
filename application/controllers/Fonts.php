<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fonts extends CI_Controller
{
	public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->load->view('login/homepage');
    }

    public function _remap($params = null)
    {
        if ($params == null) {
            return $this->index();
        }

        $newParams = $params;
        if (is_array($params)) {
            $newParams = $newParams[0];
        }

        $q_pos = strpos($newParams, '?');
        if($q_pos) {
            $newParams = substr($newParams, 0);
        }

        header('application/font');
        $initial_path = FONTS_FOLDER_APP;
        if(file_exists( file_exists( dirname(__FILE__)) . FONTS_FOLDER_FA . $newParams)) {
            $initial_path = FONTS_FOLDER_FA;
        }
        readfile(BASEPATH . $initial_path . $newParams);
        
    }

    
}
