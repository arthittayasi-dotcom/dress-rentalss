<x-app-layout>

<x-slot name="header">

<div>

<p class="text-sm font-medium tracking-[0.2em] uppercase text-[#9B8ACF]">
    User Management
</p>

<h2 class="mt-2 text-3xl font-semibold text-slate-800">
    จัดการบัญชีผู้ใช้
</h2>

<p class="mt-2 text-sm text-slate-500">
    ดู เพิ่ม แก้ไข และจัดการบัญชีผู้ใช้งานในระบบ
</p>

</div>

</x-slot>



<div class="min-h-screen bg-gradient-to-br from-[#FCFAFF] via-[#F8F6FF] to-[#FFF8FB] py-10">

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">



{{-- SUMMARY --}}

<section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">


<div class="rounded-[26px] bg-white border border-[#EEE8F6] p-6 shadow-sm">

<p class="text-sm text-slate-500">
ผู้ใช้ทั้งหมด
</p>

<p class="mt-2 text-3xl font-semibold text-[#7766A8]">
{{ $users->count() }}
</p>

</div>




<div class="rounded-[26px] bg-white border border-[#EEE8F6] p-6 shadow-sm">

<p class="text-sm text-slate-500">
ลูกค้า
</p>

<p class="mt-2 text-3xl font-semibold text-[#4F8DBA]">
{{ $users->where('role','customer')->count() }}
</p>

</div>




<div class="rounded-[26px] bg-white border border-[#EEE8F6] p-6 shadow-sm">

<p class="text-sm text-slate-500">
แอดมิน
</p>

<p class="mt-2 text-3xl font-semibold text-[#D06C96]">
{{ $users->where('role','admin')->count() }}
</p>

</div>




<div class="rounded-[26px] bg-white border border-[#EEE8F6] p-6 shadow-sm">

<p class="text-sm text-slate-500">
เจ้าของร้าน
</p>

<p class="mt-2 text-3xl font-semibold text-[#67A88B]">
{{ $users->where('role','owner')->count() }}
</p>

</div>


</section>





{{-- SEARCH --}}

