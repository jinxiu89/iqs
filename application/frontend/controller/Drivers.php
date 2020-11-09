<?php
/**
 * @Create by PhpStorm
 * @author:jinxiu89@163.com
 * @Create Date:2020/11/6 17:04
 * @User: kevin
 * @Current File : Drivers.php
 * @格言：溪涧岂能留得住，终归大海做波涛 --李忱
 * @格言： 我的内心因看见大海而波涛汹涌
 **/

namespace app\frontend\controller;
use app\common\helper\Category as CategoryHelper;
use app\common\models\DriverCategory;

class Drivers extends Base
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
            return $this->fetch();
        }
    }
}