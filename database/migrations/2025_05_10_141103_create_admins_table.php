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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('user_type');
            $table->string('password');
            $table->text('avatar')->nullable();
            $table->longText('address')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });

        \App\Models\Admin::create([
            'name' => 'Al Safri',
            'email' => 'admin@alsafri.com',
            'user_type' => 'super_admin',
            'password' => \Illuminate\Support\Facades\Hash::make('Admin@123'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
