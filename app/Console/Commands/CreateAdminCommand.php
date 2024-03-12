<?php

namespace App\Console\Commands;

use App\Enums\RoleCodesEnum;
use App\Enums\RolesEnum;
use App\Models\User;
use Godruoyi\Snowflake\Snowflake;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin user command';

    /**
     * @param User $users
     * @param Snowflake $snowflake
     */
    public function __construct(
        protected User $users,
        protected Snowflake $snowflake,
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = "Admin";
        $email = "admin@admin.com";

        $password = "admin123";

        $this->users::create([
            "unique_folder_id" => $this->snowflake->id(),
            "name" => $name,
            "email" => $email,
            'email_verified_at' => Date::now(),
            "password" => Hash::make($password),
            "role" => RoleCodesEnum::Admin->value,
            "role_name" => RolesEnum::Admin->value,
            "max_files_size" => -1
        ]);

        $this->info("Credits: \r\n email: $email\r\n password: $password");

        return Command::SUCCESS;
    }
}
