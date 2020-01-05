<?php


class App
{
    public function __call($name, $arguments)
    {
        return
            [
                'code'=>500,
                'msg'=>'请求的操作不存在'
            ];

    }

    public function init()
    {
        $data_json= file_get_contents('json/all.json');
        $data = json_decode($data_json, true);


        $otsClient=TableStore::getInstance();

        foreach ($data['data']['rows'] as $key=>$value){
            $result[]=$otsClient->putRow(
                [
                    'table_name' => 'superhero',
                    'primary_key'=>[['id',$value['id']]],
                    'attribute_columns'=>[
                        ['name',$value['name']],
                        ['poster',$value['poster']],
                        ['cover',$value['cover']],
                        ['trailer',$value['trailer']],
                        ['score',$value['score']],
                        ['prisedCounts',$value['prisedCounts']],
                        ['basicInfo',$value['basicInfo']],
                        ['originalName',$value['originalName']],
                        ['releaseDate',$value['releaseDate']],
                        ['totalTime',$value['totalTime']],
                        ['plotDesc',$value['plotDesc']],
                        ['directors',$value['directors']],
                        ['actors',$value['actors']],
                        ['plotPics',$value['plotPics']],
                        ['createTime',$value['createTime']],
                    ]
                ]
            );
        }

        return $result;
    }
}