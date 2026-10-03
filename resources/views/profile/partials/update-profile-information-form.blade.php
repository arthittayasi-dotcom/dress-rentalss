<section>
    <header>
        <h2 class="text-lg font-medium text-slate-800">
            ข้อมูลโปรไฟล์
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            แก้ไขชื่อและชื่อผู้ใช้ของบัญชีคุณ
        </p>
    </header>

    <form method="POST"
          action="{{ route('profile.update') }}"
          class="mt-6 space-y-6">

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
                value="{{ old('name', $user->name) }}"
                required
                autofocus
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
                value="{{ old('username', $user->username) }}"
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


        <div class="flex items-center gap-4">

            <button
                type="submit"
                class="rounded-2xl
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

                บันทึกข้อมูล

            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-[#4D856A]">
                    บันทึกแล้ว
                </p>
            @endif

        </div>

    </form>
</section>