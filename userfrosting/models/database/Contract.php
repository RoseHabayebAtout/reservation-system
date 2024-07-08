<?php

namespace UserFrosting;

use \Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

class Contract extends UFModel {

    protected static $_table_id = "contracts";
    protected $appends = [
        'templateName'
    ];


    public function getTemplateNameAttribute()
    {
        $data = ContractTemplate::where("id",$this->attributes['template_id'])->first();
        return isset($data) ? $data->templateName : 'اتفاقية بيع وشراء وحدة سكنية';
    }
}
