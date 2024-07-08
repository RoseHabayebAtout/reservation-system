<?php

namespace UserFrosting;

use \Illuminate\Database\Capsule\Manager as Capsule;

class CashReceipt extends UFModel {

    protected static $_table_id = "units_cash_receipts";

    public function unit()
    {
        return $this->hasOne(Unit::class, 'id','unit_id')->with('reservationsRel');
    }

    public function cashReceiptPricing()
    {
        return $this->hasMany(CashReceiptPricing::class, 'units_cash_receipts_id', 'id');
    }

    public function cashReceiptFiles()
    {
        return $this->hasMany(CashReceiptFiles::class, 'units_cash_receipts_id', 'id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id','user_id');
    }

    public function relatedTo()
    {
        return $this->hasOne(CashReceipt::class, 'id','related_to')->with('relatedTo');
    }
}
