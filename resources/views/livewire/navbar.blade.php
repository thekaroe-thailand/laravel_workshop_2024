<div class="navbar">
    <div class="flex items-center justify-between">
        <div>
            <i class="fa-solid fa-user me-2"></i>
            <span class="username">{{ $user_name }}</span>
        </div>
        <div>
            <button wire:click="editProfile"
                class="border border-blue-400 text-blue-400 hover:bg-blue-400 hover:text-white px-6 py-3 rounded-2xl mr-2">
                <i class="fa-solid fa-user me-2"></i>
                แก้ไขข้อมูล
            </button>
            <button wire:click="showModal = true"
                class="border border-orange-400 text-orange-400 hover:bg-orange-400 hover:text-white px-6 py-3 rounded-2xl">
                <i class="fa-solid fa-sign-out-alt ms-2"></i>
                ออกจากระบบ
            </button>
        </div>
    </div>

    <x-modal wire:model="showModal" maxWidth="sm" title="ออกจากระบบ">
        <div class="text-center">
            <div><i class="fa-solid fa-question text-red-500 text-5xl"></i></div>
            <div class="text-3xl font-bold text-gray-800 mt-3">ออกจากระบบ</div>
            <div class="text-gray-800 mt-3 text-2xl">คุณต้องการออกจากระบบหรือไม่</div>
        </div>
        <div class="flex justify-center mt-6 pb-4">
            <button class="btn-danger mr-2" wire:click="logout">
                <i class="fa-solid fa-check"></i>
                ยืนยัน
            </button>
            <button class="btn-secondary" wire:click="showModal = false">
                <i class="fa-solid fa-xmark"></i>
                ยกเลิก
            </button>
        </div>
    </x-modal>

    <x-modal wire:model="showModalEdit" maxWidth="sm" title="แก้ไขข้อมูลส่วนตัว">
        @if ($errors->any())
            <div class="alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div>Username</div>
        <input type="text" wire:model="username" class="form-control">

        <div class="mt-3">Password ใหม่</div>
        <input type="password" wire:model="password" class="form-control">

        <div class="mt-3">ยืนยันPassword ใหม่</div>
        <input type="password" wire:model="password_confirm" class="form-control">

        <div class="flex justify-center mt-6 pb-4">
            <button class="btn-success mr-2" wire:click="updateProfile">
                <i class="fa-solid fa-check mr-2"></i>
                ยืนยัน
            </button>
            <button class="btn-secondary" wire:click="showModalEdit = false">
                <i class="fa-solid fa-xmark mr-2"></i>
                ยกเลิก
            </button>
        </div>

        @if ($saveSuccess)
            <div class="alert alert-success">
                <i class="fa-solid fa-check mr-2"></i>
                บันทึกข้อมูลสำเร็จ
            </div>
        @endif
    </x-modal>
</div>
