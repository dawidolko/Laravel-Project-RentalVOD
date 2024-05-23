<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMovieColumnsToMoviesTable extends Migration
{
    public function up()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->decimal('super_promo_price', 8, 2)->nullable()->after('price_day');
            $table->decimal('old_price', 8, 2)->nullable()->after('price_day');
            $table->timestamp('last_promo_update')->nullable()->after('old_price');
        });
    }

    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('super_promo_price');
            $table->dropColumn('old_price');
            $table->dropColumn('last_promo_update');
        });
    }
}
