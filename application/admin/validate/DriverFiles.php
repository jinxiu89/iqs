<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/16
 * Time: 16:30
 */

namespace app\admin\validate;


use think\Validate;

/**
 * Class download
 * @package app\admin\validate
 */
class DriverFiles extends Validate
{
    protected $rule = [
        'id'=>'require|integer',
        'requirement' => 'require|max:64',
        'driver_id' => 'require',
        'path'=>'require'
    ];
    protected $message = [
        'id'=>'ID不合法',
        'driver_id' =>'必须要通过产品添加或者编辑入口才能进入添加文件功能，否则添加不进去',
        'requirement.require'=>'关键词必须填',
        'requirement.max'=>'关键词不能太长，64个字符为限制',
        'path.require'=>'请上传文件',
    ];
    protected $scene = [
        'edit' => ['id','requirement','path'],
        'add' => ['requirement','path'],
    ];
}