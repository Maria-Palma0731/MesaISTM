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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique()->nullable();
            $table->string('title');
            $table->string('subject')->nullable(); // Mantener por compatibilidad
            $table->text('description');
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
            $table->enum('status', ['nuevo', 'abierto', 'asignado', 'en_proceso', 'pendiente_usuario', 'resuelto', 'cerrado'])->default('nuevo');
            $table->enum('priority', ['baja', 'media', 'alta', 'critica'])->default('media');
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->string('department')->nullable();
            $table->integer('rating')->nullable();
            $table->text('rating_comment')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};