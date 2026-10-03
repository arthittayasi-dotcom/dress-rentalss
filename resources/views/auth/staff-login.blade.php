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
                    Staff Login
                </h1>

                <p class="mt-2 text-sm text-slate-500">
                    สำหรับเจ้าของร้านและผู้ดูแลระบบ
                </p>
            </div>

            <x-auth-session-status
                class="mb-4"
                :status="session('status')"
            />

            <form
                method="POST"
                action="{{ route('staff.login.store') }}"
                class="space-y-5"
            >
                @csrf

                <fieldset>
                    <legend class="mb-3 text-sm font-medium text-slate-700">
                        ประเภทบัญชี
                    </legend>

                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input
                                type="radio"
                                name="role"
                                value="owner"
                                required
                                class="peer sr-only"
                                @checked(old('role', 'owner') === 'owner')
                            >

                            <div class="rounded-2xl border border-[#E6DDF5]
                                        bg-[#FBF8FF] px-3 py-4 text-center
                                        transition peer-checked:border-[#9D8BD0]
                                        peer-checked:ring-2 peer-checked:ring-[#E6DDF5]
                                        peer-focus-visible:outline peer-focus-visible:outline-2">
                                <p class="text-sm font-semibold text-[#7C6AA8]">
                                    เจ้าของร้าน
                                </p>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input
                                type="radio"
                                name="role"
                                value="admin"
                                required
                                class="peer sr-only"
                                @checked(old('role') === 'admin')
                            >

                            <div class="rounded-2xl border border-[#F4DCE8]
                                        bg-[#FFF8FB] px-3 py-4 text-center
                                        transition peer-checked:border-[#D68AAE]
                                        peer-checked:ring-2 peer-checked:ring-[#F4DCE8]
                                        peer-focus-visible:outline peer-focus-visible:outline-2">
                                <p class="text-sm font-semibold text-[#C16C94]">
                                    แอดมิน
                                </p>
                            </div>
                        </label>
                    </div>

                    <x-input-error
                        :messages="$errors->get('role')"
                        class="mt-2"
                    />
                </fieldset>

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
                        autofocus
                        autocomplete="username"
                        placeholder="กรอกชื่อผู้ใช้"
                        class="w-full rounded-2xl border border-[#DDD9E8]
                               bg-[#FCFBFE] px-4 py-3 text-slate-800
                               placeholder:text-slate-400
                               focus:border-[#A89CCF]
                               focus:ring-4 focus:ring-[#EEEAF8]"
                    >

                    <x-input-error
                        :messages="$errors->get('username')"
                        class="mt-2"
                    />
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
                        autocomplete="current-password"
                        placeholder="กรอกรหัสผ่าน"
                        class="w-full rounded-2xl border border-[#DDD9E8]
                               bg-[#FCFBFE] px-4 py-3 text-slate-800
                               placeholder:text-slate-400
                               focus:border-[#A89CCF]
                               focus:ring-4 focus:ring-[#EEEAF8]"
                    >

                    <x-input-error
                        :messages="$errors->get('password')"
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
                    เข้าสู่ระบบ
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>