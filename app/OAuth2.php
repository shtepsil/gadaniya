<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 26.10.2021
 * Time: 16:21
 */

namespace app;

use components\Debugger as d;
use app\exceptions\AuthException;
use components\JwtHelper;
use models\User;

class OAuth2
{

    /**
     * @param $user_id
     * @return \Lcobucci\JWT\Token
     * @throws AuthException
     */
    public static function auth($user_id){
        $jh = new JwtHelper();
        $date = new \DateTime('+7 days');
        try{
            $domains = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];
            return $jh->generateToken($user_id,$date,$domains);

        }catch(\Exception $e){
            throw new AuthException('Ошибка авторизации OAuth2');
        }
    }

    public static function checkAuth(){
        $jwt = new JwtHelper();
        if(!empty($_COOKIE['token'])){
            try{
                $jwt->validate($_COOKIE['token']);
                $jwt->verify($_COOKIE['token']);
                if($user = User::getUserById($jwt->getClaim($_COOKIE['token'],'user_id'))){
                    $_SESSION['user_id'] = $user['id'];
                    if(!$user['id']){
                        unset($_SESSION['user_id']);
                        setcookie('token','',-1);
                    }
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

}//Class