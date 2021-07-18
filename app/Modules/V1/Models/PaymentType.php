<?php

namespace App\Modules\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    protected $table = 'payment_type';
    protected $fillable = ['name'];
    
    const PAYSTACK = 1;
    const FLUTTERWAVE = 2;

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
