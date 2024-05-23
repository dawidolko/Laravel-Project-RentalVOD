<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->text('description');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('director', 100);
            $table->integer('release_year')->check('release_year >= 1800 AND release_year <= 2155');
            $table->integer('duration')->unsigned()->check('duration <= 500');
            $table->decimal('rate', 5, 2)->check('rate >= 0.00 and rate <= 10.00');
            $table->string('img_path', 255)->nullable();
            $table->string('video_path', 255);
            $table->decimal('price_day', 8, 2)->unsigned();
            $table->string('available', 50)->default('dostępny');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
