<div>
    <div class="content-header">
        <div class="flex justify-between">
            <div>ห้องพัก</div>
            <div>ทั้งหมด <strong>{{ $rooms->count() }}</strong> ห้อง</div>
        </div>
    </div>
    <div class="content-body">
        <button class="btn-info" wire:click="openModal">
            <i class="fa-solid fa-plus mr-2"></i>
            เพิ่มห้องพัก
        </button>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th class="text-left">ห้องพัก</th>
                    <th class="text-right" width="150px">ค่าเช่าต่อวัน</th>
                    <th class="text-right" width="150px">ค่าเช่าต่อเดือน</th>
                    <th width="130px"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rooms as $room)
                    <tr>
                        <td class="text-left">{{ $room->name }}</td>
                        <td class="text-right">{{ number_format($room->price_per_day) }}</td>
                        <td class="text-right">{{ number_format($room->price_per_month) }}</td>
                        <td class="text-center">
                            <button class="btn-edit" wire:click="openModalEdit({{ $room->id }})">
                                <i class="fa fa-pencil mr-2"></i>
                            </button>
                            <button class="btn-delete" wire:click="openModalDelete({{ $room->id }})">
                                <i class="fa fa-times mr-2"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">ข้อมูลทั้งหมด {{ $totalPages }} หน้า</div>
        <div class="flex justify-center">
            <!-- หน้าแรก -->
            @if ($currentPage > 1)
                <button class="bg-blue-900 text-white px-4 py-1 rounded mr-1" wire:click="setPage(1)">
                    <i class="fa fa-angle-left mr-2"></i>
                    หน้าแรก
                </button>
            @else
                <button class="bg-blue-600 text-white px-4 py-1 rounded mr-1" disabled>
                    <i class="fa fa-angle-left mr-2"></i>
                    หน้าแรก
                </button>
            @endif

            <!-- หน้าอื่นๆ -->
            @for ($i = 2; $i < $totalPages; $i++)
                @if ($i == $currentPage)
                    <button class="bg-blue-600 text-white px-4 py-1 rounded mr-1" disabled>{{ $i }}</button>
                @else
                    <button class="bg-blue-900 text-white px-4 py-1 rounded mr-1"
                        wire:click="setPage({{ $i }})">{{ $i }}</button>
                @endif
            @endfor

            <!-- หน้าสุดท้าย -->
            @if ($currentPage < $totalPages)
                <button class="bg-blue-900 text-white px-4 py-1 rounded mr-1"
                    wire:click="setPage({{ $totalPages }})">
                    <i class="fa fa-angle-right mr-2"></i>
                    หน้าสุดท้าย
                </button>
            @else
                <button class="bg-blue-600 text-white px-4 py-1 rounded mr-1" disabled>
                    <i class="fa fa-angle-right mr-2"></i>
                    หน้าสุดท้าย
                </button>
            @endif
        </div>
    </div>

    <x-modal wire:model="showModal" title="ห้องพัก" maxWidth="xl">
        @if ($errors->any())
            <div class="alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div>
            <h1 class="text-xl text-red-500">สร้างห้องพักแบบจำนวนมากในครั้งเดียว</h1>
        </div>
        <div class="flex gap-5 mt-3">
            <div class="w-1/2">
                <label>จากหมายเลข</label>
                <input type="text" class="form-control" wire:model="from_number">
            </div>
            <div class="w-1/2">
                <label>ถึงหมายเลข</label>
                <input type="text" class="form-control" wire:model="to_number">
            </div>
            <div class="w-1/2">
                <label>ค่าเช่าต่อวัน</label>
                <input type="text" class="form-control" wire:model="price_per_day">
            </div>
            <div class="w-1/2">
                <label>ค่าเช่าต่อเดือน</label>
                <input type="text" class="form-control" wire:model="price_per_month">
            </div>
        </div>
        <div class="mt-5 text-center pb-3">
            <button class="btn-success" wire:click="createRoom">
                <i class="fa-solid fa-check mr-2"></i>
                สร้างห้องพัก
            </button>
            <button class="btn-danger" wire:click="showModal = false">
                <i class="fa-solid fa-times mr-2"></i>
                ยกเลิก
            </button>
        </div>
    </x-modal>

    <x-modal wire:model="showModalEdit" title="แก้ไขห้องพัก" maxWidth="xl">
        <div>ห้องพัก</div>
        <input type="text" class="form-control" wire:model="name">

        <div class="mt-3">ราคาเช่าต่อวัน</div>
        <input type="text" class="form-control" type="number" wire:model="price_day">

        <div class="mt-3">ราคาเช่าต่อเดือน</div>
        <input type="text" class="form-control" type="number" wire:model="price_month">

        <div class="mt-5 text-center pb-5">
            <button class="btn-success mr-2" wire:click="updateRoom">
                <i class="fa-solid fa-check mr-2"></i>
                บันทึก
            </button>
            <button class="btn-danger" wire:click="showModalEdit = false">
                <i class="fa-solid fa-times mr-2"></i>
                ยกเลิก
            </button>
        </div>
    </x-modal>

    <x-modal-confirm showModalDelete="showModalDelete" title="ลบห้องพัก"
        text="คุณต้องการลบห้องพัก {{ $nameForDelete }} หรือไม่" clickConfirm="deleteRoom"
        clickCancel="showModalDelete = false" />
</div>
