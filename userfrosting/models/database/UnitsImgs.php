<?php
        
namespace UserFrosting;

use \Illuminate\Database\Capsule\Manager as Capsule;

class UnitsImgs extends UFModel {

    protected static $_table_id = "units_images";

    protected $with = ['image'];

    public function image(){
        return $this->hasOne(UploadedFiles::class, 'id', 'img_id');
    }

}