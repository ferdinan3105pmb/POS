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
        Schema::create('item_variant', function (Blueprint $table) {
            $table->id();
            $table->string('color', 45)->nullable();
            $table->integer('price');
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('size_id');
            $table->integer('stock');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('item_id')->references('id')->on('item');
            $table->foreign('size_id')->references('id')->on('size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
