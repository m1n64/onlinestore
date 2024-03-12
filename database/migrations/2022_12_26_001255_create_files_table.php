<?php

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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->foreign("user_id")
                ->on("users")
                ->references("id");
            $table->string("name");
            $table->unsignedBigInteger("folder_id")->nullable();
            $table->foreign("folder_id")
                ->on("folders")
                ->references("id");
            $table->string("slug");
            $table->string("server_path");
            $table->string("mime_type");
            $table->float("size");
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
        Schema::dropIfExists('files');
    }
};
