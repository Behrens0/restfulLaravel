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
        Schema::create('communes', function (Blueprint $table) {
            $table->integer('id_com', true);
            $table->integer('id_reg')->index('fk_communes_region_idx');
            $table->string('description', 90);
            $table->enum('status', ['A', 'I', 'trash'])->default('A');

            $table->primary(['id_com', 'id_reg']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communes');
    }
};
