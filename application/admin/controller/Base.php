<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/6
 * Time: 15:44
 */

namespace app\admin\controller;


use think\Controller;
use app\common\models\DriverCategory;
use app\common\helper\Category as CategoryHelper;
use think\facade\Session;
/**
 * Class Base
 * @package app\admin\controller
 */
class Base extends Controller
{
    protected $toLevel;

    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        if(Session::has('adminUser','admin')){
            $session = Session::get('adminUser', 'admin');
            return $this->assign('session',$session);
        }else{
            return $this->redirect('/wavlink/login.html');
        }
    }
}