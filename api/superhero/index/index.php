<?php

require 'vendor/autoload.php';
require 'TableStore.php';

require 'App.php';

use Aliyun\OTS\OTSServerException;
use RingCentral\Psr7\Response;

/*
if you open the initializer feature, please implement the initializer function, as below:
function initializer($context) {
    echo 'initializing' . PHP_EOL;
}
*/

function handler($request, $context): Response{
    /*
    $body       = $request->getBody()->getContents();
    $queries    = $request->getQueryParams();
    $method     = $request->getMethod();
    $headers    = $request->getHeaders();
    $path       = $request->getAttribute('path');
    $requestURI = $request->getAttribute('requestURI');
    $clientIP   = $request->getAttribute('clientIP');
    */

    // return new Response(
    //     200,
    //     array(
    //         'custom_header1' => 'v1',
    //         'custom_header2' => ['v2', 'v3'],
    //     ),
    //     'hello world'
    // );

    $path       = $request->getAttribute('path');

    if(empty($path)){
        return new Response(
            400,
            ['Content-Type' => 'application/json'],
            '参数错误'
        );
    }

    $path=str_replace('/','',$path);

    try {
        $app=new App();
        $data=$app->$path();
    } catch (OTSServerException $e) {
        // 按照你的需要处理这个异常
         $e->getOTSErrorCode();
        $data=$e->getOTSErrorMessage();
    }

    return new Response(
        200,
        ['Content-Type' => 'application/json'],
        json_encode($data)
    );
}
