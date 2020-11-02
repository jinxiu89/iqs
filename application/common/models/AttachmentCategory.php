<?php
/**
 * @Create by PhpStorm
 * @author:jinxiu89@163.com
 * @Create Date:2020/10/30 13:42
 * @User: kevin
 * @Current File : AttachmentCategory.php
 * @格言：溪涧岂能留得住，终归大海做波涛 --李忱
 * @格言： 我的内心因看见大海而波涛汹涌
 **/

namespace app\common\models;

use app\common\helper\Category;

//

class AttachmentCategory extends Base
{
    protected $table = 'tb_attachment_category';

    /**
     * @return array
     */
    public function getCategoryTree()
    {
        $data = self::select()->toArray();
        return Category::toLayer($data, 'child', 0);
    }

    /**
     * @return array
     */
    public function getCategoryLevel(){
        $data = self::select()->toArray();
        foreach($data as &$item){
            unset($item['child']);
        }
        return Category::toLevel($data, '&nbsp;&nbsp;', 0);
    }
}