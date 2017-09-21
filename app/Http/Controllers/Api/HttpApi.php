<?php

namespace App\Http\Controllers\Api;

use Symfony\Component\HttpFoundation\Request;
use App\Libraries\CURL;

/**
 * api处理器抽象类
 */
class HttpApi {
    /**
     * 请求数据
     *
     * @var array
     */
    public $data = '';
    /**
     * 请求参数
     *
     * @var array
     */
    protected $queryString = '';
    /**
     * 程序开始时间
     *
     * @var array
     */
    public $startTime = '';

    /**
     * 处理结果
     *
     * @var array
     */
    protected $result = [];

    /**
     * 构造方法
     *
     * @access public
     * @param array $data
     * @return void
     */
    public function __construct(Request $request) {
        $this->startTime = $this->getCurrentTime();
        $this->data = $request->all();
        $this->queryString = $request->getQueryString();
//        if(urldecode($request->getContent())){
//            $this->data = trim(str_replace(array("\r\n", "\r", "\n",' ','='), "", urldecode($request->getContent())));
//        } else{
//            return ApiError::getError(10001);
//        }
    }

    /**
     * 用户验证
     *
     * @access public
     * @param array $data
     * @return void
     */
    public function check() {
        if(empty($this->data)){
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),4);
            return $this->response($spend_time, 400, 'application_control_id有误', []);
        }
        $options = [
            'host' => 'http://api.base-y.caixinunion.com',
            'path' => '/applicationcontrol/detail/',
            'query' => ['application_control_id' => $this->data[ 'application_control_id' ]]
        ];
        $result = Curl::getMethod($options);
        if ($result[ 'code' ] != 200 || empty($result)) {
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),14);
            return $this->response($spend_time, 400, 'application_control_id有误', []);
        }else{
            return $result;
        }
    }

    /**
     * 程序运行时间
     *
     * @access public
     * @param array $data
     * @return void
     */
    public function getCurrentTime() {
        list ($msec, $sec) = explode(" ", microtime());
        return (float) $msec + (float) $sec;
    }

    /**
     * 输出响应
     *
     * @access public
     * @return mixed
     */
    public function response($spend_time, $code, $msg, $options) {
        $options = $code == 200 ? json_encode($options) : $options;
        $result = [
            'execute_time' => $spend_time,
            'domain' => $_SERVER[ 'SERVER_NAME' ],
            'code' => $code,
            'timestamp' => microtime(TRUE),
            'msg' => urlencode($msg),
            'data' => array_map('urlencode',$options)
        ];
        return urldecode(json_encode($result));
//        $result = HttpApiUtil::makeReturn(0, '', $this->data['serial'], $this->result);
//        echo base64_encode(json_encode($result, JSON_UNESCAPED_UNICODE));
    }
}
