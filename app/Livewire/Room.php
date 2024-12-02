<?php 

namespace App\Livewire;

use Livewire\Component;
use App\Models\RoomModel;

class Room extends Component {
    public $rooms = [];
    public $showModal = false;
    public $showModalEdit = false;
    public $showModalDelete = false;
    public $id;
    public $name;
    public $price_day;
    public $price_month;
    public $from_number;
    public $to_number;
    public $price_per_day;
    public $price_per_month;
    public $nameForDelete;

    public function mount() {
        $this->fetchData();
    }

    public function openModal() {
        $this->showModal = true;
        $this->from_number = '';
        $this->to_number = '';
        $this->price_per_day = '';
        $this->price_per_month = '';
    }

    public function openModalEdit($id) {
        $this->showModalEdit = true;
        $this->id = $id;

        $room = RoomModel::find($id);
        $this->name = $room->name;
        $this->price_day = $room->price_per_day;
        $this->price_month = $room->price_per_month;
    }

    public function openModalDelete($id) {
        $this->showModalDelete = true;
        $this->id = $id;

        $room = RoomModel::find($id);
        $this->nameForDelete = $room->name;
    }

    public function updateRoom() {
        $room = RoomModel::find($this->id);
        $room->name = $this->name;
        $room->price_per_day = $this->price_day;
        $room->price_per_month = $this->price_month;
        $room->save();

        $this->showModalEdit = false;
        $this->fetchData();
    }

    public function deleteRoom() {
        $room = RoomModel::find($this->id);
        $room->status = 'delete';
        $room->save(); 

        $this->showModalDelete = false;
        $this->fetchData();
    }

    public function fetchData() {
        $this->rooms = RoomModel::where('status', 'use')
        ->orderBy('id', 'asc')
        ->get();
    }

    public function createRoom() {
        $this->validate([
            'from_number' => 'required',
            'to_number' => 'required',
            'price_per_day' => 'required',
            'price_per_month' => 'required',
        ]);

        if ($this->from_number > $this->to_number) {
            $this->addError('from_number', 'ห้องต้องมีค่าน้อยกว่าห้องสุดท้าย');
            return;
        }

        if ($this->to_number > 1000) {
            $this->addError('to_number', 'ห้องสุดท้ายต้องมีค่าน้อยกว่า 1000');
            return;
        }

        for ($i = $this->from_number; $i <= $this->to_number; $i++) {
            $room = new RoomModel();
            $room->name = $i;
            $room->price_per_day = $this->price_per_day;
            $room->price_per_month = $this->price_per_month;
            $room->status = 'use';
            $room->save();
        }

        $this->showModal = false;
        $this->fetchData();
    }

    public function render() {
        return view('livewire.room');
    }
}
