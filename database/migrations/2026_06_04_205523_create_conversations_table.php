<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversations', function (Blueprint $table) {
            $table->id('id_conversation');
            $table->foreignId('id_client')->nullable()->constrained('clients', 'id_client')->onDelete('set null');
            $table->enum('canal', ['Chatbot_site', 'WhatsApp']);
            $table->enum('statut', ['En_cours', 'Terminee', 'Escaladee'])->default('En_cours');
            $table->dateTime('date_debut')->useCurrent();
            $table->dateTime('date_fin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversations');
    }
};