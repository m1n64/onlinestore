<?php

use App\Enums\RoleCodesEnum;
use App\Enums\RolesEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("unique_folder_id")->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string("role", 1)->default(RoleCodesEnum::User->value);
            $table->string("role_name")->default(RolesEnum::User->value);
            $table->float("max_files_size")->default(100);
            $table->float("files_size")->default(0);
            $table->boolean("is_banned")->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
