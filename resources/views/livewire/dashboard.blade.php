<div>
    <div class="content-header">Dashboard</div>
    <div class="content-body">
        <div class="flex gap-4 text-right">
            <div class="box-income">
                <div class="font-bold text-xl">
                    <i class="fa-solid fa-coins mr-2"></i>
                    รายได้
                </div>
                <div class="text-4xl">{{ number_format($income) }}</div>
            </div>
            <div class="box-room-fee">
                <div class="font-bold text-xl">
                    <i class="fa-solid fa-bed mr-2"></i>
                    ห้องว่าง
                </div>
                <div class="text-4xl">{{ $roomFee }}</div>
            </div>
            <div class="box-debt">
                <div class="font-bold text-xl">
                    <i class="fa-solid fa-handshake mr-2"></i>
                    ค้างจ่าย
                </div>
                <div class="text-4xl">{{ number_format($debt) }}</div>
            </div>
            <div class="box-pay">
                <div class="font-bold text-xl">
                    <i class="fa-solid fa-dollar-sign mr-2"></i>
                    รายจ่าย
                </div>
                <div class="text-4xl">{{ number_format($pay) }}</div>
            </div>
            <div class="{{ $income - $pay > 0 ? 'box-balance-positive' : 'box-balance-negative' }}">
                <div class="font-bold text-xl">
                    <i class="fa-solid fa-chart-bar mr-2"></i>
                    ผลประกอบการ
                </div>
                <div class="text-4xl">{{ number_format($income - $pay) }}</div>
            </div>
        </div>
    </div>
</div>
