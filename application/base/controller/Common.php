<?php
/**
 * @Create by PhpStorm
 * @author:jinxiu89@163.com
 * @Create Date:2020/10/19 15:00
 * @User: kevin
 * @Current File : Common.php
 * @格言：溪涧岂能留得住，终归大海做波涛 --李忱
 * @格言： 我的内心因看见大海而波涛汹涌
 **/
namespace app\base\controller;


use think\App;
use think\captcha\Captcha;
use think\Controller;
use think\facade\Config;

/**
 * Class Common
 * @package app\common\controller
 */
class Common extends Controller
{
    public function __construct(App $app = null)
    {
        parent::__construct($app);
    }

    /**
     * @return \think\Response
     */
    public function verify()
    {
        $captcha = new Captcha(Config::get('verify.config'));
        return $captcha->entry();
    }
}