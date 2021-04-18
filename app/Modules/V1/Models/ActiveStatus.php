<?php

namespace App\Modules\V1\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveStatus extends Model
{
    use HasFactory;

    protected $table = 'active_status';
    protected $fillable = ['name'];

    public $timestamps = false;

    const ACTIVE = 1;
    const PENDING = 2;
    const DELETED = 3;
    const SUSPENDED = 4;
    const DEACTIVATED = 5;

    public static function symbols($status = null)
    {
        $symbols = [
            static::ACTIVE => ['color' => 'text-success', 'label' => 'Active'],
            static::PENDING => ['color' => 'text-slate', 'label' => 'Pending'],
            static::DELETED => ['color' => 'text-danger', 'label' => 'Deleted'],
            static::SUSPENDED => ['color' => 'text-warning', 'label' => 'Suspended'],
            static::DEACTIVATED => ['color' => 'text-danger', 'label' => 'Deactivated'],
        ];

        return ($status) ? data_get($symbols, $status) : $symbols;
    }

    public static function getStatusName($status): string
    {
        switch ($status) {
            case static::ACTIVE:
                return 'Active';
            case static::PENDING:
                return 'Pending';
            case static::DELETED:
                return 'Deleted';
            case static::SUSPENDED:
                return 'Suspended';
            case static::DEACTIVATED:
                return 'Deactivated';
            default:
                return '';
        }
    }
}
