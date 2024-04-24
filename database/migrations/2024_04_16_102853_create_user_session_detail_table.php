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
        Schema::create('user_session_detail', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('user_id');
            $table->date('date');
            $table->boolean('late')->default(0);
            $table->boolean('leave_soon')->default(0);
            $table->boolean('get_check_in')->default(0);
            $table->boolean('get_check_out')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_session_detail');
    }
};
