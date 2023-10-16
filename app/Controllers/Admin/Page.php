<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostsModel;

class Page extends BaseController
{
    protected $validation;
    protected $m_posts;

    function __construct()
    {
        $this->validation = \Config\Services::validation();
        $this->m_posts = new PostsModel();
        helper("global_function_helper");
    }


    function index()
    {
        $data = [];
        if ($this->request->getVar('action') == 'delete' && $this->request->getVar('post_id')) {
            $dataPost = $this->m_posts->getPost($this->request->getVar('post_id'));
            if ($dataPost['post_id']) {
                @unlink(LOKASI_UPLOAD . "/" . $dataPost['post_thumbnail']);
                $action = $this->m_posts->deletePost($this->request->getVar('post_id'));
                if ($action == true) {
                    session()->setFlashdata('success', "Page has been successfully deleted");
                } else {
                    session()->setFlashdata('warning', ['Failed to delete Page']);
                }
            }
            return redirect()->to("admin/page");
        }
        $data['titleTemplate'] = "Dashboard page";

        $post_type = "page";
        $numberOfRows = 5;
        $keyword = $this->request->getVar('keyword');
        $group_dataset = "dt";

        $result = $this->m_posts->listPost($post_type, $numberOfRows, $keyword, $group_dataset);

        $data['record'] = $result['record'];
        $data['pager'] = $result['pager'];
        $data['keyword'] = $keyword;

        $currentPage = $this->request->getVar('page_dt');
        $data['number'] = number($currentPage, $numberOfRows);

        echo view('admin/v_template_header', $data);
        echo view('admin/v_page', $data);
        echo view('admin/v_template_footer', $data);
    }

    function add()
    {
        $data = [];
        if ($this->request->getMethod() == 'post') {
            $data = $this->request->getVar();
            $rules = [
                'post_title' => 'required',
                'post_content' => 'required',
                'post_thumbnail' => 'is_image[post_thumbnail]'
            ];

            if (!$this->validate($rules)) {
                session()->setFlashdata('warning', $this->validation->getErrors());
            } else {
                $post_thumbnail = '';
                $file = $this->request->getFile('post_thumbnail');
                if ($file->isValid() && !$file->hasMoved()) {
                    $post_thumbnail = $file->getRandomName();
                    $file->move(LOKASI_UPLOAD, $post_thumbnail);
                }

                $record = [
                    'username' => session()->get('account_username'),
                    'post_title' => $data['post_title'],
                    'post_status' => $data['post_status'],
                    'post_thumbnail' => $post_thumbnail,
                    'post_description' => $data['post_description'],
                    'post_content' => $data['post_content']
                ];

                $post_type = 'page';

                $action = $this->m_posts->insertPost($record, $post_type);

                if ($action) {

                    $page_id = $action;

                    $set_front_page = $this->request->getVar('set_front_page');
                    $set_contact_page = $this->request->getVar('set_contact_page');

                    $page_id_page = '';


                    $configuration_name = "set_front_page";
                    $dataGet = configuration_get($configuration_name);

                    if ($set_front_page == '1') {
                        $page_id_page = $page_id;
                    }

                    if ($dataGet['configuration_value'] == $page_id && $set_front_page != '1') {
                        $page_id_page = '';
                    }

                    $dataSet = [
                        'configuration_value' => $page_id_page
                    ];
                    configuration_set($configuration_name, $dataSet);

                    // $page_id_contact = '';
                    // $configuration_name = "set_contact_page";
                    // $dataGet = configuration_get($configuration_name);

                    // if ($dataGet !== null && isset($dataGet['configuration_value'])) {
                    //     if ($dataGet['configuration_value'] == $page_id && $set_contact_page != '1') {
                    //         $page_id_contact = '';
                    //     }
                    // }

                    // if ($set_contact_page == '1') {
                    //     $page_id_contact = $page_id;
                    // }

                    // $dataSet = [
                    //     'configuration_value' => $page_id_contact
                    // ];
                    // configuration_set($configuration_name, $dataSet);



                    session()->setFlashdata('success', 'Page has been successfully inserted');
                    return redirect()->to('admin/page/add');
                } else {
                    session()->setFlashdata('warning', ['Failed to insert Page']);
                    return redirect()->to('/admin/page/add');
                }
            }
        }

        $data['titleTemplate'] = "Add New ";

        echo view('admin/v_template_header', $data);
        echo view('admin/v_page_add', $data);
        echo view('admin/v_template_footer', $data);
    }

