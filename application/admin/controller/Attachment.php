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
        if(is_object($data)) {
            foreach ($data as &$item) {
                $temp = explode('.', $item['name']);
                $item['ext'] = end($temp);
            }
            $page = $data->render();
            $this->assign('id',$parent_id);//前台点亮状态使用
            $this->assign('page', $page);
            $this->assign('data', $data);
        }
        return $this->fetch();
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

    /**
     * @param $parent_id
     * @return mixed
     * 上传文件接口
     */
    public function upload($parent_id)
    {
        if ($this->request->isGet()) {
            $this->assign('id',$parent_id);
            return $this->fetch();
        }
        if($this->request->isPost()){
            $info=[];
            $file = $this->request->file('file');
            $info['filePath']=$file->getInfo('tmp_name');
            $info['key']=$file->getInfo('name');
            $result = Uploader::imageUpload($info,0);
            if(is_string($result)) return "错误:".$result;
            unset($info);
            if (is_array($result)) { // todo ::存储附件数据
                $attachment['pid']=$parent_id !=NULL ? $parent_id : 1;
                $attachment['name']=$file->getInfo('name');
                $attachment['size']=getFilesize($file->getInfo('size'));
                $attachment['path']=$result['path'];
                $attachment['type']=$file->getInfo('type');
                $attachment['upload_type']=$result['upload_type'];
                $attachment['module_type']=1;
                $res=(new \app\common\models\Attachment())->add($attachment);
                if(is_string($res)) return $res;
                return $attachment['path'];
            }
            return "未知错误";
        }
    }
}