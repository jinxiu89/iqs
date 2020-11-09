<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/5
 * Time: 15:02
 */

namespace app\admin\controller\Drivers;


use think\App;
use think\Request;
use app\common\models\DriverCategory;
use app\common\helper\Category as CategoryHelper;
use app\admin\controller\Base;

/**
 * Class Index
 * @package app\admin\controller
 */
class Category extends Base
{
    protected $parentCategory;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->parentCategory=(new DriverCategory())->getParentCategory()->toArray();
    }

    public function index()
    {
        $data = (new DriverCategory())->getCategory();
        $count = $data->count();
        return $this->fetch('', [
            'data' => $data,
            'count' => $count
        ]);
    }

    public function add()
    {
        if (Request()->isGet()) {
            return $this->fetch('', [
                'category' => $this->parentCategory,
            ]);
        }
        if (Request()->isPost()) {
            $data = input('post.');
            $data['url_title']=substr(md5(uniqid()), 3, 12);
            return (new DriverCategory())->saveData($data);
        }
    }

    public function edit($id)
    {
        if (Request()->isGet()) {
            $data = (new DriverCategory())->getDataById($id);
            if ($data) {
                return $this->fetch('', [
                    'data' => $data,
                    'category' => $this->parentCategory
                ]);
            } else {
                return "数据库错误";
            }
        }
        if (Request()->isPost()) {
            $data = input('post.');
            return (new DriverCategory())->saveData($data);
        }
    }
}