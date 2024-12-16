<h3>ใบแจ้งค่าเช่า</h3>
<h4>{{ $organization->name }}</h4>

<div>ของเดือน {{ date('m/Y', strtotime($billing->created_at)) }}</div>
<div>ห้องที่ : {{ $billing->room->name }}</div>
<div>ชื่อผู้เช่า : {{ $billing->getCustomer()->name }}</div>
<div>เบอร์โทรศัพท์ : {{ $billing->getCustomer()->phone }}</div>

<table width="100%" cellpadding="8" cellspacing="0" style="margin-top: 10px; border-collapse: collapse" border="1">

    <thead>
        <tr style="background-color: #c8c7c7;">
            <td>รายการ</td>
            <td align="right" width="100px">ราคา</td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>ค่าเช่า</td>
            <td align="right" width="100px">{{ number_format($billing->amount_rent) }}</td>
        </tr>
        <tr>
            <td>ค่าน้ำ</td>
            <td align="right" width="100px">{{ number_format($billing->amount_water) }}</td>
        </tr>
        <tr>
            <td>ค่าไฟ</td>
            <td align="right" width="100px">{{ number_format($billing->amount_electric) }}</td>
        </tr>
        <tr>
            <td>ค่าอินเตอร์เน็ต</td>
            <td align="right" width="100px">{{ number_format($billing->amount_internet) }}</td>
        </tr>
        <tr>
            <td>ค่าฟิตเนส</td>
            <td align="right" width="100px">{{ number_format($billing->amount_fitness) }}</td>
        </tr>
        <tr>
            <td>ค่าซักรีด</td>
            <td align="right" width="100px">{{ number_format($billing->amount_wash) }}</td>
        </tr>
        <tr>
            <td>ค่าเก็บขยะ</td>
            <td align="right" width="100px">{{ number_format($billing->amount_bin) }}</td>
        </tr>
        <tr>
            <td>ค่าอื่นๆ</td>
            <td align="right" width="100px">{{ number_format($billing->amount_etc) }}</td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td align="right" style="font-weight: bold">รวม</td>
            <td align="right" style="background-color: #c8c7c7;">{{ number_format($billing->sumAmount()) }}</td>
        </tr>
    </tfoot>
</table>

<script>
    // print and prev location
    window.print();
    //window.location.href = 'http://localhost:8000/billing';
</script>
