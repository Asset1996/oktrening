<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->string('category_name');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('categories');
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->unique();
            $table->string('product_name');
            $table->integer('category_id')->unsigned();
            $table->integer('product_price');
            $table->text('product_description');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
        });

        Schema::create('attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('attribute_name');
            $table->text('attribute_description');
            $table->timestamps();
        });

        Schema::create('product_attributes_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attribute_id')->unsigned();
            $table->string('product_slug');
            $table->string('value');
            $table->timestamps();

            $table->foreign('attribute_id')->references('id')
                ->on('attributes')
                ->onDelete('cascade');
            $table->foreign('product_slug')->references('slug')
                ->on('products')
                ->onDelete('cascade');

            $table->unique(['attribute_id', 'product_slug']);
        });

        Schema::create('order_statuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status_name');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('order_sum')->comment('Total sum of all products ordered');
            $table->integer('order_quantity')->comment('Total quantity of all products ordered');
            $table->string('client_email')->nullable();
            $table->string('client_phone')->nullable();
            $table->integer('order_status_id')
                ->unsigned()
                ->default('0')
                ->comment('1-created,2-processing,3-delivered');
            $table->timestamps();

            $table->foreign('user_id')->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->foreign('order_status_id')->references('id')
                ->on('order_statuses');
        });

        Schema::create('order_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->string('product_slug');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('product_slug')->references('slug')->on('products');

            $table->unique(['order_id', 'product_slug']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_statuses');
        Schema::dropIfExists('users');
        Schema::dropIfExists('product_attributes_values');
        Schema::dropIfExists('attributes');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
}
