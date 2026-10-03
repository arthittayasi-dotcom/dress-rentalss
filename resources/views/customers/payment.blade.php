<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-slate-800">
            ชำระเงิน WANWAN
        </h2>
    </x-slot>

    @php
        $canPay = $rental->payment_status !== 'verified'
            && in_array($rental->status, ['pending', 'approved', 'renting']);

        $paymentLabel = [
            'unpaid' => 'ยังไม่ชำระ',
            'pending' => 'รอตรวจสอบ',
            'verified' => 'ตรวจสอบการชำระเงินแล้ว',
            'rejected' => 'สลิปไม่ผ่าน กรุณาตรวจสอบ',
        ][$rental->payment_status] ?? 'ยังไม่ชำระ';
    @endphp

    <div class="mx-auto max-w-2xl px-4 py-10 sm:px-6">
        <section class="rounded-3xl border border-[#EEE8F6] bg-white p-6 shadow-sm sm:p-8">

            {{-- โลโก้ --}}
            <div class="mx-auto mb-6 h-28 w-28 overflow-hidden rounded-full border border-[#E9D7DE] bg-[#F8F3EC]">
                <x-application-logo class="h-full w-full rounded-full" />
            </div>

            {{-- รายการเช่า --}}
            <div class="text-center">
                <h1 class="text-xl font-semibold text-slate-800">
                    รายการ #{{ $rental->id }}
                </h1>

                <p class="mt-2 text-slate-600">
                    {{ $rental->dress?->name }}
                </p>

                <p class="mt-2 text-sm text-slate-500">
                    {{ $rental->start_date->format('d/m/Y') }}
                    –
                    {{ $rental->end_date->format('d/m/Y') }}
                </p>

                <p class="mt-6 text-sm text-slate-500">
                    ยอดชำระทั้งหมด
                </p>

                <p class="mt-2 text-3xl font-semibold text-[#995467]">
                    {{ number_format($rental->total_price, 2) }} บาท
                </p>
            </div>

            {{-- สถานะ --}}
            <div class="mt-6 rounded-2xl bg-[#F5F0FF] p-4 text-center text-sm text-[#7766A8]">
                สถานะ: {{ $paymentLabel }}
            </div>

            @if ($rental->payment_message)
                <p class="mt-4 text-sm text-slate-600">
                    {{ $rental->payment_message }}
                </p>
            @endif

            @if (session('success'))
                <p class="mt-4 rounded-xl bg-green-50 p-4 text-sm text-green-700" role="status">
                    {{ session('success') }}
                </p>
            @endif

            @if ($errors->any())
                <div class="mt-4 rounded-xl bg-red-50 p-4" role="alert">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm text-red-700">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if ($canPay)
                {{-- QR ชำระเงิน --}}
                <div class="mt-6 rounded-2xl border border-[#EEE8F6] bg-[#FCFAFF] p-5 text-center">
                    <h2 class="text-lg font-semibold text-slate-800">
                        สแกน QR เพื่อชำระเงิน
                    </h2>

                    <img
                        src="{{ asset('wanwan-payment-qr.png') }}"
                        alt="QR ชำระเงินร้าน WANWAN"
                        class="mx-auto mt-4 h-auto w-64 max-w-full rounded-xl"
                    >

                    <p class="mt-4 text-sm text-slate-600">
                        กรุณาตรวจสอบชื่อผู้รับและโอนจำนวน
                        <span class="font-semibold text-[#995467]">
                            {{ number_format($rental->total_price, 2) }} บาท
                        </span>
                    </p>

                    <a
                        href="{{ asset('wanwan-payment-qr.png') }}"
                        download="wanwan-payment-qr.png"
                        class="mt-4 inline-block rounded-xl border border-[#DDD9E8] bg-white px-5 py-2 text-sm text-[#7766A8]"
                    >
                        ดาวน์โหลด QR
                    </a>
                </div>

                {{-- ข้อมูลบัญชี หากร้านตั้งค่าไว้ --}}
                @if (config('pinkette.account_number'))
                    <div class="mt-5 rounded-2xl bg-[#FFF1F7] p-5 text-sm text-slate-700">
                        <p>ธนาคาร: {{ config('pinkette.bank_name') }}</p>
                        <p class="mt-1">ชื่อบัญชี: {{ config('pinkette.account_name') }}</p>
                        <p class="mt-1 font-semibold">
                            เลขบัญชี: {{ config('pinkette.account_number') }}
                        </p>
                    </div>
                @endif
            @endif

            @if ($rental->slip_path)
                <a
                    href="{{ route('customer.payment.slip', $rental) }}"
                    target="_blank"
                    rel="noopener"
                    class="mt-5 inline-block text-sm text-[#7766A8] underline"
                >
                    ดูสลิปที่แนบไว้
                </a>
            @endif

            {{-- แนบสลิป --}}
            @if ($canPay)
                <form
                    method="POST"
                    action="{{ route('customer.payment.store', $rental) }}"
                    enctype="multipart/form-data"
                    class="mt-6 space-y-4"
                >
                    @csrf

                    <label for="slip" class="block font-semibold text-slate-800">
                        แนบสลิปโอนเงิน
                    </label>

                    <input
                        id="slip"
                        name="slip"
                        type="file"
                        accept="image/jpeg,image/png,image/webp"
                        required
                        class="block w-full rounded-xl border border-[#DDD9E8] p-3 text-sm"
                    >

                    <p class="text-sm text-slate-500">
                        JPG, PNG หรือ WebP ไม่เกิน 4 MB
                        ให้เห็นยอดเงิน ผู้รับ และ QR บนสลิปชัดเจน
                    </p>

                    <img
                        id="slip-preview"
                        alt="ตัวอย่างสลิปก่อนส่ง"
                        class="mx-auto rounded-xl"
                        style="display:none;max-height:360px;max-width:100%"
                    >

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-gradient-to-r from-[#87BFE8] via-[#A89CCF] to-[#DEA9BF] px-6 py-3 font-medium text-white"
                    >
                        ส่งสลิปเพื่อตรวจสอบ
                    </button>
                </form>

                <script>
                    (() => {
                        const input = document.getElementById('slip');
                        const preview = document.getElementById('slip-preview');
                        let previewUrl;

                        input.addEventListener('change', () => {
                            if (previewUrl) {
                                URL.revokeObjectURL(previewUrl);
                                previewUrl = null;
                            }

                            preview.removeAttribute('src');
                            preview.style.display = 'none';

                            const file = input.files[0];

                            if (file && ['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
                                previewUrl = URL.createObjectURL(file);
                                preview.src = previewUrl;
                                preview.style.display = 'block';
                            }
                        });
                    })();
                </script>
            @endif

            <a
                href="{{ route('customer.rentals') }}"
                class="mt-6 block text-center text-sm text-[#7766A8] underline"
            >
                กลับไปการเช่าของฉัน
            </a>
        </section>
    </div>
</x-app-layout>