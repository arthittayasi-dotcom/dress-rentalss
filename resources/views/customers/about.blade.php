<x-app-layout>
<x-slot name="header"><h2 class="text-2xl font-semibold">เกี่ยวกับร้าน WANWAN</h2></x-slot>
<div class="mx-auto max-w-3xl px-6 py-10"><section class="rounded-3xl bg-white p-8 shadow-sm">
<x-application-logo class="mx-auto mb-8 w-80" />
<h1 class="text-3xl font-semibold text-[#995467]">WANWAN Clothing Rental</h1>
<p class="mt-4 leading-8 text-slate-600">ร้านเช่าชุดสำหรับวันพิเศษของคุณ เลือกดูชุด ตรวจสอบช่วงวันที่ไม่ว่าง และส่งคำขอเช่าได้ผ่านเว็บไซต์ พร้อมแนบหลักฐานการชำระเงินและติดตามรายการเช่าของคุณ</p>
<div class="mt-6 rounded-2xl bg-[#FFF1F7] p-5"><h2 class="font-semibold">วิธีเช่าชุด</h2><ol class="mt-3 list-decimal pl-5 space-y-2"><li>เลือกชุดและวันที่เช่า ระบบตรวจสอบคิวชุดก่อนจอง</li><li>ติดตามการอนุมัติในหน้าการเช่าของฉัน</li><li>ชำระเงินตามยอดรายการและแนบสลิป</li><li>รับชุดได้ตั้งแต่ 08:00 น. และคืนภายใน 18:00 น. ของวันที่นัดคืน</li></ol></div>
@if(config('pinkette.address'))<p class="mt-5">ที่อยู่: {{ config('pinkette.address') }}</p>@endif
<p class="mt-5">ติดต่อร้าน: {{ config('pinkette.contact') ?: 'กรุณาสอบถามช่องทางติดต่อจากผู้ดูแลร้าน' }}</p>
<a href="{{ route('customer.home') }}" class="mt-6 inline-block rounded-xl bg-[#995467] px-6 py-3 text-white">เลือกชุดของคุณ</a>
</section></div>
</x-app-layout>