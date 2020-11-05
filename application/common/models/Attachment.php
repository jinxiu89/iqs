<?php
/**
 * @Create by PhpStorm
 * @author:jinxiu89@163.com
 * @Create Date:2020/10/23 10:06
 * @User: kevin
 * @Current File : Attachemt.php
 * @格言：溪涧岂能留得住，终归大海做波涛 --李忱
 * @格言： 我的内心因看见大海而波涛汹涌
 **/

namespace app\common\models;

use think\Exception;

/**
 * Class Attachment
 * @package app\common\models
 */
class Attachment extends Base
{
    protected $table = 'tb_attachment';
    protected $success = "保存成功！";
    protected $failed = "保存失败！";
//    protected $url = '/wavlink/category/list.html'

    /**
     * @param $info array
     * @return bool|string
     */
    public function add($info)
    {
        if(!is_array($info)) return __CLASS__.__FUNCTION__.'参数不合法';
        try{
            return self::allowField(true)->save($info);
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * @return string
     */
    public function getDataPage(){

        try{
            return self::paginate(12);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * @param $parent_id int
     * @return Attachment[]|string|\think\Paginator
     */
    public function getDataPageByPid($parent_id){
        try{
            return  self::where(['pid'=>$parent_id])->paginate(12);
        }catch (\Exception $exception){
            return $exception->getMessage();
        }
    }
}