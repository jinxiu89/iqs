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
        $data=(new AttachmentCategory())->getCategoryTree();
        $this->assign('tree',$data);
    }

    /**
     * @return mixed
     */
    public function index(){
        $data=(new AttachmentModel())->getDataPage();
        $page=$data->render();
        $this->assign('page',$page);
        $this->assign('data',$data);
        return $this->fetch();
    }

    /**
     * @return mixed
     *
     */
    public function add(){
        if($this->request->isGet()){
            return $this->fetch();
        }
    }

    /**
     * @return mixed
     * 上传文件接口
     */
    public function upload(){
        if($this->request->isGet()){
            return $this->fetch();
        }
    }
}