<?php


use Aliyun\OTS\OTSClient;

class TableStore
{
    public static $otsClient=null;

    private function __construct()
    {
        $otsClient = new OTSClient(array(
            'EndPoint' => getenv('EndPoint'),
            'AccessKeyID' => getenv('AccessKeyID'),
            'AccessKeySecret' => getenv('AccessKeySecret'),
            'InstanceName' => getenv('InstanceName'),
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