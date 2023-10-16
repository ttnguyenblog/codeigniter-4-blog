<?php

namespace App\Models;

use CodeIgniter\Model;

class PostsModel extends Model
{
    protected $table = "posts";
    protected $primaryKey = "post_id";
    protected $allowedFields = [
        'username', 'post_title', 'post_title_seo',
        'post_status', 'post_type', 'post_thumbnail', 'post_description', 'post_content'
    ];


    function setTitleSeo($title)
    {
        $url = mb_strtolower($title, 'UTF-8');
        $url = preg_replace('/[áàảãạăắằẳẵặâấầẩẫậ]/u', 'a', $url);
        $url = preg_replace('/[éèẻẽẹêếềểễệ]/u', 'e', $url);
        $url = preg_replace('/[óòỏõọôốồổỗộơớờởỡợ]/u', 'o', $url);
        $url = preg_replace('/[íìỉĩị]/u', 'i', $url);
        $url = preg_replace('/[úùủũụưứừửữự]/u', 'u', $url);
        $url = preg_replace('/[ýỳỷỹỵ]/u', 'y', $url);
        $url = preg_replace('/[đ]/u', 'd', $url);
        $url = preg_replace('/[^A-Za-z0-9]/', '-', $url);
        $url = strtolower(preg_replace('/-+/', '-', $url));

        // Check if the URL already exists in the database
        $builder = $this->db->table($this->table);
        $amount = $builder->where('post_title', $url)->countAllResults();

        // If the URL already exists, append a number to make it unique
        if ($amount > 0) {
            $url .= "-" . ($amount + 1);
        }

        return $url;
    }


    function insertPost($data, $post_type)
    {
        helper("global_function_helper");

        $builder = $this->table($this->table);
        $data['post_type'] = $post_type;

        foreach ($data as $key => $value) {
            $data[$key] = purify($value);
        }

        if (isset($data['post_id'])) {
            $action = $builder->save($data);
            $id = $data['post_id'];
        } else {

            $data['post_title_seo'] = $this->setTitleSeo($data['post_title']);
            $action = $builder->save($data);
            $id = $builder->getInsertID();
        }

        if ($action) {
            return $id;
        } else {
            return false;
        }
    }

    function listPost($post_type, $numberOfRows, $keyword = null, $group_dataset = null)
    {
        $builder = $this->table($this->table);

        $arr_keyword = explode(" ", $keyword);
        $builder->groupStart();
        for ($x = 0; $x < count($arr_keyword); $x++) {
            $builder->orLike('post_title', $arr_keyword[$x]);
            $builder->orLike('post_description', $arr_keyword[$x]);
            $builder->orLike('post_content', $arr_keyword[$x]);
        }
        $builder->groupEnd();

        $builder->where('post_type', $post_type);
        $builder->orderBy('post_time', 'desc');

        $data['record'] = $builder->paginate($numberOfRows, $group_dataset);
        $data['pager'] = $builder->pager;

        return $data;
    }

    function getPost($post_id)
    {
        $builder = $this->table($this->table);

        $builder->where('post_id', $post_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    function deletePost($post_id)
    {
        $builder = $this->table($this->table);
        $builder->where('post_id', $post_id);
        if ($builder->delete()) {
            return true;
        } else {
            return false;
        }
    }

    function getPostBySeo($post_title_seo)
    {
        $builder = $this->table($this->table);
        $builder->where('post_title_seo', $post_title_seo);
        $query = $builder->get();
        return $query->getRowArray();
    }
}
