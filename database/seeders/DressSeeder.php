<?php

namespace Database\Seeders;

use App\Models\Dress;
use Illuminate\Database\Seeder;

class DressSeeder extends Seeder
{
    public function run(): void
    {
        $dresses = [
            [
                'code' => 'DR001',
                'name' => 'ชุดเดรสราตรีสีม่วง',
                'size' => 'M',
                'type' => 'ชุดราตรี',
                'price_per_day' => 550,
                'status' => 'available',
                'description' => 'ชุดเดรสราตรีโทนสีม่วง สำหรับงานเลี้ยงและงานกลางคืน',
            ],
            [
                'code' => 'DR002',
                'name' => 'ชุดออกงานสีชมพู',
                'size' => 'S',
                'type' => 'ชุดไปงาน',
                'price_per_day' => 490,
                'status' => 'available',
                'description' => 'ชุดออกงานสีชมพูพาสเทล ทรงสุภาพ ใส่ง่าย',
            ],
            [
                'code' => 'DR003',
                'name' => 'ชุดเดรสสีฟ้าพาสเทล',
                'size' => 'L',
                'type' => 'ชุดแฟชั่น',
                'price_per_day' => 520,
                'status' => 'available',
                'description' => 'ชุดเดรสสีฟ้าพาสเทล สำหรับงานกลางวันและถ่ายรูป',
            ],
            [
                'code' => 'DR004',
                'name' => 'ชุดเดรสยาวสีครีม',
                'size' => 'M',
                'type' => 'ชุดราตรี',
                'price_per_day' => 590,
                'status' => 'available',
                'description' => 'ชุดเดรสยาวสีครีม เรียบหรู เหมาะสำหรับงานทางการ',
            ],
            [
                'code' => 'DR005',
                'name' => 'ชุดเดรสสีฟ้าอ่อน',
                'size' => 'S',
                'type' => 'ชุดออกงาน',
                'price_per_day' => 450,
                'status' => 'available',
                'description' => 'ชุดเดรสสีฟ้าอ่อน ลุคหวาน เหมาะสำหรับงานเลี้ยง',
            ],
            [
                'code' => 'DR006',
                'name' => 'ชุดเดรสชมพูพาสเทล',
                'size' => 'M',
                'type' => 'ชุดแฟชั่น',
                'price_per_day' => 550,
                'status' => 'available',
                'description' => 'ชุดเดรสชมพูพาสเทล สำหรับออกงานหรือถ่ายภาพ',
            ],
            [
                'code' => 'DR007',
                'name' => 'ชุดเดรสสีม่วงอ่อน',
                'size' => 'L',
                'type' => 'ชุดไปงาน',
                'price_per_day' => 620,
                'status' => 'available',
                'description' => 'ชุดเดรสสีม่วงอ่อน ทรงหรู เหมาะกับงานกลางคืน',
            ],
            [
                'code' => 'DR008',
                'name' => 'ชุดเดรสเรียบหรูสีขาว',
                'size' => 'M',
                'type' => 'ชุดราตรี',
                'price_per_day' => 620,
                'status' => 'available',
                'description' => 'ชุดเดรสสีขาวสไตล์เรียบหรู เหมาะสำหรับงานพิเศษ',
            ],
        ];

        foreach ($dresses as $dress) {
            Dress::updateOrCreate(
                ['code' => $dress['code']],
                $dress
            );
        }
    }
}
