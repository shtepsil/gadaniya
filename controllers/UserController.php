<?php

use components\Debugger as d;
use app\View;
use models\User;
use app\Request;
use app\OAuth2;
use controllers\Controller;

class UserController extends Controller
{

    public function actionRegister()
    {
        $data = [];
        $data['name'] = false;
        $data['email'] = false;
        $data['password'] = false;
        $data['result'] = false;
        $errors = [];

        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }

            if ($errors == false) {
                if($user_id = User::register($name, $email, $password)){
                    User::auth(OAuth2::auth($user_id));
                    OAuth2::checkAuth();
                    header("Location: /");
                }else{
                    $errors[] = 'Ошибка регистрации';
                }
            }
            $data['name'] = $name;
            $data['email'] = $email;
            $data['password'] = $password;
        }
        View::render('user/register',[
            'data'=>$data,
            'errors'=>$errors,
        ]);
    }

    public function actionLogin()
    {
        if (Request::isAjax()){
            $post = $_POST;// Тут можно обезопасить данные POST
            $data = ['status'=>401];
            $data['errors'] = [];
            $email = $post['email'];
            $password = $post['password'];
            if (!User::checkEmail($email)) {
                $data['errors'][] = 'Неправильный email';
            }
            if (!User::checkPassword($password)) {
                $data['errors'][] = 'Пароль не должен быть короче 6-ти символов';
            }

            $user_id = User::checkUserData($email, $password);

            if ($user_id == false) {
                $data['errors'][] = 'Логин или пароль не правильные';
            } else {
                $token = OAuth2::auth($user_id);
                $data = [
                    'status'=>'200',
                    'api_key'=>(string)$token
                ];
                $data['status'] = 200;
            }
            Request::response($data);
        }
        View::render('user/login');
    }

    public function actionOauth2logout()
    {
        unset($_SESSION['user_id']);
        header("Location: /");
    }

}//Class
