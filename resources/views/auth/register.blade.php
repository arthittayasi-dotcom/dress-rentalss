<x-guest-layout>
    <div class="flex min-h-screen items-center justify-center px-4 py-10">
        <div class="w-full max-w-md rounded-[28px] border border-[#E9E4F4]
                    bg-white p-6 shadow-[0_18px_55px_rgba(102,91,140,0.10)]
                    sm:p-8">

            {{-- โลโก้ภายในกล่อง --}}
            <div class="mb-8 text-center">
                <a
                    href="{{ url('/') }}"
                    aria-label="WANWAN หน้าหลัก"
                    class="mx-auto mb-4 block overflow-hidden rounded-full
                           border border-[#E9D7DE] bg-[#F8F3EC] shadow-sm"
                    style="width:120px;height:120px;"
                >
                    <img
                        src="{{ asset('wanwan-logo.png') }}"
                        alt="WANWAN"
                        style="display:block;width:100%;height:100%;object-fit:cover;border-radius:50%;"
                    >
                </a>

                <p class="text-sm font-medium uppercase tracking-[0.3em] text-[#8C80B4]">
                    WANWAN
                </p>

                <h1 class="mt-3 text-2xl font-semibold text-slate-800">
                    สมัครสมาชิก
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    สร้างบัญชีลูกค้าเพื่อเริ่มเช่าชุด
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label
                        for="name"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        ชื่อ
                    </label>

                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        placeholder="กรอกชื่อของคุณ"
                        class="w-full rounded-2xl border border-[#DDD9E8]
                               bg-[#FCFBFE] px-4 py-3 text-slate-800
                               placeholder:text-slate-400
                               focus:border-[#A89CCF]
                               focus:ring-4 focus:ring-[#EEEAF8]"
                    >

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <label
                        for="username"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        ชื่อผู้ใช้
                    </label>

                    <input
                        id="username"
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        required
                        autocomplete="username"
                        placeholder="กรอกชื่อผู้ใช้"
                        class="w-full rounded-2xl border border-[#DDD9E8]
                               bg-[#FCFBFE] px-4 py-3 text-slate-800
                               placeholder:text-slate-400
                               focus:border-[#A89CCF]
                               focus:ring-4 focus:ring-[#EEEAF8]"
                    >

                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <div>
                    <label
                        for="password"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        รหัสผ่าน
                    </label>

                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="new-password"
                        placeholder="กรอกรหัสผ่าน"
                        class="w-full rounded-2xl border border-[#DDD9E8]
                               bg-[#FCFBFE] px-4 py-3 text-slate-800
                               placeholder:text-slate-400
                               focus:border-[#A89CCF]
                               focus:ring-4 focus:ring-[#EEEAF8]"
                    >

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <label
                        for="password_confirmation"
                        class="mb-2 block text-sm font-medium text-slate-700"
                    >
                        ยืนยันรหัสผ่าน
                    </label>

                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        placeholder="กรอกรหัสผ่านอีกครั้ง"
                        class="w-full rounded-2xl border border-[#DDD9E8]
                               bg-[#FCFBFE] px-4 py-3 text-slate-800
                               placeholder:text-slate-400
                               focus:border-[#A89CCF]
                               focus:ring-4 focus:ring-[#EEEAF8]"
                    >

                    <x-input-error
                        :messages="$errors->get('password_confirmation')"
                        class="mt-2"
                    />
                </div>

                <button
                    type="submit"
                    class="w-full rounded-2xl bg-gradient-to-r
                           from-[#87BFE8] via-[#A89CCF] to-[#DEA9BF]
                           py-3.5 font-medium text-white shadow-sm
                           transition hover:opacity-90"
                >
                    สมัครสมาชิก
                </button>

                <div class="pt-2 text-center">
                    <span class="text-sm text-slate-500">
                        มีบัญชีอยู่แล้ว?
                    </span>

                    <a
                        href="{{ route('login') }}"
                        class="ml-1 text-sm font-semibold text-[#8C80B4]
                               hover:text-[#74689E]"
                    >
                        เข้าสู่ระบบ
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>