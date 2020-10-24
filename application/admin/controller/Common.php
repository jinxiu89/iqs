<?php
/**
 * @Create by PhpStorm
 * @author:jinxiu89@163.com
 * @Create Date:2020/10/22 10:46
 * @User: kevin
 * @Current File : Common.php
 * @格言：溪涧岂能留得住，终归大海做波涛 --李忱
 * @格言： 我的内心因看见大海而波涛汹涌
 **/

namespace app\admin\controller;
use app\common\helper\Uploader;
use think\facade\Request;
use app\common\models\Attachment;
/**
 * Class Common
 * @package app\admin\controller
 */
class Common extends Base
{
    /**
     * @return string
     */
    public function ImageUpload()
    {
        if ($this->request->isGet()) {
            abort(403,'非法访问');
        }
        if ($this->request->isPost()) {
            $info=[];
            $file = $this->request->file('file');
            $info['filePath']=$file->getInfo('tmp_name');
            $info['key']=$file->getInfo('name');
            $result = Uploader::imageUpload($info,0);
            if(is_string($result)) return "错误:".$result;
            unset($info);
            if (is_array($result)) { // todo ::存储附件数据
                $attachment['pid']=input('pid') !=NULL ? input('pid') : 1;
                $attachment['name']=$file->getInfo('name');
                $attachment['size']=getFilesize($file->getInfo('size'));
                $attachment['path']=$result['path'];
                $attachment['type']=$file->getInfo('type');
                $attachment['upload_type']=$result['upload_type'];
                $attachment['module_type']=1;
                $res=(new Attachment())->add($attachment);
                if(is_string($res)) return $res;
                return $attachment['path'];
            }
            return "未知错误";
        }
    }
}