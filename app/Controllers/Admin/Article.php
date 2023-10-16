<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostsModel;

class Article extends BaseController
{
    protected $validation;
    protected $m_posts;
    protected $halaman_controller;
    protected $halaman_label;

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
                    session()->setFlashdata('success', "Post has been successfully deleted");
                } else {
                    session()->setFlashdata('warning', ['Failed to delete post']);
                }
            }
            return redirect()->to("admin/article");
        }
        $data['titleTemplate'] = "Dashboard Article";

        $post_type = "article";
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
        echo view('admin/v_article', $data);
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

                $post_type = 'article';

                $action = $this->m_posts->insertPost($record, $post_type);

                if ($action) {
                    session()->setFlashdata('success', 'Post has been successfully inserted');
                    return redirect()->to('admin/article/add');
                } else {
                    session()->setFlashdata('warning', ['Failed to insert Post']);
                    return redirect()->to('/admin/article/add');
                }
            }
        }

        $data['titleTemplate'] = "Add New ";

        echo view('admin/v_template_header', $data);
        echo view('admin/v_article_add', $data);
        echo view('admin/v_template_footer', $data);
    }

    function edit($post_id)
    {
        $data = [];
        $dataPost = $this->m_posts->getPost($post_id);
        if (empty($dataPost)) {
            return redirect()->to('admin/article');
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
                $post_type = 'article';
                $action = $this->m_posts->insertPost($record, $post_type);
                if ($action != false) {
                    $page_id = $action;
                    if ($file->getName()) {
                        if ($dataPost['post_thumbnail']) {
                            @unlink(LOKASI_UPLOAD . "/" . $dataPost['post_thumbnail']);
                        }
                        $directory_location = LOKASI_UPLOAD;
                        $file->move($directory_location, $post_thumbnail);
                    }
                    session()->setFlashdata('success', 'Post has been successfully edit');
                    return redirect()->to('admin/article/edit/' . $page_id);
                }
            }
        }

        $data['titleTemplate'] = "Edit post ";

        echo view('admin/v_template_header', $data);
        echo view('admin/v_article_add', $data);
        echo view('admin/v_template_footer', $data);
    }
}
