<x-app-layout>

    <x-slot name="header">

        <div>

            <p class="text-sm font-medium tracking-widest text-[#9B8AC9]">

                WANWAN

            </p>

            <h2 class="mt-2 text-2xl font-semibold text-slate-800">

                เลือกชุด

            </h2>

        </div>

    </x-slot>

    <div class="min-h-screen bg-[#FCFAFF] py-8">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            @if (session('success'))

                <div class="mb-6 rounded-2xl bg-green-50 p-4 text-sm text-green-700">

                    {{ session('success') }}

                </div>

            @endif

            @if (session('error'))

                <div class="mb-6 rounded-2xl bg-red-50 p-4 text-sm text-red-700">

                    {{ session('error') }}

                </div>

            @endif

            @if ($errors->any())

                <div class="mb-6 rounded-2xl bg-red-50 p-4 text-sm text-red-700">

                    <p class="mb-2 font-semibold">ไม่สามารถส่งคำขอเช่าได้</p>

                    @foreach ($errors->all() as $error)

                        <p>{{ $error }}</p>

                    @endforeach

                </div>

            @endif

            <div class="mb-8 flex flex-wrap items-center justify-between gap-4">

                <div>

                    <h1 class="text-2xl font-semibold text-slate-800">

                        ชุดทั้งหมด

                    </h1>

                    <p class="mt-2 text-sm text-slate-500">

                        พบ {{ $dresses->total() }} ชุด · เลือกชุดแล้วระบุวันเช่า

                    </p>

                </div>

                <a

                    href="{{ route('customer.rentals') }}"

                    class="rounded-xl border border-[#E9E4F4] bg-white px-5 py-3 text-sm text-[#7766A8]"

                >

                    การเช่าของฉัน

                </a>

            </div>

            {{-- รูปชุด --}}

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

                @forelse ($dresses as $dress)

                    <article class="flex flex-col overflow-hidden rounded-3xl border border-[#EEE8F6] bg-white shadow-sm">

                        <div class="aspect-[4/5] shrink-0 overflow-hidden bg-[#F8F5FF]">

                            @if ($dress->image)

                                <img

                                    src="{{ asset('storage/' . $dress->image) }}"

                                    alt="{{ $dress->name }}"

                                    loading="lazy"

                                    class="h-full w-full object-cover"

                                >

                            @else

                                <div class="flex h-full items-center justify-center text-sm text-slate-400">

                                    ไม่มีรูปชุด

                                </div>

                            @endif

                        </div>

                        <div class="flex flex-1 flex-col p-5">

                            <p class="text-xs text-slate-400">

                                {{ $dress->code }}

                            </p>

                            <h2 class="mt-1 text-lg font-semibold text-slate-800">

                                {{ $dress->name }}

                            </h2>

                            <p class="mt-3 text-sm text-slate-500">

                                ขนาด: {{ $dress->size ?? '-' }}

                            </p>

                            <p class="mt-2 font-semibold text-[#7766A8]">

                                {{ number_format($dress->price_per_day, 2) }} บาท / วัน

                            </p>

                            <div class="mt-auto pt-5">

                                @if ($dress->status === 'maintenance')

                                    <button

                                        type="button"

                                        disabled

                                        class="w-full rounded-2xl bg-slate-100 px-4 py-3 text-sm text-slate-400"

                                    >

                                        อยู่ระหว่างดูแลชุด

                                    </button>

                                @else

                                    <button

                                        type="button"

                                        data-dress-id="{{ $dress->id }}"

                                        data-dress-name="{{ $dress->name }}"

                                        class="choose-dress w-full rounded-2xl bg-gradient-to-r

                                               from-[#87BFE8] via-[#A89CCF] to-[#DEA9BF]

                                               px-4 py-3 text-sm font-medium text-white

                                               transition hover:opacity-90"

                                    >

                                        เช่าชุดนี้

                                    </button>

                                @endif

                            </div>

                        </div>

                    </article>

                @empty

                    <div class="col-span-full rounded-3xl bg-white py-16 text-center text-slate-400">

                        ยังไม่มีชุดให้บริการ

                    </div>

                @endforelse

            </div>

            <div class="mt-8">

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

        </div>

    </div>

    {{-- กล่องเลือกวันเช่า --}}

    <div

        id="rentalModal"

        role="dialog"

        aria-modal="true"

        aria-labelledby="modalTitle"

        class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto bg-black/40 p-4"

    >

        <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-xl sm:p-8">

            <h2 id="modalTitle" class="text-2xl font-semibold text-slate-800">

                ระบุวันที่เช่า

            </h2>

            <p class="mt-2 text-sm text-slate-500">

                ชุดที่เลือก:

                <span id="modalDressName" class="font-semibold text-[#7766A8]"></span>

            </p>

            <form

                id="rentalForm"

                method="POST"

                action="{{ route('customer.rentals.store') }}"

                class="mt-6 space-y-5"

            >

                @csrf

                <input type="hidden" id="modalDressId" name="dress_id">

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <div>

                        <label

                            for="rentalStart"

                            class="mb-2 block text-sm font-medium text-slate-700"

                        >

                            วันที่เริ่มเช่า

                        </label>

                        <input

                            id="rentalStart"

                            name="start_date"

                            type="date"

                            min="{{ today()->format('Y-m-d') }}"

                            value="{{ old('start_date') }}"

                            required

                            class="h-12 w-full rounded-xl border border-[#DDD9E8]

                                   bg-[#FCFBFE] px-3 text-slate-700

                                   focus:border-[#A89CCF] focus:ring-[#EEEAF8]"

                        >

                    </div>

                    <div>

                        <label

                            for="rentalEnd"

                            class="mb-2 block text-sm font-medium text-slate-700"

                        >

                            วันที่คืน

                        </label>

                        <input

                            id="rentalEnd"

                            name="end_date"

                            type="date"

                            min="{{ today()->format('Y-m-d') }}"

                            value="{{ old('end_date') }}"

                            required

                            class="h-12 w-full rounded-xl border border-[#DDD9E8]

                                   bg-[#FCFBFE] px-3 text-slate-700

                                   focus:border-[#A89CCF] focus:ring-[#EEEAF8]"

                        >

                    </div>

                </div>

                <p class="rounded-xl bg-[#F5F0FF] p-4 text-sm text-[#7766A8]">

                    ระบบจะตรวจสอบวันว่างก่อนบันทึกคำขอ

                    หากชุดไม่ว่างในวันที่เลือก จะแจ้งให้เปลี่ยนวันที่หรือเลือกชุดอื่น

                </p>

                <div class="flex gap-3">

                    <button

                        type="submit"

                        class="flex-1 rounded-xl bg-gradient-to-r

                               from-[#87BFE8] via-[#A89CCF] to-[#DEA9BF]

                               py-3 font-medium text-white"

                    >

                        ส่งคำขอเช่า

                    </button>

                    <button

                        id="closeRentalModal"

                        type="button"

                        class="flex-1 rounded-xl bg-slate-100 py-3 text-slate-600"

                    >

                        ยกเลิก

                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>

        (() => {

            const modal = document.getElementById('rentalModal');

            const form = document.getElementById('rentalForm');

            const start = document.getElementById('rentalStart');

            const end = document.getElementById('rentalEnd');

            let trigger;

            function updateEndDate() {

                end.min = start.value || start.min;

                if (end.value && end.value < end.min) {

                    end.value = '';

                }

            }

            function closeModal() {

                modal.classList.add('hidden');

                modal.classList.remove('flex');

                trigger?.focus();

            }

            document.querySelectorAll('.choose-dress').forEach(button => {

                button.addEventListener('click', () => {

                    trigger = button;

                    form.reset();

                    document.getElementById('modalDressId').value =

                        button.dataset.dressId;

                    document.getElementById('modalDressName').textContent =

                        button.dataset.dressName;

                    updateEndDate();

                    modal.classList.remove('hidden');

                    modal.classList.add('flex');

                    start.focus();

                });

            });

            start.addEventListener('change', updateEndDate);

            document.getElementById('closeRentalModal')

                .addEventListener('click', closeModal);

            modal.addEventListener('click', event => {

                if (event.target === modal) closeModal();

            });

            document.addEventListener('keydown', event => {

                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {

                    closeModal();

                }

            });

        })();

    </script>

</x-app-layout>