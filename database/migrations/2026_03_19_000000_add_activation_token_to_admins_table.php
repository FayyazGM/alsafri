<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->string('activation_token')->nullable();
            $table->timestamp('activation_token_expires_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['activation_token', 'activation_token_expires_at']);
        });
    }
};