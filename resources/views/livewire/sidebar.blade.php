<div class="sidebar">
    <div class="sidebar-header">
        <div class="text-center">jApartment 1.0</div>
    </div>
    <div class="sidebar-body">
        <div class="menu">
            <ul>
                @if ($userLevel == 'admin')
                    <li wire:click="changeMenu('dashboard')" @if ($currentMenu == 'dashboard') class="active" @endif>
                        <i class="fa-solid fa-chart-line me-2"></i>Dashboard
                    </li>
                    <li wire:click="changeMenu('billing')" @if ($currentMenu == 'billing') class="active" @endif>
                        <i class="fa-solid fa-building me-2"></i>ใบเสร็จรับเงิน
                    </li>
                    <li wire:click="changeMenu('pay')" @if ($currentMenu == 'pay') class="active" @endif>
                        <i class="fa-solid fa-building me-2"></i>บันทึกค่าใช้จ่าย
                    </li>
                    <li wire:click="changeMenu('room')" @if ($currentMenu == 'room') class="active" @endif>
                        <i class="fa-solid fa-home me-2"></i>ห้องพัก
                    </li>
                @endif

                <li wire:click="changeMenu('customer')" @if ($currentMenu == 'customer') class="active" @endif>
                    <i class="fa-solid fa-user me-2"></i>ผู้เข้าพัก
                </li>

                @if ($userLevel == 'admin')
                    <li wire:click="changeMenu('user')" @if ($currentMenu == 'user') class="active" @endif>
                        <i class="fa-solid fa-gear me-2"></i>ผู้ใช้งาน
                    </li>
                    <li wire:click="changeMenu('company/index')"
                        @if ($currentMenu == 'company/index') class="active" @endif>
                        <i class="fa-solid fa-building me-2"></i>ข้อมูลสถานประกอบการ
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
