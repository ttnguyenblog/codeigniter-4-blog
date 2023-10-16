<?php

namespace App\Controllers;

use App\Models\PostsModel;

class Page extends BaseController
{
    protected $m_posts;

    function __construct()
    {
        $this->m_posts = new PostsModel();
        helper("global_function_helper");
    }
    public function index($seo_title)
    {
        $data = [];

        $dataHalaman = $this->m_posts->getPostBySeo($seo_title);

        $data['type'] = $dataHalaman['post_type'];
        if ($data['type'] != 'page') {
            return redirect()->to('');
        }
        $data['title'] = $dataHalaman['post_title'];
        $data['thumbnail'] = $dataHalaman['post_thumbnail'];
        $data['description'] = $dataHalaman['post_description'];
        $data['content'] = $dataHalaman['post_content'];
        $data['username'] = $dataHalaman['username'];
        $data['time'] = $dataHalaman['post_time'];

        echo view("front/v_template_header", $data);
        echo view("front/v_page", $data);
        echo view("front/v_template_footer", $data);
    }
}