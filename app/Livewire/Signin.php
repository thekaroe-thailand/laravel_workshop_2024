<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class Signin extends Component
{
    public $username;
    public $password;
    public $errorUsername;
    public $errorPassword;
    public $error = null;

    public function signin() {
        $this->errorUsername = null;
        $this->errorPassword = null;

        $validator = Validator::make([
            'username' => $this->username,
            'password' => $this->password
        ], [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            $this->errorUsername = $validator->errors()->get('username')[0] ?? null;
            $this->errorPassword = $validator->errors()->get('password')[0] ?? null;
        } else {
            $user = User::where('name', $this->username)
            ->where('password', $this->password)
            ->first();

            if (!$user) {
                $this->error = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
            } else {
                session()->put('user_id', $user->id);
                session()->put('user_name', $user->name);
                
                $this->redirect('/dashboard');
            }
        }
    }

    public function render()
    {
        return view('livewire.signin');
    }
}
