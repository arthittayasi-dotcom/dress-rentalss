<x-app-layout>

    <x-slot name="header">

        <div>

            <p class="text-sm font-medium tracking-widest text-[#9B8AC9]">

                WANWAN

            </p>

            <h2 class="mt-2 text-2xl font-semibold text-slate-800">

                ตรวจสอบสถานะชุด

            </h2>

        </div>

    </x-slot>

    @php

        $hasDates = request()->filled('start_date')

            && request()->filled('end_date');

    @endphp

    <div class="min-h-screen bg-[#FCFAFF] py-8">

        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            {{-- กฎและเงื่อนไข --}}

<div class="rounded-[28px]

            bg-white/90

            border border-white

            shadow-[0_10px_30px_rgba(120,90,170,0.06)]

            p-7">

    <div class="flex items-center justify-between mb-6">

        <div>

            <p class="text-sm font-semibold text-[#8D78BD]">

                กฎและเงื่อนไขการเช่าชุด

            </p>

            <p class="mt-1 text-xs text-slate-400">

                กรุณาอ่านก่อนทำรายการเช่า

            </p>

        </div>

    </div>

    {{-- กฎ 3 ข้อ --}}

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- การจอง --}}

        <div class="rounded-2xl

                    bg-[#F8F5FF]

                    p-5">

            <h3 class="font-semibold text-[#7766A8]">

                การคืนชุด & ความเสียหาย

            </h3>

            <p class="mt-3 text-sm text-slate-600 leading-6">

                • คราบซักไม่ออก: จุดเล็ก ปรับ 20–50 บาท / จุดใหญ่ ปรับ 100 บาท<br>

                • ชุดขาด / อะไหล่หาย / ห้ามแก้ทรงเอง: ปรับตามความเสียหาย เริ่มต้น 50 บาท<br>

                • กรณีต้องซื้อชุดใหม่ 2 เท่าของราคาชุด<br>

                • คราบดูใหญ่จนน่าเกลียด<br>

                • คราบประจำเดือน / ตกขาว<br>

                • ชุดเสียหายจนปล่อยเช่าต่อไม่ได้<br>

            </p>

        </div>

        {{-- เวลารับและคืน --}}

        <div class="rounded-2xl

                    bg-[#FFF7FA]

                    p-5">

            <h3 class="font-semibold text-[#C56690]">

                เวลารับ - คืนชุด

            </h3>

            <p class="mt-3 text-sm text-slate-600 leading-6">

                • รับชุดได้ตั้งแต่เวลา 08:00 น.<br>

                • คืนชุดภายในเวลา 18:00 น. วันที่ทำการนัดคืน<br>

                • กรุณาคืนชุดตามวันที่นัดกำหนด

            </p>

        </div>

        {{-- ค่าปรับ --}}

        <div class="rounded-2xl

                    bg-[#EDF7FF]

                    p-5">

            <h3 class="font-semibold text-[#4F8DBA]">

                ค่าปรับคืนล่าช้า

            </h3>

            <p class="mt-3 text-sm text-slate-600 leading-6">

                • คืนชุดเกินเวลาที่กำหนด<br>

                • ค่าปรับ <span class="font-semibold text-[#4F8DBA]">

                    40 บาท / ชั่วโมง

                </span><br>

                • หากเกินเวลาโดยไม่แจ้งร้าน<br>ทางร้านขอสงวนสิทธิ์คิดค่าปรับตามเวลาที่เกินจริง

            </p>

        </div>

    </div>

</div>

            {{-- เลือกวันที่ --}}

            <section class="rounded-3xl border border-[#EEE8F6] bg-white p-6 sm:p-8">

                <h1 class="text-xl font-semibold text-slate-800">

                    เลือกวันที่ต้องการเช่า

                </h1>

                <p class="mt-2 text-sm text-slate-500">

                    ระบบจะตรวจสอบว่าชุดว่างในช่วงวันที่คุณเลือกหรือไม่

                    รวมวันที่รับและวันที่คืน

                </p>

                @if ($errors->any())

                    <div class="mt-4 rounded-xl bg-red-50 p-4 text-sm text-red-700">

                        @foreach ($errors->all() as $error)

                            <p>{{ $error }}</p>

                        @endforeach

                    </div>

                @endif

                <form

                    method="GET"

                    action="{{ route('customer.home') }}"

                    class="mt-6 flex flex-wrap items-end gap-4"

                >

                    <div>

                        <label

                            for="check_start"

                            class="mb-2 block text-sm font-medium text-slate-700"

                        >

                            วันที่เริ่มเช่า

                        </label>

                        <input

                            id="check_start"

                            name="start_date"

                            type="date"

                            value="{{ request('start_date') }}"

                            min="{{ today()->format('Y-m-d') }}"

                            required

                            class="h-12 rounded-xl border border-[#DDD9E8]

                                   bg-[#FCFBFE] px-3 text-slate-700

                                   focus:border-[#A89CCF] focus:ring-[#EEEAF8]"

                        >

                    </div>

                    <div>

                        <label

                            for="check_end"

                            class="mb-2 block text-sm font-medium text-slate-700"

                        >

                            วันที่คืน

                        </label>

                        <input

                            id="check_end"

                            name="end_date"

                            type="date"

                            value="{{ request('end_date') }}"

                            min="{{ request('start_date') ?: today()->format('Y-m-d') }}"

                            required

                            class="h-12 rounded-xl border border-[#DDD9E8]

                                   bg-[#FCFBFE] px-3 text-slate-700

                                   focus:border-[#A89CCF] focus:ring-[#EEEAF8]"

                        >

                    </div>

                    <button

                        type="submit"

                        class="h-12 rounded-xl bg-[#995467] px-6 font-medium text-white"

                    >

                        ตรวจสอบชุดว่าง

                    </button>

                    <a

                        href="{{ route('customer.home') }}"

                        class="flex h-12 items-center rounded-xl border border-[#DDD9E8]

                               px-5 text-sm text-[#7766A8]"

                    >

                        ล้างวันที่

                    </a>

                </form>

                @if ($hasDates)

                    <p class="mt-5 rounded-xl bg-[#F5F0FF] p-4 text-sm text-[#7766A8]">

                        ผลตรวจสอบช่วงวันที่

                        <span class="font-semibold">

                            {{ \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') }}

                            –

                            {{ \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') }}

                        </span>

                    </p>

                @endif

            </section>

            {{-- ตารางสถานะชุด --}}

            <section class="overflow-hidden rounded-3xl border border-[#EEE8F6] bg-white">

                <div class="flex flex-wrap items-center justify-between gap-4 p-6">

                    <div>

                        <h2 class="text-xl font-semibold text-slate-800">

                            สถานะชุดทั้งหมด

                        </h2>

                        <p class="mt-2 text-sm text-slate-500">

                            พบ {{ $dresses->total() }} ชุด

                        </p>

                    </div>

                    <a

                        href="{{ route('customer.dresses') }}"

                        class="rounded-xl bg-gradient-to-r

                               from-[#87BFE8] via-[#A89CCF] to-[#DEA9BF]

                               px-5 py-3 text-sm font-medium text-white"

                    >

                        ไปเลือกชุด

                    </a>

                </div>

                <div class="overflow-x-auto">

                    <table class="w-full text-left text-sm">

                        <thead class="bg-[#FAF7FF] text-slate-700">

                            <tr>

                                <th class="whitespace-nowrap px-5 py-4">รหัสชุด</th>

                                <th class="px-5 py-4">ชื่อชุด</th>

                                <th class="px-5 py-4">ขนาด</th>

                                <th class="whitespace-nowrap px-5 py-4">ราคา / วัน</th>

                                <th class="whitespace-nowrap px-5 py-4">สถานะในวันที่เลือก</th>

                                <th class="whitespace-nowrap px-5 py-4">วันที่ไม่ว่าง</th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-[#EEE8F6]">

                            @forelse ($dresses as $dress)

                                @php

                                    $maintenance = $dress->status === 'maintenance';

                                    $conflicts = $dress->unavailableRentals->filter(

                                        fn ($booking) => $hasDates

                                            && $booking->start_date->format('Y-m-d') <= request('end_date')

                                            && $booking->end_date->format('Y-m-d') >= request('start_date')

                                    );

                                @endphp

                                <tr class="hover:bg-[#FCFAFF]">

                                    <td class="whitespace-nowrap px-5 py-5 text-slate-500">

                                        {{ $dress->code }}

                                    </td>

                                    <td class="px-5 py-5 font-medium text-slate-800">

                                        {{ $dress->name }}

                                    </td>

                                    <td class="px-5 py-5 text-slate-600">

                                        {{ $dress->size ?? '-' }}

                                    </td>

                                    <td class="whitespace-nowrap px-5 py-5 text-[#7766A8]">

                                        {{ number_format($dress->price_per_day, 2) }} บาท

                                    </td>

                                    <td class="px-5 py-5">

                                        @if ($maintenance)

                                            <span class="inline-block whitespace-nowrap rounded-full bg-slate-100 px-3 py-1.5 text-xs text-slate-600">

                                                อยู่ระหว่างดูแลชุด

                                            </span>

                                        @elseif (!$hasDates)

                                            <span class="inline-block whitespace-nowrap rounded-full bg-[#F5F0FF] px-3 py-1.5 text-xs text-[#7766A8]">

                                                กรุณาเลือกวันที่เพื่อตรวจสอบ

                                            </span>

                                        @elseif ($conflicts->isNotEmpty())

                                            <span class="inline-block whitespace-nowrap rounded-full bg-red-50 px-3 py-1.5 text-xs text-red-600">

                                                ไม่ว่างในวันที่เลือก

                                            </span>

                                        @else

                                            <span class="inline-block whitespace-nowrap rounded-full bg-green-50 px-3 py-1.5 text-xs text-green-700">

                                                ว่างในวันที่เลือก

                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-5 py-5 text-slate-500">

                                        @if ($maintenance)

                                            อยู่ระหว่างดูแลชุด กรุณาติดต่อร้าน

                                        @elseif (!$hasDates)

                                            เลือกวันที่เพื่อดูช่วงที่ติดจอง

                                        @elseif ($conflicts->isNotEmpty())

                                            @foreach ($conflicts->sortBy('start_date') as $booking)

                                                <p class="whitespace-nowrap">

                                                    {{ $booking->start_date->format('d/m/Y') }}

                                                    –

                                                    {{ $booking->end_date->format('d/m/Y') }}

                                                </p>

                                            @endforeach

                                        @else

                                            ไม่มีรายการจองทับช่วงวันที่เลือก

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td

                                        colspan="6"

                                        class="px-5 py-12 text-center text-slate-400"

                                    >

                                        ยังไม่มีชุดให้บริการ

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="border-t border-[#EEE8F6] p-5">

                    @if ($dresses->hasPages())
<nav aria-label="เลขหน้ารายการ" style="display:flex;justify-content:center;gap:8px;flex-wrap:wrap;">
    @if ($dresses->onFirstPage())
        <span style="padding:10px 15px;border-radius:12px;background:#F1F1F5;color:#B5B0C2;">‹</span>
    @else
        <a href="{{ $dresses->previousPageUrl() }}" aria-label="หน้าก่อนหน้า" style="padding:10px 15px;border-radius:12px;background:#EDF7FF;color:#4F8DBA;text-decoration:none;">‹</a>
    @endif
    @foreach ($dresses->getUrlRange(max(1, $dresses->currentPage() - 2), min($dresses->lastPage(), $dresses->currentPage() + 2)) as $page => $url)
        @if ((int) $page === $dresses->currentPage())
            <span aria-current="page" style="padding:10px 17px;border-radius:12px;background:linear-gradient(135deg,#87BFE8,#A89CCF,#DEA9BF);color:white;font-weight:700;box-shadow:0 3px 10px rgba(168,156,207,0.35);">{{ $page }}</span>
        @else
            <a href="{{ $url }}" aria-label="ไปหน้า {{ $page }}" style="padding:10px 17px;border-radius:12px;background:#F5F0FF;color:#7766A8;border:1px solid #E6DDF5;text-decoration:none;">{{ $page }}</a>
        @endif
    @endforeach
    @if ($dresses->hasMorePages())
        <a href="{{ $dresses->nextPageUrl() }}" aria-label="หน้าถัดไป" style="padding:10px 15px;border-radius:12px;background:#FFF1F7;color:#C56690;text-decoration:none;">›</a>
    @else
        <span style="padding:10px 15px;border-radius:12px;background:#F1F1F5;color:#B5B0C2;">›</span>
    @endif
</nav>
@endif

                </div>

            </section>

        </div>

    </div>

    <script>

        (() => {

            const start = document.getElementById('check_start');

            const end = document.getElementById('check_end');

            start.addEventListener('change', () => {

                end.min = start.value || start.min;

                if (end.value && end.value < end.min) {

                    end.value = '';

                }

            });

        })();

    </script>

</x-app-layout>