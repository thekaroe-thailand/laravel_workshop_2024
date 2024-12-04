<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayLogModel extends Model
{
    protected $table = 'pay_logs';
    protected $fillable = ['pay_id', 'amount', 'pay_date', 'status'];

    public $timestamps = false;

    public function pay() {
        return $this->belongsTo(PayModel::class, 'pay_id', 'id');
    }
}
