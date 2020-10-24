<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use app\common\models\DriverCategory;
use app\common\models\Drivers as driversModel;
/***
 * 返回错误信息
 * @param $status
 * @param $message
 * @param $title
 * @param $btn
 * @param string $url 返回跳转url
 * @param array $data 数据
 */
function show($status, $message = '', $url = '')
{
    $res = array(
        'status' => $status,
        'message' => $message,
        'url' => $url,
    );
    return json_encode($res);
}

function getCategoryName($id)
{
    $category = (new DriverCategory())->getCategoryName($id);
    if($category){
        if($category['parent_id'] == 0){
            return "一级分类";
        }else{
            $parent=(new DriverCategory())->getDataById($category['parent_id']);
            return $parent['name'];
        }

        return $category['parent_id'] == 0 ? "一级分类" : $category['name'];
    }else{
        return "程序错误";
    }
}

function getProductName($id){
    $product=(new driversModel())->getDataById($id);
    if($product){
        return $product['title'];
    }
}
function toJSON($data){
    return json_encode($data);
}

/**
 * @param $num
 * @return string
 */
function getFilesize($num)
{
    $p      = 0;
    $format = 'bytes';
    if ($num > 0 && $num < 1024) {
        $p = 0;
        return number_format($num) . ' ' . $format;
    }
    if ($num >= 1024 && $num < pow(1024, 2)) {
        $p      = 1;
        $format = 'KB';
    }
    if ($num >= pow(1024, 2) && $num < pow(1024, 3)) {
        $p      = 2;
        $format = 'MB';
    }
    if ($num >= pow(1024, 3) && $num < pow(1024, 4)) {
        $p      = 3;
        $format = 'GB';
    }
    if ($num >= pow(1024, 4) && $num < pow(1024, 5)) {
        $p      = 3;
        $format = 'TB';
    }
    $num /= pow(1024, $p);
    return number_format($num, 3) . ' ' . $format;
}

