<?php

namespace App\Modules\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserToNatalType extends Model
{
    use HasFactory;

    protected $table = 'user_to_natal_type';

    protected $fillable = [
        'type',
        'user_id'
    ];
    
    const NURSING_MOTHER = 'nursing_mother';
    const PREGNANT_WOMEN = 'pregnant_women';
    const HEALTHCARE_PROFESSIONAL = 'healthcare_professional';
    
    public const USER_TYPES = [self::NURSING_MOTHER, self::PREGNANT_WOMEN, self::HEALTHCARE_PROFESSIONAL];

    public const USER_TYPE = [
        self::NURSING_MOTHER => 'Nursing Mother',
        self::PREGNANT_WOMEN => 'Pregnant Women',
        self::HEALTHCARE_PROFESSIONAL => 'Healthcare Professional'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
