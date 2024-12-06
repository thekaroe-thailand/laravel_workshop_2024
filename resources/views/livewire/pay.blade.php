<div>
    <div class="content-header">บันทึกค่าใช้จ่าย</div>

    <div class="content-body">
        <div class="flex">
            <button class="btn-info mr-2" wire:click="openModalPayLog">
                <i class="fa-solid fa-plus mr-2"></i>
                เพิ่มค่าใช้จ่าย
            </button>
            <button class="btn-info" wire:click="openModalPay">
                <i class="fa-solid fa-list mr-2"></i>
                รายการค่าใช้จ่าย
            </button>
        </div>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th class="text-left" width="100px">วันที่</th>
                    <th class="text-left" width="300px">รายการ</th>
                    <th class="text-left">หมายเหตุ</th>
                    <th class="text-right" width="100px">ยอดเงิน</th>
                    <th width="130px"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payLogs as $payLog)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($payLog->pay_date)) }}</td>
                        <td>{{ $payLog->pay->name }}
                            @if ($payLog->status == 'delete')
                                <span class="badge badge-danger">*** ถูกลบ ***</span>
                            @endif
                        </td>
                        <td>{{ $payLog->remark }}</td>
                        <td class="text-right">{{ number_format($payLog->amount) }}</td>
                        <td class="text-center">
                            <button class="btn-edit" wire:click="openModalPayLogEdit({{ $payLog->id }})">
                                <i class="fa-solid fa-pencil mr-2"></i>
                            </button>

                            @if ($payLog->status == 'use')
                                <button class="btn-delete" wire:click="openModalPayLogDelete({{ $payLog->id }})">
                                    <i class="fa-solid fa-times mr-2"></i>
                                </button>
                            @endif

                            @if ($payLog->status == 'delete')
                                <button class="btn-edit" wire:click="openModalPayLogRestore({{ $payLog->id }})">
                                    <i class="fa-solid fa-chevron-left mr-2"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-modal title="รายการค่าใช้จ่าย" wire:model="showModalPayLogEdit" maxWidth="2xl">
        <div>วันที่</div>
        <input type="date" class="form-control" wire:model="payLogEditDate" />

        <div class="mt-3">รายการ</div>
        <input type="text" class="form-control bg-gray-100" wire:model="payLogEditName" readonly />

        <div class="mt-3">ยอดเงิน</div>
        <input type="number" class="form-control" wire:model="payLogEditAmount" />

        <div class="mt-3">หมายเหตุ</div>
        <input type="text" class="form-control" wire:model="payLogEditRemark" />

        <div class="mt-3 text-center">
            <button class="btn-info mr-2" wire:click="editPayLogSave">
                <i class="fa-solid fa-check mr-2"></i>
                บันทึก
            </button>
            <button class="btn-danger" wire:click="closeModalPayLogEdit">
                <i class="fa-solid fa-xmark mr-2"></i>
                ยกเลิก
            </button>
        </div>
    </x-modal>

    <x-modal-confirm title="ยืนยันการลบ" text="คุณต้องการลบรายการ {{ $payLogEditName }} นี้หรือไม่"
        showModalDelete="showModalPayLogDelete" maxWidth="sm" clickConfirm="deletePayLog()"
        clickCancel="closeModalPayLogDelete()" />

    <x-modal-confirm title="ยืนยันการกู้คืน" text="คุณต้องการกู้คืนรายการ {{ $payLogEditName }} นี้หรือไม่"
        showModalDelete="showModalPayLogRestore" maxWidth="sm" clickConfirm="restorePayLog()"
        clickCancel="closeModalPayLogRestore()" />

    <x-modal title="รายการค่าใช้จ่าย" wire:model="showModalPay" maxWidth="2xl">
        <div>รายการ</div>
        <input type="text" class="form-control" wire:model="payName" />

        <div class="mt-3">หมายเหตุ</div>
        <input type="text" class="form-control" wire:model="payRemark" />

        <div class="mt-3 text-center">
            <button class="btn-info mr-2" wire:click="savePay">
                <i class="fa-solid fa-check mr-2"></i>
                บันทึก
            </button>
            <button class="btn-danger" wire:click="closeModalPay">
                <i class="fa-solid fa-xmark mr-2"></i>
                ยกเลิก
            </button>
        </div>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th class="text-left">รายการ</th>
                    <th class="text-left">หมายเหตุ</th>
                    <th width="130px"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pays as $pay)
                    <tr>
                        <td>{{ $pay->name }}</td>
                        <td>{{ $pay->remark }}</td>
                        <td class="text-center">
                            <button class="btn-edit" wire:click="editPay({{ $pay->id }})">
                                <i class="fa-solid fa-pencil mr-2"></i>
                            </button>
                            <button class="btn-delete"
                                wire:click="openModalPayDelete({{ $pay->id }}, '{{ $pay->name }}')">
                                <i class="fa-solid fa-times mr-2"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-modal>

    <x-modal-confirm title="ยืนยันการลบ" text="คุณต้องการลบรายการ {{ $payNameForDelete }} นี้หรือไม่"
        showModalDelete="showModalPayDelete" maxWidth="sm" clickConfirm="deletePay()"
        clickCancel="closeModalPayDelete()" />

    <x-modal wire:model="showModalPayLog" title="บันทึกค่าใช้จ่าย" maxWidth="2xl">
        <div>วันที่</div>
        <input type="date" class="form-control" wire:model="payLogDate" />

        <div class="mt-3">รายการ</div>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th class="text-left">รายการ</th>
                    <th width="100px">ยอดเงิน</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pays as $pay)
                    <tr>
                        <td>{{ $pay->name }}</td>
                        <td><input type="number" class="form-control"
                                wire:model="payLogAmount.{{ $pay->id }}" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3 text-center">
            <button class="btn-info mr-2" wire:click="savePayLog">
                <i class="fa-solid fa-check mr-2"></i>
                บันทึก
            </button>
            <button class="btn-danger" wire:click="closeModalPayLog">
                <i class="fa-solid fa-times mr-2"></i>
                ยกเลิก
            </button>
        </div>
    </x-modal>
</div>
