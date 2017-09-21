<?php
/**
 * Created by PhpStorm.
 * User: senuer
 * Date: 2017/9/15
 * Time: 9:44
 */

namespace App\Http\Controllers\Api;

use App\Libraries\CURL;
use App\Model\ApplicationControl;
use Symfony\Component\HttpFoundation\Request;
class Api extends HttpApi {
    protected $check;
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->check = $this->check();
    }

    public function getInfo() {
        dd(ApplicationControl::find(1));
        if (!is_array($this->check)){
            return $this->check;
        }
        $application_control=json_decode($this->check['data']);
        switch ($application_control['state']){
            case 1:
                break;
            default:
                break;
        }
        /*········以下是代码区·········*/
        /******************************/
        /*········以上是代码区·········*/
        //程序运行时间
        $endTime = $this->getCurrentTime();
        $spend_time = $endTime-$this->startTime;
        $spend_time = round($spend_time,4);//小数点位数4
    }
}