<?php

class LoginModel extends CI_Model
{
    private $CI;

    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
        $this->CI->load->library('login/BasicUserCredentials');
        $this->CI->load->library('login/Passwords');
        $this->CI->load->library('Session');
        $this->CI->load->library('login/DbInstance');
    }

    private function connect(UserCredentialsInterface $credentials): DbInstance
    {
        $config = $this->config->item(DB_DEFAULT);
        $config[USERNAME] = $credentials->UserName;
        $config[USERPASSWORD] = $credentials->Password;
        $db = $this->load->database($config, true);

        $instance = new DbInstance();
        $instance->database = $db;
        $instance->connected = $db->initialize();
        return $instance;
    }

    public function login(UserCredentialsInterface $credentials)
    {
        if (!$credentials->validate()) {
            return false;
        }

        $connection = $this->connect($credentials);
        $connected = $connection->connected;
        $db = &$connection->database;
        $db->close();

        if (!$connected) {
            return false;
        }

        return $this->saveCredentials($credentials);
    }

    private function saveCredentials(UserCredentialsInterface $credentials)
    {
        if (!$this->CI->session) {
            return false;
        }

        $_SESSION[THEUSERNAME] = $credentials->UserName;
        $_SESSION[THEUSERPASSWORD] = $credentials->Password;
        $this->CI->session->set_userdata(USERNAME, $credentials->UserName);

        return true;
    }

    public function getCredentials(): UserCredentialsInterface
    {
        $credentials = new BasicUserCredentials();

        if (!isset($_SESSION) || !array_key_exists(THEUSERNAME, $_SESSION) || !$_SESSION[THEUSERNAME]) {
            return $credentials;
        }

        if (trim($_SESSION[THEUSERNAME]) == '') {
            return $credentials;
        }

        $credentials->UserName = $_SESSION[THEUSERNAME];
        $credentials->Password = $_SESSION[THEUSERPASSWORD];
        return $credentials;
    }

    public function clearCredentials()
    {
        unset($_SESSION[THEUSERNAME]);
        unset($_SESSION[THEUSERPASSWORD]);

        if (!$this->CI->session) {
            return true;
        }

        $this->CI->session->unset_userdata(USERNAME);
        return true;
    }

    public function isLoggedIn()
    {
        //for testing
        return false;

        $credentials = $this->getCredentials();
        if ($credentials->UserName == '') {
            return false;
        }

        if (empty($_SESSION)) {
            return false;
        }

        if (!array_key_exists(THEUSERNAME, $_SESSION)) {
            return false;
        }

        if (!$this->CI->session) {
            return false;
        }

        $userdata = $this->CI->session->get_userdata(USERNAME);
        if (!$userdata) {
            return false;
        }

        if (!array_key_exists(USERNAME, $userdata)) {
            return false;
        }

        $userid = $userdata[USERNAME];
        if ((!$userid) || ($userid != $_SESSION[THEUSERNAME])) {
            return false;
        }

        return true;
    }

    public function getEmpId(): string
    {
        $this->CI->load->model('PdsModel');
        $pds = $this->PdsModel->getOwnPds();

        $empNo = $pds->PersonalInfo->EmployeeNo;
        
        return $empNo;
    }

    public function getCurrentUser(): string
    {
        $this->CI->load->model('PdsModel');
        $pds = $this->PdsModel->getOwnPds();

        $firstName = $pds->PersonalInfo->Name->Firstname;
        $lastName = $pds->PersonalInfo->Name->Surname;
        $fullName = $firstName.' '.$lastName;
        
        return $fullName;
    }

    public function reconnect(): DbInstance
    {
        $cred = $this->getCredentials();
        if (!$cred->validate()) {
            $not_connected = new DbInstance();
            $not_connected->connected = false;
            return $not_connected;
        }

        return $this->connect($cred);
    }

    public function isEmployee()
    {
        if (!$this->isLoggedIn()) {
            return false;
        }
        /* TODO: Check if user is an employee call rpfp.emp_check_if_employee()*/
        return true;
    }

    public function isHr()
    {
        if (!$this->isLoggedIn()) {
            return false;
        }
        /* TODO: Check if user is an hr call rpfp.emp_check_if_hr()*/
        return true;
    }

    private function runQuery($customQuery, $params = false)
    {
        $dbinstance = $this->reconnect();
        if (!$dbinstance->connected) {
            return false;
        }
        $db = $dbinstance->database;
        $queryResult = $db->query($customQuery, $params, true);
        
        $x = $db->error();
        
        if (!$queryResult) {
            // database error!!!
            // return false;
            return $x;
        }

        $result = $queryResult->result();
        $queryResult->free_result();
        $db->conn_id->next_result();
        return $result;
    }

    private function runTrueFalseQuery($stored_function, $params = false)
    {
        $customQuery = 'SELECT rpfp.' . $stored_function . ' as myresult;';
        $result = $this->runQuery($customQuery, $params);

        if ($result == false || (count($result) < 1) || (!$result[0]->myresult)) {
            return false;
        }
        return true;
    }

    public function runStoredProc($stored_proc, $params = false)
    {
        
        $customQuery = 'CALL rpfp.' . $stored_proc;
        $result = $this->runQuery($customQuery, $params);
        
        if ($result[0]->MESSAGE == false) {
            return false;
        }
        
        return true;
    }

    public function firstLoggedIn()
    {
        return $this->runTrueFalseQuery('emp_login_check_first_login()');
    }

    public function changePassword(PasswordsInterface $credentials)
    {
        return $this->runStoredProc(
            'emp_login_change_own_password(?, ?)',
            [
                $credentials->OldPassword,
                $credentials->NewPassword
            ]
        );
    }

    public function changeInitialPassword(PasswordsInterface $credentials)
    {
        return $this->runStoredProc(
            'emp_login_change_initial_password(?)',
            [
                $credentials->NewPassword
            ]
        );
    }

}
