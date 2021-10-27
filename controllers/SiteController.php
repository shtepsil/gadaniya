<?php
/**
 * Created by PhpStorm.
 * User: Сергей
 * Date: 25.10.2021
 * Time: 11:46
 */

/*
 * В кассе View можно конечно много чего доработать,
 * но я решил сосредоточиться на задаче...
 */

use components\Debugger as d;
use app\View;
use models\User;
use models\Interpretation;
use app\Request;
use controllers\Controller;

class SiteController extends Controller
{

    public function actionIndex()
    {
        header("Location: /gadaniya");
    }

    public function actionGadaniya()
    {
        View::render('site/gadaniya',[
            'user'=>User::$info,
            'geks'=>Interpretation::getInterpretations(),
            'questions_history'=>User::getHistory($_SESSION['user_id'])
        ]);
    }

    public function actionGeks()
    {
        $data = [];
        if(!empty($_GET['code'])){
            $data['geks_info'] = Interpretation::getInterpretation($_GET['code']);
        }
        View::render('site/geks',$data);
    }

    public function actionGetinterpretation()
    {
        $post = $_POST;
        if(User::addHistory($post)){
            $data = [ 'status'=>200 ];
        }else{
            $data = [ 'status'=>404 ];
        }

        Request::response($data);
    }

    public function actionClearhistory()
    {
        $post = $_POST;
        if($text = User::deleteHistory((int)$post['user_id'])) {
            $data = [
                'status'=>200,
                'text' => 'История удалена',
            ];
        }else{
            $data = [
                'status'=>404,
                'message'=>'Ошибка удаления истории'
            ];
        }

        Request::response($data);
    }

}//Class
