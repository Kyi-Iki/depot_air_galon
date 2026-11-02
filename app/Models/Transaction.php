<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id',
        'transaction_number',
        'transaction_date',
        'total_amount',
        'payment_method',
        'payment_status',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'total_amount'     => 'decimal:2',
    ];

    /**
     * Get the customer for this transaction.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the admin/user who created this transaction.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all detail items for this transaction.
     */
    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Generate a unique transaction number.
     */
    public static function generateNumber(): string
    {
        $prefix = 'TRX-' . date('Ymd');
        $count = self::whereDate('transaction_date', today())->count() + 1;
        return $prefix . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Get the payment method label in Bahasa Indonesia.
     */
    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'cash'     => 'Tunai',
            'transfer' => 'Transfer',
            'qris'     => 'QRIS',
            default    => '-',
        };
    }

    /**
     * Get the payment status label in Bahasa Indonesia.
     */
    public function getPaymentStatusLabelAttribute(): string
    {
        return $this->payment_status === 'paid' ? 'Lunas' : 'Belum Lunas';
    }
}
