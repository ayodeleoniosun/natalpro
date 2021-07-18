<?php

namespace App\Modules\V1\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleToUser extends Pivot
{
    protected $table = 'role_to_user';
}
