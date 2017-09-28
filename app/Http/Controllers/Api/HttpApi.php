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
     * 调用application_control接口
     *
     * @access public
     * @param array $data
     * @return void
     */
    public function application() {
        if(empty($this->data)){
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),13);
            return $this->response($spend_time, 400, 'application_control_id有误', []);
        }
        $options = [
            'host' => 'http://test.api.base-y.caixinunion.com',
            'path' => '/applicationcontrol/detail',
            'query' => ['application_control_id' => $this->data[ 'application_control_id' ]]
        ];
        $result = Curl::getMethod($options);
        if ($result[ 'code' ] != 200 || empty($result)) {
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),13);
            return $this->response($spend_time, 400, 'application_control_id有误', []);
        }else{
            return $result;
        }
    }
    /**
     * 调用application_control更新接口
     *
     * @access public
     * @param array $data
     * @return void
     */
    public function applicationUpdate($query) {
        if(empty($this->data)){
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),13);
            return $this->response($spend_time, 400, 'application_control_id有误', []);
        }
        $options = [
            'host' => 'http://test.api.base-y.caixinunion.com',
            'path' => '/applicationcontrol/edit',
            'query' => $query
        ];
        $result = Curl::getMethod($options);
        if ($result[ 'code' ] != 200 || empty($result)) {
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),13);
            return $this->response($spend_time, 400, 'application_control_id有误', []);
        }else{
            return $result;
        }
    }
    /**
 * 调用application_shenhe接口
 *
 * @access public
 * @param array $data
 * @return void
 */
    public function check($application_shenhe_id) {
        $options = [
            'host' => 'http://test.api.base-y.caixinunion.com',
            'path' => '/applicationshenhe/detail',
            'query' => ['application_shenhe_id' => $application_shenhe_id]
        ];
        $result = Curl::getMethod($options);
        if ($result[ 'code' ] != 200 || empty($result)) {
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),13);
            return $this->response($spend_time, 400, 'application_shenhe_id有误', []);
        }else{
            return $result;
        }
    }
    /**
     * 调用application_shenhe新增接口
     *
     * @access public
     * @param array $data
     * @return void
     */
    public function checkInsert($query) {
        $options = [
            'host' => 'http://test.api.base-y.caixinunion.com',
            'path' => '/applicationshenhe/add',
            'query' => $query
        ];
        $result = Curl::getMethod($options);
        if ($result[ 'code' ] != 200 || empty($result)) {
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),13);
            return $this->response($spend_time, 400, 'application_shenhe新增失败', []);
        }else{
            return $result;
        }
    }
    /**
     * 调用application_shenhe更新接口
     *
     * @access public
     * @param array $data
     * @return void
     */
    public function checkUpdate($query) {
        $options = [
            'host' => 'http://test.api.base-y.caixinunion.com',
            'path' => '/applicationshenhe/edit',
            'query' => $query
        ];
        $result = Curl::getMethod($options);
        if ($result[ 'code' ] != 200 || empty($result)) {
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),13);
            return $this->response($spend_time, 400, 'application_shenhe_id有误', []);
        }else{
            return $result;
        }
    }
    /**
     * 调用application_shenhe_opera详情接口
     *
     * @access public
     * @param array $data
     * @return void
     */
    public function checkOpera($application_shenhe_opera_id) {
        $options = [
            'host' => 'http://test.api.base-y.caixinunion.com',
            'path' => '/applicationshenheopera/detail',
            'query' => ['application_shenhe_opera_id' => $application_shenhe_opera_id]
        ];
        $result = Curl::getMethod($options);
        if ($result[ 'code' ] != 200 || empty($result)) {
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),13);
            return $this->response($spend_time, 400, 'application_shenhe_opera_id有误', []);
        }else{
            return $result;
        }
    }
    /**
     * 调用application_shenhe_opera新增接口
     *
     * @access public
     * @param array $data
     * @return void
     */
    public function checkOperaInsert($query) {
        $options = [
            'host' => 'http://test.api.base-y.caixinunion.com',
            'path' => '/applicationshenheopera/add',
            'query' => $query
        ];
        $result = Curl::getMethod($options);
        if ($result[ 'code' ] != 200 || empty($result)) {
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),13);
            return $this->response($spend_time, 400, 'application_shenhe_opera新增失败', []);
        }else{
            return $result;
        }
    }
    /**
     * 调用application_shenhe_opera详情更新接口
     *
     * @access public
     * @param array $data
     * @return void
     */
    public function checkOperaUpdate($query) {
        $options = [
            'host' => 'http://test.api.base-y.caixinunion.com',
            'path' => '/applicationshenheopera/edit',
            'query' => $query
        ];
        $result = Curl::getMethod($options);
        if ($result[ 'code' ] != 200 || empty($result)) {
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),13);
            return $this->response($spend_time, 400, 'application_shenhe_opera_id有误', []);
        }else{
            return $result;
        }
    }
    /**
     * 调用application_shenpi_opera详情接口
     *
     * @access public
     * @param array $data
     * @return void
     */
    public function approveOpera($application_shenpi_opera_id) {
        $options = [
            'host' => 'http://test.api.base-y.caixinunion.com',
            'path' => '/applicationshenpiopera/detail',
            'query' => ['application_shenpi_opera_id' => $application_shenpi_opera_id]
        ];
        $result = Curl::getMethod($options);
        if ($result[ 'code' ] != 200 || empty($result)) {
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),13);
            return $this->response($spend_time, 400, 'application_shenpi_opera_id有误', []);
        }else{
            return $result;
        }
    }
    /**
     * 调用application_shenpi新增接口
     *
     * @access public
     * @param array $data
     * @return void
     */
    public function approveOperaInsert($query) {
        $options = [
            'host' => 'http://test.api.base-y.caixinunion.com',
            'path' => '/applicationshenpiopera/add',
            'query' => $query
        ];
        $result = Curl::getMethod($options);
        if ($result[ 'code' ] != 200 || empty($result)) {
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),13);
            return $this->response($spend_time, 400, 'application_shenpi_opera新增失败', []);
        }else{
            return $result;
        }
    }
    /**
     * 调用application_shenpi_opera更新接口
     *
     * @access public
     * @param array $data
     * @return void
     */
    public function approveOperaUpdate($query) {
        $options = [
            'host' => 'http://test.api.base-y.caixinunion.com',
            'path' => '/applicationshenpiopera/edit',
            'query' => $query
        ];
        $result = Curl::getMethod($options);
        if ($result[ 'code' ] != 200 || empty($result)) {
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),13);
            return $this->response($spend_time, 400, 'application_shenpi_opera_id有误', []);
        }else{
            return $result;
        }
    }
    /**
     * 调用新增info_log接口
     *
     * @access public
     * @param array $data
     * @return void
     */
    public function createLog($query) {
        $options = [
            'host' => 'http://test.api.base.caixinunion.com',
            'path' => '/info/log/add',
            'query' => $query
//            [
//                'table_name'=>,
//                'change_field'=>,
//                'before_value'=>,
//                'after_value'=>,
//                'remark'=>,(非必填
//                'uid'=>,
//                'pri_key'=>
//            ]
        ];
        $result = Curl::getMethod($options);
        if ($result[ 'code' ] != 200 || empty($result)) {
            $endTime = $this->getCurrentTime();
            $spend_time = round(($endTime - $this->startTime),13);
            return $this->response($spend_time, 400, '创建日志失败', []);
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
//        $options = $code == 200 ? json_encode($options) : $options;
        $options = array_map('urlencode',$options);
        $result = [
            'execute_time' => $spend_time,
            'domain' => $_SERVER[ 'SERVER_NAME' ],
            'code' => $code,
            'timestamp' => microtime(TRUE),
            'msg' => urlencode($msg),
            'data' => $options
        ];
        return urldecode(json_encode($result));
//        $result = HttpApiUtil::makeReturn(0, '', $this->data['serial'], $this->result);
//        echo base64_encode(json_encode($result, JSON_UNESCAPED_UNICODE));
    }
}
