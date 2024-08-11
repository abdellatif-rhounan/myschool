<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classe_subject', function (Blueprint $table) {
            $table->unsignedBigInteger('classe_id');
            $table->foreign('classe_id')->references('id')->on('classes');
            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects');

            $table->primary(['classe_id', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classe_subject');
    }
};
