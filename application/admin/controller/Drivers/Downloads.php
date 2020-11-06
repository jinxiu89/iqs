<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/14
 * Time: 17:44
 */

namespace app\admin\controller\Drivers;


use app\common\models\DriversFiles;
use think\Request;
use think\Route;
use app\common\helper\Aws;
use app\admin\controller\Base;
/**
 * 编写思路：当前台点击操作按钮时，点击进入--指定操作
 * 例如进入 add操作后 先判断是 是get操作还是post操作
 * 这里只说post操作
 * 先获取到post数据，然后去 模型里访问 保存数据方法，并携带数据
 * 这里注意，我们模型只做了一层，在model成就开始了逻辑判断以及保存操作
 * Class Downloads
 * @package app\admin\controller
 */
class Downloads extends Base
{
    /**
     * 添加：20190508
     *
     * @param $file_id
     * @return mixed
     */
    public function add($id)
    {
        if (Request()->isGet()) {
            return $this->fetch('', [
                'driver_id' => $id,
            ]);
        }
        if (Request()->isPost()) {
            $data = input('post.');
            return (new DriversFiles())->saveData($data);
        }
    }

    public function edit($id,$file_id){
        $model=new DriversFiles();
        //这个是直接修改驱动文件模型表
        if($this->request->isGet()){
            $data=$model->getDataById($file_id)->toArray();
            $this->assign('data',$data);
            $this->assign('driver_id',$id);
            return $this->fetch();
        }
        if($this->request->isPost()){
            $data = input('post.');
            return $model->saveData($data);
        }
    }

    /***
     * @param $id
     * @return mixed
     */
    public function list($id)
    {
        if (Request()->isGet()) {
            $files = (new DownloadModel())->getDataByFileId($id);
            $count = $files->count();
            return $this->fetch('', [
                'files' => $files,
                'driver_id' => $id,
                'count' => $count
            ]);
        }
    }

    /***
     * 编辑
     * 里面有两层意思
     * 1、编辑 2、删除aws上的key
     *
     * @param $id
     * @return false|mixed|string
     */
    public function edit_download($id)
    {
        if (Request()->isGet()) {
            $data = (new DownloadModel())->getDataById($id);
            return $this->fetch('', [
                'data' => $data,
            ]);
        }
        if (Request()->isPost()) {
            $data = input('post.');
            $old_key = $data['old_key'];
            $aws_key = $data['aws_key'];
            unset($data['old_key']);
            if ($old_key == $old_key) {
                return (new DownloadModel())->saveData($data);
            } else {
                if (Aws::deleteKey($old_key)) {
                    return (new DownloadModel())->saveData($data);
                } else {
                    return show(false, '删除失败，aws 删除接口有误', '');
                }
            }
        }
    }

    /***
     * 删除控制器
     * 1、获取需要删除的是那条数据，然后去删除，返回成功还是失败
     * @param $id
     * @return false|string
     */
    public function del($id)
    {
        if (Request()->isPost()) {
            $data = input('post.');
            return (new DownloadModel())->deleteById($data['id']);
        }
    }
}