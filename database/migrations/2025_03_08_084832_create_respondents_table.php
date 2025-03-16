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
        Schema::create('respondents', function (Blueprint $table) {
            $table->id();
            $table->string('first_name')->notNull();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->notNull();
            $table->enum('gender', ['m', 'f', 'pnts'])->notNull();
            $table->string('address')->notNull();
            $table->string('birthdate')->notNull();
            $table->string('birthplace')->notNull();
            $table->string('civil_status')->notNull();
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respondents');
    }
};

