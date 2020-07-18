<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') or define('SHOW_DEBUG_BACKTRACE', true);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE') or define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') or define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE') or define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE') or define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ') or define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE') or define('FOPEN_READ_WRITE', 'r+b');

 // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb');

 // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE') or define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b');
defined('FOPEN_WRITE_CREATE') or define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE') or define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT') or define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT') or define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS') or define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') or define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') or define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') or define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') or define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') or define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') or define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') or define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') or define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') or define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

defined('THEUSERPASSWORD') or define('THEUSERPASSWORD', 'USERPASSWORD');
defined('THEUSERNAME') or define('THEUSERNAME', 'USER');
defined('USERNAME') or define('USERNAME', 'username');
defined('USERPASSWORD') or define('USERPASSWORD', 'password');
defined('POST_USERNAME') or define('POST_USERNAME', 'username');
defined('POST_USERPASSWORD') or define('POST_USERPASSWORD', 'password');
defined('OLDPASSWORD') or define('OLDPASSWORD', 'oldPassword');
defined('NEWPASSWORD') or define('NEWPASSWORD', 'newPassword');
defined('CONFIRMPASSWORD') or define('CONFIRMPASSWORD', 'confirmPassword');
defined('INITIALPASSWORD') or define('INITIALPASSWORD', 'InitialNewPassword');
defined('INITIALCONFIRMPASSWORD') or define('INITIALCONFIRMPASSWORD', 'InitialConfirmPassword');
defined('REQUIRED') or define('REQUIRED', 'required');
defined('DB_DEFAULT') or define('DB_DEFAULT', 'db_default');
defined('NO_OUTPUT') or define('NO_OUTPUT', 'no_output');
defined('DB_INSTANCE') or define('DB_INSTANCE', 'db');
defined('CON_STATUS') or define('CON_STATUS', 'connected_status');
defined('_TYPE') or define('_TYPE', 'type');
defined('_VALUE') or define('_VALUE', 'value');
defined('N_A') or define('N_A', 'N/A');
defined('NOT_FOUND') or define('NOT_FOUND', ' NOT FOUND!!!');
defined('BLANK') or define('BLANK', '');
defined('REQUEST_METHOD') or define('REQUEST_METHOD', 'REQUEST_METHOD');
defined('POST') or define('POST', 'POST');
defined('RELOAD') or define('RELOAD', 'reload');

defined('BOOTSRAP_CSS') or define('BOOTSRAP_CSS', '/../node_modules/bootstrap/dist/css/bootstrap.min.css');
defined('BOOTSRAP_JS') or define('BOOTSRAP_JS', '/../node_modules/bootstrap/dist/js/bootstrap.min.js');
defined('BOOTSRAP_CSS_MAP') or define('BOOTSRAP_CSS_MAP', '/../node_modules/bootstrap/dist/css/bootstrap.min.css.map');
defined('JQUERY_JS') or define('JQUERY_JS', '/../node_modules/jquery/dist/jquery.min.js');
defined('POPPER_JS') or define('POPPER_JS', '/../node_modules/popper.js/dist/umd/popper.js');
defined('POPPER_JS_MAP') or define('POPPER_JS_MAP', '/../node_modules/popper.js/dist/umd/popper.js.map');

defined('SWEETALERT_CSS') or define('SWEETALERT_CSS', '/../node_modules/sweetalert2/dist/sweetalert2.min.css');
defined('SWEETALERT_JS') or define('SWEETALERT_JS', '/../node_modules/sweetalert2/dist/sweetalert2.min.js');

defined('CAPTCHA_FIELD') or define('CAPTCHA_FIELD', 'g-recaptcha');
defined('CAPTCHA_RESPONSE') or define('CAPTCHA_RESPONSE', 'g-recaptcha-response');
defined('CAPTCHA_SECRET') or define('CAPTCHA_SECRET', '6Ld1jLYUAAAAAG5MkkdSqkZSXoIKF5tIrjEd2LA4');
defined('CAPTCHA_CLIENT') or define('CAPTCHA_CLIENT', '6Ld1jLYUAAAAAM6BbI8c4khB0KbqHBjVY231cA7U');
defined('CAPTCHA_API') or define('CAPTCHA_API', 'https://www.google.com/recaptcha/api.js');
defined('CAPTCHA_VERIFY') or define('CAPTCHA_VERIFY', 'https://www.google.com/recaptcha/api/siteverify');

