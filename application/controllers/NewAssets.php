<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NewAssets extends CI_Controller
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

        if (method_exists($this, $newParams)) {
            return $this->$newParams();
        }

        $newParams = str_ireplace('.', '', $newParams);
        $newParams = str_ireplace('_', '', $newParams);
        if (method_exists($this, $newParams)) {
            return $this->$newParams();
        }

        return $this->index();
    }

    public function bootstrapCss()
    {
        header('Content-Type: text/css');
        readfile(BASEPATH . BOOTSRAP_CSS);
    }

    public function bootstrapMinCssMap()
    {
        header('Content-Type: application/json');
        readfile(BASEPATH . BOOTSRAP_CSS_MAP);
    }

    public function datatablesBootstrap()
    {
        header('Content-Type: text/css');
        readfile(BASEPATH . DATATABLES_BOOTSTRAP);
    }

    public function datatablesResponsive()
    {
        header('Content-Type: text/css');
        readfile(BASEPATH . DATATABLES_RESPONSIVE);
    }

    public function bootstrapJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . BOOTSRAP_JS);
    }

    public function jquery()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . JQUERY_JS);
    }

    public function templateJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . TEMPLATE_JS);
    }
    
    public function popper()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . POPPER_JS);
    }

    public function popperJsMap()
    {
        header('Content-Type: application/json');
        readfile(BASEPATH . POPPER_JS_MAP);
    }
    

    public function sweetalertCss()
    {
        header('Content-Type: text/css');
        readfile(BASEPATH . SWEETALERT_CSS);
    }

    public function fontAwesome()
    {
        header('Content-Type: text/css');
        readfile(BASEPATH . FONT_AWESOME);
    }

    public function nProgress()
    {
        header('Content-Type: text/css');
        readfile(BASEPATH . NPROGRESS);
    }

    public function customCss()
    {
        header('Content-Type: text/css');
        readfile(BASEPATH . CUSTOM);
    }

    public function bootstrapSelectCss()
    {
        header('Content-Type: text/css');
        readfile(BASEPATH . BOOTSTRAP_SELECT_CSS);
    }

    public function sweetalertJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . SWEETALERT_JS);
    }

    public function datatableJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . DATATABLES_JS);
    }

    public function datatableBtJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . DATATABLES_BOOTSTRAP_JS);
    }

    public function datatableRpJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . DATATABLES_RESPONSIVE_JS);
    }

    public function datatableBtrpJsJs()
    {
        $this->datatableBtrpJs();
    }

    public function datatableBtrpJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . DATATABLES_BTRP_JS);
    }

    public function nProgressJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . NPROGRESS_JS);
    }

    public function progressBarJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . PROGRESSBAR_JS);
    }

    public function customJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . CUSTOM_JS);
    }

    public function cpExcel()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . CPEXCEL_JS);
    }

    public function shimJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . SHIM_JS);
    }

    public function jsZip()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . JSZIP_JS);
    }

    public function xlsxJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . XLSX_JS);
    }

    public function inputMaskJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . INPUTMASK_JS);
    }

    public function jqueryMaskJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . JQUERYINPUT_JS);
    }

    public function inputExtJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . INPUTEXT_JS);
    }

    public function bootstrapSelectJs()
    {
        header('Content-Type: application/javascript');
        readfile(BASEPATH . BOOTSTRAP_SELECT_JS);
    }
}
