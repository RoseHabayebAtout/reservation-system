<?php
namespace UserFrosting;

use \Illuminate\Database\Capsule\Manager as Capsule;

class parking_storage_reservation extends UFModel {

    protected static $_table_id = "parking_storage_reservation";

    public function unit()
    {
        return $this->hasOne(Unit::class, 'id', 'uid')->with('reservationsRel');
    }

    public function payments()
    {
        return $this->hasMany(ParkingStoragePayment::class, 'target_id', 'parking_storage_id');

    }

    public function parking()
    {
        return $this->hasOne(Parking::class, 'id', 'parking_storage_id');
    }

    public function storage()
    {
        return $this->hasOne(Storage::class, 'id', 'parking_storage_id');
    }


}