<section class="rounded-[30px]
bg-white
border border-[#EEE8F6]
shadow-sm
p-7">


<div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5">


<div class="grid grid-cols-1 md:grid-cols-2 gap-5 flex-1">


<div>

<label class="block text-sm font-medium text-slate-700 mb-2">
ค้นหาผู้ใช้
</label>


<input id="searchUser"
type="text"
placeholder="ชื่อ หรือ username"
oninput="filterUsers()"
class="w-full rounded-2xl border-[#DDD9E8] px-4 py-3">

</div>




<div>

<label class="block text-sm font-medium text-slate-700 mb-2">
ประเภทบัญชี
</label>


<select id="roleFilter"
onchange="filterUsers()"
class="w-full rounded-2xl border-[#DDD9E8] px-4 py-3">


<option value="all">
ทั้งหมด
</option>


<option value="customer">
ลูกค้า
</option>


<option value="admin">
แอดมิน
</option>


<option value="owner">
เจ้าของร้าน
</option>


</select>


</div>


</div>




<button
onclick="openCreateModal()"
class="rounded-2xl px-6 py-3 text-sm font-medium text-white
bg-gradient-to-r from-[#87BFE8] via-[#A89CCF] to-[#DEA9BF]">

เพิ่มบัญชีผู้ใช้

</button>


</div>


</section>





{{-- TABLE --}}

<section class="rounded-[30px]
bg-white
border border-[#EEE8F6]
shadow-sm
overflow-hidden">


<div class="p-7 border-b border-[#EEE8F6]">

<p class="text-sm font-medium text-[#9B8AC9]">
Accounts
</p>


<h3 class="mt-1 text-2xl font-semibold text-slate-800">
บัญชีผู้ใช้งาน
</h3>


</div>



<div class="overflow-x-auto">


<table class="w-full text-left">


<thead class="bg-[#FAF8FF]">

<tr class="text-sm text-slate-500">

<th class="px-6 py-4">
ชื่อ
</th>

<th class="px-6 py-4">
Username
</th>

<th class="px-6 py-4">
ประเภทบัญชี
</th>

<th class="px-6 py-4 text-right">
จัดการ
</th>


</tr>

</thead>



<tbody id="userTable" class="divide-y">


@foreach($users as $user)


<tr class="user-row"
data-search="{{ strtolower($user->name.' '.$user->username) }}"
data-role="{{ $user->role }}">


<td class="px-6 py-5">

<p class="font-medium text-slate-800">
{{ $user->name }}
</p>

</td>



<td class="px-6 py-5 text-sm text-slate-600">

{{ $user->username }}

</td>



<td class="px-6 py-5">

{{ $user->role }}

</td>


<td class="px-6 py-5 text-right">


<button
    type="button"
    onclick='openEditModal(
        @json($user->name),
        @json($user->username),
        @json($user->role),
        {{ $user->id }}
    )'
    class="rounded-xl border px-4 py-2 text-sm text-[#7766A8]">

    แก้ไข

</button>



<form method="POST"
action="{{ route('owner.users.destroy',$user->id) }}"
class="inline">

@csrf
@method('DELETE')


<button
onclick="return confirm('ต้องการลบผู้ใช้นี้หรือไม่?')"
class="rounded-xl border px-4 py-2 text-sm text-[#C26B7A]">

ลบ

</button>


</form>


</td>


</tr>


@endforeach


</tbody>


</table>


</div>


</section>
{{-- MODAL --}}

<div id="userModal"
     class="hidden fixed inset-0 z-50 bg-slate-900/40 backdrop-blur-sm flex items-center justify-center px-4">


<div class="w-full max-w-lg rounded-[30px] bg-white p-7 shadow-2xl">


<p class="text-sm font-medium text-[#9B8AC9]">
User Account
</p>


<h3 id="modalTitle"
    class="mt-1 text-2xl font-semibold text-slate-800">
เพิ่มบัญชีผู้ใช้
</h3>




<form id="userForm"
      method="POST"
      class="mt-7 space-y-5">


@csrf



<input type="hidden"
       id="userId">



<div>

<label class="block mb-2 text-sm font-medium text-slate-700">
ชื่อ
</label>


<input id="modalName"
       name="name"
       type="text"
       class="w-full rounded-2xl border-[#DDD9E8] px-4 py-3">


</div>





<div>

<label class="block mb-2 text-sm font-medium text-slate-700">
Username
</label>


<input id="modalUsername"
       name="username"
       type="text"
       class="w-full rounded-2xl border-[#DDD9E8] px-4 py-3">


</div>





<div>

<label class="block mb-2 text-sm font-medium text-slate-700">
ประเภทบัญชี
</label>


<select id="modalRole"
        name="role"
        class="w-full rounded-2xl border-[#DDD9E8] px-4 py-3">


<option value="customer">
ลูกค้า
</option>


<option value="admin">
แอดมิน
</option>


<option value="owner">
เจ้าของร้าน
</option>


</select>


</div>





<div id="passwordArea">


<label class="block mb-2 text-sm font-medium text-slate-700">
รหัสผ่าน
</label>


<input id="modalPassword"
       name="password"
       type="password"
       class="w-full rounded-2xl border-[#DDD9E8] px-4 py-3">


</div>





<div class="mt-7 flex justify-end gap-3">


<button type="button"
        onclick="closeUserModal()"
        class="rounded-xl border px-5 py-2.5 text-sm text-[#7766A8]">

ยกเลิก

</button>




<button type="submit"
        class="rounded-xl bg-[#7766A8] px-5 py-2.5 text-sm text-white">

บันทึก

</button>



</div>


</form>


</div>


</div>





<div class="flex justify-center">

<a href="{{ route('owner.dashboard') }}"
   class="rounded-2xl border px-6 py-3 text-sm text-[#7766A8]">

กลับไปแดชบอร์ด

</a>

</div>




</div>

</div>






<script>


let userMode = 'create';





function openCreateModal(){


userMode = 'create';


document.getElementById('modalTitle').innerText =
'เพิ่มบัญชีผู้ใช้';


document.getElementById('userForm').action =
"{{ route('owner.users.store') }}";


document.getElementById('userForm').querySelector(
'input[name="_method"]'
)?.remove();



document.getElementById('modalName').value='';
document.getElementById('modalUsername').value='';
document.getElementById('modalRole').value='customer';
document.getElementById('modalPassword').value='';


document.getElementById('passwordArea')
.classList.remove('hidden');


document.getElementById('userModal')
.classList.remove('hidden');


}






function openEditModal(name, username, role, id) {

    userMode = 'edit';

    document.getElementById('modalTitle').innerText =
        'แก้ไขบัญชีผู้ใช้';

    // กำหนด URL สำหรับแก้ไข
    document.getElementById('userForm').action =
        "{{ url('/owner/users') }}/" + id;

    // ลบ _method เดิม ถ้ามี
    let oldMethod =
        document.querySelector('#userForm input[name="_method"]');

    if (oldMethod) {
        oldMethod.remove();
    }

    // สร้าง PUT
    let method = document.createElement('input');

    method.type = 'hidden';
    method.name = '_method';
    method.value = 'PUT';

    document.getElementById('userForm')
        .appendChild(method);

    // ใส่ข้อมูลเดิมของผู้ใช้
    document.getElementById('modalName').value = name;

    document.getElementById('modalUsername').value = username;

    document.getElementById('modalRole').value = role;

    // ล้างช่องรหัสผ่าน
    document.getElementById('modalPassword').value = '';

    // เปิดช่องรหัสผ่าน
    document.getElementById('passwordArea')
        .classList.remove('hidden');

    // เปิดหน้าต่างแก้ไข
    document.getElementById('userModal')
        .classList.remove('hidden');
}




function closeUserModal(){

document.getElementById('userModal')
.classList.add('hidden');

}





function filterUsers(){


let search =
document.getElementById('searchUser')
.value.toLowerCase();


let role =
document.getElementById('roleFilter').value;



document.querySelectorAll('.user-row')
.forEach(row=>{


let text=row.dataset.search;

let rowRole=row.dataset.role;



let show =
text.includes(search)
&&
(role==='all'||role===rowRole);



row.classList.toggle(
'hidden',
!show
);


});


}





document.getElementById('userModal')
.addEventListener('click',function(e){


if(e.target===this){

closeUserModal();

}


});


</script>


</x-app-layout>