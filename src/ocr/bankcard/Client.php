<?php


namespace kkse\baidu_ai\ocr\bankcard;


use kkse\baidu_ai\kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * @param $image
     * @param array $options
     * @return array|\kkse\baidu_ai\kernel\http\Response|\kkse\baidu_ai\kernel\support\Collection|object|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function check($image, $options=array()){
        $data = array();

        $data['image'] = base64_encode($image);

        $data = array_merge($data, $options);

        return $this->httpPost('rest/2.0/ocr/v1/bankcard', $data);
    }
}