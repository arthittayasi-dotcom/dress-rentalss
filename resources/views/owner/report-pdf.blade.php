<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<title>
Rental Report
</title>


<style>


@font-face {

    font-family: 'THSarabun';

    font-style: normal;

    font-weight: normal;

    src: url("{{ storage_path('fonts/THSarabunNew.ttf') }}");

}



@font-face {

    font-family: 'THSarabun';

    font-style: normal;

    font-weight: bold;

    src: url("{{ storage_path('fonts/THSarabunNew-Bold.ttf') }}");

}



body{

    font-family: 'THSarabun';

    font-size:20px;

    color:#222;

}



h1{

    text-align:center;

    font-size:32px;

    font-weight:bold;

}



h2,h3{

    font-weight:bold;

    font-size:24px;

}



.box{

    border:1px solid #ddd;

    padding:15px;

    margin-bottom:20px;

    border-radius:10px;

}



table{

    width:100%;

    border-collapse:collapse;

}



th{

    font-weight:bold;

    background:#f8f5ff;

}



th,td{

    border:1px solid #ddd;

    padding:8px;

    text-align:left;

    font-size:18px;

}



</style>


</head>


<body>
<img src="{{ public_path('wanwan-logo.png') }}" alt="WANWAN" style="width:160px">


<h1>
รายงานร้านเช่าชุด WANWAN
</h1>




<div class="box">


<h3>
สรุปยอดขาย
</h3>



<p>
รายได้รวม :

{{ number_format($totalSales,2) }}

บาท

</p>



<p>
จำนวนรายการ :

{{ $rentals->count() }}

รายการ

</p>



</div>







<h3>
รายการเช่า
</h3>




<table>


<thead>


<tr>

<th>
ชุด
</th>


<th>
ลูกค้า
</th>


<th>
ราคา
</th>


<th>
สถานะ
</th>


</tr>


</thead>






<tbody>


@foreach($rentals as $rental)


<tr>


<td>

{{ $rental->dress->name ?? '-' }}

</td>



<td>

{{ $rental->user->name ?? '-' }}

</td>



<td>

{{ number_format($rental->total_price,2) }}

บาท

</td>



<td>

{{ $rental->status }}

</td>



</tr>


@endforeach


</tbody>


</table>




</body>

</html>