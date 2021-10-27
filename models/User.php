<?php

namespace models;

use components\Debugger as d;
use app\exceptions\AuthException;
use app\Db;
use components\JwtHelper;

class User
{

    public static $info;

    /**
     * @param $name
     * @param $email
     * @param $password
     * @return bool
     */
    public static function register($name, $email, $password)
    {
        $db = Db::getConnection();
        $time = time();
        $sql = "INSERT INTO `users` (name, email, password, created_at) "
            . "VALUES (?, ?, ?, ?)";
        $result = $db->prepare($sql);
        $result->bind_param('sssi', $name,$email,$password,$time);
        try{
            if($result->execute()){
                return $db->insert_id;
            }else return false;
        }catch(\Exception $e){
            throw new AuthException('Registration error');
        }
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public static function checkUserData($email, $password)
    {
        $db = Db::getConnection();
        $sql = 'SELECT `id` FROM `users` WHERE `email` = ? AND `password` = ?';
        $result = $db->prepare($sql);
        $result->bind_param('ss', $email,$password);
        try{
            $result->execute();
            $result->bind_result($id);

            if ($result->fetch()) {
                return $id;
            }
            return false;
        }catch(\Exception $e){
            throw new AuthException('Check user error');
        }
    }

    /**
     * @param $userId
     */
    public static function auth($token)
    {
        setcookie('token',$token,time()+604800,'/');
    }

    /**
     * @return array|bool
     * @throws AuthException
     */
    public static function checkLogged()
    {
        $jwt = new JwtHelper();
        if(!empty($_COOKIE['token'])){
            try{
                $jwt->validate($_COOKIE['token']);
                $jwt->verify($_COOKIE['token']);
                if($user = User::getUserById($jwt->getClaim($_COOKIE['token'],'user_id'))){
                    $_SESSION['user_id'] = $user['id'];
                    return $user;
                }else{
                    unset($_SESSION['user_id']);
                }
            }catch(\Exception $e){
                throw new AuthException($e->getMessage());
            }
        }
        unset($_SESSION['user_id']);
        return false;
    }

    public static function checkAuth(){
        if(!empty($_COOKIE['token'])) return true;
        return false;
    }

    /**
     * @return bool
     */
    public static function isGuest()
    {
        if (isset($_SESSION['user_id'])) {
            return false;
        }
        return true;
    }

    /**
     * @param $name
     * @return bool
     */
    public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }

    /**
     * @param $password
     * @return bool
     */
    public static function checkPassword($password)
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

    /**
     * @param $email
     * @return bool
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }

    /**
     * @param $email
     * @return bool
     */
    public static function checkEmailExists($email)
    {
        $db = Db::getConnection();
        $sql = "SELECT * FROM `users` WHERE `email` = ?";
        $result = $db->prepare($sql);
        $result->bind_param('s', $email);
        $result->execute();
        if($result->fetch())
            return true;
        return false;
    }

    /**
     * @param $id
     * @return array
     */
    public static function getUserById($id)
    {
        $db = Db::getConnection();
        $time = time();
        $sql = "SELECT `id`,`name`,`email`,`password`,`created_at` FROM `users` WHERE `id` = ?";
        $result = $db->prepare($sql);
        $result->bind_param('s', $id);
        try{
            $result->execute();
            $result->bind_result($id,$name,$email,$password,$role);
            $result->fetch();
            $user = [
                'id'       =>$id,
                'name'     =>$name,
                'email'    =>$email,
                'password' =>$password,
                'created_at' =>$time
            ];
            return $user;
        }catch(\Exception $e){
            throw new AuthException('Get user error');
        }
    }

    /**
     * @param $data
     * @return bool
     */
    public static function addHistory($data)
    {
        $time = time();
        $db = Db::getConnection();
        $sql = "INSERT INTO `history` (user_id, code, question, created_at) "
            . "VALUES (?, ?, ?, ?)";
        $result = $db->prepare($sql);
        $result->bind_param('issi', $data['user_id'],$data['code'],$data['question'],$time);
        try{
            $result->execute();
            return true;
        }catch(\Exception $e){
            throw new AuthException('User add history error');
        }
    }

    /**
     * @param $id
     * @return array
     */
    public static function getHistory($user_id)
    {
        $db = Db::getConnection();
        $sql = "SELECT * FROM `history` WHERE `user_id` = ? ORDER BY `created_at` DESC";
        $select = $db->prepare($sql);
        $select->bind_param('s', $user_id);
        try{
            $select->execute();
            $result = $select->get_result();
            $history = [];
            if($result->num_rows > 0){
                foreach($result as $f){
                    $history[] = $f;
                }
            }
//            d::pex($history);
            return $history;
        }catch(\Exception $e){
            throw new AuthException('Get user error');
        }
    }

    /**
     * @param $user_id
     * @return bool
     */
    public static function deleteHistory($user_id)
    {
        $db = Db::getConnection();
        $sql = 'DELETE FROM `history` WHERE `user_id` = ?';
        $result = $db->prepare($sql);
        $result->bind_param('i', $user_id);
        if($result->execute()) return true;
        return false;
    }

}//Class
