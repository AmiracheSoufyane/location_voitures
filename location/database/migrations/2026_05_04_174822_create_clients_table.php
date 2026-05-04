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
        Schema::create('clients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('license_number')->unique();
            $table->string('national_id')->unique();
            $table->text('address');
            $table->string('city');
            $table->string('country');
            $table->text('notes')->nullable();
            $table->string('license_image_front');
            $table->string('license_image_back');
            $table->string('national_id_image_front');
            $table->string('national_id_image_back');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
