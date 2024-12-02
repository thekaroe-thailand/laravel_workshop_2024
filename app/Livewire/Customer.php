<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\CustomerModel;
use App\Models\RoomModel;

class Customer extends Component {
    public $customers = [];
    public $rooms = [];
    public $showModal = false;
    public $showModalDelete = false;
    public $id;
    public $name;
    public $address;
    public $phone;
    public $remark;
    public $roomId;
    public $createdAt;
    public $stayType; // รายวัน, รายเดือน (d, m)

    public function render() {
        return view('customer');
    }

    public function fetchData() {
        
    }
}
