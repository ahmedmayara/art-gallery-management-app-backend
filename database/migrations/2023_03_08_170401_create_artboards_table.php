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
        Schema::create('artboards', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->float('price');
            $table->string('description');
            $table->string('image');
            $table->foreignId('artist_id')->constrained('artists');
            $table->foreignId('category_id')->constrained('categories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artboards');
    }
};
