<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('brand', 40);          
            $table->string('model', 40);          
            $table->year('year');                  
            $table->string('registration', 30)->unique(); // immatriculation
            $table->string('fuel_type', 30);       // carburant
            $table->integer('mileage');            
            $table->integer('rest')->default(0);            
            $table->enum('status', ['disponible', 'loué', 'maintenance']);
            $table->decimal('price_per_day', 10, 2); 
            $table->text('comment')->nullable();   // commentaire
            $table->string('image', 255)->nullable(); // image

            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
        $table->dropColumn('maintenance_needed');
    }
};