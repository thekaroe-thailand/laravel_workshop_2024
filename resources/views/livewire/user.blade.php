<div>
    <div class="content-header">ผู้ใช้งาน</div>
    <div class="content-body">
        <button class="btn-info" wire:click="openModal">
            <i class="fa fa-plus mr-2"></i>
            เพิ่มผู้ใช้งาน
        </button>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th class="text-left" width="200px">ชื่อ</th>
                    <th class="text-left">อีเมล</th>
                    <th class="text-left" width="80px">level</th>
                    <th class="text-center" width="130px">วันที่สร้าง</th>
                    <th width="130px"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listUser as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->level }}</td>
                        <td class="text-center">{{ date('d/m/Y', strtotime($user->created_at)) }}</td>
                        <td class="text-center">
                            <button class="btn-edit" wire:click="openModalEdit({{ $user->id }})">
                                <i class="fa fa-pencil mr-2"></i>
                            </button>
                            <button class="btn-delete"
                                wire:click="openModalDelete({{ $user->id }}, '{{ $user->name }}')">
                                <i class="fa fa-times mr-2"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-modal wire:model="showModal" title="ผู้ใช้งาน">
        @if (isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endif

        <div>ชื่อ</div>
        <input type="text" class="form-control" wire:model="name">

        <div class="mt-3">อีเมล</div>
        <input type="text" class="form-control" wire:model="email">

        <div class="flex mt-3 gap-2">
            <div class="w-1/2">
                <div>รหัสผ่าน</div>
                <input type="password" class="form-control" wire:model="password">
            </div>
            <div class="w-1/2">
                <div>ยืนยันรหัสผ่าน</div>
                <input type="password" class="form-control" wire:model="password_confirmation">
            </div>
        </div>

        <div class="mt-3">level</div>
        <select class="form-control" wire:model="level">
            @foreach ($listLevel as $level)
                <option value="{{ $level }}">{{ $level }}</option>
            @endforeach
        </select>

        <div class="mt-4 text-center">
            <button class="btn-success" wire:click="save">
                <i class="fa fa-check mr-2"></i>
                บันทึก
            </button>
            <button class="btn-secondary" wire:click="closeModal">
                <i class="fa fa-times mr-2"></i>
                ยกเลิก
            </button>
        </div>
    </x-modal>

    <x-modal-confirm showModalDelete="showModalDelete" title="ยืนยันการลบ"
        text="คุณต้องการลบผู้ใช้งาน {{ $nameForDelete }} หรือไม่?" clickConfirm="delete"
        clickCancel="closeModalDelete" />
</div>
