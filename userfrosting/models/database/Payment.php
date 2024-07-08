<?php

namespace UserFrosting;

use \Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Eloquent\Model;

class Payment extends UFModel {

    protected static $_table_id = "payments";

    public function unit(){
        return $this->belongsTo('UserFrosting\Unit');
    }

}
