<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApplicationControl extends Model
{
    protected $table='application_control';

    protected $primaryKey='application_control_id';
    //开启白名单字段
    protected $guarded = [];
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    public $timestamps = true;
}
