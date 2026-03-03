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
        Schema::table('item_type', function (Blueprint $table) {
            $table->unsignedBigInteger('outlet_id')->default(1);

            $table->foreign('outlet_id')->references('id')->on('outlet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_type', function (Blueprint $table) {
            //
        });
    }
};
