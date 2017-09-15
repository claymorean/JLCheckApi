<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiError;
use Symfony\Component\HttpFoundation\Request;
/**
 * api处理器抽象类
 */
class HttpApi {
    /**
     * 请求数据
     * @var array
     */
    protected $data = '';

    /**
     * 处理结果
     * @var array
     */
    protected $result = [];

    /**
     * 构造方法
     * @access public
     * @param array $data
     * @return void
     */
    public function __construct(Request $request) {
        if(urldecode($request->getContent())){
            $this->data = trim(str_replace(array("\r\n", "\r", "\n",' ','='), "", urldecode($request->getContent())));
        } else{
            return ApiError::getError(10001);
        }
    }

    /**
     * 用户验证
     * @access public
     * @param array $data
     * @return void
     */
    public function checkAuth($username,$session)
    {
        $user = McUser::where('username', $username);
        if ($user->get()->isEmpty() || $user->first()->session != $session) {
            echo '{"code":10000,"message": "'.ApiError::getError(10000).'","data":{}}';
//            echo '{"error":"'.ApiError::getError(10000).'"}';
            die();
        }
    }

    /**
     * 输出响应
     * @access public
     * @return mixed
     */
    public function response() {
//        $result = HttpApiUtil::makeReturn(0, '', $this->data['serial'], $this->result);
//        echo base64_encode(json_encode($result, JSON_UNESCAPED_UNICODE));
    }
}
