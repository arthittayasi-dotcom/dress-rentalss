<x-app-layout>
    <style>
        .ww-table th {
            padding: 18px 20px;
            text-align: left;
            white-space: nowrap;
            background: #FBF8FF;
            color: #88799E;
            font-size: 13px;
            font-weight: 600;
        }

        .ww-table td {
            padding: 20px;
            vertical-align: top;
        }

        .ww-table tbody > tr:hover {
            background: #FDFBFF;
        }

        .ww-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .ww-actions {
            display: grid;
            gap: 8px;
            width: 180px;
        }

        .ww-actions form {
            margin: 0;
        }

        .ww-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            line-height: 20px;
            text-decoration: none;
            cursor: pointer;
            transition: opacity .2s;
        }

        .ww-button:hover {
            opacity: .8;
        }

        .ww-button.green {
            background: #EAF8F0;
            border-color: #D2ECDE;
            color: #378566;
        }

        .ww-button.pink {
            background: #FFF1F7;
            border-color: #F4DCE8;
            color: #BF648C;
        }

        .ww-button.blue {
            background: #EDF7FF;
            border-color: #D5E9F8;
            color: #4F8DBA;
        }

        .ww-button.purple {
            background: #F3EDFF;
            border-color: #E6DCF6;
            color: #8064AE;
        }

        .ww-panel {
            padding: 12px;
            border: 1px solid #EEE8F6;
            border-radius: 14px;
            background: #FCFAFF;
        }

        .ww-input {
            display: block;
            box-sizing: border-box;
            width: 100%;
            padding: 10px;
            border: 1px solid #DDD9E8;
            border-radius: 10px;
            background: white;
            font-size: 12px;
        }

        .ww-time {
            display: inline-flex;
            margin-top: 6px;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>

    @php
        $statusLabels = [
            'pending' => ['รออนุมัติ', '#FFF7E8', '#B97A32'],
            'approved' => ['อนุมัติแล้ว', '#EDF7FF', '#4F8DBA'],
            'renting' => ['กำลังเช่า', '#F3EDFF', '#8064AE'],
            'returned' => ['คืนชุดแล้ว', '#EAF8F0', '#378566'],
            'rejected' => ['ไม่อนุมัติ', '#FFF1F7', '#BF648C'],
            'cancelled' => ['ยกเลิกแล้ว', '#F1F5F9', '#64748B'],
        ];

        $paymentLabels = [
            'unpaid' => ['ยังไม่ชำระ', '#F1F5F9', '#64748B'],
            'pending' => ['รอตรวจสอบ', '#FFF7E8', '#B97A32'],
            'verified' => ['ตรวจสอบแล้ว', '#EAF8F0', '#378566'],
            'rejected' => ['สลิปไม่ผ่าน', '#FFF1F7', '#BF648C'],
        ];
    @endphp

    <div class="min-h-screen bg-[#FCFAFF] py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <p class="text-sm tracking-widest text-[#9B8AC9]">
                    WANWAN
                </p>

                <h1 class="mt-2 text-3xl font-semibold text-slate-800">
                    รายการเช่าชุด
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    ตรวจสอบการชำระเงินและจัดการคำขอเช่าจากลูกค้า
                </p>

                <p class="mt-3 text-sm text-[#7766A8]">
                    นัดรับชุดเวลา 08:00 น. และคืนชุดภายใน 18:00 น. ของวันกำหนดคืน
                </p>
            </div>

            @if(session('success'))
                <div
                    class="mb-5 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700"
                    role="status"
                >
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div
                    class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700"
                    role="alert"
                >
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div
                    class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700"
                    role="alert"
                >
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="overflow-hidden rounded-[28px] border border-[#EEE8F6] bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="ww-table w-full text-sm">
                        <thead>
                            <tr>
                                <th>ชุด</th>
                                <th>ลูกค้า</th>
                                <th>นัดรับ / กำหนดคืน</th>
                                <th>จำนวนวัน</th>
                                <th>ราคา</th>
                                <th>สถานะ</th>
                                <th>การชำระเงิน</th>
                                <th>จัดการ</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#F1EDF6]">
                            @forelse($rentals as $rental)
                                @php
                                    $statusBadge = $statusLabels[$rental->status]
                                        ?? ['ไม่ทราบสถานะ', '#F1F5F9', '#64748B'];

                                    $paymentBadge = $paymentLabels[$rental->payment_status ?? 'unpaid']
                                        ?? ['ไม่ทราบสถานะ', '#F1F5F9', '#64748B'];
                                @endphp

                                <tr>
                                    {{-- ชุด --}}
                                    <td>
                                        <p class="font-semibold text-slate-700">
                                            {{ $rental->dress->name ?? '-' }}
                                        </p>

                                        <p class="mt-1 text-xs text-[#9B8AC9]">
                                            {{ $rental->dress->code ?? '' }}
                                        </p>
                                    </td>

                                    {{-- ลูกค้า --}}
                                    <td>
                                        <p class="font-medium text-slate-700">
                                            {{ $rental->user->name ?? '-' }}
                                        </p>
                                    </td>

                                    {{-- เวลานัดตามกฎร้าน --}}
                                    <td class="whitespace-nowrap">
                                        <div>
                                            <p class="text-xs text-slate-400">
                                                นัดรับชุด
                                            </p>

                                            <p class="mt-1 font-medium text-slate-700">
                                                {{ $rental->start_date->format('d/m/Y') }}
                                            </p>

                                            <span
                                                class="ww-time"
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
                                                class="ww-time"
                                                style="background: #FFF1F7; color: #C56690;"
                                            >
                                                ภายใน 18:00 น.
                                            </span>
                                        </div>
                                    </td>

                                    {{-- จำนวนวัน --}}
                                    <td class="whitespace-nowrap text-slate-600">
                                        {{ $rental->rental_days }} วัน
                                    </td>

                                    {{-- ราคา --}}
                                    <td class="whitespace-nowrap font-semibold text-[#7766A8]">
                                        {{ number_format($rental->total_price, 2) }} บาท
                                    </td>

                                    {{-- สถานะการเช่า --}}
                                    <td>
                                        <span
                                            class="ww-badge"
                                            style="background: {{ $statusBadge[1] }}; color: {{ $statusBadge[2] }};"
                                        >
                                            {{ $statusBadge[0] }}
                                        </span>
                                    </td>

                                    {{-- ตรวจสอบการชำระเงิน --}}
                                    <td>
                                        <div class="ww-actions">
                                            <span
                                                class="ww-badge"
                                                style="background: {{ $paymentBadge[1] }}; color: {{ $paymentBadge[2] }};"
                                            >
                                                {{ $paymentBadge[0] }}
                                            </span>

                                            @if($rental->slip_path)
                                                <a
                                                    href="{{ route('admin.payment.slip', $rental) }}"
                                                    target="_blank"
                                                    rel="noopener"
                                                    class="ww-button purple"
                                                >
                                                    ดูสลิปชำระเงิน
                                                </a>

                                                @if(
                                                    $rental->payment_status !== 'verified'
                                                    && in_array($rental->status, ['pending', 'approved', 'renting'])
                                                )
                                                    <form
                                                        method="POST"
                                                        action="{{ route('admin.payment.review', $rental) }}"
                                                        class="ww-panel"
                                                    >
                                                        @csrf

                                                        <label
                                                            for="payment-note-{{ $rental->id }}"
                                                            class="mb-2 block text-xs font-semibold text-[#7766A8]"
                                                        >
                                                            ผลตรวจเงินเข้าบัญชี
                                                        </label>

                                                        <input
                                                            id="payment-note-{{ $rental->id }}"
                                                            name="note"
                                                            type="text"
                                                            required
                                                            maxlength="200"
                                                            placeholder="ระบุผลการตรวจสอบ"
                                                            class="ww-input"
                                                        >

                                                        <div class="mt-3 space-y-2">
                                                            <button
                                                                type="submit"
                                                                name="decision"
                                                                value="verified"
                                                                class="ww-button green"
                                                            >
                                                                ยืนยันรับเงินแล้ว
                                                            </button>

                                                            <button
                                                                type="submit"
                                                                name="decision"
                                                                value="rejected"
                                                                class="ww-button pink"
                                                            >
                                                                สลิปไม่ผ่าน
                                                            </button>
                                                        </div>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>

                                    {{-- จัดการการเช่า --}}
                                    <td>
                                        <div class="ww-actions">

                                            @if($rental->status === 'pending')
                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.rentals.approve', $rental->id) }}"
                                                >
                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="ww-button green"
                                                    >
                                                        อนุมัติการเช่า
                                                    </button>
                                                </form>

                                                <button
                                                    type="button"
                                                    class="ww-button pink"
                                                    aria-controls="reject-{{ $rental->id }}"
                                                    aria-expanded="false"
                                                    onclick="toggleReject({{ $rental->id }}, this)"
                                                >
                                                    ปฏิเสธคำขอ
                                                </button>

                                                <div
                                                    id="reject-{{ $rental->id }}"
                                                    class="ww-panel"
                                                    hidden
                                                >
                                                    <form
                                                        method="POST"
                                                        action="{{ route('admin.rentals.reject', $rental->id) }}"
                                                    >
                                                        @csrf

                                                        <label
                                                            for="reason-{{ $rental->id }}"
                                                            class="mb-2 block text-xs font-semibold text-[#BF648C]"
                                                        >
                                                            เหตุผลที่ปฏิเสธ
                                                        </label>

                                                        <textarea
                                                            id="reason-{{ $rental->id }}"
                                                            name="rejection_reason"
                                                            required
                                                            maxlength="255"
                                                            rows="3"
                                                            class="ww-input"
                                                            placeholder="เช่น ชุดไม่ว่าง วันที่ซ้ำ หรือข้อมูลไม่ครบ"
                                                        ></textarea>

                                                        <div class="mt-3 space-y-2">
                                                            <button
                                                                type="submit"
                                                                class="ww-button pink"
                                                            >
                                                                ยืนยันการปฏิเสธ
                                                            </button>

                                                            <button
                                                                type="button"
                                                                class="ww-button purple"
                                                                onclick="closeReject({{ $rental->id }})"
                                                            >
                                                                ยกเลิก
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>

                                            @elseif($rental->status === 'approved')
                                                <form
                                                    method="POST"
                                                    action="{{ route('admin.rentals.start', $rental->id) }}"
                                                >
                                                    @csrf

                                                    <button
                                                        type="submit"
                                                        class="ww-button blue"
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
                                                        value="สภาพปกติ"
                                                    >

                                                    <button
                                                        type="submit"
                                                        class="ww-button purple"
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

                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
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
            </div>

        </div>
    </div>

    <script>
        function toggleReject(id, button) {
            const box = document.getElementById('reject-' + id);

            box.hidden = !box.hidden;
            button.setAttribute('aria-expanded', String(!box.hidden));

            if (!box.hidden) {
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