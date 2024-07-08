<?php
        
namespace UserFrosting;

use \Illuminate\Database\Capsule\Manager as Capsule;

class Checkbook extends UFModel {

    protected static $_table_id = "checkbook";
    
	public function units(){
	    $link_table = Database::getSchemaTable('checkbook_unit')->name;
	    return $this->belongsToMany('UserFrosting\Unit', $link_table);
	}
}