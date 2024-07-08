<?php

namespace UserFrosting;

use \Illuminate\Database\Capsule\Manager as Capsule;

class Unit extends UFModel {

    protected static $_table_id = "unit";

    public $appenix = [
        'Reservation Receipt',
        'Appendix/Storage',
        'Appendix/Parking',
        'Appendix/Payment',
    ];

	public function reservations($unit_id){

	    $link_table = Database::getSchemaTable('reservation_unit')->name;
        return Capsule::table($link_table)->where("unit_id",$unit_id)->get();

	}
	public function reservationsRel(){
	    $link_table = Database::getSchemaTable('reservation_unit')->name;
	    return $this->belongsToMany('UserFrosting\Reservation', $link_table);
	}
	public function checkbooks($unit_id){

	    $link_table = Database::getSchemaTable('checkbook_unit')->name;
        return Capsule::table($link_table)->where("unit_id",$unit_id)->get();

	}
	public function contracts1($unit_id){

	    $link_table = Database::getSchemaTable('contract1_unit')->name;
        return Capsule::table($link_table)->where("unit_id",$unit_id)->get();

	}

    public function contract1()
    {
        $link_table = Database::getSchemaTable('contract1_unit')->name;
        return $this->belongsToMany('UserFrosting\Contract1', $link_table);
    }

    public function contract2()
    {
        $link_table = Database::getSchemaTable('contract2_unit')->name;
        return $this->belongsToMany('UserFrosting\Contract2', $link_table);
    }

	public function contracts2($unit_id){

	    $link_table = Database::getSchemaTable('contract2_unit')->name;
        return Capsule::table($link_table)->where("unit_id",$unit_id)->get();

	}
	public function contracts3($unit_id){

	    $link_table = Database::getSchemaTable('contract3_unit')->name;
        return Capsule::table($link_table)->where("unit_id",$unit_id)->get();

	}
	public function payments(){
        return $this->hasMany(Payment::class, 'unit_id', 'id');
	}

	public function payments1Delete($unit_id){
        return Capsule::table('payments')->where("unit_id",$unit_id)->delete();
	}

    public function contractsDelete($unit_id){
        return Capsule::table('contracts')->where("unit_id",$unit_id)->delete();
    }

    public function contract(){
        return $this->hasOne(Contract::class, 'unit_id', 'id')->where('type', 'purchase_contract')->where('status', 'ACTIVE');
    }

}
