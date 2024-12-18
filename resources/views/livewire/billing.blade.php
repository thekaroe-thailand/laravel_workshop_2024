<div>
    <div class="content-header">ใบเสร็จรับเงิน</div>
    <div class="content-body">
        <button class="btn-info mr-1" wire:click="openModal">
            <i class="fa fa-plus mr-2"></i>
            เพิ่มรายการ
        </button>
        <button class="btn-info">
            <i class="fa fa-print mr-2"></i>
            พิมพ์ใบแจ้งค่าเช่าทุกห้อง
        </button>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th class="text-left">ห้อง</th>
                    <th class="text-left">ผู้เช่า</th>
                    <th class="text-left">เบอร์โทร</th>
                    <th class="text-left">วันที่</th>
                    <th class="text-right">ยอดเงิน</th>
                    <th class="text-center">สถานะ</th>
                    <th class="text-left">หมายเหตุ</th>
                    <th width="230px">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($billings as $billing)
                    <tr>
                        <td class="text-left">{{ $billing->room->name }}</td>
                        <td>{{ $billing->getCustomer()->name }}</td>
                        <td>{{ $billing->getCustomer()->phone }}</td>
                        <td>{{ date('d/m/Y', strtotime($billing->created_at)) }}</td>
                        <td class="text-right">{{ number_format($billing->sumAmount()) }}</td>
                        <td class="text-center">
                            @if ($billing->status == 'paid')
                                <span class="text-green-500">
                                    <i class="fa fa-check mr-1"></i>
                                    {{ $billing->getStatusName() }}
                                </span>
                            @else
                                <span class="text-red-500">
                                    <i class="fa fa-times mr-1"></i>
                                    {{ $billing->getStatusName() }}
                                </span>
                            @endif
                        </td>
                        <td>{{ $billing->remark }}</td>
                        <td>
                            <button class="btn-edit" wire:click="openModalGetMoney({{ $billing->id }})">
                                <i class="fa fa-dollar-sign mr-2"></i>
                            </button>
                            <button class="btn-edit" wire:click="printBilling({{ $billing->id }})">
                                <i class="fa fa-file-alt mr-2"></i>
                            </button>
                            <button class="btn-edit" wire:click="openModalEdit({{ $billing->id }})">
                                <i class="fa fa-pencil mr-2"></i>
                            </button>
                            <button class="btn-delete"
                                wire:click="openModalDelete({{ $billing->id }}, '{{ $billing->getCustomer()->name }}')">
                                <i class="fa fa-times mr-2"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-modal title="รายการบิล" wire:model="showModal" maxWidth="2xl">
        <div class="flex gap-2 justify-between">
            <div class="w-1/3">
                <div>ห้อง</div>

                @if ($id != null)
                    <input type="text" class="form-control bg-gray-200" value="{{ $roomNameForEdit }}" readonly />
                @else
                    <select class="form-control" wire:model="roomId" wire:change="selectedRoom()">
                        @foreach ($rooms as $room)
                            <option value="{{ $room['id'] }}">
                                {{ $room['name'] }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
            <div class="w-1/3">
                <div>วันที่</div>
                <input type="date" class="form-control" wire:model="createdAt" />
            </div>
            <div class="w-1/3">
                <div>สถานะบิล</div>
                <select class="form-control" wire:model="status">
                    @foreach ($listStatus as $status)
                        <option value="{{ $status['status'] }}">
                            {{ $status['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="flex gap-2 mt-3">
            <div class="w-1/3">
                <div>ผู้เช่า</div>
                <input type="text" class="form-control bg-gray-200" wire:model="customerName" readonly />
            </div>
            <div class="w-1/3">
                <div>เบอร์โทร</div>
                <input type="text" class="form-control bg-gray-200" wire:model="customerPhone" readonly />
            </div>
        </div>
        <div class="mt-3">หมายเหตุ</div>
        <input type="text" class="form-control" wire:model="remark" />

        <table class="table mt-3">
            <thead>
                <tr>
                    <th class="text-left" width="300px">รายการ</th>
                    <th class="text-right">ยอดเงิน</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-left">ค่าเช่าห้อง</td>
                    <td><input type="number" class="form-control text-right" wire:model="amountRent"
                            wire:change="computeSumAmount()" />
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <div class="flex gap-2">
                            <div class="w-1/3">ค่าน้ำ</div>
                            <div class="w-1/3">
                                <input type="number" class="form-control text-right" wire:model="waterUnit"
                                    wire:change="computeSumAmount()" />
                            </div>
                            <div class="w-1/3">หน่วย</div>
                        </div>
                    </td>
                    <td><input type="number" class="form-control text-right" wire:model="amountWater"
                            wire:change="computeSumAmount()" />
                    </td>
                </tr>
                <tr>
                    <td class="text-left">
                        <div class="flex gap-2">
                            <div class="w-1/3">ค่าไฟฟ้า</div>
                            <div class="w-1/3">
                                <input type="number" class="form-control text-right" wire:model="electricUnit"
                                    wire:change="computeSumAmount()" />
                            </div>
                            <div class="w-1/3">หน่วย</div>
                        </div>
                    </td>
                    <td><input type="number" class="form-control text-right" wire:model="amountElectric"
                            wire:change="computeSumAmount()" />
                    </td>
                </tr>
                <tr>
                    <td class="text-left">ค่าอินเตอร์เน็ต</td>
                    <td><input type="number" class="form-control text-right" wire:model="amountInternet"
                            wire:change="computeSumAmount()" />
                    </td>
                </tr>
                <tr>
                    <td class="text-left">ค่าฟิตเนส</td>
                    <td><input type="number" class="form-control text-right" wire:model="amountFitness"
                            wire:change="computeSumAmount()" />
                    </td>
                </tr>
                <tr>
                    <td class="text-left">ค่าซักรีด</td>
                    <td><input type="number" class="form-control text-right" wire:model="amountWash"
                            wire:change="computeSumAmount()" />
                    </td>
                </tr>
                <tr>
                    <td class="text-left">ค่าเก็บขยะ</td>
                    <td><input type="number" class="form-control text-right" wire:model="amountBin"
                            wire:change="computeSumAmount()" />
                    </td>
                </tr>
                <tr>
                    <td class="text-left">ค่าอื่นๆ</td>
                    <td><input type="number" class="form-control text-right" wire:model="amountEtc"
                            wire:change="computeSumAmount()" />
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-3 text-center font-bold">รวมค่าใช้จ่าย : {{ number_format($sumAmount) }} บาท</div>

        <div class="text-center mt-3">
            <button class="btn-success" wire:click="save()">
                <i class="fa fa-check mr-2"></i>
                บันทึก
            </button>
            <button class="btn-danger" wire:click="closeModal()">
                <i class="fa fa-times mr-2"></i>
                ยกเลิก
            </button>
        </div>
    </x-modal>

    <x-modal-confirm title="ยืนยันการลบ" text="คุณต้องการลบรายการห้อง {{ $roomForDelete }} หรือไม่?"
        showModalDelete="showModalDelete" clickConfirm="deleteBilling()" clickCancel="closeModalDelete()">
    </x-modal-confirm>

    <x-modal title="รับเงิน" wire:model="showModalGetMoney">
        <div class="flex gap-2 justify-between">
            <div class="w-1/2">
                <span class="font-bold">ห้อง</span>
                <span class="text-blue-500 ps-3 font-bold text-xl">
                    {{ $roomNameForGetMoney }}
                </span>
            </div>
            <div class="w-1/2 text-right">
                <a class="ms-3 bg-green-500 text-white px-5 py-2 rounded-lg shadow-md hover:bg-green-600"
                    href="print-invoice/{{ $id }}" target="_blank">
                    <i class="fa fa-print mr-2"></i>
                    พิมพ์ใบเสร็จรับเงิน
                </a>
            </div>
        </div>

        <div class="mt-3">ผู้เช่า : {{ $customerNameForGetMoney }}</div>
        <div class="mt-3">วันที่ชำระ</div>
        <input type="date" class="form-control" wire:model="payedDateForGetMoney" />

        <div class="mt-3">ยอดรวมค่าใช้จ่าย :
            <span class="font-bold">{{ number_format($sumAmountForGetMoney) }}</span>
            บาท
        </div>

        <div class="flex gap-2 mt-3">
            <div class="w-1/2">
                <div>ค่าปรับ</div>
                <input type="number" class="form-control" wire:model="moneyAdded"
                    wire:blur="handleChangeAmountForGetMoney()" />
            </div>
            <div class="w-1/2">
                <div>ยอดรับเงิน</div>
                <input type="number" class="form-control" wire:model="amountForGetMoney" />
            </div>
        </div>

        <div class="mt-3">หมายเหตุ</div>
        <input type="text" class="form-control" wire:model="remarkForGetMoney" />

        <div class="text-center mt-5">
            <button class="btn-success" wire:click="saveGetMoney()">
                <i class="fa fa-check mr-2"></i>
                บันทึก
            </button>
            <button class="btn-danger" wire:click="closeModalGetMoney()">
                <i class="fa fa-times mr-2"></i>
                ยกเลิก
            </button>
        </div>
    </x-modal>
</div>
