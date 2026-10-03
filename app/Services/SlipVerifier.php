<?php

namespace App\Services;

use App\Models\Rental;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Throwable;

class SlipVerifier
{
    public function verify(string $path, Rental $rental): array
    {
        $pending = ['payment_status' => 'pending', 'payment_message' => 'รับสลิปแล้ว รอร้านตรวจสอบการชำระเงิน'];
        if (! config('pinkette.slip_api_key') || ! config('pinkette.account_number')) {
            return $pending;
        }

        try {
            $response = Http::withToken(config('pinkette.slip_api_key'))->acceptJson()->timeout(25)
                ->attach('image', file_get_contents($path), basename($path))
                ->post('https://api.easyslip.com/v2/verify/bank', [
                    'matchAccount' => 'true', 'matchAmount' => (string) $rental->total_price,
                    'checkDuplicate' => 'true', 'remark' => 'WANWAN rental '.$rental->id,
                ]);
            $result = $response->json();
            if (! $response->successful() || data_get($result, 'success') !== true) {
                $code = data_get($result, 'error.code');
                if (in_array($code, ['SLIP_NOT_FOUND', 'INVALID_IMAGE_FORMAT', 'DUPLICATE_SLIP'])) {
                    return $this->rejected('ไม่พบสลิปที่ถูกต้อง หรือสลิปนี้ถูกใช้แล้ว กรุณาตรวจสอบรูปภาพ');
                }

                return $pending;
            }
            $data = data_get($result, 'data', []);
            if (data_get($data, 'isDuplicate') !== false) {
                return $this->rejected('สลิปนี้ถูกใช้แล้ว หรือไม่สามารถยืนยันว่าเป็นสลิปใหม่ได้');
            }
            $amount = data_get($data, 'rawSlip.amount.amount');
            if (! is_numeric($amount) || (int) round((float) $amount * 100) !== (int) round((float) $rental->total_price * 100)) {
                return $this->rejected('ยอดเงินในสลิปไม่ตรงกับยอดที่ต้องชำระ');
            }
            $account = preg_replace('/[^0-9]/', '', (string) data_get($data, 'matchedAccount.bankNumber'));
            $expected = preg_replace('/[^0-9]/', '', (string) config('pinkette.account_number'));
            if (! $account || $account !== $expected) {
                return $this->rejected('บัญชีผู้รับเงินไม่ตรงกับบัญชีร้าน');
            }
            $reference = data_get($data, 'rawSlip.transRef');
            $date = data_get($data, 'rawSlip.date');
            if (! is_string($reference) || ! $reference || strlen($reference) > 255 || ! is_string($date) || ! $date) {
                return $pending;
            }
            $paidAt = Carbon::parse($date);
            if ($paidAt->lt($rental->created_at->copy()->subMinutes(5)) || $paidAt->gt(now()->addMinutes(5))) {
                return $this->rejected('วันที่โอนเงินไม่อยู่ในช่วงของรายการเช่านี้');
            }
            if (Rental::where('payment_reference', $reference)->where('id', '!=', $rental->id)->exists()) {
                return $this->rejected('สลิปนี้ถูกใช้กับรายการอื่นแล้ว');
            }

            return ['payment_status' => 'verified', 'payment_message' => 'ตรวจสอบยอดเงิน บัญชีผู้รับ และสลิปเรียบร้อยแล้ว',
                'payment_reference' => $reference, 'paid_at' => $paidAt];
        } catch (Throwable $exception) {
            return $pending;
        }
    }

    private function rejected(string $message): array
    {
        return ['payment_status' => 'rejected', 'payment_message' => $message];
    }
}
