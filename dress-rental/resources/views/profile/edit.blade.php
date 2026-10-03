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

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <section class="rounded-[32px]
                            bg-gradient-to-r
                            from-[#EDF7FF]
                            via-[#F5F0FF]
                            to-[#FFF0F6]
                            border border-white
                            shadow-[0_18px_45px_rgba(120,90,170,0.08)]
                            p-8">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">

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
                                บัญชีผู้ใช้งาน
                            </p>

                            <h2 class="mt-1 text-2xl font-semibold text-slate-800">
                                {{ auth()->user()->name }}
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ '@' . auth()->user()->username }}
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

                        @if(auth()->user()->role === 'customer')
                            ลูกค้า
                        @elseif(auth()->user()->role === 'owner')
                            เจ้าของร้าน
                        @elseif(auth()->user()->role === 'admin')
                            ผู้ดูแลระบบ
                        @endif
                    </span>

                </div>

            </section>


            <section class="rounded-[30px]
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

                @if(session('status') === 'profile-updated')
                    <div class="mb-6 rounded-2xl
                                border border-[#DDECE5]
                                bg-[#F4FBF7]
                                px-5 py-4
                                text-sm text-[#4D856A]">
                        บันทึกข้อมูลเรียบร้อยแล้ว
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('profile.update') }}"
                      class="space-y-5">

                    @csrf
                    @method('PATCH')

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

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">
                            ประเภทบัญชี
                        </label>

                        <div class="w-full rounded-2xl
                                    border border-[#EEE8F6]
                                    bg-[#F8F6FC]
                                    px-4 py-3
                                    text-sm text-slate-500">

                            @if(auth()->user()->role === 'customer')
                                ลูกค้า
                            @elseif(auth()->user()->role === 'owner')
                                เจ้าของร้าน
                            @elseif(auth()->user()->role === 'admin')
                                ผู้ดูแลระบบ
                            @else
                                ผู้ใช้งาน
                            @endif

                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
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


            <div class="flex justify-center">

                @if(auth()->user()->role === 'customer')
                    <a href="{{ route('customer.home') }}"
                       class="rounded-2xl
                              border border-[#DED6EC]
                              bg-white
                              px-6 py-3
                              text-sm font-medium
                              text-[#7766A8]
                              hover:bg-[#F8F5FC]
                              transition">
                        กลับไปแดชบอร์ด
                    </a>

                @elseif(auth()->user()->role === 'owner')
                    <a href="{{ route('owner.dashboard') }}"
                       class="rounded-2xl
                              border border-[#DED6EC]
                              bg-white
                              px-6 py-3
                              text-sm font-medium
                              text-[#7766A8]
                              hover:bg-[#F8F5FC]
                              transition">
                        กลับไปแดชบอร์ด
                    </a>

                @elseif(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                       class="rounded-2xl
                              border border-[#DED6EC]
                              bg-white
                              px-6 py-3
                              text-sm font-medium
                              text-[#7766A8]
                              hover:bg-[#F8F5FC]
                              transition">
                        กลับไปแดชบอร์ด
                    </a>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>