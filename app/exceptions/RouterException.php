<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 25.10.2021
 * Time: 11:23
 */
namespace app\exceptions;

class RouterException extends Exception
{
    /**
     * RouterException constructor.
     * @param string $message
     */
    public function __construct($message = 'Ошибка Router',$title='RouterException')
    {
        $this->title = $title;
        parent::__construct($message);
    }
}