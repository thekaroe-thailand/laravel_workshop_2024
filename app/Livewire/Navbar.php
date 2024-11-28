<?php 

namespace App\Livewire;

use Livewire\Component;

class Navbar extends Component {
    public $user_name;
    public $showModal = false;

    public function mount() {
        $this->user_name = session()->get('user_name');
    }

    public function logout() {
        session()->flush();
        $this->redirect('/');
    }

    public function render() {
        return view('livewire.navbar');
    }
}
