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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string("number")->unique();
            $table->uuid("uuid");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("state_id");
            $table->decimal("total", 12, 2)->default(0);
            $table->ipAddress("ip")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
