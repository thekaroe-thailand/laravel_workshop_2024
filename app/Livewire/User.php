<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class User extends Component {
    public $showModal = false;
    public $showModalDelete = false;
    public $id;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $level = 'user';
    public $listLevel = ['user', 'admin'];
    public $listUser = [];
    public $error = null;
    public $errorList = [];
    public $nameForDelete = null;

    public function mount() {
        $this->fetchData();
    }

    public function fetchData() {
        $this->listUser = UserModel::all();
    }

    public function openModal() {
        $this->showModal = true;
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->password_confirmation = null;
        $this->level = 'user';
    }

    public function closeModal() {
        $this->showModal = false;
    }   

    public function save() {
        if ($this->password  != $this->password_confirmation) {
            $this->error = 'รหัสผ่านไม่ตรงกัน';
            return;
        }

        $user = new UserModel();
        $password = Hash::make($this->password);

        if ($this->id != null) {
            $user = UserModel::find($this->id);

            if ($this->password != null) {
                $user->password = $password;
            } else {
                $user->password = $user->password;
            }
        } else {
            $user->password = $password;
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->level = $this->level;
        $user->save();

        $this->fetchData();
        $this->closeModal();
    }

    public function openModalEdit($id) {
        $this->id = $id;
        $this->showModal = true;
    }

    public function closeModalEdit() {
        $this->showModal = false;
    }

    public function openModalDelete($id, $name) {
        $this->id = $id;
        $this->nameForDelete = $name;
        $this->showModalDelete = true;
    }

    public function closeModalDelete() {
        $this->showModalDelete = false;
    }

    public function delete() {
        UserModel::find($this->id)->delete();
        $this->fetchData();
        $this->closeModalDelete();
    }

    public function render() {
        return view('livewire.user');
    }
}
