<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\BillingModel;
use App\Models\CustomerModel;
use App\Models\RoomModel;
use App\Models\OrganizationModel;
use Illuminate\Support\Facades\Log;

class Billing extends Component {
    public $showModal = false;
    public $showModalDelete = false; 
    public $showModalGetMoney = false;
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
    public $waterUnit = 0;
    public $electricUnit = 0;
    public $waterCostPerUnit = 0;
    public $electricCostPerUnit = 0;
    public $roomNameForEdit = '';

    // get money
    public $roomNameForGetMoney = '';
    public $customerNameForGetMoney = '';
    public $payedDateForGetMoney = '';
    public $moneyAdded = 0;
    public $remarkForGetMoney = '';
    public $sumAmountForGetMoney = 0;
    public $amountForGetMoney = 0;

    public function mount() {
        $this->fetchData();
        $this->createdAt = date('Y-m-d');
        $this->status = 'wait';
    }

    public function fetchData() {
        $customers = CustomerModel::where('status', 'use')->get();
        $rooms = [];

        $this->billings = BillingModel::orderBy('id', 'desc')->get();

        foreach ($customers as $customer) {
            $isBilling = false;

            foreach ($this->billings as $billing) {
                if ($billing->room_id == $customer->room_id) {
                    $isBilling = true;
                    break;
                }
            }

            if (!$isBilling) {
                $rooms[] = [
                    'id' => $customer->room_id, 
                    'name' => $customer->room->name
                ];
            }
        }

        $this->rooms = $rooms;
        
        if (count($rooms) > 0) {
            $this->roomId = $rooms[0]['id'];
            $this->selectedRoom();
        }
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
        $organization = OrganizationModel::first();

        if ($organization->amount_water > 0) {
            $this->amountWater = $organization->amount_water;
        } else {
            $this->waterCostPerUnit = $organization->amount_water_per_unit;
        }

        if ($organization->amount_electric_per_unit > 0) {
            $this->electricCostPerUnit = $organization->amount_electric_per_unit;
        }

        $this->amountInternet = $organization->amount_internet;
        $this->amountEtc = $organization->amount_etc;
        
        $this->customerName = $customer->name;
        $this->customerPhone = $customer->phone;
        $this->amountRent = $room->price_per_month;

        $this->computeSumAmount();
    }

    public function computeSumAmount() {
        if ($this->waterUnit > 0) {
            $this->amountWater = $this->waterUnit * $this->waterCostPerUnit;
        }

        if ($this->electricUnit > 0) {
            $this->amountElectric = $this->electricUnit * $this->electricCostPerUnit;
        }

        $this->amountWater = $this->amountWater ?? 0;
        $this->amountElectric = $this->amountElectric ?? 0;

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
        $billing->remark = $this->remark ?? '';
        $billing->amount_rent = $this->amountRent ?? 0;
        $billing->amount_water = $this->amountWater ?? 0;
        $billing->amount_electric = $this->amountElectric ?? 0;
        $billing->amount_internet = $this->amountInternet ?? 0;
        $billing->amount_fitness = $this->amountFitness ?? 0;
        $billing->amount_wash = $this->amountWash ?? 0;
        $billing->amount_bin = $this->amountBin ?? 0;
        $billing->amount_etc = $this->amountEtc ?? 0;
        $billing->save();

        $this->fetchData();
        $this->closeModal();

        $this->id = null;
        $this->waterUnit = 0;
        $this->electricUnit = 0;
        $this->electricCostPerUnit = 0;
        $this->waterCostPerUnit = 0;
    }

    public function openModalEdit($id) {
        $this->showModal = true;
        $this->billing = BillingModel::find($id);
        $this->id = $id;
        $this->roomId = $this->billing->room_id;

        $this->selectedRoom();
        $this->amountWater = $this->billing->amount_water;
        $this->amountElectric = $this->billing->amount_electric;

        $this->roomNameForEdit = $this->billing->room->name;
    
        $organization = OrganizationModel::first();    
        $this->waterUnit = $this->amountWater / $organization->amount_water_per_unit;
        $this->electricUnit = $this->amountElectric / $organization->amount_electric_per_unit;

        $this->computeSumAmount();
    }

    public function closeModalEdit() {
        $this->showModal = false;
    }

    public function openModalDelete($id, $name) {
        $this->showModalDelete = true;
        $this->id = $id;
        $this->roomForDelete = $name;
    }

    public function closeModalDelete() {
        $this->showModalDelete = false;
    }

    public function deleteBilling() {
        $billing = BillingModel::find($this->id);
        $billing->delete();

        $this->fetchData();
        $this->closeModalDelete();
    }

    public function openModalGetMoney($id) {
        $billing = BillingModel::find($id);
        $this->showModalGetMoney = true;
        $this->id = $id;
        $this->roomNameForGetMoney = $billing->room->name;
        $this->customerNameForGetMoney = $billing->getCustomer()->name;
        $this->sumAmountForGetMoney = $billing->sumAmount();
        $this->payedDateForGetMoney = date('Y-m-d');
        $this->moneyAdded = $billing->money_added ?? 0;
        $this->remarkForGetMoney = $billing->remark ?? '';
        $this->amountForGetMoney = $this->sumAmountForGetMoney + $this->moneyAdded;
    }

    public function closeModalGetMoney() {
        $this->showModalGetMoney = false;
        $this->id = null;
        $this->roomNameForGetMoney = '';
        $this->customerNameForGetMoney = '';
        $this->sumAmountForGetMoney = 0;
        $this->payedDateForGetMoney = '';
        $this->moneyAdded = 0;
        $this->remarkForGetMoney = '';
        $this->amountForGetMoney = 0;
    }

    public function handleChangeAmountForGetMoney() {
        $billing = BillingModel::find($this->id);
        $this->moneyAdded = $this->moneyAdded == '' ? 0 : $this->moneyAdded;
        $this->amountForGetMoney = $billing->sumAmount() + $this->moneyAdded;
    }

    public function printBilling($billingId) {
        return redirect()->to('print-billing/' . $billingId);
    }

    public function saveGetMoney() {
        $billing = BillingModel::find($this->id);
        $billing->payed_date = $this->payedDateForGetMoney;
        $billing->remark = $this->remarkForGetMoney;
        $billing->money_added = $this->moneyAdded;
        $billing->status = 'paid';
        $billing->save();

        $this->fetchData();
        $this->closeModalGetMoney();
    }
}
