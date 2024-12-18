<?php

namespace App\Livewire;

use Livewire\Component;

class Sidebar extends Component {
    public $currentMenu = '';

    public function mount() {
        $user_id = session()->get('user_id');

        if (!isset($user_id)) {
            return redirect()->to('/');
        }

        $this->currentMenu = session()->get('current_menu') ?? '';
    }

    public function changeMenu($menu) {
        session()->put('current_menu', $menu);
        $this->currentMenu = $menu;

        return redirect()->to('/' . $menu);
    }

    public function render() {
        return view('livewire.sidebar');
    }
}
