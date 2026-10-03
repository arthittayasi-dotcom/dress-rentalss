<x-app-layout>

<x-slot name="header">

<div>

<p class="text-sm font-medium tracking-[0.25em] uppercase text-[#9B8AC9]">
WANWAN
</p>


<h2 class="mt-2 text-3xl font-semibold text-slate-800">
Admin Dashboard
</h2>


<p class="mt-2 text-sm text-slate-500">
จัดการคำขอเช่า ตรวจสอบสถานะชุด และดูแลงานเช่าประจำวัน
</p>


</div>

</x-slot>






<div class="min-h-screen bg-gradient-to-br from-[#FCFAFF] via-[#F8F6FF] to-[#FFF8FB] py-10">


<div class="max-w-7xl mx-auto px-6 space-y-8">







<section class="rounded-[34px]
bg-gradient-to-r
from-[#EDF7FF]
via-[#F5F0FF]
to-[#FFF0F6]
p-10">


<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">



<div class="lg:col-span-2">


<span class="rounded-full bg-white px-4 py-2 text-xs text-[#8D78BD]">

Administrator

</span>



<h1 class="mt-5 text-4xl font-semibold">

สวัสดี,
{{ auth()->user()->name }}

</h1>



<p class="mt-4 text-slate-600">

ตรวจสอบคำขอเช่า อนุมัติหรือปฏิเสธ
ติดตามสถานะชุด และตรวจรับคืน

</p>




<a href="{{ route('admin.rentals') }}"
class="inline-flex mt-7 px-7 py-3 rounded-2xl text-white
bg-gradient-to-r from-[#87BFE8] via-[#A89CCF] to-[#DEA9BF]">

ตรวจสอบคำขอเช่า

</a>


</div>






<div class="bg-white rounded-[28px] p-6">


<p class="text-[#8D78BD] font-semibold">

สถานะวันนี้

</p>




<div class="mt-5 space-y-3">





<div class="flex justify-between bg-[#FFF7E8] rounded-2xl px-4 py-3">

<span>
คำขอรออนุมัติ
</span>

<span class="font-semibold text-[#B97A32]">

{{ $pending }} รายการ

</span>

</div>






<div class="flex justify-between bg-[#EDF7FF] rounded-2xl px-4 py-3">

<span>
กำลังเช่า
</span>

<span class="font-semibold text-[#4F8DBA]">

{{ $renting }} รายการ

</span>

</div>






<div class="flex justify-between bg-[#FFF7FA] rounded-2xl px-4 py-3">

<span>
ต้องคืนวันนี้
</span>

<span class="font-semibold text-[#D06C96]">

{{ $returnToday }} รายการ

</span>

</div>




</div>


</div>



</div>


</section>









{{-- SUMMARY --}}

<section class="grid grid-cols-1 md:grid-cols-6 gap-5">





<div class="bg-white rounded-[26px] p-6 border">

<p class="text-slate-500">
รายได้รวม
</p>

<p class="mt-2 text-2xl font-semibold text-[#7766A8]">

{{ number_format($totalSales,2) }}

</p>

<span class="text-sm text-slate-400">
บาท
</span>

</div>







<div class="bg-white rounded-[26px] p-6 border">

<p class="text-slate-500">
รายการทั้งหมด
</p>

<p class="mt-2 text-3xl font-semibold text-[#4F8DBA]">

{{ $totalRentals }}

</p>

</div>







<div class="bg-white rounded-[26px] p-6 border">

<p class="text-slate-500">
คำขอใหม่
</p>

<p class="mt-2 text-3xl font-semibold text-[#D18BAA]">

{{ $pending }}

</p>

</div>








<div class="bg-white rounded-[26px] p-6 border">

<p class="text-slate-500">
อนุมัติแล้ว
</p>

<p class="mt-2 text-3xl font-semibold text-[#4F8DBA]">

{{ $approved }}

</p>

</div>







<div class="bg-white rounded-[26px] p-6 border">

<p class="text-slate-500">
กำลังเช่า
</p>

<p class="mt-2 text-3xl font-semibold text-[#7766A8]">

{{ $renting }}

</p>

</div>







<div class="bg-white rounded-[26px] p-6 border">

<p class="text-slate-500">
คืนแล้ว
</p>

<p class="mt-2 text-3xl font-semibold text-[#67A88B]">

{{ $returned }}

</p>

</div>





</section>









<section class="grid grid-cols-1 lg:grid-cols-2 gap-6">






<div class="bg-white rounded-[30px] p-7 border">


<p class="text-[#9B8AC9]">
Today
</p>



<h3 class="text-xl font-semibold mt-1">

งานที่ต้องตรวจวันนี้

</h3>





<div class="mt-6 space-y-3">





<a href="{{ route('admin.rentals') }}"
class="flex justify-between bg-[#FFF9EC] rounded-2xl px-4 py-4">


<span>
คำขอเช่ารออนุมัติ
</span>


<span class="font-semibold">

{{ $pending }}

</span>


</a>







<a href="{{ route('admin.calendar') }}"
class="flex justify-between bg-[#F8FBFE] rounded-2xl px-4 py-4">


<span>
ชุดที่กำลังเช่า
</span>


<span class="font-semibold">

{{ $renting }}

</span>


</a>







<a href="{{ route('admin.returns') }}"
class="flex justify-between bg-[#FFF7FA] rounded-2xl px-4 py-4">


<span>
ชุดที่ต้องคืนวันนี้
</span>


<span class="font-semibold">

{{ $returnToday }}

</span>


</a>





</div>


</div>









<div class="bg-white rounded-[30px] p-7 border">


<p class="text-[#9B8AC9]">

Latest Request

</p>



<h3 class="text-xl font-semibold mt-1">

คำขอล่าสุด

</h3>







@if($latestRental)



<div class="mt-6 bg-[#FAF8FF] rounded-2xl p-5">


<p class="font-semibold">

{{ $latestRental->dress->code ?? '-' }}

·

{{ $latestRental->dress->name ?? '-' }}

</p>




<p class="mt-2 text-sm text-slate-500">

ลูกค้า :

{{ $latestRental->user->name ?? '-' }}

</p>




<p class="text-sm text-slate-500">

{{ $latestRental->start_date }}

-

{{ $latestRental->end_date }}

</p>





<span class="inline-block mt-3 px-3 py-1 rounded-full bg-[#FFF7E8] text-[#B97A32] text-sm">

{{ $latestRental->status }}

</span>



</div>





@else


<div class="mt-6 text-center text-slate-400">

ยังไม่มีรายการเช่า

</div>


@endif





</div>





</section>





</div>

</div>


</x-app-layout>