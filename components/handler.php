<?php

use Components\Linker;
if(!empty($_POST)) {
    $response = [];
    if(!preg_match('[^(http://)]',$_POST['link']) &&
        !preg_match('[^(https://)]',$_POST['link'])
        )
    {
        $_POST['link'] = 'http://'.$_POST['link'];
    }

    if (filter_var($_POST['link'], FILTER_VALIDATE_URL) && isValidUrl($_POST['link'])) {
        if (Linker::isLinkExists($_POST['link'])) {
            $response = ['result' => 'ok'];
            $response['link'] = Linker::getShortLink($_POST['link']);
            echo json_encode($response);
        } else {
            $response = ['result' => 'ok'];
            $response['link'] = Linker::addLink($_POST['link']);
            echo json_encode($response);
        }
    } else {
        $response = ['result' => 'error'];
        $response['errNo'] = '1';
        echo json_encode($response);
    }
}

function isValidUrl($url) {
    $url = parse_url($url);
    if (!isset($url["host"])) return false;
    return !(gethostbyname($url["host"]) == $url["host"]);
}
