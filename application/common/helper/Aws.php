<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/5/11
 * Time: 8:47
 */

namespace app\common\helper;

use Aws\Exception\AwsException;
use Aws\Exception\MultipartUploadException;
use Aws\S3\S3Client;
use Aws\S3\MultipartUploader;
use think\facade\Config;

/**
 * Class Aws
 * @package app\common\helper
 */
class Aws
{
    protected $Bucket;

    /**
     *  最后修改日期：20190520  1314520  我就是那个爱你的pythoner 啊
     *  本方法 创建一个s3的客户端，app_key  option 都存储在app.config中
     *  具体写法 请参考 aws s3的php sdk 示例
     *  https://docs.aws.amazon.com/zh_cn/sdk-for-php/v3/developer-guide/getting-started_basic-usage.html
     * @return S3Client
     */
    public static function createClient()
    {
        $aws_app_key = Config::get('app.aws_app_key');
        $aws_options = Config::get('app.aws_options');
        $options = [
            'version' => $aws_options['version'],
            'region' => $aws_options['region'],
            'credentials' => [
                'key' => $aws_app_key['key'],
                'secret' => $aws_app_key['secret']
            ],
            'debug' => $aws_options['debug']
        ];
        $s3 = new S3Client($options);
        return $s3;
    }

    /**
     * @param $source
     * 源文件 上传文件 修改时间 20190517
     * 本方法 上传文件到s3 存储桶中
     * 需要两个参数 第一个参数是文件本身
     * 第二个是 文件名 也就是key
     * 该方法能将文件上传到亚马逊s3,如果成功返回文件在s3中的地址；
     * API参考 连接  MultipartUploader
     * https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-s3-2006-03-01.html
     * @param $key
     * @return mixed|void
     */
    public static function uploader($source, $key)
    {
        $client = self::createClient();
        $uploader = new MultipartUploader($client, $source, [
            "bucket" => Config::get('app.aws_bucket'),
            "key" => $key,
        ]);
        do {
            try {
                $result = $uploader->upload()->get('Key');
            } catch (MultipartUploadException $exception) {
                rewind($source);
                $uploader = new MultipartUploader($client, $source, [
                    'state' => $exception->getState(),
                ]);
            }
        } while (!isset($result));
        return $result;
    }

    /***
     * 根据key 删除 本桶里的数据
     * 修改时间 ： 20190520 1314520
     * 接收一个参数，就是需要删除的key
     * 如果这个文件存在，就删除，没有查询到这个文件就忽略掉不删除，防止在存储桶里删除了文件，系统里没有删除导致程序出错
     * API 参考  getObjectUrl   deleteObject
     * https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-s3-2006-03-01.html
     * @param $key
     * @return bool
     */
    public static function deleteKey($key)
    {
        $Bucket = Config::get('app.aws_bucket');
        $client = self::createClient();
        try {
            $client->getObjectUrl($Bucket, $key); //有url
            try{
                $client->deleteObject(['Bucket' => $Bucket, 'Key' => $key,]);
                return true; //删除成功
            }catch (AwsException $exception){
                return false; //删除失败！
            }
        } catch (AwsException $exception) {
            return true; // 所查询的 KEY 不存在 不需要删除
        }
    }
}