<?php


namespace kkse\baidu_ai\ocr\idcard;


use kkse\baidu_ai\kernel\BaseClient;

class Client extends BaseClient
{
    /**
     * @param $image
     * @param string $idCardSide  front：身份证含照片的一面；back：身份证带国徽的一面
     * @param array $options
     * @return array|\kkse\baidu_ai\kernel\http\Response|\kkse\baidu_ai\kernel\support\Collection|object|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function check($image, $idCardSide, $options=array()){
        $data = array();

        $data['image'] = base64_encode($image);
        $data['id_card_side'] = $idCardSide;

        $data = array_merge($data, $options);

        return $this->httpPost('rest/2.0/ocr/v1/idcard', $data);
    }
}