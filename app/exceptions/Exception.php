<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 25.10.2021
 * Time: 9:57
 */
namespace app\exceptions;

use app\View;

class Exception extends \Exception
{
    public $title;
    public $error_text;

    /**
     * Exception constructor.
     * @param string $message
     */
    public function __construct($message = 'Ошибка Exception')
    {
        $this->error_text = $message;
        parent::__construct($message);
    }

    public function __toString()
    {
        exit(View::getContent('site/errors',['context'=>$this]));
    }
}