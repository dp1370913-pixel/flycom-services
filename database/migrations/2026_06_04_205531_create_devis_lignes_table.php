<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devis_lignes', function (Blueprint $table) {
            $table->foreignId('id_devis')->constrained('devis', 'id_devis')->onDelete('cascade');
            $table->foreignId('id_service')->constrained('services', 'id_service')->onDelete('restrict');
            $table->integer('quantite')->default(1);
            $table->decimal('prix_unitaire', 12, 2);
            
            // Snapshots pour préserver l'historique légal des devis si le catalogue change
            $table->string('nom_service_snapshot', 150);
            $table->text('description_snapshot')->nullable();

            $table->primary(['id_devis', 'id_service']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('devis_lignes');
    }
};