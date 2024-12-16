<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerModel;
use App\Models\RoomModel;

class BillingModel extends Model
{
    protected $table = 'billings';

    protected $fillable = [
        'room_id', 'remark', 'status', 'amount_rent', 
        'created_at', 'amount_water', 'amount_electric', 'amount_internet',
        'amount_fitness', 'amount_wash', 'amount_bin', 'amount_etc',
        'money_added'
    ];

    public $timestamps = false;

    public function room() {
        return $this->belongsTo(RoomModel::class, 'room_id', 'id');
    }

    public function getCustomer() {
        return CustomerModel::where('room_id', $this->room_id)->first();
    }

    public function sumAmount() {
        return $this->amount_rent + $this->amount_water + $this->amount_electric 
        + $this->amount_internet + $this->amount_fitness + $this->amount_wash 
        + $this->amount_bin + $this->amount_etc;
    }

    public function getStatusName() {
        switch ($this->status) {
            case 'wait': return 'รอชำระเงิน';
            case 'paid': return 'ชำระเงินแล้ว';
            case 'next': return 'ขอค้างจ่าย';
        }
    }
}
