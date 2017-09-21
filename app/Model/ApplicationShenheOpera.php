<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApplicationShenheOpera extends Model
{
    protected $table='application_shenhe_opera';

    protected $primaryKey='application_shenhe_opera_id';
    //开启白名单字段
    protected $guarded = [];
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    public $timestamps = true;
}
