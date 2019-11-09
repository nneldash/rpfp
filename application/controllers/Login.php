<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function index()
    {
        redirect(site_url());
    }

    private function captcha($captcha_response)
    {
        /** DURING DEVELOPMENT, CAPTCHA WILL SHOULD RETURN TRUE
         *  Remove the following line before deployment
         * */
        return true; // remove this
        $client_response = $this->input->post(CAPTCHA_RESPONSE);
        if(!$client_response) {
            return false;
        }

        $api_client = new GuzzleHttp\Client();
        $response = $api_client->request(
            $method = 'POST',
            $uri = CAPTCHA_VERIFY,
            $options = [
                'form_params' => [
                    'secret' => CAPTCHA_SECRET,
                    'response' => $client_response,
                ]
            ]
        );

        $success = 'success';
        $message = [$success => false];
    
        $header = $response->getHeader('content-type')[0];
        if (substr_compare($header, 'application/json', 0) >= 0) {
            $output = $response->getBody()->getContents();
            $message = json_decode($output);
        }
        
        if ($message->$success) {
            return true;
        }
        
        return false;
    }

    private function loadLoginPage($header)
    {
        $this->load->view("includes/header", $header);
        $this->load->view("login/login_page");
        return;
    }

    public function loginUser()
    {
        $header['title'] = 'RPFP - Login';
        if ($this->input->server('REQUEST_METHOD') != 'POST') {
            $this->loadLoginPage($header);
            return;
        }

        if ($this->LoginModel->isLoggedIn()) {
            redirect(site_url());
            return;
        }

        $this->load->library('form_validation');
        
        /* CAPTCHA  */
        if (!$this->captcha($this->input->post(CAPTCHA_RESPONSE))) {
            $this->form_validation->set_rules(CAPTCHA_FIELD, 'Captcha', [REQUIRED, ['invalid_captcha', function () {
                $this->form_validation->set_message('invalid_captcha', 'Prove you are not a robot.');
                return false;
            }]]);

            if ($this->form_validation->run() == false) {
                $this->loadLoginPage($header);
                return;
            }
        }

        /* GET USER INPUT */
        $this->load->library('login/BasicUserCredentials');
        $cred = $this->basicusercredentials;
        
        $cred->UserName = $this->input->post(POST_USERNAME);
        $cred->Password = $this->input->post(POST_USERPASSWORD);

        /* VALIDATE INPUT */
        $this->form_validation->set_rules(POST_USERNAME, 'Username', REQUIRED);
        $this->form_validation->set_rules(POST_USERPASSWORD, 'Password', REQUIRED);

        if ($this->form_validation->run() == false) {
            $this->loadLoginPage($header);
            return;
        }
        
        /* CHECK DATABASE PASSWORD */
        if (!$this->LoginModel->login($cred)) {
            $this->form_validation->set_rules(POST_USERNAME, 'User Name', [REQUIRED, ['invalid_password', function () {
                $this->form_validation->set_message('invalid_password', 'Invalid Username or Password!');
                return false;
            }]]);

            if ($this->form_validation->run() == false) {
                $this->loadLoginPage($header);
                return;
            }
        }

        /* CHECK IF ACTIVE */
        if ($this->LoginModel->isDeactivated()) {
            $this->logoffUser();
            return;
        }

        redirect(site_url());
    }

    public function logoffUser()
    {
        $this->LoginModel->clearCredentials();
        redirect(site_url());
    }

    public function logoffSystem()
    {
        $header['title'] = 'Online RPFP Monitoring System - Login';

        if ($this->input->get('timeout') == 1) {
            $this->loadLoginPage($header);
        } elseif ($this->input->get('timeout') == 2) {
            $this->LoginModel->clearCredentials();
            redirect(site_url());
        }
    }

    public function changePassword()
    {
        /* GET USER INPUT */
        $this->load->library('login/Passwords');
        $passCred = $this->passwords;
        $cred = $this->LoginModel->getCredentials();

        $passCred->OldPassword = $this->input->post(OLDPASSWORD);
        $passCred->NewPassword = $this->input->post(NEWPASSWORD);
        $passCred->ConfirmPassword = $this->input->post(CONFIRMPASSWORD);

        if ($passCred->OldPassword == $cred->Password) {
            if ($passCred->NewPassword == $passCred->ConfirmPassword) {
                $res = $this->LoginModel->changePassword($passCred);
                if (!empty($res)) {
                    $data = ['change_password' => true, 'has_new_password' => true];
                }
            } else {
                $data = ['change_password' => false, 'has_new_password' => false];
            }
        } else {
            $data = ['old_pass' => false,'change_password' => false, 'has_new_password' => false];
        }
        

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function firstLoggedIn()
    {
        $this->load->library('login/BasicUserCredentials');
        $cred = $this->LoginModel->getCredentials();

        $data = ['change_password' => false, 'first_login'=> false, 'has_new_password' => true];

        if ($this->LoginModel->firstLoggedIn($cred)) {
            $data = ['change_password' => true, 'first_login'=> true, 'has_new_password' => false];
        }
        
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function changeInitialPassword()
    {
        /* GET USER INPUT */
        $this->load->library('login/Passwords');
        $cred = $this->passwords;

        $cred->NewPassword = $this->input->post(INITIALPASSWORD);
        $cred->ConfirmPassword = $this->input->post(INITIALCONFIRMPASSWORD);

        
        if ($cred->NewPassword == $cred->ConfirmPassword) {
            if ($this->LoginModel->changeInitialPassword($cred)) {
                $data = ['change_password' => true, 'has_new_password' => true];
            }
        } else {
            $data = ['change_password' => false, 'has_new_password' => false];
        }

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
