<x-app-layout>
    @php
        $statusLabels = [
            'pending' => ['รออนุมัติ', '#FFF7E8', '#B97A32'],
            'approved' => ['อนุมัติแล้ว', '#EAF8F0', '#378566'],
            'renting' => ['กำลังเช่า', '#EDF7FF', '#4F8DBA'],
            'returned' => ['คืนชุดแล้ว', '#F3EDFF', '#8064AE'],
            'rejected' => ['ไม่อนุมัติ', '#FFF1F7', '#BF648C'],
            'cancelled' => ['ยกเลิกแล้ว', '#F1F5F9', '#64748B'],
        ];
    @endphp

    <div class="mx-auto max-w-7xl px-6 py-10">

        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <p class="text-sm tracking-widest text-[#9B8AC9]">
                    OWNER REPORT
                </p>

                <h1 class="mt-2 text-3xl font-semibold text-slate-800">
                    รายงานร้านเช่าชุด
                </h1>

                <p class="mt-2 text-slate-500">
                    ภาพรวมรายได้และข้อมูลการเช่า
                </p>
            </div>

            <a
                href="{{ route('owner.reports.pdf') }}"
                class="self-start rounded-xl bg-[#EEE7FF] px-5 py-3 font-medium text-[#7766A8] hover:bg-[#E4D9FF]"
            >
                📄 Export PDF
            </a>
        </div>

        {{-- สรุปข้อมูล --}}
        <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-[28px] border bg-white p-6">
                <p class="text-sm text-slate-400">
                    รายได้รวม
                </p>

                <p class="mt-3 text-3xl font-semibold text-[#7766A8]">
                    {{ number_format($totalSales, 2) }}
                </p>

                <span class="text-sm text-slate-400">
                    บาท
                </span>
            </div>

            <div class="rounded-[28px] border bg-white p-6">
                <p class="text-sm text-slate-400">
                    จำนวนการเช่า
                </p>

                <p class="mt-3 text-3xl font-semibold text-[#4F8DBA]">
                    {{ $totalRentals }}
                </p>

                <span class="text-sm text-slate-400">
                    รายการ
                </span>
            </div>

            <div class="rounded-[28px] border bg-white p-6">
                <p class="text-sm text-slate-400">
                    รายได้วันนี้
                </p>

                <p class="mt-3 text-3xl font-semibold text-[#67A88B]">
                    {{ number_format($todaySales, 2) }}
                </p>

                <span class="text-sm text-slate-400">
                    บาท
                </span>
            </div>

            <div class="rounded-[28px] border bg-white p-6">
                <p class="text-sm text-slate-400">
                    รายได้เดือนนี้
                </p>

                <p class="mt-3 text-3xl font-semibold text-[#C26B7A]">
                    {{ number_format($monthSales, 2) }}
                </p>

                <span class="text-sm text-slate-400">
                    บาท
                </span>
            </div>
        </div>

        {{-- ชุดยอดนิยม --}}
        <div class="mb-8 rounded-[30px] border bg-white p-6">
            <h2 class="text-xl font-semibold text-slate-800">
                ชุดยอดนิยม
            </h2>

            <div class="mt-4">
                @if($popularDress && $popularDress->dress)
                    <p class="text-lg font-semibold text-slate-700">
                        {{ $popularDress->dress->name }}
                    </p>

                    <p class="text-sm text-slate-500">
                        ถูกเช่า {{ $popularDress->total }} ครั้ง
                    </p>
                @else
                    <p class="text-slate-400">
                        ยังไม่มีข้อมูล
                    </p>
                @endif
            </div>
        </div>

        {{-- รายการเช่าล่าสุด --}}
        <div class="overflow-hidden rounded-[30px] border bg-white">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-slate-800">
                    รายการเช่าล่าสุด
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#FBF8FF]">
                        <tr class="text-left text-sm text-slate-600">
                            <th class="px-6 py-4">
                                ชุด
                            </th>

                            <th class="px-6 py-4">
                                ลูกค้า
                            </th>

                            <th class="px-6 py-4">
                                ราคา
                            </th>

                            <th class="px-6 py-4">
                                สถานะ
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#EEE8F6]">
                        @forelse($latestRentals as $rental)
                            @php
                                $statusBadge = $statusLabels[$rental->status]
                                    ?? ['ไม่ทราบสถานะ', '#F1F5F9', '#64748B'];
                            @endphp

                            <tr class="hover:bg-[#FDFBFF]">
                                <td class="px-6 py-4 text-slate-700">
                                    {{ $rental->dress->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-slate-700">
                                    {{ $rental->user->name ?? '-' }}
                                </td>

                                <td class="whitespace-nowrap px-6 py-4 text-slate-700">
                                    {{ number_format($rental->total_price, 2) }} บาท
                                </td>

                                <td class="whitespace-nowrap px-6 py-4">
                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-sm font-medium"
                                        style="background: {{ $statusBadge[1] }}; color: {{ $statusBadge[2] }};"
                                    >
                                        {{ $statusBadge[0] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-slate-400">
                                    ยังไม่มีรายการ
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>