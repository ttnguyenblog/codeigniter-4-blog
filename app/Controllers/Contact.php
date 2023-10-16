<?php

namespace App\Controllers;

use App\Models\PostsModel;

class Contact extends BaseController
{

    protected $m_posts;
    protected $validation;

    function __construct()
    {
        $this->m_posts = new PostsModel();
        helper("global_function_helper");
        $this->validation = \Config\Services::validation();
    }
    public function index()
    {
        $data = [];

        if ($this->request->getMethod() == 'post') {
            $data = $this->request->getVar(); 

            $rules = [
                'contact_name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Name must be filled'
                    ]
                ],
                'contact_email' => [
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => 'Email must be filled',
                        'valid_email' => 'The email you entered is not valid'
                    ]
                ],
                'contact_tel' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Telephone must be filled'
                    ]
                ],
                'contact_message' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Message must be filled'
                    ]
                ],
            ];
            if (!$this->validate($rules)) {
                session()->setFlashdata('warning', $this->validation->getErrors());
            } else {
                $attachment = '';
                $to = 'chemgiopro009@gmail.com';
                $title = "[Contact me]";
                $message = "The following is a new email that has come in with the details as follows::<br/><br/>";
                $message .= "<b>Nama:</b><br/>";
                $message .= $data['contact_name'] . "<br/>";
                $message .= "<b>Email:</b><br/>";
                $message .= $data['contact_email'] . "<br/>";
                $message .= "<b>Telphone:</b><br/>";
                $message .= $data['contact_tel'] . "<br/>";
                $message .= "<b>Pesan:</b><br/>";
                $message .= $data['contact_message'] . "<br/>";
                $message .= "----------------------------<br/>";
                $message .= "Please respond promptly to this message at the sender's address.";
                send_email($attachment, $to, $title, $message);
                session()->setFlashdata('success', "We have received your message. Please wait for our response.");
                return redirect()->to('contact');
            }
        }


        $data = [];

    
        $data['title'] = 'Contact';

        echo view("front/v_template_header", $data);
        echo view("front/v_contact", $data);
        echo view("front/v_template_footer", $data);
    }
}