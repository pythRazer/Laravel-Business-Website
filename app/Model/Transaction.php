<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $table = 'transaction';
    protected $primaryKey = 'id';
    protected $fillable = [
        "id",
        "user_id",
        "merchandise_id",
        "price",
        "buy_count",
        "total_price",

    ];

    public function Merchandise(){
        return $this->hasOne('App\Model\Merchandise', 'id', 'merchandise_id');

    }
}
