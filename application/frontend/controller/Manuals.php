<?php
/**
 * @Create by PhpStorm
 * @author:jinxiu89@163.com
 * @Create Date:2020/11/6 17:21
 * @User: kevin
 * @Current File : Manuals.php
 * @格言：溪涧岂能留得住，终归大海做波涛 --李忱
 * @格言： 我的内心因看见大海而波涛汹涌
 **/

namespace app\frontend\controller;


class Manuals extends Base
{
    public function index(){
        if($this->request->isGet()){
            return "hello manuals";
        }
    }
}