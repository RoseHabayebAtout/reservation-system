<?php
        
namespace UserFrosting;

use \Illuminate\Database\Capsule\Manager as Capsule;

class Reservation extends UFModel {

    protected static $_table_id = "reservation";

	public function units(){
	    $link_table = Database::getSchemaTable('reservation_unit')->name;
	    return $this->belongsToMany('UserFrosting\Unit', $link_table);
	}
	public function users(){
	    $link_table = Database::getSchemaTable('reservation_user')->name;
	    return $this->belongsToMany('UserFrosting\User', $link_table);
	}
	public function getUsers($user_id){
	    $link_table = Database::getSchemaTable('reservation_user')->name;
        return Capsule::table($link_table)->where("user_id",$user_id)->get();
	}
	public function getUnits($unit_id){
	    $link_table = Database::getSchemaTable('reservation_unit')->name;
        return Capsule::table($link_table)->where("unit_id",$unit_id)->get();

	}
}