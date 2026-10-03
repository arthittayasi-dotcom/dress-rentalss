<x-app-layout>
    @php
        $statusLabels = [
            'pending' => ['รออนุมัติ', '#FFF7E8', '#B97A32'],
            'approved' => ['อนุมัติแล้ว', '#EDF7FF', '#4F8DBA'],
            'renting' => ['กำลังเช่า', '#F3EDFF', '#8064AE'],
            'returned' => ['คืนชุดแล้ว', '#EAF8F0', '#378566'],
            'rejected' => ['ไม่อนุมัติ', '#FFF1F7', '#BF648C'],
            'cancelled' => ['ยกเลิกแล้ว', '#F1F5F9', '#64748B'],
        ];
    @endphp

    <div class="min-h-screen bg-[#FCFAFF] py-10">
        <div class="mx-auto max-w-7xl px-6">

            <div class="mb-8">
                <p class="text-sm tracking-widest text-[#9B8AC9]">
                    WANWAN
                </p>

                <h1 class="mt-2 text-3xl font-semibold text-slate-800">
                    ประวัติการเช่าทั้งหมด
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    ตรวจสอบรายการเช่าและสถานะของลูกค้าทั้งหมด
                </p>
            </div>

            <div class="overflow-hidden rounded-[30px] border border-[#EEE8F6] bg-white">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-[#FAF8FF]">
                            <tr class="text-left text-[#88799E]">
                                <th class="px-6 py-4">ชุด</th>
                                <th class="px-6 py-4">ลูกค้า</th>
                                <th class="px-6 py-4">นัดรับชุด</th>
                                <th class="px-6 py-4">กำหนดคืนชุด</th>
                                <th class="px-6 py-4">ราคา</th>
                                <th class="px-6 py-4">สถานะ</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#EEE8F6]">
                            @forelse($rentals as $rental)
                                @php
                                    $badge = $statusLabels[$rental->status]
                                        ?? ['ไม่ทราบสถานะ', '#F1F5F9', '#64748B'];
                                @endphp

                                <tr class="hover:bg-[#FDFBFF]">
                                    <td class="px-6 py-5 align-top">
                                        <p class="font-semibold text-slate-700">
                                            {{ $rental->dress->name ?? '-' }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#9B8AC9]">
                                            {{ $rental->dress->code ?? '' }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-5 align-top text-slate-700">
                                        {{ $rental->user->name ?? '-' }}
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-5 align-top">
                                        <p class="font-medium text-slate-700">
                                            {{ $rental->start_date->format('d/m/Y') }}
                                        </p>

                                        <span
                                            class="mt-2 inline-flex rounded-lg px-3 py-1 text-xs font-semibold"
                                            style="background: #F3EDFF; color: #7766A8;"
                                        >
                                            เวลา 08:00 น.
                                        </span>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-5 align-top">
                                        <p class="font-medium text-slate-700">
                                            {{ $rental->end_date->format('d/m/Y') }}
                                        </p>

                                        <span
                                            class="mt-2 inline-flex rounded-lg px-3 py-1 text-xs font-semibold"
                                            style="background: #FFF1F7; color: #C56690;"
                                        >
                                            ภายใน 18:00 น.
                                        </span>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-5 align-top font-semibold text-[#7766A8]">
                                        {{ number_format($rental->total_price, 2) }} บาท
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-5 align-top">
                                        <span
                                            class="inline-flex rounded-full px-3 py-2 text-xs font-semibold"
                                            style="background: {{ $badge[1] }}; color: {{ $badge[2] }};"
                                        >
                                            {{ $badge[0] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                        ยังไม่มีประวัติการเช่า
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>