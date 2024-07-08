<?php
        
namespace UserFrosting;

use \Illuminate\Database\Capsule\Manager as Capsule;

class Payments1 extends UFModel {

    protected static $_table_id = "payments1";

	public function units(){
	    $link_table = Database::getSchemaTable('payments1_unit')->name;
	    return $this->belongsToMany('UserFrosting\Unit', $link_table);
	}
	public function getUnits($unit_id){
	    $link_table = Database::getSchemaTable('payments1_unit')->name;
        return Capsule::table($link_table)->where("unit_id",$unit_id)->get();
	}
}