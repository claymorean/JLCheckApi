<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table='info_log';
    protected $primaryKey='info_log_id';

    //开启白名单字段
    protected $guarded = [];
    public $timestamps = false;
}
