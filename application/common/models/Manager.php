<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/6
 * Time: 17:59
 */

namespace app\common\models;


use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\Exception;
use think\exception\DbException;
use think\facade\Config;

/**
 * Class manager
 * @package app\common\models
 */
class Manager extends Base
{
    protected $table = "tb_manager";

    public function login($data, $url)
    {
        $map = array(
            "name" => $data['name'],
            "status" => 1,
        );
        try {
            $obj = self::where($map)->findOrEmpty();
            $user = $obj->toArray();
            if ($user['password'] != md5($data['password'] . Config::get('app.user_secret') . $user['code'])) {
                return show(false, '密码不正确', '');
            }
            session("adminUser", $user, 'admin');
            return show(true, '登录成功！', $url);
        } catch (Exception $e) {
            return show(false, $e->getMessage(), '');
        }
    }

    public function modify($data)
    {
        try {
            return self::save($data, ['id' => $data['id']]);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}