<?php

/**
 * @Create by PhpStorm
 * @author:jinxiu89@163.com
 * @Create Date:2020/10/29 14:08
 * @User: kevin
 * @Current File : Attachment.php
 * @格言：溪涧岂能留得住，终归大海做波涛 --李忱
 * @格言： 我的内心因看见大海而波涛汹涌
 **/

namespace app\admin\controller;


use app\common\helper\Uploader;
use think\App;
use app\common\models\AttachmentCategory;
use app\common\models\Attachment as AttachmentModel;
use Exception;

/**
 * Class Attachment
 * @package app\admin\controller
 */
class Attachment extends Base
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $data = (new AttachmentCategory())->getCategoryTree();
        $this->assign('tree', $data);
    }

    /**
     * @param $parent_id
     * @return mixed
     */
    public function index($parent_id = 0)
    {
        $model = new AttachmentModel();
        if ($parent_id != 0) $data = $model->getDataPageByPid($parent_id);
        if ($parent_id == 0) $data = $model->getDataPage();
        if (is_object($data)) {
            foreach ($data as &$item) {
                $temp = explode('.', $item['name']);
                $item['ext'] = end($temp);
            }
            $page = $data->render();
            $this->assign('id', $parent_id); //前台点亮状态使用
            $this->assign('page', $page);
            $this->assign('data', $data);
            return $this->fetch();
        }
    }

    /**
     * @return mixed
     *
     */
    public function add()
    {
        if ($this->request->isGet()) {
            return $this->fetch();
        }
    }
    public function delete()
    {
        if ($this->request->isPost()) {
            $model = (new AttachmentModel());
            $postData = input('post.');
            $data = $model->getDataById($postData['id']);
            $delRes = $model->deleteById($postData['id']);
            if (is_string($delRes)) return show(0, $delRes);
            $deleteCloud = Uploader::delete($data['name'], 0);
            if (is_string($deleteCloud)) return show(0, $deleteCloud);
            if ($deleteCloud == true) {
                return show(1, "删除成功");
            }
            return show(0, "删除失败");
        }
    }

    /**
     * @param $parent_id
     * @return mixed
     * 上传文件接口
     */
    public function upload($parent_id)
    {
        if ($this->request->isGet()) {
            $this->assign('id', $parent_id);
            return $this->fetch();
        }
        if ($this->request->isPost()) {
            $file = $this->request->file('file');
            $info['filePath'] = $file->getInfo('tmp_name');
            //            $info['filePath']=$file->getRealPath();
            $info['key'] = $file->getInfo('name');
            $temp = (new AttachmentModel())->getDataByName($info['key']);
            if (is_array($temp) and !empty($temp)) return $temp['path'];
            $result = Uploader::imageUpload($info, 0);
            if (is_string($result)) return "错误:" . $result;
            if (is_array($result)) {
                $attachment['pid'] = $parent_id != NULL ? $parent_id : 1;
                $attachment['name'] = $file->getInfo('name');
                $attachment['size'] = getFilesize($file->getInfo('size'));
                $attachment['path'] = $result['path'];
                $attachment['type'] = $file->getInfo('type');
                $attachment['upload_type'] = $result['upload_type'];
                $attachment['module_type'] = 1;
                try {
                    $res = (new AttachmentModel())->save((array) $attachment); //todo:: 保存表失败还要删除文件
                    if (is_string($res)) return false;
                    // return $attachment['path'];
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }
            return "未知错误";
        }
    }
}