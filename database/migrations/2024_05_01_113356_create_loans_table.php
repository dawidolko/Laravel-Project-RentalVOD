<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->date('start');
            $table->date('end');
            $table->decimal('price', 8, 2);
            $table->string('status', 50);
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });        
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};

