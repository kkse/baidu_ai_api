<?php


namespace kkse\baidu_ai\ocr\business_license;


use kkse\baidu_ai\kernel\BaseClient;
use kkse\baidu_ai\kernel\support\Arr;
use RuntimeException;

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

        //单位名称、类型、法人、地址、有效期、证件编号、社会信用代码
        $ret = $this->httpPost('rest/2.0/ocr/v1/business_license', $data);
        if (!empty($ret['error_code'])) {
            throw new RuntimeException($ret['error_msg'], $ret['error_code']);
        }

        return $this->results_map($ret);
    }

    protected function results_map($ret){
        $map = [
            'log_id' => 'log_id',
            'unit_name' => 'words_result.单位名称.words',
            'type' => 'words_result.类型.words',
            'legal_person' => 'words_result.法人.words',
            'address' => 'words_result.地址.words',
            'validity_date' => 'words_result.有效期.words',
            'number' => 'words_result.证件编号.words',
            'credit_Code' => 'words_result.社会信用代码.words',
        ];

        $ret_data = [];
        foreach ($map as $key => $val) {
            Arr::has($ret, $val) and $ret_data[$key] = Arr::get($ret, $val);
        }

        return $ret_data;
    }
}