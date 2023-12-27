<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mst_users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->string('verify_email', 100)->nullable();
            $table->string('password', 255);
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('is_delete')->default(0);
            $table->timestamp('last_login_at');
            $table->string('last_login_ip', 40);
            $table->tinyInteger('attempt_time')->default(0);
            $table->timestamp('lock_time')->nullable();
            $table->foreignId('group_id')->constrained("groups");
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
