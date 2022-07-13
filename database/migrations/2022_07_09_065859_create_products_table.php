<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->integer('rating')->nullable();
            $table->integer('price');
            $table->text('description');
            $table->string('category');
            $table->integer('countInStock');
            $table->string('image')->nullable();
            $table->string('brand')->nullable();
            $table->foreignId('user_id');
            $table->integer('numReviews')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
