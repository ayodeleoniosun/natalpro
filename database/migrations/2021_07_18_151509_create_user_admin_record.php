<?php

use App\Modules\ApiUtility;
use App\Modules\V1\Models\Role;
use App\Modules\V1\Models\RoleToUser;
use App\Modules\V1\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAdminRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('role_to_user', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->after('role_id');
            $table->foreign('user_id')->references('id')->on('user');
        });

        $user = User::create([
            'first_name' => 'super',
            'last_name' => 'admin',
            'email_address' => 'admin@natalpro.org',
            'phone_number' => '2348063712314',
            'bearer_token' => ApiUtility::generate_bearer_token(),
            'token_expires_at' => ApiUtility::next_one_month(),
            'password' => bcrypt('admin')
        ]);
        

        RoleToUser::create([
            'user_id' => $user->id,
            'role_id' => Role::ADMIN
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        User::where('id', User::SUPER_ADMIN)->delete();

        RoleToUser::where([
            'user_id' => User::SUPER_ADMIN,
            'role_id' => Role::ADMIN
        ])->delete();
    }
}
