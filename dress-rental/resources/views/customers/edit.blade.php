<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-sm font-medium tracking-[0.2em] uppercase text-[#9B8AC9]">
                Profile
            </p>

            <h2 class="mt-2 text-3xl font-semibold text-slate-800">
                โปรไฟล์ของฉัน
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                ดูและแก้ไขข้อมูลบัญชีของคุณ
            </p>
        </div>
    </x-slot>


    <div class="min-h-screen bg-gradient-to-br from-[#FCFAFF] via-[#F8F6FF] to-[#FFF8FB] py-10">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Profile Summary --}}
            <section class="rounded-[32px]
                            bg-gradient-to-r
                            from-[#EDF7FF]
                            via-[#F5F0FF]
                            to-[#FFF0F6]
                            border border-white
                            shadow-[0_18px_45px_rgba(120,90,170,0.08)]
                            p-8">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">

                    <div class="flex items-center gap-5">

                        <div class="w-20 h-20 rounded-full
                                    bg-white
                                    border border-[#E8E1F5]
                                    shadow-sm
                                    flex items-center justify-center">

                            <span class="text-2xl font-semibold text-[#7766A8]">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>

                        </div>

                        <div>
                            <p class="text-sm text-[#9B8AC9]">
                                บัญชีลูกค้า
                            </p>

                            <h2 class="mt-1 text-2xl font-semibold text-slate-800">
                                {{ auth()->user()->name }}
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                @{{ auth()->user()->username }}
                            </p>
                        </div>

                    </div>


                    <span class="inline-flex w-fit items-center
                                 rounded-full
                                 bg-white/80
                                 border border-white
                                 px-4 py-2
                                 text-sm font-medium
                                 text-[#7766A8]">
                        สมาชิกทั่วไป
                    </span>

                </div>

            </section>


            <div class="grid grid-cols-1 lg:grid-cols-3 gap-7">

                {{-- Account Info --}}
                <section class="lg:col-span-2
                                rounded-[30px]
                                bg-white
                                border border-[#EEE8F6]
                                shadow-[0_12px_35px_rgba(120,90,170,0.07)]
                                p-7 md:p-8">

                    <div class="mb-7">
                        <p class="text-sm font-medium text-[#9B8AC9]">
                            Account Information
                        </p>

                        <h3 class="mt-1 text-2xl font-semibold text-slate-800">
                            ข้อมูลบัญชี
                        </h3>

                        <p class="mt-2 text-sm text-slate-500">
                            แก้ไขชื่อและชื่อผู้ใช้ของคุณ
                        </p>
                    </div>


                    @if (session('status') === 'profile-updated')
                        <div class="mb-6 rounded-2xl
                                    border border-[#DDECE5]
                                    bg-[#F4FBF7]
                                    px-5 py-4
                                    text-sm text-[#4D856A]">

                            บันทึกข้อมูลเรียบร้อยแล้ว

                        </div>
                    @endif


                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="space-y-5">

                            {{-- Name --}}
                            <div>
                                <label for="name"
                                       class="block text-sm font-medium text-slate-700 mb-2">
                                    ชื่อ
                                </label>

                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name', auth()->user()->name) }}"
                                    required
                                    autocomplete="name"
                                    class="w-full rounded-2xl
                                           border border-[#DDD9E8]
                                           bg-[#FCFBFE]
                                           px-4 py-3
                                           text-slate-800
                                           focus:border-[#A89CCF]
                                           focus:ring-4
                                           focus:ring-[#EEEAF8]"
                                >

                                @error('name')
                                    <p class="mt-2 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>


                            {{-- Username --}}
                            <div>
                                <label for="username"
                                       class="block text-sm font-medium text-slate-700 mb-2">
                                    ชื่อผู้ใช้
                                </label>

                                <input
                                    id="username"
                                    name="username"
                                    type="text"
                                    value="{{ old('username', auth()->user()->username) }}"
                                    required
                                    autocomplete="username"
                                    class="w-full rounded-2xl
                                           border border-[#DDD9E8]
                                           bg-[#FCFBFE]
                                           px-4 py-3
                                           text-slate-800
                                           focus:border-[#A89CCF]
                                           focus:ring-4
                                           focus:ring-[#EEEAF8]"
                                >

                                @error('username')
                                    <p class="mt-2 text-sm text-red-500">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>


                            {{-- Role readonly --}}
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    ประเภทบัญชี
                                </label>

                                <div class="w-full rounded-2xl
                                            border border-[#EEE8F6]
                                            bg-[#F8F6FC]
                                            px-4 py-3
                                            text-sm text-slate-500">
                                    ลูกค้า
                                </div>
                            </div>

                        </div>


                        <div class="mt-7 flex justify-end">

                            <button
                                type="submit"
                                class="rounded-2xl
                                       px-7 py-3
                                       text-sm font-medium
                                       text-white
                                       bg-gradient-to-r
                                       from-[#87BFE8]
                                       via-[#A89CCF]
                                       to-[#DEA9BF]
                                       shadow-md
                                       hover:opacity-90
                                       transition">

                                บันทึกข้อมูล

                            </button>

                        </div>

                    </form>

                </section>


                {{-- Side Info --}}
                <section class="rounded-[30px]
                                bg-white
                                border border-[#EEE8F6]
                                shadow-[0_12px_35px_rgba(120,90,170,0.07)]
                                p-7">

                    <p class="text-sm font-medium text-[#9B8AC9]">
                        Account
                    </p>

                    <h3 class="mt-1 text-xl font-semibold text-slate-800">
                        สรุปบัญชี
                    </h3>


                    <div class="mt-6 space-y-3">

                        <div class="rounded-2xl bg-[#FAF8FF] px-4 py-4">
                            <p class="text-xs text-slate-400">
                                ชื่อผู้ใช้
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ auth()->user()->username }}
                            </p>
                        </div>


                        <div class="rounded-2xl bg-[#F8FBFE] px-4 py-4">
                            <p class="text-xs text-slate-400">
                                ชื่อ
                            </p>

                            <p class="mt-1 text-sm font-semibold text-slate-700">
                                {{ auth()->user()->name }}
                            </p>
                        </div>


                        <div class="rounded-2xl bg-[#FFF7FA] px-4 py-4">
                            <p class="text-xs text-slate-400">
                                บทบาท
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#D06C96]">
                                customer
                            </p>
                        </div>

                    </div>


                    <a href="{{ route('customer.dashboard') }}"
                       class="mt-6 flex items-center justify-center
                              rounded-2xl
                              border border-[#DED6EC]
                              bg-white
                              px-5 py-3
                              text-sm font-medium
                              text-[#7766A8]
                              hover:bg-[#F8F5FC]
                              transition">

                        กลับไปแดชบอร์ด

                    </a>

                </section>

            </div>


            {{-- Password --}}
            <section class="rounded-[30px]
                            bg-white
                            border border-[#EEE8F6]
                            shadow-[0_12px_35px_rgba(120,90,170,0.07)]
                            p-7 md:p-8">

                <div class="mb-7">
                    <p class="text-sm font-medium text-[#9B8AC9]">
                        Security
                    </p>

                    <h3 class="mt-1 text-2xl font-semibold text-slate-800">
                        เปลี่ยนรหัสผ่าน
                    </h3>

                    <p class="mt-2 text-sm text-slate-500">
                        แนะนำให้ใช้รหัสผ่านที่ไม่ซ้ำกับบัญชีอื่น
                    </p>
                </div>


                @if (session('status') === 'password-updated')
                    <div class="mb-6 rounded-2xl
                                border border-[#DDECE5]
                                bg-[#F4FBF7]
                                px-5 py-4
                                text-sm text-[#4D856A]">

                        เปลี่ยนรหัสผ่านเรียบร้อยแล้ว

                    </div>
                @endif


                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                        <div>
                            <label for="update_password_current_password"
                                   class="block text-sm font-medium text-slate-700 mb-2">
                                รหัสผ่านปัจจุบัน
                            </label>

                            <input
                                id="update_password_current_password"
                                name="current_password"
                                type="password"
                                autocomplete="current-password"
                                class="w-full rounded-2xl
                                       border border-[#DDD9E8]
                                       bg-[#FCFBFE]
                                       px-4 py-3
                                       focus:border-[#A89CCF]
                                       focus:ring-4
                                       focus:ring-[#EEEAF8]"
                            >

                            @error('current_password', 'updatePassword')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <div>
                            <label for="update_password_password"
                                   class="block text-sm font-medium text-slate-700 mb-2">
                                รหัสผ่านใหม่
                            </label>

                            <input
                                id="update_password_password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                class="w-full rounded-2xl
                                       border border-[#DDD9E8]
                                       bg-[#FCFBFE]
                                       px-4 py-3
                                       focus:border-[#A89CCF]
                                       focus:ring-4
                                       focus:ring-[#EEEAF8]"
                            >

                            @error('password', 'updatePassword')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <div>
                            <label for="update_password_password_confirmation"
                                   class="block text-sm font-medium text-slate-700 mb-2">
                                ยืนยันรหัสผ่านใหม่
                            </label>

                            <input
                                id="update_password_password_confirmation"
                                name="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                class="w-full rounded-2xl
                                       border border-[#DDD9E8]
                                       bg-[#FCFBFE]
                                       px-4 py-3
                                       focus:border-[#A89CCF]
                                       focus:ring-4
                                       focus:ring-[#EEEAF8]"
                            >
                        </div>

                    </div>


                    <div class="mt-7 flex justify-end">

                        <button
                            type="submit"
                            class="rounded-2xl
                                   px-7 py-3
                                   text-sm font-medium
                                   text-white
                                   bg-[#7766A8]
                                   hover:bg-[#685895]
                                   transition">

                            เปลี่ยนรหัสผ่าน

                        </button>

                    </div>

                </form>

            </section>

        </div>

    </div>

</x-app-layout>