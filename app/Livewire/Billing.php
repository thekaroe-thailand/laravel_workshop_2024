<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BillingModel;
use App\Models\CustomerModel;
use App\Models\RoomModel;

class Billing extends Component {
    public $showModal = false;
    public $showModalDelete = false;
    public $rooms = [];
    public $billings = [];
    public $id;
    public $roomId;
    public $remark;
    public $createdAt;
    public $status;
    public $amountRent;
    public $amountWater;
    public $amountElectric;
    public $amountInternet;
    public $amountFitness;
    public $amountWash;
    public $amountBin;
    public $amountEtc;
    public $customerName;
    public $customerPhone;
    public $listStatus = [
        ['status' => 'wait', 'name' => 'รอชำระเงิน'],
        ['status' => 'paid', 'name' => 'ชำระเงินแล้ว'],
        ['status' => 'next', 'name' => 'ขอค้างจ่าย'],
    ];
    public $sumAmount = 0;
    public $roomForDelete;

    public function mount() {
        $this->fetchData();
        $this->createdAt = date('Y-m-d');
        $this->status = 'wait';
    }

    public function fetchData() {
        $this->rooms = RoomModel::where('is_empty', 'no')
            ->where('status', 'use')
            ->orderBy('id', 'desc')
            ->get();

        $this->billings = BillingModel::orerBy('id', 'desc')->get();
        $roomNoBilling = [];

        foreach ($this->rooms as $room) {
            foreach ($this->billings as $billing) {
                if ($billing->room_id == $room->id) {
                    $roomNoBilling[] = $room;
                }
            }
        }

        $this->rooms = $roomNoBilling;
    }

    public function render() {
        return view('livewire.billing');
    }

    public function openModal() {
        $this->showModal = true;
    }

    public function closeModal() {
        $this->showModal = false;
    }

    public function selectedRoom() {
        $room = RoomModel::find($this->roomId);
        $customer = CustomerModel::where('room_id', $this->roomId)->first();
        
        $this->customerName = $customer->name;
        $this->customerPhone = $customer->phone;
        $this->amountRent = $room->amount_rent;

        $this->computeSumAmount();
    }

    public function computeSumAmount() {
        $this->sumAmount = $this->amountRent + $this->amountWater + $this->amountElectric 
        + $this->amountInternet + $this->amountFitness + $this->amountWash 
        + $this->amountBin + $this->amountEtc;
    }

    public function save() {
        $billing = new BillingModel();

        if ($this->id != null) {
            $billing = BillingModel::find($this->id);
        }
        $billing->room_id = $this->roomId;
        $billing->created_at = $this->createdAt;
        $billing->status = $this->status;
        $billing->remark = $this->remark;
        $billing->amount_rent = $this->amountRent;
        $billing->amount_water = $this->amountWater;
        $billing->amount_electric = $this->amountElectric;
        $billing->amount_internet = $this->amountInternet;
        $billing->amount_fitness = $this->amountFitness;
        $billing->amount_wash = $this->amountWash;
        $billing->amount_bin = $this->amountBin;
        $billing->amount_etc = $this->amountEtc;
        $billing->save();

        $this->fetchData();
        $this->closeModal();

        $this->id = null;
    }
}
