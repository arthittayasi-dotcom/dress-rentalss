<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium tracking-[0.2em] uppercase text-[#9B8AC9]">
                My Rentals
            </p>

            <h2 class="mt-2 text-3xl font-semibold text-slate-800">
                การเช่าของฉัน
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                ตรวจสอบรายการเช่าและสถานะคำขอของคุณ
            </p>
        </div>
    </x-slot>


    <div class="min-h-screen
                bg-gradient-to-br
                from-[#FCFAFF]
                via-[#F8F6FF]
                to-[#FFF8FB]
                py-10">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">


            {{-- SUCCESS --}}
            @if(session('success'))

                <div class="rounded-[24px]
                            border border-[#CDEADB]
                            bg-[#F3FCF7]
                            px-6 py-4
                            text-sm
                            text-[#478064]">

                    {{ session('success') }}

                </div>

            @endif



            {{-- HEADER CARD --}}
            <section class="rounded-[34px]
                            bg-gradient-to-r
                            from-[#EDF7FF]
                            via-[#F5F0FF]
                            to-[#FFF0F6]
                            border border-white
                            shadow-[0_18px_45px_rgba(120,90,170,0.08)]
                            p-8 md:p-10">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                    <div>

                        <span class="inline-flex
                                     rounded-full
                                     bg-white/80
                                     px-4 py-2
                                     text-xs font-medium
                                     text-[#8D78BD]">

                            Rental History

                        </span>

                        <h1 class="mt-5 text-3xl font-semibold text-slate-800">
                            รายการเช่าของคุณ
                        </h1>

                        <p class="mt-3 text-sm text-slate-500">
                            คุณมีรายการเช่าทั้งหมด {{ $rentals->count() }} รายการ
                        </p>

                    </div>


                    <a href="{{ route('customer.home') }}"
                       class="inline-flex
                              justify-center
                              rounded-2xl
                              px-6 py-3
                              text-sm font-medium
                              text-white
                              bg-gradient-to-r
                              from-[#87BFE8]
                              via-[#A89CCF]
                              to-[#DEA9BF]
                              shadow-md
                              hover:opacity-90
                              transition">

                        เช่าชุดเพิ่ม

                    </a>

                </div>

            </section>



            {{-- SUMMARY --}}
            <section class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="rounded-[24px]
                            bg-white
                            border border-[#EEE8F6]
                            p-5
                            shadow-sm">

                    <p class="text-xs text-slate-400">
                        ทั้งหมด
                    </p>

                    <p class="mt-2 text-2xl font-semibold text-[#7766A8]">
                        {{ $rentals->count() }}
                    </p>

                </div>


                <div class="rounded-[24px]
                            bg-white
                            border border-[#EEE8F6]
                            p-5
                            shadow-sm">

                    <p class="text-xs text-slate-400">
                        รออนุมัติ
                    </p>

                    <p class="mt-2 text-2xl font-semibold text-[#B97A32]">
                        {{ $rentals->where('status', 'pending')->count() }}
                    </p>

                </div>


                <div class="rounded-[24px]
                            bg-white
                            border border-[#EEE8F6]
                            p-5
                            shadow-sm">

                    <p class="text-xs text-slate-400">
                        กำลังเช่า
                    </p>

                    <p class="mt-2 text-2xl font-semibold text-[#7766A8]">
                        {{ $rentals->where('status', 'renting')->count() }}
                    </p>

                </div>


                <div class="rounded-[24px]
                            bg-white
                            border border-[#EEE8F6]
                            p-5
                            shadow-sm">

                    <p class="text-xs text-slate-400">
                        คืนแล้ว
                    </p>

                    <p class="mt-2 text-2xl font-semibold text-[#67A88B]">
                        {{ $rentals->where('status', 'returned')->count() }}
                    </p>

                </div>

            </section>



            {{-- RENTALS --}}
            @if($rentals->count() > 0)

                <section class="space-y-5">

                    @foreach($rentals as $rental)

                        <article class="rounded-[30px]
                                        bg-white
                                        border border-[#EEE8F6]
                                        shadow-[0_12px_35px_rgba(120,90,170,0.07)]
                                        p-6 md:p-7">

                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-7">


                                {{-- DRESS --}}
                                <div class="flex gap-5">

                                    <div class="w-24 h-28
                                                rounded-[22px]
                                                bg-gradient-to-br
                                                from-[#EDF7FF]
                                                via-[#F5F0FF]
                                                to-[#FFF0F6]
                                                flex items-center
                                                justify-center
                                                shrink-0">

                                        <span class="text-sm font-semibold text-[#8D78BD]">
                                            {{ $rental->dress->code ?? '-' }}
                                        </span>

                                    </div>


                                    <div>

                                        <div class="flex flex-wrap items-center gap-2">

                                            <span class="rounded-full
                                                         bg-[#F3F0FA]
                                                         px-3 py-1
                                                         text-xs font-semibold
                                                         text-[#7766A8]">

                                                {{ $rental->dress->code ?? '-' }}

                                            </span>


                                            {{-- STATUS --}}
                                            @if($rental->status === 'pending')

                                                <span class="rounded-full
                                                             bg-[#FFF7E8]
                                                             px-3 py-1
                                                             text-xs font-medium
                                                             text-[#B97A32]">

                                                    รออนุมัติ

                                                </span>

                                            @elseif($rental->status === 'approved')

                                                <span class="rounded-full
                                                             bg-[#EDF7FF]
                                                             px-3 py-1
                                                             text-xs font-medium
                                                             text-[#4F8DBA]">

                                                    อนุมัติแล้ว

                                                </span>

                                            @elseif($rental->status === 'rejected')

                                                <span class="rounded-full
                                                             bg-[#FFF7F8]
                                                             px-3 py-1
                                                             text-xs font-medium
                                                             text-[#C26B7A]">

                                                    ปฏิเสธ

                                                </span>

                                            @elseif($rental->status === 'renting')

                                                <span class="rounded-full
                                                             bg-[#F0EDFF]
                                                             px-3 py-1
                                                             text-xs font-medium
                                                             text-[#7766A8]">

                                                    กำลังเช่า

                                                </span>

                                            @elseif($rental->status === 'returned')

                                                <span class="rounded-full
                                                             bg-[#ECFDF5]
                                                             px-3 py-1
                                                             text-xs font-medium
                                                             text-[#378566]">

                                                    คืนแล้ว

                                                </span>

                                            @elseif($rental->status === 'cancelled')

                                                <span class="rounded-full
                                                             bg-slate-100
                                                             px-3 py-1
                                                             text-xs font-medium
                                                             text-slate-500">

                                                    ยกเลิกแล้ว

                                                </span>

                                            @endif

                                        </div>


                                        <h3 class="mt-3 text-lg font-semibold text-slate-800">
                                            {{ $rental->dress->name ?? 'ไม่พบข้อมูลชุด' }}
                                        </h3>


                                        <p class="mt-1 text-sm text-slate-500">

                                            @if($rental->dress)

                                                Size {{ $rental->dress->size ?? '-' }}

                                                @if($rental->dress->type)
                                                    · {{ $rental->dress->type }}
                                                @endif

                                            @endif

                                        </p>

                                    </div>

                                </div>



                                {{-- RENTAL DETAIL --}}
                                <div class="grid grid-cols-2 sm:grid-cols-4 gap-5 lg:min-w-[570px]">

                                    {{-- START DATE --}}
                                    <div>

                                        <p class="text-xs text-slate-400">
                                            วันที่เริ่มเช่า
                                        </p>

                                        <p class="mt-1 text-sm font-medium text-slate-700">
                                            {{ $rental->start_date->format('d/m/Y') }}
                                        </p>

                                    </div>


                                    {{-- END DATE --}}
                                    <div>

                                        <p class="text-xs text-slate-400">
                                            วันที่คืน
                                        </p>

                                        <p class="mt-1 text-sm font-medium text-slate-700">
                                            {{ $rental->end_date->format('d/m/Y') }}
                                        </p>

                                    </div>


                                    {{-- RENTAL DAYS --}}
                                    <div>

                                        <p class="text-xs text-slate-400">
                                            จำนวนวัน
                                        </p>

                                        <p class="mt-1 text-sm font-medium text-slate-700">
                                            {{ $rental->start_date->diffInDays($rental->end_date) }} วัน
                                        </p>

                                    </div>


                                    {{-- TOTAL --}}
                                    <div>

                                        <p class="text-xs text-slate-400">
                                            ยอดรวม
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-[#7766A8]">
                                            {{ number_format($rental->total_price, 0) }} ฿
                                        </p>

                                    </div>

                                </div>

                            </div>



                            {{-- REJECTION REASON --}}
                            @if($rental->status === 'rejected' && $rental->rejection_reason)

                                <div class="mt-6
                                            rounded-[20px]
                                            border border-[#F0D8DF]
                                            bg-[#FFF7F8]
                                            px-5 py-4">

                                    <p class="text-xs font-semibold text-[#B76575]">
                                        เหตุผลที่คำขอถูกปฏิเสธ
                                    </p>

                                    <p class="mt-2 text-sm text-[#8E5A64]">
                                        {{ $rental->rejection_reason }}
                                    </p>

                                </div>

                            @endif



                            @if(in_array($rental->status, ['pending', 'approved', 'renting']))
                            <div class="my-4">
                                <a class="inline-flex rounded-xl bg-[#FFF1F7] px-5 py-3 text-[#995467]" href="{{ route('customer.payment', $rental) }}">ชำระเงิน / แนบสลิป</a>
                                <p class="mt-2 text-sm">สถานะชำระเงิน: {{ ['unpaid'=>'ยังไม่ชำระ', 'pending'=>'รอตรวจสอบ', 'verified'=>'ตรวจสอบแล้ว', 'rejected'=>'สลิปไม่ผ่าน'][$rental->payment_status] ?? 'ยังไม่ชำระ' }}</p>
                            </div>
                            @endif
                            {{-- RETURN CONDITION --}}
                            @if($rental->status === 'returned' && $rental->return_condition)

                                <div class="mt-6
                                            rounded-[20px]
                                            border border-[#D7EADF]
                                            bg-[#F5FCF8]
                                            px-5 py-4">

                                    <p class="text-xs font-semibold text-[#478064]">
                                        ผลการตรวจรับคืน
                                    </p>

                                    <p class="mt-2 text-sm text-slate-600">
                                        สภาพชุด: {{ $rental->return_condition }}
                                    </p>

                                    @if($rental->return_note)

                                        <p class="mt-1 text-sm text-slate-500">
                                            หมายเหตุ: {{ $rental->return_note }}
                                        </p>

                                    @endif

                                </div>

                            @endif



                            <div class="mt-5 pt-5 border-t border-[#F1EDF6]">

                                <p class="text-xs text-slate-400">
                                    ส่งคำขอเมื่อ
                                    {{ $rental->created_at->format('d/m/Y H:i') }}
                                </p>

                            </div>

                        </article>

                    @endforeach

                </section>


            @else

                {{-- EMPTY --}}
                <section class="rounded-[32px]
                                bg-white
                                border border-[#EEE8F6]
                                p-12
                                text-center
                                shadow-sm">

                    <div class="mx-auto
                                w-20 h-20
                                rounded-full
                                bg-[#F3F0FA]
                                flex items-center
                                justify-center">

                        <span class="text-2xl text-[#7766A8]">
                            ♡
                        </span>

                    </div>


                    <h3 class="mt-5 text-xl font-semibold text-slate-700">
                        ยังไม่มีรายการเช่า
                    </h3>

                    <p class="mt-2 text-sm text-slate-500">
                        เลือกชุดที่คุณชอบแล้วส่งคำขอเช่าได้เลย
                    </p>


                    <a href="{{ route('customer.home') }}"
                       class="mt-6
                              inline-flex
                              rounded-2xl
                              px-6 py-3
                              text-sm font-medium
                              text-white
                              bg-gradient-to-r
                              from-[#87BFE8]
                              via-[#A89CCF]
                              to-[#DEA9BF]">

                        เลือกชุด

                    </a>

                </section>

            @endif


        </div>

    </div>

</x-app-layout>