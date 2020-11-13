<?php
/**
 * @Create by PhpStorm
 * @author:jinxiu89@163.com
 * @Create Date:2020/11/13 10:55
 * @User: kevin
 * @Current File : DriversCategory.php
 * @格言：溪涧岂能留得住，终归大海做波涛 --李忱
 * @格言： 我的内心因看见大海而波涛汹涌
 **/

namespace app\frontend\controller;


use app\common\helper\Category as CategoryHelper;
use app\common\models\DriverCategory;

class DriversCategory extends Base
{
    protected $toLevel;
    public function initialize()
    {
        parent::initialize();
        $category = (new DriverCategory())->getCategory()->toArray();
        $this->toLevel = CategoryHelper::toLayer($category, 'child', 0);
    }
    public function index(){
        if($this->request->isGet()){
            $this->assign('category',$this->toLevel);
            $data=(new DriverCategory())->getDataWithDriver();
            if(is_string($data)) $this->error($data);
            $this->assign('data',$data);
            return $this->fetch();
        }
    }

    public function category($url_title){
        if($this->request->isGet()){
            $this->assign('category',$this->toLevel);
            $data=(new DriverCategory())->getDataByUrlTtile($url_title);
            $this->assign('data',$data);
            $this->assign('title',$url_title);
            return $this->fetch();
        }
    }
}