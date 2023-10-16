<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use CodeIgniter\Config\Config;

class Admin extends BaseController
{
    protected $m_admin;
    protected $validation;

    function __construct()
    {
        $this->m_admin = new AdminModel();
        $this->validation = \Config\Services::validation();
        helper("cookie");
        helper("global_function_helper");
    }
    public function login()
    {
        // session()->destroy();
        // exit();
        if (get_cookie('cookie_username') && get_cookie('cookie_password')) {
            $username = get_cookie('cookie_username');
            $password = get_cookie('cookie_password');

            $myData = $this->m_admin->getData($username);
            if ($password != $myData['password']) {
                $err[] = "The account you entered does not match.";
                session()->setFlashdata('username', $username);
                session()->setFlashdata('warning', $err);

                delete_cookie('cookie_username');
                delete_cookie('cookie_password');
                return redirect()->to('admin/login');
            }

            // Cái chỗ này fix remmember me
            // $account = [
            //     'account_username' => $username,
            //     'account_fullname' => $myData['fullname'],
            //     'account_email' => $myData['email']
            // ];
            // session()->set($account);
            // return redirect()->to('admin/success');
        }
        $data = [];
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'username' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Username must be filled!'
                    ]
                ],
                'password' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Password must be filled!'
                    ]
                ]
            ];
            if (!$this->validate($rules)) {
                session()->setFlashdata("warning", $this->validation->getErrors());
                return redirect()->to("admin/login");
            }

            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');
            $remember_me = $this->request->getVar('remember_me');

            $myData = $this->m_admin->getData($username);

            if (empty($myData)) {
                $err[] = "Username is incorrect!";
                session()->setFlashdata('username', $username);
                session()->setFlashdata('warning', $err);
                return redirect()->to("admin/login");
            }

            if (!password_verify($password, $myData['password'])) {
                $err[] = "Passsword is incorrect!";
                session()->setFlashdata('username', $username);
                session()->setFlashdata('warning', $err);
                return redirect()->to("admin/login");
            }

            if ($remember_me == '1') {
                set_cookie("cookie_username", $username, 3600 * 24 * 30);
                set_cookie("cookie_password", $myData['password'], 3600 * 24 * 30);
            }

            $account = [
                'account_username' => $myData['username'],
                'account_fullname' => $myData['fullname'],
                'account_email' => $myData['email']
            ];
            session()->set($account);
            return redirect()->to('admin/success')->withCookies();
        }
        echo view("admin/v_login", $data);
    }

    function success()
    {
        return redirect()->to('admin/article');
    }

    function logout()
    {
        delete_cookie("cookie_username");
        delete_cookie("cookie_password");
        session()->destroy();
        if (session()->get('account_username') != '') {
            session()->setFlashdata("success", "You have successfully logged out");
        }
        echo view("admin/v_login");
    }

    function forgot_password()
    {
        $err = [];

        if ($this->request->getMethod() == 'post') {
            $username = $this->request->getVar('username');

            if ($username == '') {
                $err[] = "Please enter your username or email!";
            }

            if (empty($err)) {
                $data = $this->m_admin->getData($username);

                if (empty($data)) {
                    $err[] = "The account you entered is not registered!";
                }
            }

            if (empty($err)) {
                $email = $data['email'];
                $token = md5(date('ymdhis'));

                $link = site_url("admin/reset-password/?email=$email&token=$token");
                $attachment = "";
                $to = $email;
                $title = "Reset Password";
                $message = "Here is the link to reset your password.";
                $message .= "Please click the following link: $link";

                $isEmailSent = send_email($attachment, $to, $title, $message);

                $dataUpdate = [
                    'email' => $email,
                    'token' => $token
                ];
                $this->m_admin->updateData($dataUpdate);

                if ($isEmailSent) {
                    session()->setFlashdata("success", "We have sent a recovery email to your email address.");
                } else {
                    session()->setFlashdata("error", "Failed to send recovery email.");
                }
            }

            if ($err) {
                session()->setFlashdata("username", $username);
                session()->setFlashdata("warning", $err);
            }

            return redirect()->to("admin/forgot-password");
        }

        echo view("admin/v_forgot_password");
    }

    function reset_password()
    {
        $err = [];
        $email = $this->request->getVar('email');
        $token = $this->request->getVar('token');

        if ($email != '' && $token != '') {
            $myData = $this->m_admin->getData($email);

            if ($myData['token'] != $token) {
                $err[] = "Invalid token";
            }
        } else {
            $err[] = "Invalid parameters sent";
        }

        if ($err) {
            session()->setFlashdata("warning", $err);
        }

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'password' => [
                    'rules' => 'required|min_length[5]',
                    'errors' => [
                        'required' => 'Password must be filled',
                        'min_length' => 'Minimum password length is 5 characters'
                    ]
                ],
                'confirm_password' => [
                    'rules' => 'required|min_length[5]|matches[password]',
                    'errors' => [
                        'required' => 'Confirm password must be filled',
                        'min_length' => 'Minimum confirm password length is 5 characters',
                        'matches' => 'Confirm password does not match the entered password'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                session()->setFlashdata('warning', $this->validation->getErrors());
            } else {
                $dataUpdate = [
                    'email' => $email,
                    'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'token' => null
                ];
                $this->m_admin->updateData($dataUpdate);
                session()->setFlashdata('success', 'Password reset successful, please login');

                delete_cookie('cookie_username');
                delete_cookie('cookie_password');

                return redirect()->to('admin/login')->withCookies();
            }
        }

        echo view("admin/v_reset_password");
    }
}
