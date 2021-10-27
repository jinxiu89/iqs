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
     * @return array|string
     */
    public function add($info)
    {
        if (!is_array($info)) return __CLASS__ . __FUNCTION__ . '参数不合法';
        try {
            $result = self::allowField(true)->save($info);
            return ['url' => $result];
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @param $id
     * @return bool|string
     */
    public function deleteById($id)
    {
        try {
            return self::destroy($id);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @param $name
     * @return array|string
     */
    public function getDataByName($name)
    {
        try {
            $data = self::where(['name' => $name])->findOrEmpty();
            return  $data->toArray();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @param $id
     * @return array|string
     */
    public function getDataById($id)
    {
        try {
            $data = self::where(['id' => $id])->findOrEmpty();
            return $data->toArray();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @return string
     */
    public function getDataPage()
    {

        try {
            return self::paginate(12);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @param $parent_id int
     * @return Attachment[]|string|\think\Paginator
     */
    public function getDataPageByPid($parent_id)
    {
        try {
            return  self::where(['pid' => $parent_id])->paginate(12);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}