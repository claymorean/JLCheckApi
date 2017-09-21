<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ApplicationShenpiOpera extends Model
{
    protected $table='application_shenpi_opera';

    protected $primaryKey='application_shenpi_opera_id';
    //开启白名单字段
    protected $guarded = [];
    const CREATED_AT = 'create_time';
    const UPDATED_AT = 'update_time';
    public $timestamps = true;
}
