<x-app-layout>

<div class="max-w-7xl mx-auto px-6 py-10">


    <div class="flex justify-between items-center mb-8">

        <div>

            <p class="text-sm text-[#8C80B4]">
                Dress Management
            </p>

            <h1 class="text-3xl font-semibold text-slate-800">
                จัดการชุด
            </h1>

        </div>



        <button
            onclick="document.getElementById('addModal').classList.remove('hidden')"
            class="px-5 py-3 rounded-2xl bg-[#7766A8] text-white">

            + เพิ่มชุด

        </button>

    </div>





   @if(session('success'))
    <div class="mb-5 rounded-2xl bg-green-100 px-5 py-3 text-green-700">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-5 rounded-2xl bg-red-100 px-5 py-3 text-red-700">
        <p class="font-semibold mb-2">เพิ่มชุดไม่สำเร็จ</p>

        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif






    <div class="bg-white rounded-[28px] border border-[#EEE8F6] overflow-hidden min-h-[920px]">


        <table class="w-full">


            <thead class="bg-[#FBF8FF]">

                <tr class="text-left text-sm">


                    <th class="px-5 py-4">
                        รูป
                    </th>


                    <th class="px-5 py-4">
                        รหัส
                    </th>


                    <th class="px-5 py-4">
                        ชื่อชุด
                    </th>


                    <th class="px-5 py-4">
                        ประเภท
                    </th>


                    <th class="px-5 py-4">
                        ราคา/วัน
                    </th>


                    <th class="px-5 py-4">
                        จัดการ
                    </th>


                </tr>

            </thead>




            <tbody>
            

            @foreach($dresses as $dress)


            <tr class="border-t">


                <td class="px-5 py-4">


                    @if($dress->image)

                    <img
                    src="{{ asset('storage/'.$dress->image) }}"
                    class="w-16 h-16 rounded-xl object-cover">


                    @else

                    <div class="w-16 h-16 rounded-xl bg-[#F5F0FF] flex items-center justify-center text-xs">

                        ไม่มีรูป

                    </div>

                    @endif


                </td>





                <td class="px-5 py-4">

                    {{ $dress->code }}

                </td>





                <td class="px-5 py-4 font-medium">

                    {{ $dress->name }}

                </td>





                <td class="px-5 py-4">

                    {{ $dress->type }}

                </td>





                <td class="px-5 py-4">

                    {{ number_format($dress->price_per_day,2) }}

                </td>



                <td class="px-5 py-4">


                    <div class="flex gap-2">


                        <button

                        onclick="document.getElementById('editModal{{ $dress->id }}').classList.remove('hidden')"

                        class="px-4 py-2 rounded-xl text-sm bg-[#F3EEFF] text-[#7766A8]">

                            ✏️ แก้ไข

                        </button>





                        <form method="POST"

                        action="{{ route('admin.dresses.destroy',$dress->id) }}">


                        @csrf

                        @method('DELETE')



                        <button

                        onclick="return confirm('ต้องการลบชุดนี้หรือไม่?')"

                        class="px-4 py-2 rounded-xl text-sm bg-[#FFF0F3] text-[#D46A8C]">


                            🗑 ลบ


                        </button>



                        </form>


                    </div>


                </td>



            </tr>


            @endforeach


            </tbody>


        </table>


    </div>


{{-- PAGINATION ต้องอยู่นอกกล่องตาราง --}}
<div class="flex justify-center items-center py-8 min-h-[100px]">

    {{ $dresses->links() }}

</div>









{{-- ADD --}}

<div id="addModal"

class="hidden fixed inset-0 bg-black/30 flex items-center justify-center">


<div class="bg-white rounded-[30px] p-8 w-full max-w-lg">


<h2 class="text-xl font-semibold mb-5">
เพิ่มชุด
</h2>



<form method="POST"

action="{{ route('admin.dresses.store') }}"

enctype="multipart/form-data">


@csrf


<input name="code"
placeholder="รหัสชุด"
class="w-full mb-3 rounded-xl border">


<input name="name"
placeholder="ชื่อชุด"
class="w-full mb-3 rounded-xl border">


<input name="type"
placeholder="ประเภท"
class="w-full mb-3 rounded-xl border">


<input name="size"
placeholder="ไซซ์"
class="w-full mb-3 rounded-xl border">


<input
    type="number"
    name="price_per_day"
    placeholder="ราคา/วัน"
    step="0.01"
    min="0"
    class="w-full mb-3 rounded-xl border px-4 py-3">


<input type="file"
name="image"
class="w-full mb-3">



<textarea name="description"
placeholder="รายละเอียด"
class="w-full mb-3 rounded-xl border"></textarea>



<button class="w-full py-3 rounded-xl bg-[#7766A8] text-white">

บันทึก

</button>


</form>


</div>

</div>









{{-- EDIT --}}

@foreach($dresses as $dress)


<div id="editModal{{ $dress->id }}"

class="hidden fixed inset-0 bg-black/30 flex items-center justify-center">


<div class="bg-white rounded-[30px] p-8 w-full max-w-lg">


<h2 class="text-xl font-semibold mb-5">

แก้ไขชุด

</h2>



<form method="POST"

action="{{ route('admin.dresses.update',$dress->id) }}"

enctype="multipart/form-data">


@csrf

@method('PUT')



<input name="name"

value="{{ $dress->name }}"

class="w-full mb-3 rounded-xl border">



<input name="type"

value="{{ $dress->type }}"

class="w-full mb-3 rounded-xl border">



<input name="size"

value="{{ $dress->size }}"

class="w-full mb-3 rounded-xl border">



<input name="price_per_day"

value="{{ $dress->price_per_day }}"

class="w-full mb-3 rounded-xl border">





<select name="status"

class="w-full mb-3 rounded-xl border px-4 py-3">




</select>





<input type="file"

name="image"

class="w-full mb-3">



<textarea name="description"

class="w-full mb-3 rounded-xl border">{{ $dress->description }}</textarea>



<button class="w-full py-3 rounded-xl bg-[#7766A8] text-white">

บันทึกแก้ไข

</button>



</form>


</div>


</div>


@endforeach





</x-app-layout>