<x-app-layout>

<x-slot name="header">

<div>

<p class="text-sm font-medium tracking-[0.2em] uppercase text-[#9B8AC9]">
WANWAN
</p>


<h2 class="mt-2 text-3xl font-semibold text-slate-800">
เช่าชุด
</h2>


<p class="mt-2 text-sm text-slate-500">
เลือกชุดที่ต้องการและระบุวันที่เช่า
</p>


</div>

</x-slot>





<div class="min-h-screen bg-gradient-to-br from-[#FCFAFF] via-[#F8F6FF] to-[#FFF8FB] py-10">


<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">



@if(session('error'))

<div class="rounded-[24px]
border border-[#F0D8DF]
bg-[#FFF7F8]
px-6 py-4
text-sm text-[#B76575]">

{{ session('error') }}

</div>

@endif




@if($errors->any())

<div class="rounded-[24px]
border border-[#F0D8DF]
bg-[#FFF7F8]
px-6 py-4">


<p class="text-sm font-semibold text-[#B76575]">
ไม่สามารถส่งคำขอเช่าได้
</p>


<ul class="mt-2 space-y-1 text-sm text-[#B76575]">

@foreach($errors->all() as $error)

<li>
• {{ $error }}
</li>

@endforeach

</ul>


</div>

@endif





{{-- HERO --}}

<section class="rounded-[34px]
bg-gradient-to-r
from-[#EDF7FF]
via-[#F5F0FF]
to-[#FFF0F6]
border border-white
shadow-[0_18px_45px_rgba(120,90,170,0.08)]
p-8 md:p-10">



<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">



<div class="lg:col-span-2">


<span class="inline-flex rounded-full
bg-white/80
px-4 py-2
text-xs font-medium
text-[#8D78BD]
shadow-sm">

Dress Collection

</span>




<h1 class="mt-5 text-3xl md:text-4xl font-semibold text-slate-800">

เลือกชุดที่ใช่สำหรับวันพิเศษของคุณ

</h1>




<p class="mt-4 text-slate-600 leading-7 max-w-2xl">

เลือกชุดที่ต้องการ ระบุวันที่เริ่มเช่าและวันที่คืน
ระบบจะตรวจสอบวันว่างก่อนบันทึกคำขอเช่า

</p>


</div>






<div class="rounded-[28px]
bg-white/90
border border-white
p-6
shadow-sm">


<p class="text-sm font-semibold text-[#8D78BD]">

วิธีเช่า

</p>



<div class="mt-5 space-y-4">


<div class="flex gap-3">

<div class="w-8 h-8 rounded-full bg-[#EDF7FF]
text-[#4F8DBA]
text-xs font-semibold
flex items-center justify-center">

1

</div>


<div>

<p class="text-sm font-medium text-slate-700">

เลือกชุด

</p>


<p class="mt-1 text-xs text-slate-400">

เลือกจากรายการด้านล่าง

</p>


</div>

</div>



<div class="flex gap-3">

<div class="w-8 h-8 rounded-full bg-[#F3F0FA]
text-[#7766A8]
text-xs font-semibold
flex items-center justify-center">

2

</div>


<div>

<p class="text-sm font-medium text-slate-700">

เลือกวันที่

</p>


<p class="mt-1 text-xs text-slate-400">

ระบุวันที่เริ่มเช่าและวันที่คืน

</p>


</div>

</div>



<div class="flex gap-3">

<div class="w-8 h-8 rounded-full bg-[#FFF1F7]
text-[#C56690]
text-xs font-semibold
flex items-center justify-center">

3

</div>


<div>

<p class="text-sm font-medium text-slate-700">

รอการอนุมัติ

</p>


<p class="mt-1 text-xs text-slate-400">

Admin จะตรวจสอบคำขอของคุณ

</p>


</div>

</div>


</div>


</div>


</div>


</section>





{{-- COLLECTION HEADER --}}

<section>


<div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">


<div>


<p class="text-sm font-medium text-[#9B8AC9]">

Collection

</p>



<h2 class="mt-1 text-2xl font-semibold text-slate-800">

ชุดทั้งหมด

</h2>



<p class="mt-2 text-sm text-slate-500">

พบ {{ $dresses->total() }} ชุด

</p>


</div>



<div class="flex gap-3 mt-6">


<a href="{{ route('customer.rentals') }}"

class="px-6 py-3 rounded-2xl bg-white border text-[#7766A8]">


การเช่าของฉัน


</a>


</div>


</div>


</section>

{{-- DRESS LIST --}}

<section>


<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">



@forelse($dresses as $dress)



<div class="bg-white
rounded-[30px]
border border-[#EEE8F6]
overflow-hidden
shadow-sm">





<div class="h-72 bg-[#F8F5FF]">


@if($dress->image)


<img
src="{{ asset('storage/'.$dress->image) }}"
class="w-full h-full object-cover">


@else


<div class="w-full h-full flex items-center justify-center text-[#B9A9D8]">

ไม่มีรูป

</div>


@endif


</div>








<div class="p-5">



<div class="flex justify-between items-start gap-3">


<div>


<p class="text-xs text-slate-400">

{{ $dress->code }}

</p>



<h3 class="mt-1 text-lg font-semibold text-slate-800">

{{ $dress->name }}

</h3>


</div>





@if($dress->status == 'available')


<span class="px-3 py-1 rounded-full text-xs bg-green-100 text-green-700">

พร้อมเช่า

</span>


@else


<span class="px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-600">

{{ $dress->status }}

</span>


@endif



</div>







<p class="mt-3 text-sm text-slate-500">

ขนาด:

{{ $dress->size ?? '-' }}

</p>





<p class="mt-2 text-[#7766A8] font-semibold">

{{ number_format($dress->price_per_day,2) }}

บาท / วัน

</p>






@if($dress->status == 'available')



<button

type="button"

onclick="openRentalModal(
{{ $dress->id }},
'{{ $dress->name }}'
)"

class="mt-5 w-full px-4 py-3 rounded-2xl text-white
bg-gradient-to-r from-[#87BFE8] via-[#A89CCF] to-[#DEA9BF]">


เช่าชุดนี้


</button>



@else



<button

disabled

class="mt-5 w-full px-4 py-3 rounded-2xl bg-gray-100 text-gray-400">


ไม่พร้อมให้เช่า


</button>



@endif




</div>




</div>





@empty



<div class="col-span-full text-center py-16 text-slate-400">


ยังไม่มีชุดให้บริการ


</div>



@endforelse



</div>



{{-- PAGINATION --}}

<div class="mt-10">


{{ $dresses->links() }}


</div>



</section>
</div>

</div>





{{-- RENTAL MODAL --}}

<div

id="rentalModal"

class="hidden fixed inset-0 z-50 bg-black/30 flex items-center justify-center px-4">



<div class="bg-white rounded-[30px] p-8 w-full max-w-md">





<h2 class="text-2xl font-semibold text-slate-800">

เช่าชุด

</h2>



<p class="mt-2 text-sm text-slate-500">

ชุดที่เลือก:

<span id="modalDressName" class="font-semibold">

</span>

</p>







<form method="POST"

action="{{ route('customer.rentals.store') }}"

class="mt-6 space-y-4">


@csrf



<input

type="hidden"

id="modalDressId"

name="dress_id">





<div>


<label class="text-sm text-slate-600">

วันที่เริ่มเช่า

</label>



<input

type="date"

name="start_date"

required

class="mt-2 w-full rounded-xl border-gray-200">

</div>







<div>


<label class="text-sm text-slate-600">

วันที่คืน

</label>



<input

type="date"

name="end_date"

required

class="mt-2 w-full rounded-xl border-gray-200">

</div>






<div class="flex gap-3 mt-6">


<button

type="submit"

class="flex-1 px-5 py-3 rounded-2xl text-white

bg-gradient-to-r from-[#87BFE8] via-[#A89CCF] to-[#DEA9BF]">


ยืนยันเช่า


</button>





<button

type="button"

onclick="closeRentalModal()"

class="flex-1 px-5 py-3 rounded-2xl bg-gray-100 text-slate-600">


ยกเลิก


</button>



</div>



</form>



</div>


</div>






</div>


</div>







<script>


function openRentalModal(id,name)

{

    document
    .getElementById('modalDressId')
    .value = id;


    document
    .getElementById('modalDressName')
    .innerText = name;



    document
    .getElementById('rentalModal')
    .classList
    .remove('hidden');

}





function closeRentalModal()

{

    document
    .getElementById('rentalModal')
    .classList
    .add('hidden');

}



</script>





</x-app-layout>