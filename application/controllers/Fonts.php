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
        redirect('Menu');
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

        $initial_path = FONTS_FOLDER_APP;
        if (file_exists( file_exists( dirname(__FILE__)) . FONTS_FOLDER_FA . $newParams)) {
            $initial_path = FONTS_FOLDER_FA;
        }
        if (file_exists(BASEPATH . $initial_path . $newParams)) {
            $this->output->set_content_type('application/font');
            readfile(BASEPATH . $initial_path . $newParams);
            return;
        }
        
        $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(array('data' => 'null')));
    }

    
}
