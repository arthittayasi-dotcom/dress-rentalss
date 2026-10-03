<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'slip_path', 'slip_hash', 'payment_status', 'payment_message', 'payment_reference', 'paid_at',
        'user_id',
        'dress_id',
        'start_date',
        'end_date',
        'rental_days',
        'price_per_day',
        'total_price',
        'status',
        'rejection_reason',
        'return_condition',
        'return_note',
        'approved_at',
        'returned_at',
    ];

    protected function casts(): array
    {
        return [
            'paid_at' => 'datetime',
            'start_date' => 'date',
            'end_date' => 'date',
            'price_per_day' => 'decimal:2',
            'total_price' => 'decimal:2',
            'approved_at' => 'datetime',
            'returned_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dress(): BelongsTo
    {
        return $this->belongsTo(Dress::class);
    }
}
