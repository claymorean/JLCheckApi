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
use App\Model\ApplicationShenhe;
use App\Model\ApplicationShenheOpera;
use App\Model\Log;
use Symfony\Component\HttpFoundation\Request;
class Api extends HttpApi {
    protected $check;
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->check = $this->check();
    }

    public function getInfo() {
//        dd($this->data['uid']);
        $ope_time=date('Y-m-d H:i:s',time());
        if (!is_array($this->check)){
            return $this->check;
        }
        $application_control=$this->check['data']['application_control'];
        switch ($application_control['state']){
            case 1:
                ApplicationControl::find($this->data['application_control_id'])->update([
                    'state'=>2
                ]);
                Log::create([
                    'table_name'=>'application_control',
                    'change_field'=>'state',
                    'before_value'=>1,
                    'after_value'=>2,
                    'create_time'=>$ope_time,
                    'uid'=>$this->data['uid']
                ]);
                ApplicationShenhe::create([
                    'application_control_id'=>$this->data['application_control_id'],
                    'store_id'=>$application_control['store_id']
                ]);
                ApplicationShenheOpera::create([
                    'shenhe_start'=>$ope_time,
                    'application_control_id'=>$this->data['application_control_id'],
                    'shenhe_uid'=>$this->data['uid']
                ]);
                break;
            case 17:
                ApplicationControl::find($this->data['application_control_id'])->update([
                    'state'=>10
                ]);
                Log::create([
                    'table_name'=>'application_control',
                    'change_field'=>'state',
                    'before_value'=>17,
                    'after_value'=>10,
                    'create_time'=>$ope_time,
                    'uid'=>$this->data['uid']
                ]);
                ApplicationShenheOpera::create([
                    'shenhe_start'=>$ope_time,
                    'application_control_id'=>$this->data['application_control_id'],
                    'shenhe_uid'=>$this->data['uid']
                ]);
                break;
            case 2:
                break;
            case 10:
                break;
            default:
                $endTime = $this->getCurrentTime();
                $spend_time = $endTime-$this->startTime;
                $spend_time = round($spend_time,4);//小数点位数4
                return $this->response($spend_time,400, '审核状态错误', ['state'=>$application_control['state']]);
                break;
        }
        $endTime = $this->getCurrentTime();
        $spend_time = $endTime-$this->startTime;
        $spend_time = round($spend_time,4);//小数点位数4
        return $this->response($spend_time,200, '操作成功', $this->data);
    }
}