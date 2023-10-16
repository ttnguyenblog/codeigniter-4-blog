<?php

namespace App\Controllers;
use App\Models\PostsModel;

class Home extends BaseController
{
    protected $m_posts;

    function __construct()
    {
        $this->m_posts = new PostsModel();       
        helper("global_function_helper");
    }

    public function index()
    {
        $data = [];

        $post_type = 'article';
        $numberOfRows = 3;
        $keyword = '';
        $group_dataset = 'ft';

      
        $data['title'] = 'Home';
  

        $hasil = $this->m_posts->listPost($post_type, $numberOfRows, $keyword, $group_dataset);
        $data['record'] = $hasil['record'];
        $data['pager'] = $hasil['pager'];

        echo view('front/v_template_header_home',$data);
        echo view('front/v_home',$data);
        echo view('front/v_template_footer',$data);
    }
}
