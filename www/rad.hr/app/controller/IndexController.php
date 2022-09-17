<?php

class IndexController extends Controller
{
    public function index()
    {
        // echo 'IndexController->index';
        // jako puno koda
        //$view = new View(); - izvučeno u nadklasu
        $this->view->render('index');
    }
}