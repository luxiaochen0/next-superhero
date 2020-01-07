<?php


use Aliyun\OTS\OTSClient;

class TableStore
{
    public static $otsClient=null;

    private function __construct()
    {
        $otsClient = new OTSClient(array(
            'EndPoint' => "https://superhero.cn-shanghai.ots.aliyuncs.com",
            'AccessKeyID' => "LTAI4FdG8crCbMjfz9PXwuwC",
            'AccessKeySecret' => "FF4eyFEbgBeXCpIztS3g2xzlxo2VmR",
            'InstanceName' => "superhero",
            'ErrorLogHandler'=>false,
            'DebugLogHandler'=>false
        ));
        self::$otsClient=$otsClient;
    }

    public static function getInstance(){
        if(is_null(self::$otsClient)){
            new self();
        }
        return self::$otsClient;
    }
}