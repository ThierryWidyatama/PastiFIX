<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email', 255)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username', 255);
            $table->string('password');
            $table->timestamp('last_password_updated_at')->nullable();
            $table->rememberToken();
            $table->string('reset_password_token')->nullable();
            $table->timestamp('reset_password_expires_at')->nullable();
            $table->string('role_id', 255)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->char('status', 36);
            $table->timestamps();
            $table->ipAddress('last_login_ip')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->boolean('is_twofa_enabled')->default(false);
            $table->string('twofa_code')->nullable();
            $table->timestamp('twofa_expires_at')->nullable();
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
