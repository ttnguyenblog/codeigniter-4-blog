<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AdminModel;

class Account extends BaseController
{

    protected $m_admin;
    protected $validation;

    function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->m_admin = new AdminModel();
        helper("global_function_helper");
    }
    function index()
    {
        $data = [];
        if ($this->request->getMethod() == 'post') {
            $data = $this->request->getVar();

            $full_name = $this->request->getVar('full_name');
            $password_old = $this->request->getVar('password_old');
            $password_new = $this->request->getVar('password_new');
            $password_new_cf = $this->request->getVar('password_new_cf');

            $regulations = [
                'full_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Full name must be filled'
                    ]
                ]
            ];

            if ($password_new != '') {
                $regulations = [
                    'password_old' => [
                        'rules' => 'required|check_old_password[password_old]',
                        'errors' => [
                            'required' => 'Old password must be filled',
                            'check_old_password' => 'Old password is incorrect'
                        ]
                    ],
                    'password_new' => [
                        'rules' => 'min_length[5]|alpha_numeric',
                        'errors' => [
                            'min_length' => 'The minimum password length is 5 charactersr',
                            'alpha_numeric' => 'Only numbers, letters, and certain symbols are allowed'
                        ]
                    ],
                    'password_new_cf' => [
                        'rules' => 'matches[password_new]',
                        'errors' => [
                            'matches' => 'Password confirmation does not match'
                        ]
                    ]
                ];
            }

            if (!$this->validate($regulations)) {
                session()->setFlashdata('warning', $this->validation->getErrors());
            } else {
                $dataUpdate = [
                    'email' => session()->get('account_email'),
                    'fullname' => $full_name
                ];
                $this->m_admin->updateData($dataUpdate);

                $sesi = [
                    'account_fullname' => $full_name
                ];
                session()->set($sesi);

                if ($password_new != '') {
                    $password_new = password_hash($password_new, PASSWORD_DEFAULT);
                    $dataUpdate = [
                        'email' => session()->get('account_email'),
                        'password' => $password_new
                    ];
                    $this->m_admin->updateData($dataUpdate);

                    helper('cookie');
                    if (get_cookie('cookie_password')) {
                        set_cookie("cookie_username", session()->get('account_username'), 3600 * 24 * 30);
                        set_cookie("cookie_password", $password_new, 3600 * 24 * 30);
                    }
                }

                session()->setFlashdata('success', 'Account successfully updated');
            }


            return redirect()->to('admin/account')->withCookies();
        }

        $username = session()->get('account_username');
        $data = $this->m_admin->getData($username);

        $data['titleTemplate'] = "Account";
        /** header */
        echo view('admin/v_template_header', $data);
        echo view('admin/v_account', $data);
        echo view('admin/v_template_footer', $data);
        /** footer */
    }
}
