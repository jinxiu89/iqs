<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/14
 * Time: 14:14
 */

namespace app\common\models;

use app\admin\validate\drivers as driverValidate;
use function PHPSTORM_META\type;
use think\Collection;
use think\Exception;

/**
 * Class files
 * @package app\common\models
 */
class Drivers extends Base
{
    protected $table = 'tb_drivers';
    protected $success = "保存成功！";
    protected $failed = "保存失败！";
    protected $url = '/wavlink/driver/list.html';

    /***
     * 创建文件和下载地址的一对多关系
     * @return \think\model\relation\HasMany
     */
    public function files()
    {
        return $this->hasMany('DriversFiles', 'driver_id');
    }

    /***
     * 当搜索时 根据关键词查找数据并生成json数据结构
     *
     * @param $key
     * @return false|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getDataByKey($key)
    {
        $data = self::with('Downloads')->where('keywords', 'like', '%'.$key.'%')->order(['listorder' => 'desc', 'id' => 'asc'])->select()->toArray();
        if(empty($data)){
            $result = [
                'code' => "10001",
                'message' => '失败',
                'data' => [],
            ];
        }else{
            $result = [
                'code' => "10000",
                'message' => '成功！',
                'data' => $data,
            ];
        }
        return toJSON($result);
    }

    /***
     * 获取所有的数据并带上downloads
     * @return false|\think\db\Query[]
     * @throws Exception\DbException
     */
    public function getAllData($page, $listRow)
    {
        $offset = ($page - 1) == 0 ? 0 : ($page - 1) * $listRow;
        return self::with('Downloads')->order(['listorder' => 'desc', 'id' => 'asc'])->limit($offset, $listRow)->select()->toArray();
    }

    public function getCount()
    {
        return count(self::all());
    }

    /***
     * 此方法用于获取所有的文件列表
     *
     * @return bool|false|\think\db\Query[]
     */
    public function getDrivers()
    {
        try {

            return self::with('files')->order(['listorder' => 'desc', 'id' => 'asc'])->paginate();
        } catch (Exception $e) {
            return [];
        }
    }

    public function getDataById($id)
    {
        try {
            return self::get($id);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
    public function getDataWithFiles($url_title){
        try{
            $data=self::where(['url_title'=>$url_title])->with('files')->find();
            return $data->toArray();
        }catch (Exception $exception){
            return $exception->getMessage();
        }
    }

    /**
     * @param $data
     * @return false|string
     */
    public function saveData($data)
    {
        $validate = new driverValidate();
        if (isset($data['id'])) {
            if ($validate->check($data)) {
                try {
                    return self::allowField(true)->save($data, ['id' => $data['id']]) ?
                        show(true, $this->success, $this->url) : show(false, $this->failed, $this->url);
                } catch (Exception $exception) {
                    return show(false, $exception->getMessage(), '');
                }
            } else {
                return show(false, $validate->getError(), '');
            }
        } else {
            if ($validate->check($data)) {
                try {
                    return self::allowField(true)->save($data) ?
                        show(true, $this->success, $this->url) : show(false, $this->failed, $this->url);
                } catch (Exception $e) {
                    return show(false, $e->getMessage(), '');
                }
            } else {
                return show(false, $validate->getError(), '');
            }
        }
    }
}