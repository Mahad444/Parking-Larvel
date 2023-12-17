<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// import sector model
use App\Models\Sector;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sectors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('hourly_price');
            $table->timestamps();
        });
    
    // adding a new sector table
     Sector::create([
        'name' => 'A',
        'hourly_price' => 100,
     ]);
     Sector::create([
        'name' => 'B',
        'hourly_price' => 200,
     ]);
     Sector::create([
        'name' => 'C',
        'hourly_price' => 300,
     ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sectors');
    }
};
