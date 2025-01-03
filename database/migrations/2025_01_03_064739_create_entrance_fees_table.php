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
        Schema::create('entrance_fees', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['adult', 'kid']); // Visitor type
            $table->decimal('price', 10, 2); // Regular price
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrance_fees');
    }
};
