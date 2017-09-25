<?php
/**
 * Created by PhpStorm.
 * User: senuer
 * Date: 2017/9/15
 * Time: 9:44
 */

namespace App\Http\Controllers\Api;

use App\Model\ApplicationControl;
use App\Model\ApplicationShenhe;
use App\Model\ApplicationShenheOpera;
use App\Model\ApplicationShenpiOpera;
use App\Model\Log;
use Symfony\Component\HttpFoundation\Request;
class Api extends HttpApi {
    protected $application;
    public function __construct(Request $request) {
        parent::__construct($request);
        $this->application = $this->application();
    }
    /**
     * 数组判空
     *
     * @access public
     * @return void
     */
    private function is_array_empty($arrays){
        foreach ($arrays as $array){
            if(empty($array)){
                return true;
            }
        }
        return false;
    }
    /**
     * 2001 点击“审核租车”
     *
     * @access public
     * @return void
     */
    public function get() {
        $ope_time=date('Y-m-d H:i:s',time());
        if (!is_array($this->application)){
            return $this->application;
        }
        $application_control=$this->application['data']['application_control'];
        switch ($application_control['state']){
            case 1:
                $appUpdate=$this->applicationUpdate([
                    'application_control_id'=>$this->data['application_control_id'],
                    'state'=>2
                ]);
                if (!is_array($appUpdate)){
                    return $appUpdate;
                }
                $logCreate=$this->createLog([
                    'table_name'=>'application_control',
                    'change_field'=>'state',
                    'before_value'=>1,
                    'after_value'=>2,
                    'uid'=>$this->data['uid'],
                    'pri_key'=>'application_control_id'
                ]);
                if (!is_array($logCreate)){
                    return $logCreate;
                }
                $checkCreate=$this->checkInsert([
                    'application_control_id'=>$this->data['application_control_id'],
                    'store_id'=>$application_control['store_id']
                ]);
                if (!is_array($checkCreate)){
                    return $checkCreate;
                }
                $checkOperaCreate=$this->checkOperaInsert([
                    'shenhe_start'=>$ope_time,
                    'application_control_id'=>$this->data['application_control_id'],
                    'shenhe_uid'=>$this->data['uid']
                ]);
                if (!is_array($checkOperaCreate)){
                    return $checkOperaCreate;
                }
                break;
            case 17:
                $appUpdate=$this->applicationUpdate([
                    'application_control_id'=>$this->data['application_control_id'],
                    'state'=>10
                ]);
                if (!is_array($appUpdate)){
                    return $appUpdate;
                }
                $logCreate=$this->createLog([
                    'table_name'=>'application_control',
                    'change_field'=>'state',
                    'before_value'=>17,
                    'after_value'=>10,
                    'uid'=>$this->data['uid'],
                    'pri_key'=>'application_control_id'
                ]);
                if (!is_array($logCreate)){
                    return $logCreate;
                }
                $checkOperaCreate=$this->checkOperaInsert([
                    'shenhe_start'=>$ope_time,
                    'application_control_id'=>$this->data['application_control_id'],
                    'shenhe_uid'=>$this->data['uid']
                ]);
                if (!is_array($checkOperaCreate)){
                    return $checkOperaCreate;
                }
                break;
            case 2:
                break;
            case 10:
                break;
            default:
                $endTime = $this->getCurrentTime();
                $spend_time = $endTime-$this->startTime;
                $spend_time = round($spend_time,13);//小数点位数13
                return $this->response($spend_time,400, '审核状态错误', ['state'=>$application_control['state']]);
                break;
        }
        $endTime = $this->getCurrentTime();
        $spend_time = $endTime-$this->startTime;
        $spend_time = round($spend_time,13);//小数点位数13
        return $this->response($spend_time,200, '操作成功', $this->data);
    }
    /**
     * 2002 更新审核信息
     *
     * @access public
     * @return void
     */
    public function update(){
        if (!is_array($this->application)){
            return $this->application;
        }
        $check=$this->check($this->data['application_shenhe_id']);
        if (!is_array($check)){
            return $check;
        }
        $checkOpera=$this->checkOpera($this->data['application_shenhe_opera_id']);
        if (!is_array($checkOpera)){
            return $checkOpera;
        }
        $application_control=$this->application['data']['application_control'];
        switch ($application_control['state']){
            case 2:
                break;
            case 10:
                break;
            default:
                $endTime = $this->getCurrentTime();
                $spend_time = $endTime-$this->startTime;
                $spend_time = round($spend_time,13);//小数点位数13
                return $this->response($spend_time,400, '审核状态错误', ['state'=>$application_control['state']]);
                break;
        }
        $application_shenhe=array_except($this->data,['uid','application_control_id','application_shenhe_opera_id','shenhe_sug','sub_shenpi_remark','shenhe_end_reason','shenhe_end_remark','return_file','shenhe_return_reason','shenhe_return_remark']);
        $bool_shenhe=$this->checkUpdate($application_shenhe);
        $application_shenhe_opera=array_only($this->data,['application_shenhe_opera_id','shenhe_sug','sub_shenpi_remark','shenhe_end_reason','shenhe_end_remark','return_file','shenhe_return_reason','shenhe_return_remark']);
        $bool_shenhe_opera=$this->checkUpdate($application_shenhe_opera);

        $endTime = $this->getCurrentTime();
        $spend_time = $endTime-$this->startTime;
        $spend_time = round($spend_time,13);//小数点位数13
        if(!(is_array($bool_shenhe) || is_array($bool_shenhe_opera))){
            return $this->response($spend_time,400, '更新操作失败', []);
        }
        return $this->response($spend_time,200, '操作成功', array_only($this->data,['application_control_id','application_shenhe_id','application_shenhe_opera_id']));
    }
    /**
     * 2003 提交审批
     *
     * @access public
     * @return void
     */
    public function submit() {
        if (!is_array($this->application)){
            return $this->application;
        }
        $check=$this->check($this->data['application_shenhe_id']);
        if (!is_array($check)){
            return $check;
        }
        $checkOpera=$this->checkOpera($this->data['application_shenhe_opera_id']);
        if (!is_array($checkOpera)){
            return $checkOpera;
        }
        $application_shenhe=array_except($this->data,['uid','application_control_id','application_shenhe_id','application_shenhe_opera_id','shenhe_sug','sub_shenpi_remark','shenhe_end_reason','shenhe_end_remark','return_file','shenhe_return_reason','shenhe_return_remark','other_check','other_check_remark']);
        if($this->is_array_empty($application_shenhe)){
            $endTime = $this->getCurrentTime();
            $spend_time = $endTime-$this->startTime;
            $spend_time = round($spend_time,13);//小数点位数13
            return $this->response($spend_time,400, '填写信息不全', []);
        }
        $application_shenhe_opera=array_only($this->data,['shenhe_sug','sub_shenpi_remark']);
        if($this->is_array_empty($application_shenhe_opera)){
            $endTime = $this->getCurrentTime();
            $spend_time = $endTime-$this->startTime;
            $spend_time = round($spend_time,13);//小数点位数13
            return $this->response($spend_time,400, '填写信息不全', []);
        }
        $application_control=$this->application['data']['application_control'];
        switch ($application_control['state']){
            case 2:
                $appUpdate=$this->applicationUpdate([
                    'application_control_id'=>$this->data['application_control_id'],
                    'state'=>4
                ]);
                if (!is_array($appUpdate)){
                    return $appUpdate;
                }
                $logCreate=$this->createLog([
                    'table_name'=>'application_control',
                    'change_field'=>'state',
                    'before_value'=>2,
                    'after_value'=>4,
                    'uid'=>$this->data['uid'],
                    'pri_key'=>'application_control_id'
                ]);
                if (!is_array($logCreate)){
                    return $logCreate;
                }
                break;
            case 10:
                $appUpdate=$this->applicationUpdate([
                    'application_control_id'=>$this->data['application_control_id'],
                    'state'=>19
                ]);
                if (!is_array($appUpdate)){
                    return $appUpdate;
                }
                $logCreate=$this->createLog([
                    'table_name'=>'application_control',
                    'change_field'=>'state',
                    'before_value'=>10,
                    'after_value'=>19,
                    'uid'=>$this->data['uid'],
                    'pri_key'=>'application_control_id'
                ]);
                if (!is_array($logCreate)){
                    return $logCreate;
                }
                break;
            default:
                $endTime = $this->getCurrentTime();
                $spend_time = $endTime-$this->startTime;
                $spend_time = round($spend_time,13);//小数点位数13
                return $this->response($spend_time,400, '审核状态错误', ['state'=>$application_control['state']]);
                break;
        }
        $update_time=date('Y-m-d H:i:s',time());
        $appUpdate=$this->applicationUpdate([
            'application_control_id'=>$this->data['application_control_id'],
            'shenhe_sub_time'=>$update_time
        ]);
        if (!is_array($appUpdate)){
            return $appUpdate;
        }
        $logCreate=$this->createLog([
            'table_name'=>'application_control',
            'change_field'=>'shenhe_sub_time',
            'before_value'=>$application_control['shenhe_sub_time'],
            'after_value'=>$update_time,
            'uid'=>$this->data['uid'],
            'pri_key'=>'application_control_id'
        ]);
        if (!is_array($logCreate)){
            return $logCreate;
        }
        $checkOperaUpdate=$this->checkOperaUpdate([
            'application_shenhe_opera_id'=>$this->data['application_shenhe_opera_id'],
            'shenhe_sub_time'=>$update_time
        ]);
        if (!is_array($checkOperaUpdate)){
            return $checkOperaUpdate;
        }
        $logCreate=$this->createLog([
            'table_name'=>'application_shenhe_opera',
            'change_field'=>'shenhe_sub_time',
            'before_value'=>$checkOpera['data']['application_shenhe_opera']['shenhe_sub_time'],
            'after_value'=>$update_time,
            'uid'=>$this->data['uid'],
            'pri_key'=>'application_shenhe_opera_id'
        ]);
        if (!is_array($logCreate)){
            return $logCreate;
        }
        $endTime = $this->getCurrentTime();
        $spend_time = $endTime-$this->startTime;
        $spend_time = round($spend_time,13);//小数点位数13
        return $this->response($spend_time,200, '操作成功', array_only($this->data,['application_control_id','application_shenhe_id','application_shenhe_opera_id']));
    }
    /**
     * 2004 审核拒绝
     *
     * @access public
     * @return void
     */
    public function reject() {
        $ope_time=date('Y-m-d H:i:s',time());
        if (!is_array($this->application)){
            return $this->application;
        }
        if($this->is_array_empty(array_only($this->data,['shenhe_sug','shenhe_end_reason','shenhe_end_remark']))){
            $endTime = $this->getCurrentTime();
            $spend_time = $endTime-$this->startTime;
            $spend_time = round($spend_time,13);//小数点位数13
            return $this->response($spend_time,400, '填写信息不全', []);
        }
        $application_control=$this->application['data']['application_control'];
        switch ($application_control['state']){
            case 2:
                ApplicationControl::find($this->data['application_control_id'])->update([
                    'state'=>8
                ]);
                Log::create([
                    'table_name'=>'application_control',
                    'change_field'=>'state',
                    'before_value'=>2,
                    'after_value'=>8,
                    'create_time'=>$ope_time,
                    'uid'=>$this->data['uid']
                ]);
                break;
            case 10:
                ApplicationControl::find($this->data['application_control_id'])->update([
                    'state'=>8
                ]);
                Log::create([
                    'table_name'=>'application_control',
                    'change_field'=>'state',
                    'before_value'=>10,
                    'after_value'=>8,
                    'create_time'=>$ope_time,
                    'uid'=>$this->data['uid']
                ]);
                break;
            default:
                $endTime = $this->getCurrentTime();
                $spend_time = $endTime-$this->startTime;
                $spend_time = round($spend_time,13);//小数点位数13
                return $this->response($spend_time,400, '审核状态错误', ['state'=>$application_control['state']]);
                break;
        }
        $end_time=date('Y-m-d H:i:s',time());
        Log::create([
            'table_name'=>'application_control',
            'change_field'=>'shenhe_sub_time',
            'before_value'=>ApplicationControl::find($this->data['application_control_id'])->shenhe_sub_time,
            'after_value'=>$end_time,
            'create_time'=>$end_time,
            'uid'=>$this->data['uid']
        ]);
        $bool_control=ApplicationControl::find($this->data['application_control_id'])->update([
            'end_time'=>$end_time
        ]);
        $bool_shenhe_opera=ApplicationShenheOpera::find($this->data['application_shenhe_opera_id'])
            ->update(array_except($this->data,['application_control_id','uid','application_shenhe_opera_id']));
        $endTime = $this->getCurrentTime();
        $spend_time = $endTime-$this->startTime;
        $spend_time = round($spend_time,13);//小数点位数13
        if(!($bool_control || $bool_shenhe_opera)){
            return $this->response($spend_time,400, '更新操作失败', []);
        }
        return $this->response($spend_time,200, '操作成功', array_only($this->data,['application_control_id','application_shenhe_id','application_shenhe_opera_id']));
    }
    /**
     * 2005 点击“审批租车”
     *
     * @access public
     * @return void
     */
    public function approve() {
        $ope_time=date('Y-m-d H:i:s',time());
        if (!is_array($this->application)){
            return $this->application;
        }
        $application_control=$this->application['data']['application_control'];
        switch ($application_control['state']){
            case 4:
                ApplicationControl::find($this->data['application_control_id'])->update([
                    'state'=>5
                ]);
                Log::create([
                    'table_name'=>'application_control',
                    'change_field'=>'state',
                    'before_value'=>4,
                    'after_value'=>5,
                    'create_time'=>$ope_time,
                    'uid'=>$this->data['uid']
                ]);
                ApplicationShenpiOpera::create([
                    'shenpi_start'=>$ope_time,
                    'application_control_id'=>$this->data['application_control_id'],
                    'shenpi_uid'=>$this->data['uid']
                ]);
                break;
            case 19:
                ApplicationControl::find($this->data['application_control_id'])->update([
                    'state'=>20
                ]);
                Log::create([
                    'table_name'=>'application_control',
                    'change_field'=>'state',
                    'before_value'=>19,
                    'after_value'=>20,
                    'create_time'=>$ope_time,
                    'uid'=>$this->data['uid']
                ]);
                ApplicationShenpiOpera::create([
                    'shenpi_start'=>$ope_time,
                    'application_control_id'=>$this->data['application_control_id'],
                    'shenpi_uid'=>$this->data['uid']
                ]);
                break;
            case 5:
                break;
            case 20:
                break;
            default:
                $endTime = $this->getCurrentTime();
                $spend_time = $endTime-$this->startTime;
                $spend_time = round($spend_time,13);//小数点位数13
                return $this->response($spend_time,400, '审批状态错误', ['state'=>$application_control['state']]);
                break;
        }
        $endTime = $this->getCurrentTime();
        $spend_time = $endTime-$this->startTime;
        $spend_time = round($spend_time,13);//小数点位数13
        return $this->response($spend_time,200, '操作成功', $this->data);
    }
    /**
     * 2006 审批通过
     *
     * @access public
     * @return void
     */
    public function pass() {
        $ope_time=date('Y-m-d H:i:s',time());
        if (!is_array($this->application)){
            return $this->application;
        }
        $application_control=$this->application['data']['application_control'];
        if($this->is_array_empty(array_only($this->data,['shenpi_sug','car_effect','carcondition','risk','shenpi_pass_remark']))){
            $endTime = $this->getCurrentTime();
            $spend_time = $endTime-$this->startTime;
            $spend_time = round($spend_time,13);//小数点位数13
            return $this->response($spend_time,400, '填写信息不全', ['state'=>$application_control['state']]);
        }
        switch ($application_control['state']){
            case 5:
                ApplicationControl::find($this->data['application_control_id'])->update([
                    'state'=>6
                ]);
                Log::create([
                    'table_name'=>'application_control',
                    'change_field'=>'state',
                    'before_value'=>5,
                    'after_value'=>6,
                    'create_time'=>$ope_time,
                    'uid'=>$this->data['uid']
                ]);
                break;
            case 20:
                ApplicationControl::find($this->data['application_control_id'])->update([
                    'state'=>6
                ]);
                Log::create([
                    'table_name'=>'application_control',
                    'change_field'=>'state',
                    'before_value'=>20,
                    'after_value'=>6,
                    'create_time'=>$ope_time,
                    'uid'=>$this->data['uid']
                ]);
                break;
            default:
                $endTime = $this->getCurrentTime();
                $spend_time = $endTime-$this->startTime;
                $spend_time = round($spend_time,13);//小数点位数13
                return $this->response($spend_time,400, '当前状态有误', ['state'=>$application_control['state']]);
        }
        $update_time=date('Y-m-d H:i:s',time());
        ApplicationControl::find($this->data['application_control_id'])->update([
            'shepi_sub_time'=>$update_time
        ]);
    }
    /**
     * 2007 审批拒绝
     *
     * @access public
     * @return void
     */
    public function refuse() {
        $ope_time=date('Y-m-d H:i:s',time());
        if (!is_array($this->application)){
            return $this->application;
        }
    }
    /**
     * 2008 审批退回审核
     *
     * @access public
     * @return void
     */
    public function review() {
        $ope_time=date('Y-m-d H:i:s',time());
        if (!is_array($this->application)){
            return $this->application;
        }
    }
}