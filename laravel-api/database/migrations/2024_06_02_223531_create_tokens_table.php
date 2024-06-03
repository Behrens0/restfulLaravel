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
        Schema::create('tokens', function (Blueprint $table) {
            $table->integer('id_tok', true);
            $table->string('token')->unique('token_unique')->comment('token');
            $table->dateTime('login_time')->comment('Fecha de inicio del token');
            $table->string('email', 120)->index('fk_tokens_customers_idx')->comment('Correo Electrónico');
            $table->integer('random_value')->comment('Valor aleatorio del código');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tokens');
    }
};
