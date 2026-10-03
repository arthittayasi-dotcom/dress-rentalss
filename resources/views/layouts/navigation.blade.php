@php
    $user = auth()->user();

    $menus = match ($user?->role) {
        'customer' => [
            ['label' => 'หน้าหลัก', 'route' => 'customer.home'],
            ['label' => 'เลือกชุด', 'route' => 'customer.dresses'],
            ['label' => 'การเช่าของฉัน / ชำระเงิน', 'route' => 'customer.rentals'],
            ['label' => 'เกี่ยวกับร้าน', 'route' => 'customer.about'],
        ],
        'owner' => [
            ['label' => 'แดชบอร์ด', 'route' => 'owner.dashboard'],
            ['label' => 'รายงาน', 'route' => 'owner.reports'],
            ['label' => 'ผู้ใช้งาน', 'route' => 'owner.users'],
            ['label' => 'ประวัติการเช่า', 'route' => 'owner.history'],
        ],
        'admin' => [
            ['label' => 'แดชบอร์ด', 'route' => 'admin.dashboard'],
            ['label' => 'รายการเช่า', 'route' => 'admin.rentals'],
            ['label' => 'จัดการชุด', 'route' => 'admin.dresses'],
            ['label' => 'ปฏิทินคิวชุด', 'route' => 'admin.calendar'],
            ['label' => 'ตรวจสอบคืนชุด', 'route' => 'admin.returns'],
            ['label' => 'ประวัติ', 'route' => 'admin.history'],
        ],
        default => [],
    };

    $roleLabel = match ($user?->role) {
        'customer' => 'ลูกค้า',
        'owner' => 'เจ้าของร้าน',
        'admin' => 'ผู้ดูแลระบบ',
        default => '',
    };

    $homeRoute = match ($user?->role) {
        'customer' => 'customer.home',
        'owner' => 'owner.dashboard',
        'admin' => 'admin.dashboard',
        default => null,
    };
@endphp

<nav class="border-b border-[#EEE8F6] bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex min-h-20 items-center gap-6 overflow-x-auto py-3">

            {{-- โลโก้ --}}
            <a
                href="{{ $homeRoute ? route($homeRoute) : url('/') }}"
                class="flex shrink-0 items-center gap-3"
                aria-label="WANWAN หน้าหลัก"
            >
                <span
                    class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-full border border-[#E9D7DE] bg-[#F8F3EC]"
                >
                    <x-application-logo class="h-full w-full rounded-full" />
                </span>

                <span class="text-lg font-semibold tracking-wider text-[#7766A8]">
                    WANWAN
                </span>
            </a>

            {{-- เมนู --}}
            @auth
                <div class="flex shrink-0 items-center gap-1">
                    @foreach ($menus as $menu)
                        @php
                            $active = request()->routeIs($menu['route'])
                                || (
                                    $menu['route'] === 'customer.rentals'
                                    && request()->routeIs('customer.payment*')
                                );
                        @endphp

                        <a
                            href="{{ route($menu['route']) }}"
                            @if ($active) aria-current="page" @endif
                            @class([
                                'whitespace-nowrap rounded-xl px-3 py-2 text-sm font-medium transition',
                                'bg-[#F5F0FF] text-[#7766A8]' => $active,
                                'text-slate-600 hover:bg-[#FAF7FF] hover:text-[#7766A8]' => !$active,
                            ])
                        >
                            {{ $menu['label'] }}
                        </a>
                    @endforeach
                </div>

                {{-- ข้อมูลผู้ใช้ --}}
                <div class="ml-auto flex shrink-0 items-center gap-3">
                    <div class="shrink-0 whitespace-nowrap text-right">
    <p class="text-sm font-semibold text-slate-700">
        {{ auth()->user()->name }}
    </p>

    <p class="text-xs text-slate-400">
        {{ auth()->user()->role }}
    </p>
</div>

                    <a
                        href="{{ route('profile.edit') }}"
                        class="whitespace-nowrap rounded-xl bg-[#F5F0FF] px-4 py-2 text-sm text-[#7766A8]"
                    >
                        โปรไฟล์
                    </a>

                    <form
                        method="POST"
                        action="{{ route($user->role === 'customer' ? 'logout' : 'staff.logout') }}"
                    >
                        @csrf

                        <button
                            type="submit"
                            class="whitespace-nowrap rounded-xl bg-gradient-to-r from-[#87BFE8] via-[#A89CCF] to-[#DEA9BF] px-4 py-2 text-sm font-medium text-white"
                        >
                            ออกจากระบบ
                        </button>
                    </form>
                </div>
            @endauth

        </div>
    </div>
</nav>