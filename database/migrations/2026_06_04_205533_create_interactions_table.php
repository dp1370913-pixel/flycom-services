<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('interactions', function (Blueprint $table) {
            $table->id('id_interaction');
            $table->foreignId('id_client')->constrained('clients', 'id_client')->onDelete('cascade');
            $table->foreignId('id_user')->constrained('users')->onDelete('restrict'); // Lié à la table users par défaut de Laravel
            $table->foreignId('id_lead')->nullable()->constrained('leads', 'id_lead')->onDelete('set null');
            $table->enum('type_canal', ['Appel', 'WhatsApp', 'Email', 'Rendez_vous', 'Visite_terrain', 'Chatbot']);
            $table->dateTime('date')->useCurrent();
            $table->text('note');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('interactions');
    }
};