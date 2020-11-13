<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/5
 * Time: 15:02
 */

namespace app\admin\controller\Drivers;

use think\Request;
use app\common\models\Drivers as DriversModel;
use think\Route;
use app\admin\controller\Base;
use app\common\helper\Category as CategoryHelper;
use app\common\models\DriverCategory;
/**
 * Class Index
 * @package app\admin\controller
 */
class Driver extends Base
{
    public function initialize()
    {
        parent::initialize();
        $category = (new DriverCategory())->getCategory()->toArray();
        $this->toLevel = CategoryHelper::toLevel($category, '&nbsp;&nbsp;&nbsp;&nbsp;', 0, 0);
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $data = (new DriversModel())->getDrivers();
        $count = $data->count();
        $page = $data->render();
        return $this->fetch('',[
            'data' => $data,
            'count' => $count,
            'page' =>$page
        ]);
    }

    /**
     * @return mixed
     */
    public function add()
    {
//        $next_url=0
        if (Request()->isGet()) {

            return $this->fetch('', [
                'to_level' => $this->toLevel,
            ]);
        }
        if (Request()->isPost()) {
            $data = input('post.');
            $data['url_title']=substr(md5(uniqid()), 3, 12);
            return (new DriversModel())->saveData($data);
        }
    }
    public function edit($id){
        if(Request()->isGet()){
            $data=(new DriversModel())->getDataById($id);
            return $this->fetch('',[
                'to_level'=>$this->toLevel,
                'data' =>$data
            ]);
        }
        if(Request()->isPost()){
            $data= input('post.');
            $data['url_title']=substr(md5(uniqid()), 3, 12);
            return (new DriversModel())->saveData($data);
        }
    }
}