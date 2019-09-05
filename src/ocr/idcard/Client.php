<?php


namespace kkse\baidu_ai\ocr\idcard;


use kkse\baidu_ai\kernel\BaseClient;
use kkse\baidu_ai\kernel\support\Arr;
use RuntimeException;

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

        $ret = $this->httpPost('rest/2.0/ocr/v1/idcard', $data);

        if (!empty($ret['error_code'])) {
            throw new RuntimeException($ret['error_msg'], $ret['error_code']);
        }

        return $this->results_map($ret);
    }

    protected function results_map($ret){
        $map = [
            'direction' => 'direction',
            'image_status' => 'image_status',
            'risk_type' => 'risk_type',
            'edit_tool' => 'edit_tool',
            'log_id' => 'log_id',
            'address' => 'words_result.住址.words',
            'birth' => 'words_result.出生.words',
            'name' => 'words_result.姓名.words',
            'idcard' => 'words_result.公民身份号码.words',
            'gender' => 'words_result.性别.words',
            'nation' => 'words_result.民族.words',
            'expire_date' => 'words_result.失效日期.words',
            'sign_organization' => 'words_result.签发机关.words',
            'sign_date' => 'words_result.签发日期.words',
        ];

        $ret_data = [];
        foreach ($map as $key => $val) {
            Arr::has($ret, $val) and $ret_data[$key] = Arr::get($ret, $val);
        }

        return $ret_data;
    }
}