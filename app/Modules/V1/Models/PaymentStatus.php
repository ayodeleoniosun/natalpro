<?php

namespace App\Modules\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    use HasFactory;

    protected $table = 'payment_status';
    protected $fillable = ['name'];
    
    const NO_PAYMENT = 1;
    const PAID = 2;

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
}
