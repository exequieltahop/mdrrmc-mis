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
        Schema::create('response', function (Blueprint $table) {
            $table->id();
            $table->string('respondent_id');
            $table->string('location')->notNull();
            $table->dateTime('date_time')->notNull();
            $table->enum('involve',['m','f','mf'])->notNull();
            $table->string('refered_hospital')->notNull();
            $table->string('incident_type')->notNull();
            $table->string('immediate_cause_or_reason')->notNull();
            $table->string('remark')->null();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('response');
    }
};
