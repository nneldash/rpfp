<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function index()
    {
        redirect(site_url());
    }

    public function loginUser()
    {
        $header['title'] = 'RPFP - Login';

        if ($this->LoginModel->isLoggedIn()) {
            redirect(site_url());
            return;
        }

        /* GET USER INPUT */
        $this->load->library('login/BasicUserCredentials');
        $cred = $this->basicusercredentials;

        $cred->UserName = $this->input->post(POST_USERNAME);
        $cred->Password = $this->input->post(POST_USERPASSWORD);

        /* VALIDATE INPUT */
        $this->load->library('form_validation');
        $this->form_validation->set_rules(POST_USERNAME, 'User Name', REQUIRED);
        $this->form_validation->set_rules(POST_USERPASSWORD, 'Password', REQUIRED);

        if ($this->form_validation->run() == false) {
            $this->load->view("includes/header", $header);
            $this->load->view("login/login_page");
            $this->load->view("includes/footer");
            return;
        }

        /* CHECK DATABASE PASSWORD */
        if (!$this->LoginModel->login($cred)) {
            $this->form_validation->set_rules(POST_USERNAME, 'User Name', [REQUIRED, ['invalid_password', function () {
                $this->form_validation->set_message('invalid_password', 'Invalid Username or Password!');
                return false;
            }]]);

            if ($this->form_validation->run() == false) {
                $this->load->view("includes/header", $header);
                $this->load->view("login/login_page");
                $this->load->view("includes/footer");
                return;
            }
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
        $header['title'] = 'RPFP - Login';

        if ($this->input->get('timeout') == 1) {
            $this->load->view("includes/header", $header);
            $this->load->view("login/login_page");
            $this->load->view("includes/footer");
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
