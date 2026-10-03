<x-app-layout>
    <div class="min-h-screen bg-[#FCFAFF] py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <p class="text-sm tracking-widest text-[#9B8AC9]">
                    RETURN MANAGEMENT
                </p>

                <h1 class="mt-2 text-3xl font-semibold text-slate-800">
                    ตรวจสอบคืนชุด
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    รายการชุดที่รอรับและกำลังเช่า
                </p>

                <p class="mt-3 text-sm text-[#7766A8]">
                    นัดรับชุดเวลา 08:00 น. และคืนชุดภายใน 18:00 น. ของวันกำหนดคืน
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
                                    นัดรับชุด
                                </th>

                                <th class="whitespace-nowrap px-6 py-4 font-semibold">
                                    กำหนดคืนชุด
                                </th>

                                <th class="whitespace-nowrap px-6 py-4 font-semibold">
                                    สถานะ
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#F1EDF6]">
                            @forelse($rentals as $rental)
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

                                    <td class="whitespace-nowrap px-6 py-5 align-top">
                                        @if($rental->status === 'approved')
                                            <span
                                                class="inline-flex rounded-full px-3 py-2 text-xs font-semibold"
                                                style="background: #FFF7E8; color: #B97A32;"
                                            >
                                                รอรับชุด
                                            </span>

                                        @elseif($rental->status === 'renting')
                                            <span
                                                class="inline-flex rounded-full px-3 py-2 text-xs font-semibold"
                                                style="background: #F3EDFF; color: #8064AE;"
                                            >
                                                กำลังเช่า
                                            </span>

                                        @else
                                            <span class="text-slate-400">
                                                —
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <p class="text-lg font-semibold text-slate-600">
                                            ไม่มีรายการรอรับหรือคืนชุด
                                        </p>

                                        <p class="mt-2 text-sm text-slate-400">
                                            รายการที่อนุมัติแล้วและกำลังเช่าจะแสดงที่นี่
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