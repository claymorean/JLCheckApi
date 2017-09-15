<?php
/**
 * Created by PhpStorm.
 * User: senuer
 * Date: 2017/7/7
 * Time: 15:30
 */
namespace App\Http\Controllers\Api;

/**
 * api错误定义
 */
class ApiError {
    /**
     * 用户认证错误
     * @var integer
     */
    const USER_NULL = 10000;
    /**
     * 数据格式错误
     * @var integer
     */
    const INVALID_DATA = 10001;

    /**
     * 数据解析错误
     * @var integer
     */
    const DATA_PARSE_ERROR = 10002;

    /**
     * 签名错误
     * @var integer
     */
    const INVALID_SIGNATURE = 10003;

    /**
     * 接口不存在
     * @var integer
     */
    const INVALID_API = 10004;

    /**
     * 无法创建处理器
     * @var integer
     */
    const CANT_CREATE_HANDLER = 10005;

    /**
     * 未知错误
     * @var integer
     */
    const UNKNOWN_ERROR = 90001;

    /**
     * 错误码与错误信息映射
     * @var array
     */
    private static $errors = [
        10000 => '用户认证失败',
        10001 => '请求的数据不对',
        10002 => '数据格式错误',
        10003 => '签名错误',
        10004 => '接口不存在',
        10005 => '无法创建处理器',
        10006 => '操作失败',
        90001 => '未知错误',
    ];

    /**
     * 获取错误信息
     * @access public
     * @param integer $code 错误码
     * @return mixed
     */
    public static function getError($code) {
        return isset(self::$errors[$code]) ? self::$errors[$code] : false;
    }
}