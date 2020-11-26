<?php
/**
 * @Create by PhpStorm
 * @author:jinxiu89@163.com
 * @Create Date:2020/11/26 15:57
 * @User: kevin
 * @Current File : Manager.php
 * @格言：溪涧岂能留得住，终归大海做波涛 --李忱
 * @格言： 我的内心因看见大海而波涛汹涌
 **/

namespace app\admin\controller;


use think\Controller;
use think\facade\Config;
use app\common\models\Manager as Model;

class Manager extends Controller
{
    /*public function modify(){
        if($this->request->isPost()){
            $data['id']=1;
            $data['name']='admin';
            $code=uniqid();
            $data['password']=md5("Wavlink@163.com".Config::get('app.user_secret').$code);
            $data['code']=$code;
            $res=(new Model())->modify($data);
            print_r($data['password']);
        }
    }*/
}