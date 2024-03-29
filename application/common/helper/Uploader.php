<?php

namespace app\common\helper;

/**
 * @Create by vscode,
 * @author:jinxiu89@163.com
 * @Create Date:2020年10月21日 12:33:22 Wednesday
 * @User: admin
 * @Current File : Uploader.php
 * @格言：溪涧岂能留得住，终归大海做波涛 --李忱
 * @格言： 我的内心因看见大海而波涛汹涌
 **/

use app\common\storage\Aws;
use think\Exception;

/**
 * Class Uploader
 * @package app\common\helper
 */
class Uploader
{
    protected $path;

    protected function __construct()
    {
    }

    /**
     * 单图片上传
     * @param $fileInfo array 上传文件名
     * @param $file object
     * @param $type int
     * @return array|string
     */
    public static function imageUpload($fileInfo, $type)
    {
        if (!is_array($fileInfo)) return '非法上传请求';
        //        $info = [];
        try {
            switch ($type) {
                case 0: // 亚马逊云
                    return Aws::uploader($fileInfo); //桶前缀后面要给到配置里去
                    break;
                case 1: // 阿里李云
                    $info = Aws::uploader();
                    if (is_string($info)) return $info;
                    break;
                default:
                    // todo :: 本地上传
                    break;
            }
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @param $key
     * @param $type
     * @return string
     */
    public static function delete($key, $type)
    {
        try {
            switch ($type) {
                case 0:
                    return Aws::deleteKey($key);
                case 1:
                    //todo::阿里云
                    break;
            }
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @param $fileName
     */
    public function uploadLocal($fileName)
    {
        //todo::本地上传
        return [];
    }
}