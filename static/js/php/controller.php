<?php
//header('Access-Control-Allow-Origin: http://www.baidu.com'); //设置http://www.baidu.com允许跨域访问
//header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header
require_once './oss-sdk-php/autoload.php';
require './obs/vendor/autoload.php';
require './obs/obs-autoloader.php';

use OSS\OssClient;
use OSS\Core\OssException;

use Obs\ObsClient;

date_default_timezone_set("Asia/chongqing");
error_reporting(E_ERROR);
header("Content-Type: text/html; charset=utf-8");

$CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", file_get_contents("config.json")), true);
$action = $_GET['action'];

switch ($action) {
    case 'config':
        $result =  json_encode($CONFIG);
        break;

    /* 上传图片 */
    case 'uploadimage':
    /* 上传涂鸦 */
    case 'uploadscrawl':
    /* 上传视频 */
    case 'uploadvideo':
    /* 上传文件 */
    case 'uploadfile':
        $result = include("action_upload.php");
        break;

    /* 列出图片 */
    case 'listimage':
        $result = include("action_list.php");
        break;
    /* 列出文件 */
    case 'listfile':
        $result = include("action_list.php");
        break;

    /* 抓取远程文件 */
    case 'catchimage':
        $result = include("action_crawler.php");
        break;

    default:
        $result = json_encode(array(
            'state'=> '请求地址出错'
        ));
        break;
}

$BASE_PATH = str_replace('\\','/',realpath(dirname(__FILE__).'/../../../'));

/* 输出结果 */
if (isset($_GET["callback"])) {
    if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
        echo htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
    } else {
        echo json_encode(array(
            'state'=> 'callback参数不合法'
        ));
    }
} else {
    $path = $BASE_PATH.json_decode($result)->url;
    $name = json_decode($result)->title;

    $content = file_get_contents($path);
    $object = "images/" . date('YmdHis') . '_' . $name;
    $res = moveObs($object, $content);
    $res  = rtrim($res, "\"");
    $res  = ltrim($res, "\"");
    $newres = json_decode($result);
    $newres->url = stripslashes($res);
    echo json_encode($newres);
}


function moveObs($object, $content)
    {
        $accessKeyId = 'HPUADKD860ULTAAE8TDB';
        $accessKeySecret = '165di598gNnONKYGVStNRyZFx6ElS13oVJrmKiZC';
        $endpoint = 'obs.cn-north-12.myhuaweicloud.com';
        $bucket = 'kefuimage1202';
        $options = array(
            // 可以参看https://help.aliyun.com/document_detail/31859.html?spm=a2c4g.11186623.2.10.481e2b72ggLS4F#concept-lkf-swy-5db
            OssClient::OSS_CONTENT_TYPE => 'image/jpg',  // 简单的举例使用 要根据实际的图片类型 可以看下MimeTypes::getMimetype()里的
        );
        try {
            $obsClient = new ObsClient([
                'key' => $accessKeyId,
                'secret' => $accessKeySecret,
                'endpoint' => $endpoint
         ]);
         $res = $obsClient->putObject([
                'Bucket' => $bucket,
                'Key' => $object,
                'Body' => $content
        ]);
        } catch (OssException $e) {
            print $e->getMessage();
        }
        return $res['ObjectURL'];
    }


function moveOss($object, $content)
    {
        $accessKeyId = 'HPUADKD860ULTAAE8TDB';
        $accessKeySecret = '165di598gNnONKYGVStNRyZFx6ElS13oVJrmKiZC';
        $endpoint = 'obs.cn-north-12.myhuaweicloud.com';
        $bucket = 'kefuimage1202';
        $options = array(
            // 可以参看https://help.aliyun.com/document_detail/31859.html?spm=a2c4g.11186623.2.10.481e2b72ggLS4F#concept-lkf-swy-5db
            OssClient::OSS_CONTENT_TYPE => 'image/jpg',  // 简单的举例使用 要根据实际的图片类型 可以看下MimeTypes::getMimetype()里的
        );
        try {
            $obsClient = new ObsClient([
                'key' => $accessKeyId,
                'secret' => $accessKeySecret,
                'endpoint' => $endpoint
         ]);
         $res = $obsClient->putObject([
                'Bucket' => $bucket,
                'Key' => $object,
                'Body' => $content
        ]);
        } catch (OssException $e) {
            print $e->getMessage();
        }
        return $res['ObjectURL'];
    }