    function edit($post_id)
    {
        $data = [];
        $dataPost = $this->m_posts->getPost($post_id);
        if (empty($dataPost)) {
            return redirect()->to('admin/page');
        }
        $data = $dataPost;

        if ($this->request->getMethod() == 'post') {
            $data = $this->request->getVar();
            $rules = [
                'post_title' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Title must be filled'
                    ],
                ],
                'post_content' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Content must be filled'
                    ],
                ],
                'post_thumbnail' => [
                    'rules' => 'is_image[post_thumbnail]',
                    'errors' => [
                        'is_image' => 'Only images are allowed to be uploaded'
                    ]
                ]
            ];
            $file = $this->request->getFile('post_thumbnail');
            if (!$this->validate($rules)) {
                session()->setFlashdata('warning', $this->validation->getErrors());
            } else {
                $post_thumbnail = $dataPost['post_thumbnail'];
                if ($file->getName()) {
                    $post_thumbnail = $file->getRandomName();
                }
                $record = [
                    'username' => session()->get('account_username'),
                    'post_title' => $this->request->getVar('post_title'),
                    'post_status' => $this->request->getVar('post_status'),
                    'post_thumbnail' => $post_thumbnail,
                    'post_description' => $this->request->getVar('post_description'),
                    'post_content' => $this->request->getVar('post_content'),
                    'post_id' => $post_id
                ];
                $post_type = 'page';
                $action = $this->m_posts->insertPost($record, $post_type);
                if ($action != false) {
                    $page_id = $post_id;

                    $set_front_page = $this->request->getVar('set_front_page');
                    $set_contact_page = $this->request->getVar('set_contact_page');

                    $configuration_name = "set_front_page";
                    $dataGet = configuration_get($configuration_name);

                    if ($set_front_page == '1') {
                        $page_id_page = $page_id;
                    }

                    if ($dataGet['configuration_value'] == $page_id && $set_front_page != '1') {
                        $page_id_page = '';
                    }

                    if (isset($page_id_page)) {
                        $dataSet = [
                            'configuration_value' => $page_id_page
                        ];
                        configuration_set($configuration_name, $dataSet);
                    }

                    $configuration_name = "set_contact_page";
                    $dataGet = configuration_get($configuration_name);

                    if ($dataGet !== null && isset($dataGet['configuration_value'])) {
                        if ($dataGet['configuration_value'] == $page_id && $set_contact_page != '1') {
                            $page_id_contact = '';
                        }
                    }

                    if ($set_contact_page == '1') {
                        $page_id_contact = $page_id;
                    }

                    if (isset($page_id_contact)) {
                        $dataSet = [
                            'configuration_value' => $page_id_contact
                        ];
                        configuration_set($configuration_name, $dataSet);
                    }


                    if ($file->getName()) {
                        if ($dataPost['post_thumbnail']) {
                            @unlink(LOKASI_UPLOAD . "/" . $dataPost['post_thumbnail']);
                        }
                        $directory_location = LOKASI_UPLOAD;
                        $file->move($directory_location, $post_thumbnail);
                    }
                    session()->setFlashdata('success', 'Page has been successfully edit');
                    return redirect()->to('admin/page/edit/' . $page_id);
                }
            }
        }

        $dataGet = configuration_get('set_front_page');
        if ($dataGet !== null && isset($dataGet['configuration_value']) && $dataGet['configuration_value'] == $post_id) {
            $data['set_front_page'] = 1;
        }

        $dataGet = configuration_get('set_contact_page');
        if ($dataGet !== null && isset($dataGet['configuration_value']) && $dataGet['configuration_value'] == $post_id) {
            $data['set_contact_page'] = 1;
        }


        $data['titleTemplate'] = "Edit Page ";

        echo view('admin/v_template_header', $data);
        echo view('admin/v_page_add', $data);
        echo view('admin/v_template_footer', $data);
    }
}
