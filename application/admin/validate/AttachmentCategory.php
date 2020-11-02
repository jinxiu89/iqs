<?php
/**
 * @Create by PhpStorm
 * @author:jinxiu89@163.com
 * @Create Date:2020/10/23 14:34
 * @User: kevin
 * @Current File : Attachment.php
 * @格言：溪涧岂能留得住，终归大海做波涛 --李忱
 * @格言： 我的内心因看见大海而波涛汹涌
 **/

namespace app\admin\validate;


use think\Validate;

/**
 * Class Attachment
 * @package app\admin\validate
 */
class AttachmentCategory extends Validate
{
    protected $rule = [
        'id'=>'require|integer',
        'parent_id'=>'require|integer',
        "name" => "require|max:25"
    ];
    protected $message = [
        "id"=>'ID不合法',
        "parent_id"=>'parent_ID不合法',
        "name.require" => "分类名必须填",
        "name.max" => "分类名最长不超过25个字符"
    ];
    protected $scene = [
        'edit' => ['id','parent_id','name'],
        'add' => ['parent_id','name'],
    ];
}