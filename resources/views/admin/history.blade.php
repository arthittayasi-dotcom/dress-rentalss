<x-app-layout>
    @php
        $statusLabels = [
            'returned' => ['คืนชุดแล้ว', '#EAF8F0', '#378566'],
            'rejected' => ['ไม่อนุมัติ', '#FFF1F7', '#BF648C'],
            'cancelled' => ['ยกเลิกแล้ว', '#F1F5F9', '#64748B'],
        ];
    @endphp

    <div class="min-h-screen bg-[#FCFAFF] py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <p class="text-sm tracking-widest text-[#9B8AC9]">
                    RENTAL HISTORY
                </p>

                <h1 class="mt-2 text-3xl font-semibold text-slate-800">
                    ประวัติการเช่า
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    รายการเช่าที่ดำเนินการเสร็จแล้ว
                </p>

                <p class="mt-3 text-sm text-[#7766A8]">
                    เวลานัดตามกฎร้าน: รับชุด 08:00 น. และคืนภายใน 18:00 น.
                </p>
            </div>

            <div class="overflow-hidden rounded-[30px] border border-[#EEE8F6] bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-[#FAF8FF]">
                            <tr class="text-left text-[#88799E]">
                                <th class="whitespace-nowrap px-6 py-4 font-semibold">
                                    ชุด
                                </th>

                                <th class="whitespace-nowrap px-6 py-4 font-semibold">
                                    ลูกค้า
                                </th>

                                <th class="whitespace-nowrap px-6 py-4 font-semibold">
                                    นัดรับ / กำหนดคืน
                                </th>

                                <th class="whitespace-nowrap px-6 py-4 font-semibold">
                                    ราคา
                                </th>

                                <th class="whitespace-nowrap px-6 py-4 font-semibold">
                                    สถานะ
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#F1EDF6]">
                            @forelse($rentals as $rental)
                                @php
                                    $statusBadge = $statusLabels[$rental->status]
                                        ?? ['ไม่ทราบสถานะ', '#F1F5F9', '#64748B'];
                                @endphp

                                <tr class="hover:bg-[#FDFBFF]">
                                    <td class="px-6 py-5 align-top">
                                        <p class="font-semibold text-slate-700">
                                            {{ $rental->dress->code ?? '-' }}
                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ $rental->dress->name ?? '-' }}
                                        </p>
                                    </td>

                                    <td class="px-6 py-5 align-top">
                                        <p class="font-medium text-slate-700">
                                            {{ $rental->user->name ?? '-' }}
                                        </p>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-5 align-top">
                                        <div>
                                            <p class="text-xs text-slate-400">
                                                นัดรับชุด
                                            </p>

                                            <p class="mt-1 font-medium text-slate-700">
                                                {{ $rental->start_date->format('d/m/Y') }}
                                            </p>

                                            <span
                                                class="mt-2 inline-flex rounded-lg px-3 py-1 text-xs font-semibold"
                                                style="background: #F3EDFF; color: #7766A8;"
                                            >
                                                เวลา 08:00 น.
                                            </span>
                                        </div>

                                        <div class="mt-3">
                                            <p class="text-xs text-slate-400">
                                                กำหนดคืนชุด
                                            </p>

                                            <p class="mt-1 font-medium text-slate-700">
                                                {{ $rental->end_date->format('d/m/Y') }}
                                            </p>

                                            <span
                                                class="mt-2 inline-flex rounded-lg px-3 py-1 text-xs font-semibold"
                                                style="background: #FFF1F7; color: #C56690;"
                                            >
                                                ภายใน 18:00 น.
                                            </span>
                                        </div>
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-5 align-top font-semibold text-[#7766A8]">
                                        {{ number_format($rental->total_price ?? 0, 2) }} บาท
                                    </td>

                                    <td class="whitespace-nowrap px-6 py-5 align-top">
                                        <span
                                            class="inline-flex rounded-full px-3 py-2 text-xs font-semibold"
                                            style="background: {{ $statusBadge[1] }}; color: {{ $statusBadge[2] }};"
                                        >
                                            {{ $statusBadge[0] }}
                                        </span>
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <p class="text-lg font-semibold text-slate-600">
                                            ยังไม่มีประวัติการเช่า
                                        </p>

                                        <p class="mt-2 text-sm text-slate-400">
                                            รายการที่คืนชุดแล้ว ไม่อนุมัติ หรือยกเลิก จะแสดงที่นี่
                                        </p>
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