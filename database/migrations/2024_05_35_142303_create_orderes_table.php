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
        Schema::create('orderes', function (Blueprint $table) {
            $table->id();
            $table->string("status");
            $table->foreignId("user_id")->constrained('users')->onDelete('cascade');
            $table->unsignedBigInteger("table_id");
            $table->integer("total_price");
            $table->softDeletes(); // This adds the deleted_at column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orderies');
        
    }
};
