<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 25.10.2021
 * Time: 20:39
 */

namespace app\exceptions;


class AuthException extends Exception
{

    /**
     * AuthException constructor.
     * @param string $message
     */
    public function __construct($message = 'Ошибка Auth')
    {
        $this->title = 'AuthException';
        parent::__construct($message);
    }

}//Class