<?php

namespace Controllers;

use Components\Linker;

class MainController
{
    public function index()
    {
        $links = Linker::getPopularLinks();
        require_once __DIR__. '/../template.php';
    }

    public function handleForm()
    {
        require_once __DIR__."/../components/handler.php";
    }

    public function redirect($short)
    {
        Linker::redirect($short);
    }
}