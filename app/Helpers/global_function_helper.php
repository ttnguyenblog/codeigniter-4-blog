<?php
function send_email($attachment, $to, $title, $message)
{
    $email = \Config\Services::email();
    $sender_email = "chemgiopro009@gmail.com";
    $sender_name = "Tien Truong";

    $config['protocol'] = "smtp";
    $config['SMTPHost'] = "smtp.gmail.com";
    $config['SMTPUser'] = $sender_email;
    $config['SMTPPass'] = "cqtnmvmavoglfwym";
    $config['SMTPPort'] = 465;
    $config['SMTPCrypto'] = "ssl";
    $config['mailType'] = "html";

    $email->initialize($config);
    $email->setFrom($sender_email, $sender_name);
    $email->setTo($to);

    if ($attachment) {
        $email->attach($attachment);
    }

    $email->setSubject($title);
    $email->setMessage($message);

    if (!$email->send()) {
        // $data = $email->printDebugger(['headers']);
        // print_r($data);
        return false;
    } else {
        return true;
    }
}


function number($currentPage, $numberOfRows)
{
    if (is_null($currentPage)) {
        $number = 1;
    } else {
        $number = 1 + ($numberOfRows * ($currentPage - 1));
    }
    return $number;
}


function purify($dirty_html)
{
    $config = HTMLPurifier_Config::createDefault();
    $config->set('URI.AllowedSchemes', array('data' => true));
    $purifier = new HTMLPurifier($config);
    $clean_html = $purifier->purify($dirty_html);
    return $clean_html;
}


function configuration_get($configuration_name)
{
    $model = new \App\Models\ConfigurationModel;
    $filter = [
        'configuration_name' => $configuration_name
    ];
    $data = $model->getData($filter);
    return $data;
}

function configuration_set($configuration_name, $data_baru)
{
    $model = new \App\Models\ConfigurationModel;
    $dataGet = configuration_get($configuration_name);

    $dataUpdate = [
        'id' => $dataGet['id'],
        'configuration_name' => $configuration_name,
        'configuration_value' => $data_baru['configuration_value']
    ];

    $model->updateData($dataUpdate);
}


function post_author($username)
{
    $model = new \App\Models\AdminModel;
    $data = $model->getData($username);
    return $data['fullname'];
}

function set_post_link($post_id)
{
    $model = new \App\Models\PostsModel;
    $data = $model->getPost($post_id);
    $type = $data['post_type']; 
    $seo = $data['post_title_seo'];
    return site_url($type . "/" . $seo);
}
