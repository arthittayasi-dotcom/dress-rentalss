<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium tracking-widest text-[#9B8AC9]">
                WANWAN
            </p>

            <h2 class="mt-2 text-3xl font-semibold text-slate-800">
                รายการเช่าชุด
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                ตรวจสอบการชำระเงินและจัดการคำขอเช่าจากลูกค้า
            </p>
        </div>
    </x-slot>

    <style>
        .wanwan-table th {
            padding: 18px 20px;
            text-align: left;
            white-space: nowrap;
            color: #88799e;
            font-weight: 600;
            background: #faf8ff;
        }

        .wanwan-table td {
            padding: 20px;
            vertical-align: top;
        }

        .wanwan-table .rental-row:hover {
            background: #fdfbff;
        }

        .wanwan-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .wanwan-actions {
            display: grid;
            gap: 8px;
            width: 150px;
        }

        .wanwan-actions form {
            margin: 0;
        }

        .wanwan-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 40px;
            padding: 10px 14px;
            border: 1px solid transparent;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            line-height: 20px;
            text-decoration: none;
            cursor: pointer;
            transition: opacity .2s, transform .2s;
        }

        .wanwan-button:hover {
            opacity: .85;
            transform: translateY(-1px);
        }

        .wanwan-button.green {
            background: #eaf8f0;
            border-color: #d2ecde;
            color: #378566;
        }

        .wanwan-button.pink {
            background: #fff1f7;
            border-color: #f4dce8;
            color: #bf648c;
        }

        .wanwan-button.blue {
            background: #edf7ff;
            border-color: #d5e9f8;
            color: #4f8dba;
        }

        .wanwan-button.purple {
            background: #f3edff;
            border-color: #e6dcf6;
            color: #8064ae;
        }

        .wanwan-date-label {
            margin: 0;
            font-size: 12px;
            color: #94a3b8;
        }

        .wanwan-date-value {
            margin: 4px 0 0;
            font-weight: 500;
            color: #334155;
        }

        .wanwan-time {
            display: inline-flex;
            margin-top: 6px;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }

        .wanwan-time.pickup {
            background: #f3edff;
            color: #7766a8;
        }

        .wanwan-time.return {
            background: #fff1f7;
            color: #c56690;
        }
    </style>

    @php
        $rentalStatuses = [
            'pending' => ['รออนุมัติ', '#FFF7E8', '#B97A32'],
            'approved' => ['อนุมัติแล้ว', '#EDF7FF', '#4F8DBA'],
            'renting' => ['กำลังเช่า', '#F3EDFF', '#8064AE'],
            'returned' => ['คืนชุดแล้ว', '#EAF8F0', '#378566'],
            'rejected' => ['ไม่อนุมัติ', '#FFF1F7', '#BF648C'],
            'cancelled' => ['ยกเลิกแล้ว', '#F1F5F9', '#64748B'],
        ];

        $paymentStatuses = [
            'unpaid' => ['ยังไม่ชำระ', '#F1F5F9', '#64748B'],
            'pending' => ['รอตรวจสอบ', '#FFF7E8', '#B97A32'],
            'verified' => ['ตรวจสอบแล้ว', '#EAF8F0', '#378566'],
            'rejected' => ['สลิปไม่ผ่าน', '#FFF1F7', '#BF648C'],
        ];
    @endphp

    <div class="min-h-screen bg-[#FCFAFF] py-10">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div
                    class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700"
                    role="status"
                >
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div
                    class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700"
                    role="alert"
                >
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div
                    class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700"
                    role="alert"
                >
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <section
                class="rounded-3xl p-7"
                style="background: linear-gradient(120deg, #EDF7FF, #F5F0FF, #FFF0F6);"
            >
                <h1 class="text-2xl font-semibold text-slate-800">
                    คำขอเช่าทั้งหมด
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    แสดง {{ $rentals->count() }} รายการ
                </p>

                <p class="mt-3 text-sm text-[#7766A8]">
                    นัดรับชุดเวลา 08:00 น. และคืนชุดภายใน 18:00 น. ของวันกำหนดคืน
                </p>
            </section>

            <section class="overflow-hidden rounded-3xl border border-[#EEE8F6] bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="wanwan-table w-full text-sm">
                        <thead>
                            <tr>
                                <th>ลูกค้า</th>
                                <th>ชุด</th>
                                <th>นัดรับ / กำหนดคืน</th>
                                <th>ราคา</th>
                                <th>สถานะการเช่า</th>
                                <th>การชำระเงิน</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#F1EDF6]">
                            @forelse($rentals as $rental)
                                @php
                                    $rentalBadge = $rentalStatuses[$rental->status]
                                        ?? ['ไม่ทราบสถานะ', '#F1F5F9', '#64748B'];

                                    $paymentBadge = $paymentStatuses[$rental->payment_status ?? 'unpaid']
                                        ?? ['ไม่ทราบสถานะ', '#F1F5F9', '#64748B'];
                                @endphp

                                <tr class="rental-row">
                                    {{-- ลูกค้า --}}
                                    <td>
                                        <p class="font-semibold text-slate-700">
                                            {{ $rental->user->name ?? '-' }}
                                        </p>

                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ $rental->user->username ?? '' }}
                                        </p>
                                    </td>

                                    {{-- ชุด --}}
                                    <td>
                                        <p class="font-semibold text-slate-700">
                                            {{ $rental->dress->name ?? '-' }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#9B8AC9]">
                                            {{ $rental->dress->code ?? '' }}
                                        </p>
                                    </td>

                                    {{-- เวลานัดตามกฎร้าน --}}
                                    <td class="whitespace-nowrap">
                                        <div>
                                            <p class="wanwan-date-label">
                                                นัดรับชุด
                                            </p>

                                            <p class="wanwan-date-value">
                                                {{ $rental->start_date->format('d/m/Y') }}
                                            </p>

                                            <span class="wanwan-time pickup">
                                                เวลา 08:00 น.
                                            </span>
                                        </div>

                                        <div class="mt-3">
                                            <p class="wanwan-date-label">
                                                กำหนดคืนชุด
                                            </p>

                                            <p class="wanwan-date-value">
                                                {{ $rental->end_date->format('d/m/Y') }}
                                            </p>

                                            <span class="wanwan-time return">
                                                ภายใน 18:00 น.
                                            </span>
                                        </div>
                                    </td>

                                    {{-- ราคา --}}
                                    <td class="whitespace-nowrap font-semibold text-[#7766A8]">
                                        {{ number_format($rental->total_price, 2) }} บาท
                                    </td>

                                    {{-- สถานะการเช่า --}}
                                    <td>
                                        <span
                                            class="wanwan-badge"
                                            style="background: {{ $rentalBadge[1] }}; color: {{ $rentalBadge[2] }};"
                                        >
                                            {{ $rentalBadge[0] }}
                                        </span>
                                    </td>

                                    {{-- การชำระเงิน --}}
                                    <td>
                                        <div class="wanwan-actions">
                                            <span
                                                class="wanwan-badge"
                                                style="background: {{ $paymentBadge[1] }}; color: {{ $paymentBadge[2] }};"
                                            >
                                                {{ $paymentBadge[0] }}
                                            </span>

                                            @if($rental->slip_path)
                                                <a
                                                    href="{{ route('admin.payment.slip', $rental->id) }}"
                                                    target="_blank"
                                                    rel="noopener"
                                                    class="wanwan-button purple"
                                                >
                                                    ดูสลิปชำระเงิน
                                                </a>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- จัดการ --}}
                                    <td>
                                        <div class="wanwan-actions">
                                            @if($rental->status === 'pending')
                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.rentals.approve', $rental->id) }}"
                                                >
                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="wanwan-button green"
                                                    >
                                                        อนุมัติการเช่า
                                                    </button>
                                                </form>

                                                <button
                                                    type="button"
                                                    class="wanwan-button pink"
                                                    aria-controls="reject-{{ $rental->id }}"
                                                    aria-expanded="false"
                                                    onclick="toggleReject({{ $rental->id }}, this)"
                                                >
                                                    ปฏิเสธคำขอ
                                                </button>

                                            @elseif($rental->status === 'approved')
                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.rentals.start', $rental->id) }}"
                                                >
                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="wanwan-button blue"
                                                    >
                                                        รับชุด / เริ่มเช่า
                                                    </button>
                                                </form>

                                            @elseif($rental->status === 'renting')
                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.rentals.return', $rental->id) }}"
                                                >
                                                    @csrf

                                                    <input
                                                        type="hidden"
                                                        name="return_condition"
                                                        value="ปกติ"
                                                    >

                                                    <button
                                                        type="submit"
                                                        class="wanwan-button purple"
                                                    >
                                                        รับคืนชุด
                                                    </button>
                                                </form>

                                            @else
                                                <span class="py-2 text-center text-slate-400">
                                                    —
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                {{-- ช่องกรอกเหตุผลปฏิเสธ --}}
                                @if($rental->status === 'pending')
                                    <tr id="reject-{{ $rental->id }}" hidden>
                                        <td colspan="7" style="background: #FFF8FB;">
                                            <form
                                                method="POST"
                                                action="{{ route('admin.rentals.reject', $rental->id) }}"
                                            >
                                                @csrf

                                                <label
                                                    for="reason-{{ $rental->id }}"
                                                    class="mb-3 block font-medium text-[#BF648C]"
                                                >
                                                    เหตุผลที่ปฏิเสธคำขอ
                                                </label>

                                                <div class="flex flex-col gap-3 sm:flex-row">
                                                    <input
                                                        id="reason-{{ $rental->id }}"
                                                        name="rejection_reason"
                                                        type="text"
                                                        required
                                                        placeholder="ระบุเหตุผลที่ปฏิเสธ..."
                                                        class="min-w-0 flex-1 rounded-xl border-[#E8D7DE] text-sm focus:border-[#D68AAE] focus:ring-[#F4DCE8]"
                                                    >

                                                    <button
                                                        type="submit"
                                                        class="wanwan-button pink"
                                                        style="width: 150px;"
                                                    >
                                                        ยืนยันการปฏิเสธ
                                                    </button>

                                                    <button
                                                        type="button"
                                                        class="wanwan-button purple"
                                                        style="width: 100px;"
                                                        onclick="closeReject({{ $rental->id }})"
                                                    >
                                                        ยกเลิก
                                                    </button>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endif

                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="py-10">
                                            <p class="text-lg font-semibold text-slate-600">
                                                ยังไม่มีรายการเช่า
                                            </p>

                                            <p class="mt-2 text-sm text-slate-400">
                                                เมื่อมีลูกค้าส่งคำขอ รายการจะแสดงที่นี่
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </div>

    <script>
        function toggleReject(id, button) {
            const row = document.getElementById('reject-' + id);

            row.hidden = !row.hidden;
            button.setAttribute('aria-expanded', String(!row.hidden));

            if (!row.hidden) {
                document.getElementById('reason-' + id).focus();
            }
        }

        function closeReject(id) {
            document.getElementById('reject-' + id).hidden = true;

            const button = document.querySelector(
                '[aria-controls="reject-' + id + '"]'
            );

            if (button) {
                button.setAttribute('aria-expanded', 'false');
                button.focus();
            }
        }
    </script>
</x-app-layout>