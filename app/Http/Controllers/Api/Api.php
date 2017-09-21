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
     * 2001 点击“审核租车”
     *
     * @access public
     * @return void
     */
    public function get() {
//        dd($this->data['uid']);
        $ope_time=date('Y-m-d H:i:s',time());
        if (!is_array($this->application)){
            return $this->application;
        }
        $application_control=$this->application['data']['application_control'];
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
        $ope_time=date('Y-m-d H:i:s',time());
        if (!is_array($this->application)){
            return $this->application;
        }
    }
    /**
     * 2003 提交审批
     *
     * @access public
     * @return void
     */
    public function submit() {
        $ope_time=date('Y-m-d H:i:s',time());
        if (!is_array($this->application)){
            return $this->application;
        }
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