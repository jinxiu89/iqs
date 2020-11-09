<?php
/**
 * @Create by PhpStorm
 * @author:jinxiu89@163.com
 * @Create Date:2020/11/2 10:43
 * @User: kevin
 * @Current File : AttachmentCategory.php
 * @格言：溪涧岂能留得住，终归大海做波涛 --李忱
 * @格言： 我的内心因看见大海而波涛汹涌
 **/

namespace app\admin\controller;


use think\App;
use app\common\models\AttachmentCategory as CategoryModel;
use app\admin\validate\AttachmentCategory as CategoryValidate;

/**
 * Class AttachmentCategory
 * @package app\admin\controller
 */
class AttachmentCategory extends Base
{
    protected $category;
    public function __construct(App $app = null)
    {
        parent::__construct($app);
        $this->category=(new CategoryModel())->getCategoryTree();
    }


    /**
     * @return false|mixed|string
     */

    public function add(){
        if($this->request->isGet()){
            $this->assign('category',$this->category);
            return $this->fetch();
        }
        if($this->request->isPost()){
            $data=input('post.','','htmlspecialchars,trim');
            $data['dir']=substr(md5(uniqid()), 3, 12);
            $validate=new CategoryValidate();
            if(!$validate->scene('add')->check($data)){
                return show(false, $validate->getError(), '');
            }
            try{
                if(!(new CategoryModel())->save($data)) return show(false,'新增失败','');
                 return show(true,'新增成功','http://www.baidu.com');
            }catch (\Exception $exception){
                return show(false,$exception->getMessage(),'');
            }
        }
        return show(0,'非法访问');//功能完善后再来修饰

    }

    public function edit($id){
        if($this->request->isGet()){
            $data=(new CategoryModel())->get($id);
            $this->assign('category',$this->category);
            $this->assign('data',$data->toArray());
            return $this->fetch();
        }
        if($this->request->isPost()){
            $data=input('post.','','htmlspecialchars,trim');
            $validate=new CategoryValidate();
            if(!$validate->scene('edit')->check($data)){
                return show(false, $validate->getError(), '');
            }
            try{
                if(!(new CategoryModel())->save($data,['id'=>$data['id']])) return show(false,'新增失败','');
                return show(true,'保存成功','http://www.baidu.com');
            }catch (\Exception $exception){
                return show(false,$exception->getMessage(),'');
            }
        }
    }
}