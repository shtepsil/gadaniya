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
        $history = User::getHistory($_SESSION['user_id']);
        View::render('site/gadaniya',[
            'user'=>User::$info,
            'history'=>$history
        ]);
        return;
    }

    public function actionGeks()
    {
        $data = [];
        if(!empty($_GET['code'])){
            $data['geks_info'] = Interpretation::getInterpretation($_GET['code']);
        }else{
            $data['geks'] = Interpretation::getInterpretations();
        }
        View::render('site/geks',$data);
        return;
    }

    public function actionInterpretation()
    {
        $post = $_POST;
        $code = implode('',$post['code']);
        if($int_info = Interpretation::getInterpretation($code)) {
            User::addHistory([
                'user_id'=>(int)$post['user_id'],
                'code'=>$code,
            ]);
            $data = [
                'status'=>200,
                'text' => $int_info['text'],
            ];
        }else{
            $data = [
                'status'=>404,
                'message'=>'Не найдена'
            ];
        }

        Request::response($data);
    }

    public function actionClearhistory()
    {
        $post = $_POST;
//        d::pe($post);
        if($text = User::deleteHistory((int)$post['user_id'])) {
//        if(0) {
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
