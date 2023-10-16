<?php

namespace App\Controllers;

use App\Models\PostsModel;

class Article extends BaseController
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

        $pageData = $this->m_posts->getPostBySeo($seo_title);

        $data['type'] = $pageData['post_type'];
        if ($data['type'] != 'article') {
            return redirect()->to('');
        }
        $data['title'] = $pageData['post_title'];
        $data['thumbnail'] = $pageData['post_thumbnail'];
        $data['description'] = $pageData['post_description'];
        $data['content'] = $pageData['post_content'];
        $data['author'] = $pageData['username'];
        $data['time'] = $pageData['post_time'];

        echo view("front/v_template_header", $data);
        echo view("front/v_article", $data);
        echo view("front/v_template_footer", $data);
    }
}