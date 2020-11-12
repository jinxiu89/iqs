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
use app\common\models\Drivers as DriverModel;
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
            $data=(new DriverCategory())->getDataWithDriver();
            $this->assign('data',$data);
            return $this->fetch();
        }
    }
    public function details($url_title){
        if($this->request->isGet()){
            $data=(new DriverModel())->getDataWithFiles($url_title);
            if(is_string($data)) $this->error('参数不正确');
            $this->assign('data',$data);
            return $this->fetch();
        }
        $this->error('非法访问');
    }
}