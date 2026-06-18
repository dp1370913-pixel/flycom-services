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
        Schema::create('devis', function (Blueprint $table) {
            $table->id('id_devis');
            $table->foreignId('id_client')->constrained('clients', 'id_client')->onDelete('restrict');
            
            // RENDU FACULTATIF CONFORME À LA LOGIQUE MÉTIER DE LA MAQUETTE
            $table->foreignId('id_lead')->nullable()->constrained('leads', 'id_lead')->onDelete('set null');
            
            $table->string('numero', 20)->unique();
            $table->enum('type', ['Devis', 'Facture_proforma'])->default('Devis');
            $table->date('date_emission');
            $table->date('date_expiration');
            $table->decimal('montant_ht', 12, 2);
            $table->decimal('tva', 12, 2)->default(0);
            $table->decimal('montant_ttc', 12, 2);
            $table->enum('statut', ['En_attente', 'Accepte', 'Refuse', 'Expire'])->default('En_attente');
            $table->enum('statut_paiement', ['Non_paye', 'Acompte_recu', 'Solde'])->default('Non_paye');
            $table->string('fichier_pdf', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};