<?php


namespace kkse\baidu_ai\ocr\bankcard;


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

        $ret = $this->httpPost('rest/2.0/ocr/v1/bankcard', $data);
        if (!empty($ret['error_code'])) {
            throw new RuntimeException($ret['error_msg'], $ret['error_code']);
        }

        return $this->results_map($ret);
    }

    protected function results_map($ret){
        $map = [
            'log_id' => 'log_id',
            'bank_card_number' => 'result.bank_card_number',
            'valid_date' => 'result.valid_date',
            'bank_card_type' => 'result.bank_card_type',
            'bank_name' => 'result.bank_name',
        ];

        $ret_data = [];
        foreach ($map as $key => $val) {
            Arr::has($ret, $val) and $ret_data[$key] = Arr::get($ret, $val);
        }

        return $ret_data;
    }
}