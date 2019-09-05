<?php


namespace kkse\baidu_ai\ocr\business_license;


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
        //detect_direction	string	否	可选值 true,false是否检测图像朝向，默认不检测，即：false。可选值包括true - 检测朝向；false - 不检测朝向。朝向是指输入图像是正常方向、逆时针旋转90/180/270度
        //accuracy	string	否	可选值：normal,high参数选normal或为空使用快速服务；选择high使用高精度服务，但是时延会根据具体图片有相应的增加

        return $this->httpPost('rest/2.0/ocr/v1/business_license', $data);
    }
}