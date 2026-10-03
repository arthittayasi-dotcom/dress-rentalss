<x-app-layout>

<div class="max-w-7xl mx-auto px-6 py-10">


<div class="flex justify-between items-center mb-6">


<div>

<p class="text-sm text-[#8C80B4]">
Rental Calendar
</p>

<h1 class="text-3xl font-semibold text-slate-800">
ปฏิทินคิวชุด
</h1>

<p class="text-slate-500 mt-1">
ดูตารางการจองและคิวคืนชุด
</p>

</div>




<div class="flex gap-3">


<a href="?month={{ $month->copy()->subMonth()->format('Y-m') }}"
class="px-4 py-2 rounded-xl bg-[#F3EEFF] hover:bg-[#E9DFFF]">

‹

</a>



<div class="px-5 py-2 rounded-xl bg-white border font-medium">

{{ $month->translatedFormat('F Y') }}

</div>



<a href="?month={{ $month->copy()->addMonth()->format('Y-m') }}"
class="px-4 py-2 rounded-xl bg-[#F3EEFF] hover:bg-[#E9DFFF]">

›

</a>


</div>


</div>






{{-- LEGEND --}}

<div class="flex gap-5 mb-6 text-sm">


<div class="flex items-center gap-2">

<span class="w-3 h-3 rounded-full bg-yellow-300"></span>

รออนุมัติ

</div>



<div class="flex items-center gap-2">

<span class="w-3 h-3 rounded-full bg-purple-300"></span>

อนุมัติแล้ว

</div>



<div class="flex items-center gap-2">

<span class="w-3 h-3 rounded-full bg-blue-300"></span>

กำลังเช่า

</div>


</div>








<div class="bg-white rounded-[30px] border overflow-hidden shadow-sm">



<div class="grid grid-cols-7 bg-[#FBF8FF] text-center font-semibold">


<div class="py-3 text-red-500">
อาทิตย์
</div>


<div class="py-3">
จันทร์
</div>


<div class="py-3">
อังคาร
</div>


<div class="py-3">
พุธ
</div>


<div class="py-3">
พฤหัสบดี
</div>


<div class="py-3">
ศุกร์
</div>


<div class="py-3 text-purple-500">
เสาร์
</div>


</div>







<div class="grid grid-cols-7">


@php

$start = $month->copy()
    ->startOfMonth()
    ->startOfWeek();


$end = $month->copy()
    ->endOfMonth()
    ->endOfWeek();

@endphp





@while($start <= $end)



<div class="min-h-[150px] border p-3 hover:bg-[#FCFAFF] transition">



<div class="
font-semibold mb-3

{{ $start->month != $month->month 
? 'text-gray-300'
: 'text-slate-700'
}}

">

{{ $start->day }}

</div>







@foreach($rentals as $rental)



@if(
$start->between(
Carbon\Carbon::parse($rental->start_date),
Carbon\Carbon::parse($rental->end_date)
)
)





<div

class="
mb-2
px-3
py-2
rounded-xl
text-xs
transition
hover:scale-[1.03]

@if($rental->status == 'pending')

bg-yellow-100 text-yellow-700

@elseif($rental->status == 'approved')

bg-purple-100 text-purple-700

@elseif($rental->status == 'renting')

bg-blue-100 text-blue-700

@else

bg-gray-100 text-gray-600

@endif

"

>



<div class="font-semibold flex items-center gap-1">

👗 {{ $rental->dress->code ?? '-' }}

</div>



<div class="mt-1">

{{ $rental->dress->name ?? 'ไม่ระบุชุด' }}

</div>



<div class="mt-1 opacity-70">

👤 {{ $rental->user->name ?? '-' }}

</div>



</div>




@endif



@endforeach





</div>





@php

$start->addDay();

@endphp



@endwhile



</div>



</div>


</div>


</x-app-layout>