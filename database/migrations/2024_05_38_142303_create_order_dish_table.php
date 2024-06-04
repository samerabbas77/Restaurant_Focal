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
        Schema::create('order_dish', function (Blueprint $table) {
            $table->id();
            $table->string("dish_id");
            $table->string("order_id");
            $table->integer("quentity");
            $table->softDeletes(); // This adds the deleted_at column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_dish');
    }
};
