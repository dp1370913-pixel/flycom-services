<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id('id_lead');
            $table->foreignId('id_client')->constrained('clients', 'id_client')->onDelete('cascade');
            $table->foreignId('id_conversation')->nullable()->constrained('conversations', 'id_conversation')->onDelete('set null');
            $table->text('message_origine')->nullable();
            $table->enum('statut', ['Nouveau', 'Contacte', 'Devis_envoye', 'Negociation', 'Gagne', 'Perdu'])->default('Nouveau');
            $table->enum('priorite', ['Haute', 'Normale', 'Basse'])->default('Normale');
            $table->enum('source', ['Site_web', 'WhatsApp', 'Chatbot', 'Appel_direct', 'Recommandation'])->default('Site_web');
            $table->dateTime('prochaine_relance')->nullable(); // Précision temporelle utile pour l'IA WhatsApp
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};