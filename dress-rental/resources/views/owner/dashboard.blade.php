<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium uppercase tracking-[0.2em] text-[#9B8AC9]">
                Owner Dashboard
            </p>

            <h2 class="mt-2 text-3xl font-semibold text-slate-800">
                สรุปยอดขาย
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                ดูยอดขายรายวัน รายเดือน และตามช่วงวันที่
            </p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gradient-to-br from-[#FCFAFF] via-[#F8F6FF] to-[#FFF8FB] py-10">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">

            {{-- ภาพรวม --}}
            <section
                class="rounded-[34px] p-7 md:p-10"
                style="background: linear-gradient(120deg, #EDF7FF, #F5F0FF, #FFF0F6);"
            >
                <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <span class="rounded-full bg-white px-4 py-2 text-xs text-[#8D78BD]">
                            WANWAN
                        </span>

                        <h1 class="mt-5 text-3xl font-semibold text-slate-800 md:text-4xl">
                            ภาพรวมยอดขายของร้าน
                        </h1>

                        <p class="mt-4 text-sm leading-6 text-slate-600">
                            ติดตามยอดขายและจำนวนการเช่าตามวันที่สร้างรายการ
                        </p>
                    </div>

                    <a
                        href="{{ route('owner.reports') }}"
                        class="self-start whitespace-nowrap rounded-2xl px-7 py-3 text-sm font-medium text-white"
                        style="background: linear-gradient(120deg, #87BFE8, #A89CCF, #DEA9BF);"
                    >
                        ดูรายงานยอดขาย
                    </a>
                </div>
            </section>

            {{-- สถิติภาพรวม --}}
            <section class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-[26px] border border-[#EEE8F6] bg-white p-6">
                    <p class="text-sm text-slate-500">ยอดขายวันนี้</p>
                    <p class="mt-3 text-3xl font-semibold text-[#4F8DBA]">
                        {{ number_format($todaySales, 2) }}
                    </p>
                    <p class="mt-1 text-sm text-slate-400">บาท</p>
                </div>

                <div class="rounded-[26px] border border-[#EEE8F6] bg-white p-6">
                    <p class="text-sm text-slate-500">ยอดขายเดือนนี้</p>
                    <p class="mt-3 text-3xl font-semibold text-[#7766A8]">
                        {{ number_format($monthSales, 2) }}
                    </p>
                    <p class="mt-1 text-sm text-slate-400">บาท</p>
                </div>

                <div class="rounded-[26px] border border-[#EEE8F6] bg-white p-6">
                    <p class="text-sm text-slate-500">ยอดขายเดือนก่อน</p>
                    <p class="mt-3 text-3xl font-semibold text-[#D06C96]">
                        {{ number_format($lastMonthSales, 2) }}
                    </p>
                    <p class="mt-1 text-sm text-slate-400">บาท</p>
                </div>

                <div class="rounded-[26px] border border-[#EEE8F6] bg-white p-6">
                    <p class="text-sm text-slate-500">ค่าเฉลี่ยต่อรายการทั้งหมด</p>
                    <p class="mt-3 text-3xl font-semibold text-[#67A88B]">
                        {{ number_format($averageRental, 2) }}
                    </p>
                    <p class="mt-1 text-sm text-slate-400">บาท</p>
                </div>
            </section>

            {{-- เลือกช่วงวันที่ --}}
            <section class="rounded-[30px] border border-[#EEE8F6] bg-white p-6 md:p-7">
                <h3 class="text-xl font-semibold text-slate-800">
                    เลือกช่วงวันที่ดูยอดขาย
                </h3>

                <p class="mt-2 text-sm text-slate-500">
                    เลือกวันเริ่มต้นและวันสิ้นสุด หากต้องการดูวันเดียวให้เลือกวันที่เดียวกัน
                </p>

                @if($errors->any())
                    <div class="mt-4 rounded-2xl bg-red-50 p-4 text-sm text-red-700" role="alert">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form
                    method="GET"
                    action="{{ route('owner.dashboard') }}"
                    class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4 lg:items-end"
                >
                    <div>
                        <label for="start_date" class="mb-2 block text-sm font-medium text-slate-700">
                            วันที่เริ่มต้น
                        </label>

                        <input
                            id="start_date"
                            name="start_date"
                            type="date"
                            required
                            value="{{ old('start_date', request('start_date', $startDate->format('Y-m-d'))) }}"
                            class="h-12 w-full rounded-xl border-[#DDD9E8] bg-[#FCFBFE] text-sm focus:border-[#A89CCF] focus:ring-[#EEEAF8]"
                        >
                    </div>

                    <div>
                        <label for="end_date" class="mb-2 block text-sm font-medium text-slate-700">
                            วันที่สิ้นสุด
                        </label>

                        <input
                            id="end_date"
                            name="end_date"
                            type="date"
                            required
                            value="{{ old('end_date', request('end_date', $endDate->format('Y-m-d'))) }}"
                            class="h-12 w-full rounded-xl border-[#DDD9E8] bg-[#FCFBFE] text-sm focus:border-[#A89CCF] focus:ring-[#EEEAF8]"
                        >
                    </div>

                    <button
                        type="submit"
                        class="h-12 rounded-xl px-5 text-sm font-semibold text-white"
                        style="background: linear-gradient(120deg, #87BFE8, #A89CCF, #DEA9BF);"
                    >
                        ดูยอดขาย
                    </button>

                    <a
                        href="{{ route('owner.dashboard') }}"
                        class="flex h-12 items-center justify-center rounded-xl bg-[#F5F0FF] px-5 text-sm font-medium text-[#7766A8]"
                    >
                        กลับไป 7 วันล่าสุด
                    </a>
                </form>
            </section>

            {{-- ผลตามช่วงวันที่ --}}
            <section>
                <div class="mb-4">
                    <h3 class="text-xl font-semibold text-slate-800">
                        {{ $hasDateFilter ? 'สรุปช่วงวันที่เลือก' : 'สรุป 7 วันล่าสุด' }}
                    </h3>

                    <p class="mt-1 text-sm text-[#9B8AC9]">
                        {{ $startDate->format('d/m/Y') }}
                        – {{ $endDate->format('d/m/Y') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                    <div class="rounded-[26px] border border-[#EEE8F6] bg-white p-6">
                        <p class="text-sm text-slate-500">ยอดขายในช่วงวันที่</p>
                        <p class="mt-3 text-3xl font-semibold text-[#7766A8]">
                            {{ number_format($rangeSales, 2) }}
                        </p>
                        <p class="mt-1 text-sm text-slate-400">บาท</p>
                    </div>

                    <div class="rounded-[26px] border border-[#EEE8F6] bg-white p-6">
                        <p class="text-sm text-slate-500">จำนวนรายการในช่วงวันที่</p>
                        <p class="mt-3 text-3xl font-semibold text-[#4F8DBA]">
                            {{ number_format($rangeRentals) }}
                        </p>
                        <p class="mt-1 text-sm text-slate-400">รายการ</p>
                    </div>

                    <div class="rounded-[26px] border border-[#EEE8F6] bg-white p-6">
                        <p class="text-sm text-slate-500">ค่าเฉลี่ยต่อรายการในช่วงวันที่</p>
                        <p class="mt-3 text-3xl font-semibold text-[#67A88B]">
                            {{ number_format($rangeAverage, 2) }}
                        </p>
                        <p class="mt-1 text-sm text-slate-400">บาท</p>
                    </div>
                </div>
            </section>

            {{-- กราฟยอดขาย --}}
            <section class="rounded-[30px] border border-[#EEE8F6] bg-white p-6 md:p-7">
                <p class="text-sm font-medium text-[#9B8AC9]">
                    Daily Sales
                </p>

                <h3 class="mt-1 text-2xl font-semibold text-slate-800">
                    {{ $hasDateFilter ? 'ยอดขายตามช่วงวันที่เลือก' : 'ยอดขาย 7 วันล่าสุด' }}
                </h3>

                <p class="mt-2 text-sm text-slate-500">
                    ยอดขายรายวัน หน่วยบาท
                </p>

                @if($rangeRentals > 0)
                    @php
                        $maxAmount = max((float) $chartData->max(), 1);
                    @endphp

                    <div class="mt-6 overflow-x-auto">
                        <div
                            style="display:flex;gap:16px;min-width:100%;width:max-content;padding:12px 0;"
                        >
                            @foreach($chartData as $day => $amount)
                                @php
                                    $barHeight = $amount > 0
                                        ? max(4, ($amount / $maxAmount) * 220)
                                        : 2;
                                @endphp

                                <div style="flex:1 0 90px;min-width:90px;text-align:center;">
                                    <div style="height:260px;display:flex;flex-direction:column;justify-content:flex-end;align-items:center;">
                                        <p class="mb-2 text-xs text-slate-500">
                                            {{ number_format($amount, 2) }}
                                        </p>

                                        <div
                                            title="{{ $day }}: {{ number_format($amount, 2) }} บาท"
                                            style="
                                                width:48px;
                                                height:{{ $barHeight }}px;
                                                border-radius:12px 12px 0 0;
                                                background:{{ $amount > 0
                                                    ? 'linear-gradient(to top, #9BC9E8, #AEA1D2, #E3B1C6)'
                                                    : '#E2E8F0' }};
                                            "
                                        ></div>
                                    </div>

                                    <p class="mt-3 whitespace-nowrap text-xs text-slate-400">
                                        {{ $day }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="py-16 text-center">
                        <p class="font-medium text-slate-500">
                            ไม่มีรายการในช่วงวันที่นี้
                        </p>

                        <p class="mt-2 text-sm text-slate-400">
                            ลองเลือกช่วงวันที่อื่น
                        </p>
                    </div>
                @endif
            </section>

            {{-- รายละเอียดวันนี้และรายงาน --}}
            <section class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div class="rounded-[30px] border border-[#EEE8F6] bg-white p-7">
                    <p class="text-sm font-medium text-[#9B8AC9]">
                        Today
                    </p>

                    <h3 class="mt-1 text-xl font-semibold text-slate-800">
                        ยอดขายวันนี้
                    </h3>

                    <div class="mt-6 space-y-3">
                        <div class="flex items-center justify-between gap-3 rounded-2xl bg-[#FAF8FF] px-4 py-4">
                            <span class="text-sm text-slate-500">
                                จำนวนรายการเช่าวันนี้
                            </span>

                            <span class="whitespace-nowrap font-semibold text-slate-700">
                                {{ $todayRentals }} รายการ
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-3 rounded-2xl bg-[#F8FBFE] px-4 py-4">
                            <span class="text-sm text-slate-500">
                                ยอดขายวันนี้
                            </span>

                            <span class="whitespace-nowrap font-semibold text-[#4F8DBA]">
                                {{ number_format($todaySales, 2) }} บาท
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-3 rounded-2xl bg-[#FFF7FA] px-4 py-4">
                            <span class="text-sm text-slate-500">
                                ค่าเฉลี่ยต่อรายการวันนี้
                            </span>

                            <span class="whitespace-nowrap font-semibold text-[#D06C96]">
                                {{ number_format($todayRentals > 0 ? $todaySales / $todayRentals : 0, 2) }} บาท
                            </span>
                        </div>
                    </div>
                </div>

                <div class="rounded-[30px] border border-[#EEE8F6] bg-white p-7">
                    <p class="text-sm font-medium text-[#9B8AC9]">
                        Report
                    </p>

                    <h3 class="mt-1 text-xl font-semibold text-slate-800">
                        รายงานยอดขาย
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        ดูภาพรวมรายได้ ชุดยอดนิยม และรายการเช่าล่าสุด
                        พร้อมส่งออกรายงาน PDF จากหน้ารายงาน
                    </p>

                    <a
                        href="{{ route('owner.reports') }}"
                        class="mt-6 flex items-center justify-center rounded-2xl bg-[#7766A8] px-6 py-3 text-sm font-medium text-white"
                    >
                        เปิดรายงานยอดขาย
                    </a>
                </div>
            </section>

        </div>
    </div>

    <script>
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        function updateEndDateMin() {
            endDateInput.min = startDateInput.value;

            if (
                startDateInput.value &&
                endDateInput.value &&
                endDateInput.value < startDateInput.value
            ) {
                endDateInput.value = startDateInput.value;
            }
        }

        startDateInput.addEventListener('change', updateEndDateMin);
        updateEndDateMin();
    </script>
</x-app-layout>