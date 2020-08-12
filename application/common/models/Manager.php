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
use think\exception\DbException;
use think\facade\Config;

/**
 * Class manager
 * @package app\common\models
 */
class manager extends Base
{
    protected $table = "tb_manager";

    public function login($data, $url)
    {
        $map = array(
            "name" => $data['name'],
            "status" => 1,
        );
        try {
            $user = self::where($map)->find()->toArray();
            session("adminUser", $user, 'admin');
            return show(true, '登录成功！', $url);
            /*if ($user['password'] != md5($data['password']) . Config::get('app.user_secret')) {
//                return show(false, '密码不正确', '');
            } else {

            }*/
        } catch (DataNotFoundException $e) {
            return show(false, $e->getMessage(), '');
        } catch (ModelNotFoundException $e) {
            return show(false, $e->getMessage(), '');
        } catch (DbException $e) {
            return show(false, $e->getMessage(), '');
        }
    }
}