defined('FONT_AWESOME') or define('FONT_AWESOME', '/../node_modules/gentelella/vendors/font-awesome/css/font-awesome.min.css');
defined('FONTS_FOLDER_FA') or define('FONTS_FOLDER_FA', '/../node_modules/gentelella/vendors/font-awesome/fonts/');
defined('FONTS_FOLDER_APP') or define('FONTS_FOLDER_APP', '/../../fonts/');
defined('NPROGRESS') or define('NPROGRESS', '/../node_modules/gentelella/vendors/nprogress/nprogress.css');
defined('CUSTOM') or define('CUSTOM', '/../node_modules/gentelella/build/css/custom.min.css');
defined('TEMPLATE_JS') or define('TEMPLATE_JS', '/../node_modules/gentelella/vendors/jquery/dist/jquery.min.js');
defined('NPROGRESS_JS') or define('NPROGRESS_JS', '/../node_modules/gentelella/vendors/nprogress/nprogress.js');
defined('PROGRESSBAR_JS') or define('PROGRESSBAR_JS', '/../node_modules/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js');
defined('CUSTOM_JS') or define('CUSTOM_JS', '/../node_modules/gentelella/build/js/custom.min.js');

defined('DATATABLES_BOOTSTRAP') or define('DATATABLES_BOOTSTRAP', '/../node_modules/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css');
defined('DATATABLES_RESPONSIVE') or define('DATATABLES_RESPONSIVE', '/../node_modules/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');
defined('DATATABLES_JS') or define('DATATABLES_JS', '/../node_modules/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js');
defined('DATATABLES_BOOTSTRAP_JS') or define('DATATABLES_BOOTSTRAP_JS', '/../node_modules/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js');
defined('DATATABLES_RESPONSIVE_JS') or define('DATATABLES_RESPONSIVE_JS', '/../node_modules/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js');
defined('DATATABLES_BTRP_JS') or define('DATATABLES_BTRP_JS', '/../node_modules/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js');

defined('CPEXCEL_JS') or define('CPEXCEL_JS', '/../node_modules/xlsx/dist/cpexcel.js');
defined('SHIM_JS') or define('SHIM_JS', '/../node_modules/xlsx/dist/shim.min.js');
defined('JSZIP_JS') or define('JSZIP_JS', '/../node_modules/xlsx/dist/jszip.js');
defined('XLSX_JS') or define('XLSX_JS', '/../node_modules/xlsx/dist/xlsx.full.min.js');

defined('INPUTMASK_JS') or define('INPUTMASK_JS', '/../node_modules/inputmask/dist/inputmask/inputmask.js');
defined('JQUERYINPUT_JS') or define('JQUERYINPUT_JS', '/../node_modules/inputmask/dist/inputmask/jquery.inputmask.js');
defined('INPUTEXT_JS') or define('INPUTEXT_JS', '/../node_modules/inputmask/dist/inputmask/inputmask.extensions.js');

defined('LOC_REGION') or define('LOC_REGION', 'REGION');
defined('LOC_PROVINCE') or define('LOC_PROVINCE', 'PROVINCE');
defined('LOC_MUNICIPALITY') or define('LOC_MUNICIPALITY', 'MUNICIPALITY');
defined('LOC_BARANGAY') or define('LOC_BARANGAY', 'BARANGAY');
defined('LOC_LIST') or define('LOC_LIST', 'LOCATION_LIST');
defined('LOC_SPECIFIC') or define('LOC_SPECIFIC', 'LOCATION_DESCRIPTION');
defined('LOC_ERRORS') or define('LOC_ERRORS', 'ERRORS');
defined('TIME_STAMP') or define('TIME_STAMP', 'DATETIME');

defined('BOOTSTRAP_SELECT_CSS') or define('BOOTSTRAP_SELECT_CSS', '/../node_modules/bootstrap-select/dist/css/bootstrap-select.min.css');
defined('BOOTSTRAP_SELECT_JS') or define('BOOTSTRAP_SELECT_JS', '/../node_modules/bootstrap-select/dist/js/bootstrap-select.min.js');
defined('BOOTSTRAP_SELECT_MAP') or define('BOOTSTRAP_SELECT_MAP', '/../node_modules/bootstrap-select/dist/js/bootstrap-select.min.js.map');

defined('JQUERY_UI') or define('JQUERY_UI', '/../node_modules/jquery-ui/ui/widgets/datepicker.js');
defined('THEME') or define('THEME', '/../node_modules/jquery-ui/themes/base/datepicker.css');

defined('CHART_JS') or define('CHART_JS', '/../node_modules/chart.js/dist/Chart.bundle.min.js');