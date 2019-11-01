<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->float('price');
            $table->float('avg_rating');
            $table->integer('num_reviews');
            $table->dateTime('amazon_date');
            $table->timestamps();

            $table->index('amazon_date');
            $table->index('price');
            $table->index('avg_rating');
            $table->index('num_reviews');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
