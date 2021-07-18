<?php

namespace App\Modules\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment';

    protected $fillable = [
        'reference_code',
        'payment_type_id',
        'payment_status_id',
        'description',
        'active_status'
    ];
    
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class);
    }
}
