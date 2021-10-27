<?php

namespace controllers;

use app\View;

class Controller{

    public $title;
    public $error_text;

    public function actionError()
    {
        $this->title = '404';
        $this->error_text = 'Запрошенная страница не найдена';
        View::render('site/errors',['context'=>$this]);
    }

}//Class