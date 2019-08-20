<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

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
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

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
defined('EXIT_SUCCESS') OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR') OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG') OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE') OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS') OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT') OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE') OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN') OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX') OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

defined('THEUSERPASSWORD') or define('THEUSERPASSWORD', 'theuserpassword');
defined('THEUSERNAME') or define('THEUSERNAME', 'theusername');
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
defined('NO_OUTPUT') or define('NO_OUTPUT', 'no_output');
defined('N_A') or define('N_A', 'N/A');
defined('NOT_FOUND') or define('NOT_FOUND', ' NOT FOUND!!!');
defined('BLANK') or define('BLANK', '');

defined('BOOTSRAP_CSS')         or define('BOOTSRAP_CSS', '/../node_modules/bootstrap/dist/css/bootstrap.min.css');
defined('BOOTSRAP_JS')          or define('BOOTSRAP_JS', '/../node_modules/bootstrap/dist/js/bootstrap.min.js');
defined('JQUERY_JS')            or define('JQUERY_JS', '/../node_modules/jquery/dist/jquery.min.js');
defined('POPPER_JS')            or define('POPPER_JS', '/../node_modules/popper.js/dist/popper.js');

defined('SWEETALERT_CSS')       or define('SWEETALERT_CSS', '/../node_modules/sweetalert2/dist/sweetalert2.min.css');
defined('SWEETALERT_JS')        or define('SWEETALERT_JS', '/../node_modules/sweetalert2/dist/sweetalert2.min.js');