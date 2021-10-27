<?php

namespace app\exceptions;

class DbException extends Exception{

    /**
     * DbException constructor.
     * @param string $message
     */
    public function __construct($message = 'Ошибка Db')
    {
        $this->title = 'DbException';
        parent::__construct($message);
    }

}//Class